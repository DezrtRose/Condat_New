<?php namespace App\Modules\Tenant\Models\Timeline;

use Illuminate\Database\Eloquent\Model;
use DB;

class Timeline extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'timelines';

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'timeline_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['created_date', 'timeline_type_id', 'message', 'added_by', 'created_at'];

    /**
     * Disable default timestamp feature.
     *
     * @var boolean
     */
    public $timestamps = false;

    public function getTimeline()
    {
        $logs = Timeline::join('timeline_types', 'timeline_types.type_id', '=', 'timelines.timeline_type_id')
            ->select('timelines.*', 'timeline_types.image')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('created_date');
        return $logs;
    }

}
