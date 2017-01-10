<?php namespace App\Modules\Tenant\Controllers;

use App\Http\Requests;
use App\Modules\Tenant\Models\Agent;
use App\Modules\Tenant\Models\Institute\Institute;
use App\Modules\Tenant\Models\Institute\InstituteCourse;
use App\Modules\Tenant\Models\Institute\InstituteDocument;
use App\Modules\Tenant\Models\Document;
use App\Modules\Tenant\Models\Institute\SuperAgentInstitute;
use Flash;
use DB;

use Illuminate\Http\Request;

class InstituteController extends BaseController
{

    protected $request;/* Validation rules for user create and edit */
    protected $rules = [
        'name' => 'required|min:2|max:155',
        'short_name' => 'required|min:2|max:55',
        'number' => 'required',
        'website' => 'required|min:2|max:155'
    ];

    function __construct(Institute $institute, Request $request, InstituteDocument $document, SuperAgentInstitute $superagent, Agent $agent)
    {
        $this->institute = $institute;
        $this->request = $request;
        $this->document = $document;
        $this->superagent = $superagent;
        $this->agent = $agent;
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view("Tenant::Institute/index");
    }

    /**
     * Get all the users through ajax request.
     *
     * @return JSON response
     */
    function getData($tenant_id)
    {
        $institutes = Institute::leftJoin('companies', 'institutes.company_id', '=', 'companies.company_id')
            ->leftJoin('phones', 'phones.phone_id', '=', 'companies.phone_id')
            //->leftJoin('users', 'users.user_id', '=', 'institutes.added_by')
            ->select(['institutes.institution_id', 'institutes.short_name', 'institutes.created_at', 'companies.name', 'companies.phone_id', 'companies.website', 'companies.invoice_to_name', 'phones.number'])
            ->orderBy('institution_id', 'desc');

        $datatable = \Datatables::of($institutes)
            ->addColumn('action', function ($data) use ($tenant_id) {
                return '<a data-toggle="tooltip" title="View Institute" class="btn btn-action-box" href ="' . route('tenant.institute.show', [$tenant_id, $data->institution_id]) . '"><i class="fa fa-eye"></i></a> <a data-toggle="tooltip" title="Institute Documents" class="btn btn-action-box" href ="' . route('tenant.institute.document', [$tenant_id, $data->institution_id]) . '"><i class="fa fa-file"></i></a> <a data-toggle="tooltip" title="Delete Institute" class="delete-user btn btn-action-box" href="' . route('tenant.institute.destroy', [$tenant_id, $data->institution_id]) . '"><i class="fa fa-trash"></i></a>';
            })
            ->editColumn('created_at', function ($data) {
                return format_datetime($data->created_at);
            })
            ->editColumn('institution_id', function ($data) {
                return format_id($data->institution_id, 'I');
            })
            ->editColumn('added_by', function ($data) {
                return get_tenant_name($data->added_by);
            });
        return $datatable->make(true);
    }

    /**
     * Get all the courses through ajax request.
     *
     * @return JSON response
     */
    function getCoursesData($tenant_id, $institute_id)
    {
        $courses = InstituteCourse::join('courses', 'institute_courses.course_id', '=', 'courses.course_id')
            ->leftJoin('course_fees', 'course_fees.course_id', '=', 'courses.course_id')
            ->leftJoin('course_levels', 'course_levels.level_id', '=', 'courses.level_id')
            ->leftJoin('fees', 'fees.fee_id', '=', 'course_fees.fees_id')
            ->where('institute_courses.institute_id', $institute_id)
            ->select(['institute_courses.description', 'courses.course_id', 'courses.name', 'course_levels.name as level', 'courses.commission_percent', 'fees.total_tuition_fee'])
            ->orderBy('course_id', 'desc');

        $datatable = \Datatables::of($courses)
            ->addColumn('action', function ($data) use ($tenant_id) {
                return '<a data-toggle="tooltip" title="View Course" class="btn btn-action-box" href ="' . route('tenant.course.show', [$tenant_id, $data->course_id]) . '"><i class="fa fa-eye"></i></a> <a data-toggle="tooltip" title="Edit Course" class="btn btn-action-box" href ="' . route('tenant.course.edit', [$tenant_id, $data->course_id]) . '"><i class="fa fa-edit"></i></a> <a data-toggle="tooltip" title="Delete Course" class="delete-user btn btn-action-box" href="' . route('tenant.course.destroy', [$tenant_id, $data->course_id]) . '"><i class="fa fa-trash"></i></a>';
            })
            ->editColumn('course_id', function ($data) {
                return format_id($data->course_id, 'Cou');
            });
        return $datatable->make(true);
    }

