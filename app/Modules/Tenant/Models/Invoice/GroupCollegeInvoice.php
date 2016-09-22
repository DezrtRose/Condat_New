<?php namespace App\Modules\Tenant\Models\Invoice;

use Illuminate\Database\Eloquent\Model;
use DB;

class GroupCollegeInvoice extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'group_college_invoices';

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'group_college_invoice_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['group_invoice_id', 'college_invoices_id'];

    public $timestamps = false;

}
