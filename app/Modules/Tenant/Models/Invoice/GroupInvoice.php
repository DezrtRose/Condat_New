<?php namespace App\Modules\Tenant\Models\Invoice;

use Illuminate\Database\Eloquent\Model;
use DB;

class GroupInvoice extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'group_invoices';

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'group_invoice_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['date', 'description', 'due_date'];

    public $timestamps = false;

    function add(array $request)
    {
        DB::beginTransaction();

        try {
            $group_invoice = GroupInvoice::create([
                'date' => insert_dateformat($request['date']),
                'description' => $request['description'],
                'due_date' => insert_dateformat($request['due_date'])
            ]);

            $thePostIdArray = explode(',', $request['group_ids']);
            foreach($thePostIdArray as $key => $invoice_id) {
                GroupCollegeInvoice::create([
                    'group_invoices_id' => $group_invoice->group_invoice_id,
                    'college_invoices_id' => $invoice_id
                ]);
            }

            DB::commit();
            return true;
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            // something went wrong
        }
    }

    function getAll()
    {
        $grouped_invoices = GroupInvoice::join('group_college_invoices', 'group_college_invoices.group_invoices_id', '=', 'group_invoices.group_invoice_id')
            ->join('college_invoices', 'college_invoices.college_invoice_id', '=', 'group_college_invoices.college_invoices_id')
            ->groupBy('group_college_invoices.group_invoices_id')
            ->select('group_invoices.*', DB::raw('COUNT(college_invoices.college_invoice_id) as invoiceCount'))
            ->get();
        return $grouped_invoices;
    }

}