    /**
     * Get all the intakes through ajax request.
     *
     * @return JSON response
     */
    function getIntakesData($tenant_id, $institute_id)
    {
        $intakes = Institute::join('institute_intakes', 'institute_intakes.institute_id', '=', 'institutes.institution_id')
            ->join('intakes', 'intakes.intake_id', '=', 'institute_intakes.intake_id')
            ->where('institute_intakes.institute_id', $institute_id)
            ->whereNull('intakes.deleted_at')
            ->select(['intakes.*'])
            ->orderBy('intake_id', 'desc');

        $datatable = \Datatables::of($intakes)
            ->addColumn('action', function ($data) use ($tenant_id, $institute_id) {
                return '<a data-toggle="tooltip" title="View Intake" class="btn btn-action-box" href ="' . route('tenant.intake.show', [$tenant_id, $data->intake_id]) . '"><i class="fa fa-eye"></i></a> <a data-toggle="modal" title="Edit Intake" class="btn btn-action-box" data-tooltip="tooltip" data-target="#condat-modal" data-url="' . route('tenant.intake.edit', [$tenant_id, $data->intake_id]) . '"><i class="fa fa-edit"></i></a> <a data-toggle="tooltip" title="Delete Intake" class="delete-user btn btn-action-box" href="' . route('tenant.intake.destroy', [$tenant_id, $institute_id, $data->intake_id]) . '" onclick="return confirm(\'Are you sure?\')"><i class="fa fa-trash"></i></a>';
            })
            ->editColumn('intake_id', function ($data) {
                return format_id($data->intake_id, 'Int');
            })
            ->editColumn('intake_date', function ($data) {
                return format_date($data->intake_date);
            });
        return $datatable->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('Tenant::Institute/add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store($tenant_id)
    {
        /* Additional validations for creating institution */
        $this->rules['email'] = 'required|min:2|max:255|unique:institute_addresses';

        $messages = [
            'email.unique' => 'Institute with the same email address already exists.',
        ];

        if ($this->request->ajax()) {
            $validator = \Validator::make($this->request->all(), $this->rules, $messages);
            if ($validator->fails())
                return $this->fail(['errors' => $validator->getMessageBag()->toArray()]);
            // if validates
            $institute_id = $this->institute->add($this->request->all());
            return $this->success(['institute_id' => $institute_id, 'name' => $this->request->get('name')]);
        } else {
            $this->validate($this->request, $this->rules);
            // if validates
            $institute_id = $this->institute->add($this->request->all());
            if ($institute_id)
                Flash::success('Institute has been created successfully.');

            return redirect()->route('tenant.institute.index', $tenant_id);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $institution_id
     * @return Response
     */
    public function show($tenant_id, $institution_id)
    {
        $data['super_agents'] = $this->superagent->getDetails($institution_id);
        $data['agents'] = $this->agent->getRemaining($institution_id);
        $data['institute'] = $this->institute->getDetails($institution_id);
        return view("Tenant::Institute/show", $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($tenant_id, $institution_id)
    {
        /* Getting the institute details*/
        $data['institute'] = $this->institute->getDetails($institution_id);
        //dd($data['institute']->toArray());
        if ($data['institute'] != null) {
            return view('Tenant::Institute/edit', $data);
        } else
            return show_404();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $institution_id
     * @return Response
     */
    public function update($tenant_id, $institution_id)
    {
        /* Additional validation rules checking for uniqueness */
        /*$this->rules['email'] = 'required|min:2|max:255|unique:institute_addresses,email,' . $institution_id . ',institution_id';

        $messages = [
            'email.unique' => 'Institute with the same email address already exists.',
        ];*/

        $this->validate($this->request, $this->rules);
        // if validates
        $updated = $this->institute->edit($this->request->all(), $institution_id);
        if ($updated)
            Flash::success('Institute has been updated successfully.');
        return redirect()->route('tenant.institute.index', $tenant_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }


    /**
     * Attach document to the institute.
     *
     * @param  int $institution_id
     * @return Response
     */
    function document($tenant_id, $institution_id)
    {
        $data['institute'] = $this->institute->getDetails($institution_id);
        $data['documents'] = $this->document->getInstituteDocuments($institution_id);
        return view("Tenant::Institute/document", $data);
    }

    function uploadDocument($tenant_id, $institution_id)
    {
        $upload_rules = ['document' => 'required|mimes:jpeg,jpg,bmp,png,doc,docx,pdf,txt,xls,xlsx',
            'type' => 'required',
        ];
        $this->validate($this->request, $upload_rules);

        $folder = 'document';
        $file = $this->request->input('document');
        $file = ($file == '') ? 'document' : $file;

        if ($file_info = tenant()->folder($folder, true)->upload($file)) {
            $this->document->uploadDocument($institution_id, $file_info, $this->request->all());
            \Flash::success('File uploaded successfully!');
            return redirect()->route('tenant.institute.document', [$tenant_id, $institution_id]);
        }

        \Flash::danger('Uploaded file is not valid!');
        return redirect()->back();
    }

    function downloadDocument($tenant_id, $id)
    {
        $document = Document::find($id);
        if (empty($document))
            abort(404);

        tenant()->folder('document')->download($document->name);
    }

    /**
     * Add contact persons to institute.
     *
     * @param  int $institution_id
     * @return Response
     */
    function storeContact($tenant_id, $institution_id)
    {
        if ($this->request->ajax()) {
            $rules = [
                'first_name' => 'required',
                'last_name' => 'required',
                'position' => 'required',
                'number' => 'required',
                'email' => 'required|email',
            ];
            $validator = \Validator::make($this->request->all(), $rules);
            if ($validator->fails())
                return $this->fail(['errors' => $validator->getMessageBag()->toArray()]);
            // if validates
            $contact_id = $this->institute->addContact($institution_id, $this->request->all());
            if ($contact_id)
                Flash::success('Contact added successfully!');
            return $this->success(['message' => 'Contact added successfully!']);
        } else { // Not necessary
            $contact_id = $this->institute->addContact($institution_id, $this->request->all());
            if ($contact_id) {
                \Flash::success('Contact added successfully!');
                return redirect()->route('tenant.institute.show', [$tenant_id, $institution_id]);
            }
        }
    }

    /**
     * Add contact persons to institute.
     *
     * @param  int $institution_id
     * @return Response
     */
    function storeAddress($tenant_id, $institution_id)
    {
        $rules = [
            'number' => 'required',
            'email' => 'required|email',
        ];
        $validator = \Validator::make($this->request->all(), $rules);
        if ($validator->fails())
            return $this->fail(['errors' => $validator->getMessageBag()->toArray()]);
        // if validates
        $address_id = $this->institute->addAddress($institution_id, $this->request->all());
        if ($address_id)
            Flash::success('Address added successfully!');
        return $this->success(['message' => 'Address added successfully!']);
    }

}