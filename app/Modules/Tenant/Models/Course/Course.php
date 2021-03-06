<?php namespace App\Modules\Tenant\Models\Course;

use App\Modules\Tenant\Models\Fee;
use App\Modules\Tenant\Models\Institute\InstituteCourse;
use Illuminate\Database\Eloquent\Model;
use DB;

class Course extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'courses';

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'course_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'broad_field', 'level_id', 'narrow_field', 'commission_percent'];

    /**
     * Disable default timestamp feature.
     *
     * @var boolean
     */
    public $timestamps = false;


    /*
     * Add course info
     * Output course id
     */
    function add(array $request, $institute_id)
    {
        DB::beginTransaction();

        try {
            $course = Course::create([
                'name' => $request['name'],
                'broad_field' => $request['broad_field'],
                'level_id' => $request['level_id'],
                'narrow_field' => $request['narrow_field'],
                'commission_percent' => $request['commission_percent']
            ]);

            InstituteCourse::create([
                'course_id' => $course->course_id,
                'institute_id' => $institute_id,
                'description' => $request['description'],
            ]);

            $fee = Fee::create([
                'total_tuition_fee' => $request['total_tuition_fee'],
                'coe_fee' => $request['coe_fee'],
            ]);

            CourseFee::create([
                'fees_id' => $fee->fee_id,
                'course_id' => $course->course_id
            ]);

            DB::commit();
            return $course->course_id;
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            // something went wrong
        }
    }


    function getCourses($institute_id)
    {
        $courses = InstituteCourse::join('courses', 'institute_courses.course_id', '=', 'courses.course_id')
            ->where('institute_courses.institute_id', $institute_id)
            ->orderBy('courses.name', 'asc')
            ->lists('courses.name', 'courses.course_id');
        return $courses;
    }

    /*
     * Edit course info
     * Output boolean
     */
    function edit(array $request, $course_id)
    {
        DB::beginTransaction();

        try {
            $course = Course::find($course_id);
            $course->name = $request['name'];
            $course->broad_field = $request['broad_field'];
            $course->level_id = $request['level_id'];
            $course->narrow_field = $request['narrow_field'];
            $course->commission_percent = $request['commission_percent'];
            $course->save();

            $institute_course = InstituteCourse::where('course_id', $course_id)->first();
            $institute_course->description = $request['description'];
            $institute_course->save();

            $course_fee = CourseFee::where('course_id', $course_id)->first();
            $fee = Fee::find($course_fee->fees_id);
            $fee->total_tuition_fee = $request['total_tuition_fee'];
            $fee->coe_fee = $request['coe_fee'];
            $fee->save();

            DB::commit(); //dd($institute_course->toArray());
            return $institute_course->institute_id;
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            // something went wrong
        }
    }

    function getDetails($course_id)
    {
        $course = Course::join('institute_courses', 'institute_courses.course_id', '=', 'courses.course_id')
            ->leftJoin('course_fees', 'course_fees.course_id', '=', 'courses.course_id')
            ->leftJoin('course_levels', 'course_levels.level_id', '=', 'courses.level_id')
            ->leftJoin('fees', 'fees.fee_id', '=', 'course_fees.fees_id')
            ->select(['institute_courses.description', 'courses.course_id', 'courses.name', 'courses.broad_field', 'courses.narrow_field', 'course_levels.name as level','courses.commission_percent', 'fees.total_tuition_fee', 'fees.coe_fee'])
            ->find($course_id);
        return $course;
    }

    function getFee($course_id)
    {
        $course = Course::leftJoin('course_fees', 'course_fees.course_id', '=', 'courses.course_id')
            ->leftJoin('fees', 'fees.fee_id', '=', 'course_fees.fees_id')
            ->select('fees.total_tuition_fee', 'fees.coe_fee')
            ->find($course_id);
        return (!empty($course))? $course->total_tuition_fee : '0';
    }

    function getFilterResults($search_params = false)
    {
        $courses = InstituteCourse::leftjoin('courses', 'institute_courses.course_id', '=', 'courses.course_id')
            ->leftJoin('course_fees', 'course_fees.course_id', '=', 'courses.course_id')
            ->leftJoin('course_levels', 'course_levels.level_id', '=', 'courses.level_id')
            ->leftJoin('institutes', 'institutes.institution_id', '=', 'institute_courses.institute_id')
            ->leftJoin('fees', 'fees.fee_id', '=', 'course_fees.fees_id')
            ->select(['institutes.short_name', 'courses.course_id', 'courses.name', 'course_levels.name as level','courses.commission_percent', 'fees.total_tuition_fee'])
            ->orderBy('course_id', 'desc');

        if($search_params) {
            if(!empty($search_params['institute'])) {
                $courses->whereIn('institute_courses.institute_id', $search_params['institute']);
            }

            if($search_params['course_name']) {
                $courses = $courses->where('courses.name', 'LIKE',  '%'.$search_params['course_name'].'%');
            }

            if(!empty($search_params['level'])) {
                $courses->whereIn('courses.level_id', $search_params['level']);
            }

            if($search_params['from'] != '' && $search_params['to'] != '')
                $courses = $courses->whereBetween('fees.total_tuition_fee', [$search_params['from'], $search_params['to']]);
            elseif($search_params['from'])
                $courses = $courses->where('fees.total_tuition_fee', '>=', $search_params['from']);
            elseif($search_params['to'])
                $courses = $courses->where('fees.total_tuition_fee', '<=', $search_params['to']);

            if($search_params['commission_from'] != '' && $search_params['commission_to'] != '')
                $courses = $courses->whereBetween('courses.commission_percent', [$search_params['commission_from'], $search_params['commission_to']]);
            elseif($search_params['commission_from'])
                $courses = $courses->where('courses.commission_percent', '>=', $search_params['commission_from']);
            elseif($search_params['commission_to'])
                $courses = $courses->where('courses.commission_percent', '<=', $search_params['commission_to']);
        }
        return $courses->get();
    }
}
