<?php namespace App\Modules\Tenant\Controllers;

use App\Http\Requests;
use App\Modules\Tenant\Models\Course\BroadField;
use App\Modules\Tenant\Models\Course\Course;
use App\Modules\Tenant\Models\Course\CourseLevel;
use App\Modules\Tenant\Models\Course\NarrowField;
use App\Modules\Tenant\Models\Document;
use App\Modules\Tenant\Models\Institute\Institute;
use App\Modules\Tenant\Models\Institute\InstituteCourse;
use Flash;
use DB;

use Illuminate\Http\Request;

class CourseController extends BaseController
{

    protected $request;/* Validation rules for user create and edit */
    protected $course;
    protected $rules = [
        'name'=>'required|min:2|max:255',
        'coe_fee' => 'required|numeric',
        'total_tuition_fee' => 'required|numeric',
    ];

    function __construct(Course $course, Institute $institute, Request $request)
    {
        $this->course = $course;
        $this->institute = $institute;
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
        $data['courses'] = InstituteCourse::join('courses', 'institute_courses.course_id', '=', 'courses.course_id')
            ->leftJoin('course_fees', 'course_fees.course_id', '=', 'courses.course_id')
            ->leftJoin('course_levels', 'course_levels.level_id', '=', 'courses.level_id')
            ->leftJoin('fees', 'fees.fee_id', '=', 'course_fees.fees_id')
            ->where('institute_courses.institute_id', $institution_id)
            ->select(['institute_courses.description', 'courses.course_id', 'courses.name', 'course_levels.name as level', 'courses.commission_percent', 'fees.total_tuition_fee'])
            ->orderBy('course_id', 'desc')
            ->get();

        $data['institute'] = $this->institute->getDetails($institution_id);
        $data['institution_id'] = $institution_id;
        return view("Tenant::Course/index", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($tenant_id, $institution_id)
    {
        $courses = InstituteCourse::join('courses', 'institute_courses.course_id', '=', 'courses.course_id')
        ->where('institute_courses.institute_id', $institution_id)
        ->select('courses.commission_percent')
        ->orderBy('courses.course_id', 'desc')
        ->first();
        $data['commission_percent']= $courses['commission_percent'];

        $data['institution_id'] = $institution_id;
        $data['course_levels'] = CourseLevel::lists('name', 'level_id');
        $data['broad_fields'] = BroadField::lists('name', 'id');
        $data['narrow_fields'] = NarrowField::where('broad_field_id', 1)->lists('name', 'id');
        /* send in data for dropdowns : fields and level */
        return view('Tenant::Course/add', $data);
    }

    /**
     * Get narrow fields based on broad field selected
     *
     * @return JSON Array
     */
    public function getNarrowField($tenant_id, $broad_id)
    {
        if ($this->request->ajax()) {
            $fields = NarrowField::where('broad_field_id', $broad_id)->lists('name', 'id');
            $options = '';
            foreach ($fields as $key => $field) {
                $options .= "<option value =" . $key . ">" . $field . "</option>";
            }
            return $this->success(['options' => $options]);
        } else {
            return $this->fail(['error' => 'The method is not authorized.']);
        }
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
            $course_id = $this->course->add($this->request->all(), $institution_id);
            return $this->success(['course_id' => $course_id, 'name' => $this->request->get('name')]);
        }
        else {
            $this->validate($this->request, $this->rules);
            // if validates
            $course_id = $this->course->add($this->request->all(), $institution_id);
            if ($course_id)
                Flash::success('Course has been created successfully.');
            return redirect()->route('tenant.course.index', [$tenant_id, $institution_id]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $course_id
     * @return Response
     */
    public function show($tenant_id, $course_id)
    {
        $data['course'] = $this->course->getDetails($course_id);
        $course_institute = InstituteCourse::where('course_id', $course_id)->first();
        $data['institute'] = $this->institute->getDetails($course_institute->institute_id);
        return view("Tenant::Course/show", $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($tenant_id, $course_id)
    {
        /* Getting the course details*/
        $data['course'] = $course = $this->course->getDetails($course_id);
        $data['course_levels'] = CourseLevel::lists('name', 'level_id');
        $data['broad_fields'] = BroadField::lists('name', 'id');
        $data['narrow_fields'] = NarrowField::where('broad_field_id', $course->broad_field)->lists('name', 'id');
        return view('Tenant::Course/edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $institution_id
     * @return Response
     */
    public function update($tenant_id, $course_id)
    {
        $this->validate($this->request, $this->rules);
        // if validates
        $institution_id = $this->course->edit($this->request->all(), $course_id);
        if ($institution_id)
            Flash::success('Course has been updated successfully.');
        return redirect()->route('tenant.course.index', [$tenant_id, $institution_id]);
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
     * Get courses based on institute selected
     *
     * @return JSON Array
     */
    public function getCourses($tenant_id, $institute_id)
    {
        if ($this->request->ajax()) {
            $courses = $this->course->getCourses($institute_id);
            $options = '';
            foreach ($courses as $key => $course) {
                $options .= "<option value =" . $key . ">" . $course . "</option>";
            }
            return $this->success(['options' => $options]);
        } else {
            return $this->fail(['error' => 'The method is not authorized.']);
        }
    }

    public function getCourseFee($tenant_id, $course_id)
    {
        $fee = $this->course->getFee($course_id);
        return $this->success(['fee' => $fee]);
    }

    public function search($tenant_id)
    {
        $data['search_attributes'] = array();
        $data['institutes'] = $this->institute->get()->lists('short_name', 'institution_id');
        $data['levels'] = CourseLevel::lists('name', 'level_id');
        $data['courses'] = $this->course->getFilterResults();
        if ($this->request->isMethod('post')) {
            $data['courses'] = $this->course->getFilterResults($this->request->all());
            $data['search_attributes'] = $this->request->all();
            Flash::success(count($data['courses']) . ' record(s) found.');
        }
        return view("Tenant::Course/search", $data);
    }
}
