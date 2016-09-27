<?php namespace App\Modules\Tenant\Models\Course;

use Illuminate\Database\Eloquent\Model;
use DB;

class CourseLevel extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'course_levels';

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'level_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description'];

    /**
     * Disable default timestamp feature.
     *
     * @var boolean
     */
    public $timestamps = false;

}
