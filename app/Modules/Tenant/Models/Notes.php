<?php namespace App\Modules\Tenant\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


class Notes extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'notes';

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'notes_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['added_by_user_id', 'description', 'remind', 'reminder_date', 'status', 'completed_date', 'completed_by'];

    public $timestamps = false;

    public function markComplete($note_id)
    {
        $note = Notes::find($note_id);
        $note->status = 1;
        $note->completed_by = current_tenant_id();
        $note->completed_date = Carbon::now();
        $note->save();

        return true;
    }
}
