<?php namespace App\Modules\Tenant\Models\Invoice;

use App\Modules\Tenant\Models\Payment\CollegePayment;
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

    /**
     * Get the group college invoice for the blog post.
     */
    public function groupCollegeInvoices()
    {
        return $this->hasMany('App\Modules\Tenant\Models\Invoice\CollegeInvoice', 'group_invoices_id');
    }

    function add(array $request)
    {
        DB::beginTransaction();

        try {
            $group_invoice = GroupInvoice::create([
                'date' => insert_dateformat($request['date']),
                'description' => $request['description'],
                //'due_date' => insert_dateformat($request['due_date'])
            ]);

            $thePostIdArray = explode(',', $request['group_ids']);
            foreach ($thePostIdArray as $key => $invoice_id) {
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
            //->join('college_invoices', 'college_invoices.college_invoice_id', '=', 'group_college_invoices.college_invoices_id')
            ->groupBy('group_college_invoices.group_invoices_id')
            ->select('group_invoices.*', DB::raw('COUNT(group_college_invoices.college_invoices_id) as invoiceCount'))
            ->get();
        foreach ($grouped_invoices as $key => $group_invoice) {
            $grouped_college_invoices = GroupCollegeInvoice::where('group_invoices_id', $group_invoice->group_invoice_id)->get();
            $paid_amount = 0;
            $outstanding_amount = 0;
            $total_amount = 0;
            $total_gst = 0;
            foreach ($grouped_college_invoices as $col_key => $group_col) {
                $col_invoice = new CollegeInvoice();
                $paid_amount += $col_invoice->getPaidAmount($group_col->college_invoices_id);
                $outstanding_amount += $col_invoice->getOutstandingAmount($group_col->college_invoices_id);

                $invoice_details = CollegeInvoice::find($group_col->college_invoices_id);
                $total_amount += $invoice_details->final_total;
                $total_gst += $invoice_details->total_gst;
            }
            $grouped_invoices[$key]['paid_amount'] = $paid_amount;
            $grouped_invoices[$key]['outstanding_amount'] = $outstanding_amount;
            $grouped_invoices[$key]['total_amount'] = $total_amount;
            $grouped_invoices[$key]['total_gst'] = $total_gst;
        }
        return $grouped_invoices;
    }

    function getDetails($group_invoice_id)
    {
        $grouped_invoice = GroupInvoice::join('group_college_invoices', 'group_college_invoices.group_invoices_id', '=', 'group_invoices.group_invoice_id')
            ->groupBy('group_college_invoices.group_invoices_id')
            ->select('group_invoices.*', DB::raw('COUNT(group_college_invoices.college_invoices_id) as invoiceCount'))
            ->find($group_invoice_id);
        $grouped_college_invoices = GroupCollegeInvoice::where('group_invoices_id', $group_invoice_id)->get();
        $grouped_invoice->paid_amount = 0;
        $grouped_invoice->outstanding_amount = 0;
        $grouped_invoice->total_amount = 0;
        $grouped_invoice->total_gst = 0;
        foreach ($grouped_college_invoices as $col_key => $group_col) {
            $col_invoice = new CollegeInvoice();
            $grouped_invoice->paid_amount += $col_invoice->getPaidAmount($group_col->college_invoices_id);
            $grouped_invoice->outstanding_amount += $col_invoice->getOutstandingAmount($group_col->college_invoices_id);

            $invoice_details = CollegeInvoice::find($group_col->college_invoices_id);
            $grouped_invoice->total_amount += $invoice_details->final_total;
            $grouped_invoice->total_gst += $invoice_details->total_gst;
        }
        return $grouped_invoice;
    }

    function clearInvoice(array $request, $group_invoice_id)
    {
        DB::beginTransaction();
        try {
            $invoices = $this->getInvoices($group_invoice_id);
            foreach ($invoices as $invoice) {
                $outstanding = $invoice->total_commission - $invoice->total_paid;
                if ($outstanding > 0) {
                    $payment = CollegePayment::create([
                        'course_application_id' => $invoice->course_application_id,
                        'amount' => $outstanding,
                        'date_paid' => insert_dateformat($request['date_paid']),
                        'payment_method' => $request['payment_method'],
                        'payment_type' => $request['payment_type'],
                        'description' => $request['description']
                    ]);

                    CollegeInvoicePayment::create([
                        'ci_payment_id' => $payment->college_payment_id,
                        'college_invoice_id' => $invoice->college_invoice_id
                    ]);
                }
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

    function getInvoices($grouped_invoice_id)
    {
        $college_invoices_id = GroupCollegeInvoice::where('group_invoices_id', $grouped_invoice_id)->lists('college_invoices_id');

        $invoices_query = CollegeInvoice::leftjoin('college_invoice_payments', 'college_invoice_payments.college_invoice_id', '=', 'college_invoices.college_invoice_id')
            ->leftjoin('college_payments', 'college_payments.college_payment_id', '=', 'college_invoice_payments.ci_payment_id')
            ->leftJoin('course_application', 'course_application.course_application_id', '=', 'college_invoices.course_application_id')
            ->leftjoin('courses', 'course_application.institution_course_id', '=', 'courses.course_id')
            ->leftjoin('institute_courses', 'institute_courses.course_id', '=', 'courses.course_id')
            ->leftjoin('institutes', 'institute_courses.institute_id', '=', 'institutes.institution_id')
            ->leftjoin('companies', 'companies.company_id', '=', 'institutes.company_id')
            ->leftjoin('clients', 'clients.client_id', '=', 'course_application.client_id')
            ->leftjoin('persons', 'persons.person_id', '=', 'clients.person_id')
            ->leftjoin('person_emails', 'persons.person_id', '=', 'person_emails.person_id')
            ->leftjoin('emails', 'emails.email_id', '=', 'person_emails.email_id')
            ->leftjoin('person_phones', 'persons.person_id', '=', 'person_phones.person_id')
            ->leftjoin('phones', 'person_phones.phone_id', '=', 'phones.phone_id')
            ->select(['college_invoices.college_invoice_id', 'course_application.course_application_id', DB::raw('CONCAT(persons.first_name, " ", persons.last_name) AS fullname'), 'email', 'phones.number', 'companies.name as institute_name', 'college_invoices.final_total', 'college_invoices.college_invoice_id as invoice_id', 'college_invoices.final_total', 'college_invoices.total_gst', 'college_invoices.total_commission', 'college_invoices.invoice_date', DB::raw('IFNULL(SUM(college_payments.amount), 0) AS total_paid'), 'companies.name as institute_name', 'courses.name as course_name',
                DB::raw('CASE WHEN (ISNULL(course_application.super_agent_id) OR course_application.super_agent_id = 0)
                THEN (companies.invoice_to_name)
                ELSE (SELECT comp.name FROM companies as comp JOIN agents as ag
                    ON ag.company_id = comp.company_id
                    WHERE ag.agent_id = course_application.super_agent_id)
                END
                AS invoice_to')])
            ->whereIn('college_invoices.college_invoice_id', $college_invoices_id)
            ->orderBy('college_invoices.created_at', 'desc')
            ->groupBy('college_invoices.college_invoice_id');

        $invoices = $invoices_query->get();
        return $invoices;
    }

    function addMoreInvoices(array $request, $group_invoice_id)
    {
        foreach ($request['invoice_ids'] as $key => $invoice_id) {
            GroupCollegeInvoice::create([
                'group_invoices_id' => $group_invoice_id,
                'college_invoices_id' => $invoice_id
            ]);
        }
    }

    function getOtherInvoicesList($grouped_invoice_id)
    {
        $college_invoices_ids = GroupCollegeInvoice::where('group_invoices_id', $grouped_invoice_id)->lists('college_invoices_id');

        $invoices = CollegeInvoice::whereNotIn('college_invoices.college_invoice_id', $college_invoices_ids)
            ->lists('college_invoice_id', 'college_invoice_id');
        foreach ($invoices as $key => $invoice) {
            $invoices[$key] = format_id($invoice, 'CI');
        }
        return $invoices;
    }
}
