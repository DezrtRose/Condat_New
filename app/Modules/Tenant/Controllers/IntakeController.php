<?php namespace App\Modules\Tenant\Controllers;

use App\Http\Requests;
use App\Modules\Tenant\Models\Institute\Institute;
use App\Modules\Tenant\Models\Intake\InstituteIntake;
use App\Modules\Tenant\Models\Intake\Intake;
use Flash;
use DB;

use Illuminate\Http\Request;

class IntakeController extends BaseController
{

    protected $request;/* Validation rules for user create and edit */
    protected $course;
    protected $rules = [
        'intake_date'=>'required',
        'description'=>'required|min:2|max:155'
    ];

    function __construct(Intake $intake, Institute $institute, InstituteIntake $institute_intake, Request $request)
    {
        $this->intake = $intake;
        $this->institute = $institute;
        $this->institute_intake = $institute_intake;
        $this->request = $request;
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($tenant_id, $institution_id)
    {
        $data['institute'] = $this->institute->getDetails($institution_id);
        $data['institution_id'] = $institution_id;
        return view("Tenant::Intake/index", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($tenant_id, $institution_id)
    {
        $data['institution_id'] = $institution_id;
        /* send in data for dropdowns : fields and level */
        return view('Tenant::Intake/add', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store($tenant_id, $institution_id)
    {
        if($this->request->ajax()) {
            $validator = \Validator::make($this->request->all(), $this->rules);
            if ($validator->fails())
                return $this->fail(['errors' => $validator->getMessageBag()->toArray()]);
            // if validates
            $intake_id = $this->intake->add($this->request->all(), $institution_id);
            Flash::success('Intake has been created successfully.');
            return $this->success(['intake_id' => $intake_id, 'description' => $this->request->get('intake_date') . " " . $this->request->get('description')]);
        }
        else {
            $this->validate($this->request, $this->rules);
            // if validates
            $intake_id = $this->intake->add($this->request->all(), $institution_id);
            if ($intake_id)
                Flash::success('Intake has been created successfully.');
            return redirect()->route('tenant.intake.index', [$tenant_id, $institution_id]);
        }

    }

    /**
     * Get intakes based on institute selected
     *
     * @return JSON Array
     */
    public function getIntakes($tenant_id, $institute_id)
    {
        if ($this->request->ajax()) {
            $intakes = $this->intake->getIntakes($institute_id);
            $options = '';
            foreach ($intakes as $key => $intake) {
                $options .= "<option value =" . $key . ">" . $intake . "</option>";
            }
            return $this->success(['options' => $options]);
        } else {
            return $this->fail(['error' => 'The method is not authorized.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $intake_id
     * @return Response
     */
    public function show($tenant_id, $intake_id)
    {
        $data['intake'] = $this->course->getDetails($intake_id);
        return view("Tenant::Intake/show", $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($tenant_id, $intake_id)
    {
        /* Getting the course details*/
        $data['intake'] = $this->intake->getDetails($intake_id);
        return view('Tenant::Intake/edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $institution_id
     * @return Response
     */
    public function update($tenant_id, $intake_id)
    {
        if($this->request->ajax()) {
            $validator = \Validator::make($this->request->all(), $this->rules);
            if ($validator->fails())
                return $this->fail(['errors' => $validator->getMessageBag()->toArray()]);
            // if validates
            $institute_id = $this->intake->edit($this->request->all(), $intake_id);
            if ($institute_id)
                Flash::success('Intake has been updated successfully.');
            return $this->success(['intake_id' => $intake_id, 'message' => 'Intake has been updated successfully.']);
        }
        //return redirect()->route('tenant.intake.index', [$tenant_id, $institute_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($tenant_id, $institute_id, $intake_id)
    {
        Intake::find($intake_id)->delete();
        Flash::success('Intake has been deleted successfully.');

        return redirect()->route('tenant.intake.index', [$tenant_id, $institute_id]);
    }
}
