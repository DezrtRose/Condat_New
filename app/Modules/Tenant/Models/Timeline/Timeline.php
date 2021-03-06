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
            ->join('client_timeline', 'client_timeline.timeline_id', '=', 'timelines.timeline_id')
            ->select('timelines.*', 'timeline_types.image', 'client_timeline.client_id')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->groupBy('created_date');
        return $logs;
    }

    public function getTimelineWithPage($page = 0)
    {
        $limit = 10;
        $logs = Timeline::join('timeline_types', 'timeline_types.type_id', '=', 'timelines.timeline_type_id')
            ->join('client_timeline', 'client_timeline.timeline_id', '=', 'timelines.timeline_id')
            ->select('timelines.*', 'timeline_types.image', 'client_timeline.client_id')
            ->orderBy('created_at', 'desc')
            ->offset($limit * $page)
            ->limit($limit)
            ->get()
            ->groupBy('created_date');
        return $logs;
    }

}
