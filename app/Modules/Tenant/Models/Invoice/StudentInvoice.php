<?php namespace App\Modules\Tenant\Models\Invoice;

use App\Modules\Tenant\Models\Application\CourseApplication;
use App\Modules\Tenant\Models\Application\StudentApplicationPayment;
use App\Modules\Tenant\Models\Client\Client;
use App\Modules\Tenant\Models\Client\ClientPayment;
use App\Modules\Tenant\Models\PaymentInvoiceBreakdown;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use DB;

class StudentInvoice extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'student_invoices';

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'student_invoice_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['invoice_id', 'application_id', 'client_id'];

    public $timestamps = false;

    function add(array $request, $client_id)
    {
        DB::beginTransaction();

        try {
            $invoice = Invoice::create([
                'amount' => $request['amount'],
                'invoice_date' => insert_dateformat($request['invoice_date']),
                'discount' => $request['discount'],
                'invoice_amount' => $request['invoice_amount'],
                'final_total' => $request['final_total'],
                'total_gst' => $request['total_gst'],
                'description' => $request['description'],
                'due_date' => insert_dateformat($request['due_date']),
            ]);

            $student_invoice = StudentInvoice::create([
                'invoice_id' => $invoice->invoice_id,
                'application_id' => ($request['application_id'] != 0) ? $request['application_id'] : null,
                'client_id' => $client_id
            ]);

            DB::commit();
            return $student_invoice->student_invoice_id;
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            // something went wrong
        }
    }

    function getStats($application_id)
    {
        $stats = array();
        $stats['invoice_amount'] = $this->getTotalAmount($application_id);
        $stats['total_paid'] = $this->getTotalPaid($application_id);
        $due_amount = $stats['invoice_amount'] - $stats['total_paid'];
        $stats['due_amount'] = ($due_amount < 0) ? 0 : $due_amount;
        return $stats;
    }

    function getTotalAmount($application_id)
    {
        $invoices = StudentInvoice::join('invoices', 'student_invoices.invoice_id', '=', 'invoices.invoice_id')
            ->where('student_invoices.application_id', $application_id)
            ->sum('invoices.final_total');
        return $invoices;
    }

    function getTotalPaid($application_id)
    {
        $payments = StudentApplicationPayment::leftJoin('client_payments', 'client_payments.client_payment_id', '=', 'student_application_payments.client_payment_id')
            ->join('payment_invoice_breakdowns', 'client_payments.client_payment_id', '=', 'payment_invoice_breakdowns.payment_id')
            ->where('course_application_id', $application_id)
            ->sum('client_payments.amount');
        return $payments;
    }

    function getList($application_id)
    {
        $invoices = StudentInvoice::join('invoices', 'student_invoices.invoice_id', '=', 'invoices.invoice_id')
            ->where('student_invoices.application_id', $application_id)
            ->select('invoices.invoice_id', 'invoices.invoice_amount')
            ->orderBy('created_at', 'desc')
            ->get();
        //->lists('invoice_details', 'invoices.invoice_id');
        $invoice_list = array();
        foreach ($invoices as $key => $invoice) {
            $formatted_id = format_id($invoice->invoice_id, 'SI');
            $invoice_list[$invoice->invoice_id] = $formatted_id . ', $' . $invoice->invoice_amount;
        }
        return $invoice_list;
    }

    function getListByClient($client_id)
    {
        $invoices = StudentInvoice::join('invoices', 'student_invoices.invoice_id', '=', 'invoices.invoice_id')
            ->where('student_invoices.client_id', $client_id)
            ->select('invoices.invoice_id', 'invoices.invoice_amount')
            ->orderBy('created_at', 'desc')
            ->get();
        //->lists('invoice_details', 'invoices.invoice_id');
        $invoice_list = array();
        foreach ($invoices as $key => $invoice) {
            $formatted_id = format_id($invoice->invoice_id, 'I');
            $invoice_list[$invoice->invoice_id] = $formatted_id . ', $' . $invoice->invoice_amount;
        }
        return $invoice_list;
    }

    function getAll($status = 1)
    {
        $invoices_query = StudentInvoice::join('invoices', 'student_invoices.invoice_id', '=', 'invoices.invoice_id')
            ->leftjoin('payment_invoice_breakdowns', 'payment_invoice_breakdowns.invoice_id', '=', 'invoices.invoice_id')
            ->leftjoin('client_payments', 'client_payments.client_payment_id', '=', 'payment_invoice_breakdowns.payment_id')
            ->leftjoin('clients', 'clients.client_id', '=', 'student_invoices.client_id')
            ->leftjoin('persons', 'persons.person_id', '=', 'clients.person_id')
            ->leftjoin('person_emails', 'persons.person_id', '=', 'person_emails.person_id')
            ->leftjoin('emails', 'emails.email_id', '=', 'person_emails.email_id')
            ->leftjoin('person_phones', 'persons.person_id', '=', 'person_phones.person_id')
            ->leftjoin('phones', 'person_phones.phone_id', '=', 'phones.phone_id')
            ->select([DB::raw('CONCAT(persons.first_name, " ", persons.last_name) AS fullname'), 'emails.email', 'phones.number', 'invoices.invoice_amount', 'invoices.discount', 'student_invoices.student_invoice_id', 'invoices.final_total', 'invoices.invoice_id', 'invoices.total_gst', 'invoices.invoice_date',
                DB::raw('SUM(client_payments.amount) AS total_paid')
            ])
            ->orderBy('invoices.invoice_id', 'desc')
            //->where('invoices.invoice_date', '<=', get_today_datetime())
            ->groupBy('invoices.invoice_id');

        if ($status == 1) { // Pending
            $invoices_query = $invoices_query->havingRaw('invoices.final_total - IFNULL(SUM(client_payments.amount), 0) > 0')->where('invoices.due_date', '<', get_today_datetime()); //->where('college_invoices.invoice_date', '<=', get_today_datetime());
        } elseif ($status == 2) { // Paid
            $invoices_query = $invoices_query->havingRaw('invoices.final_total - IFNULL(SUM(client_payments.amount), 0) <= 0')->where('invoices.invoice_date', '<=', get_today_datetime());
        } elseif ($status == 3) { // Future
            $invoices_query = $invoices_query->where('invoices.invoice_date', '>', get_today_datetime());
        }
        $invoices = $invoices_query->get(); //dd($invoices->toArray());
        return $invoices;
    }

    function getRandomPendingInvoice()
    {
        $invoice = StudentInvoice::join('invoices', 'student_invoices.invoice_id', '=', 'invoices.invoice_id')
            ->leftjoin('payment_invoice_breakdowns', 'payment_invoice_breakdowns.invoice_id', '=', 'invoices.invoice_id')
            ->leftjoin('client_payments', 'client_payments.client_payment_id', '=', 'payment_invoice_breakdowns.payment_id')
            ->leftjoin('clients', 'clients.client_id', '=', 'student_invoices.client_id')
            ->leftjoin('persons', 'persons.person_id', '=', 'clients.person_id')
            ->leftjoin('person_emails', 'persons.person_id', '=', 'person_emails.person_id')
            ->leftjoin('emails', 'emails.email_id', '=', 'person_emails.email_id')
            ->leftjoin('person_phones', 'persons.person_id', '=', 'person_phones.person_id')
            ->leftjoin('phones', 'person_phones.phone_id', '=', 'phones.phone_id')
            ->select([DB::raw('CONCAT(persons.first_name, " ", persons.last_name) AS fullname'), 'emails.email', 'phones.number', 'invoices.invoice_amount', 'invoices.description', 'student_invoices.student_invoice_id', 'invoices.final_total', 'invoices.invoice_id', 'invoices.total_gst', 'invoices.invoice_date',
                DB::raw('SUM(client_payments.amount) AS total_paid')
            ])
            ->groupBy('invoices.invoice_id')
            ->havingRaw('invoices.final_total - IFNULL(SUM(client_payments.amount), 0) > 0')
            ->where('invoices.due_date', '<', get_today_datetime())
            ->inRandomOrder()
            ->take(5)
            ->get();
        return $invoice;
    }

    function getFilterResults(array $request)
    {
        $invoices_query = StudentInvoice::join('invoices', 'student_invoices.invoice_id', '=', 'invoices.invoice_id')
            ->leftjoin('payment_invoice_breakdowns', 'payment_invoice_breakdowns.invoice_id', '=', 'invoices.invoice_id')
            ->leftjoin('client_payments', 'client_payments.client_payment_id', '=', 'payment_invoice_breakdowns.payment_id')
            ->leftjoin('clients', 'clients.client_id', '=', 'student_invoices.client_id')
            ->leftjoin('persons', 'persons.person_id', '=', 'clients.person_id')
            ->leftjoin('person_emails', 'persons.person_id', '=', 'person_emails.person_id')
            ->leftjoin('emails', 'emails.email_id', '=', 'person_emails.email_id')
            ->leftjoin('person_phones', 'persons.person_id', '=', 'person_phones.person_id')
            ->leftjoin('phones', 'person_phones.phone_id', '=', 'phones.phone_id')
            ->leftjoin('course_application', 'course_application.course_application_id', '=', 'student_invoices.application_id')
            ->select([DB::raw('CONCAT(persons.first_name, " ", persons.last_name) AS fullname'), 'email', 'phones.number', 'invoices.invoice_amount', 'invoices.discount', 'student_invoices.student_invoice_id', 'invoices.final_total', 'invoices.invoice_id', 'invoices.total_gst', 'invoices.invoice_date', DB::raw('SUM(client_payments.amount) AS total_paid')])
            ->orderBy('invoices.created_at', 'desc')
            ->groupBy('invoices.invoice_id');

        if ($request['status'] == 1) { // Pending
            $invoices_query = $invoices_query->havingRaw('invoices.invoice_amount - SUM(client_payments.amount) > 0'); //->where('invoices.invoice_date', '<=', get_today_datetime());
        } elseif ($request['status'] == 2) { // Paid
            $invoices_query = $invoices_query->havingRaw('invoices.invoice_amount - SUM(client_payments.amount) <= 0');
        } elseif ($request['status'] == 3) { // Future
            $invoices_query = $invoices_query->where('invoices.invoice_date', '>', get_today_datetime());
        }

        if ($request['invoice_date'] != '') {
            $dates = explode(' - ', $request['invoice_date']);
            $invoices_query = $invoices_query->whereBetween('invoices.invoice_date', array(insert_dateformat($dates[0]), insert_dateformat($dates[1])));
        }

        if (isset($request['client_name']) && $request['client_name'] != '')
            //$invoices_query = $invoices_query->where(DB::raw('CONCAT(persons.first_name, " ", persons.last_name)'), 'LIKE', '%' . $request['client_name'] . '%');
            $invoices_query = $invoices_query->whereIn('student_invoices.client_id', $request['client_name']);

        if ($request['from'] != '' && $request['to'] != '')
            $invoices_query = $invoices_query->whereBetween('invoices.invoice_amount', [$request['from'], $request['to']]);
        elseif ($request['from'])
            $invoices_query = $invoices_query->where('invoices.invoice_amount', '>=', $request['from']);
        elseif ($request['to'])
            $invoices_query = $invoices_query->where('invoices.invoice_amount', '<=', $request['to']);

        if (isset($request['college_name']) && !empty($request['college_name']))
            $invoices_query = $invoices_query->whereIn('course_application.institute_id', $request['college_name']);

        $invoices = $invoices_query->get();
        return $invoices;
    }

    function getClientId($invoice_id)
    {
        $client = StudentInvoice::join('course_application', 'student_invoices.application_id', '=', 'course_application.course_application_id')
            ->select('client_id')
            ->find($invoice_id);
        return $client->client_id;
    }

    function getOutstandingAmount($invoice_id)
    {
        $paid = $this->getPaidAmount($invoice_id);
        $final_total = Invoice::find($invoice_id)->final_total;
        $outstanding = ($final_total - $paid > 0) ? $final_total - $paid : 0;
        return $outstanding;
    }

    function getPaidAmount($invoice_id)
    {
        $paid = PaymentInvoiceBreakdown::leftJoin('client_payments', 'client_payments.client_payment_id', '=', 'payment_invoice_breakdowns.payment_id')
            ->leftJoin('student_application_payments', 'client_payments.client_payment_id', '=', 'student_application_payments.client_payment_id')
            ->where('invoice_id', $invoice_id)
            ->sum('client_payments.amount');
        /*StudentApplicationPayment::leftJoin('client_payments', 'client_payments.client_payment_id', '=', 'student_application_payments.client_payment_id')
            ->join('payment_invoice_breakdowns', 'client_payments.client_payment_id', '=', 'payment_invoice_breakdowns.payment_id')
            ->where('invoice_id', $invoice_id)
            ->sum('client_payments.amount');*/
        return $paid;
    }

    function getDetails($invoice_id)
    {
        $student_invoice = StudentInvoice::join('invoices', 'student_invoices.invoice_id', '=', 'invoices.invoice_id')
            ->join('clients', 'student_invoices.client_id', '=', 'clients.client_id')
            ->leftjoin('persons', 'persons.person_id', '=', 'clients.person_id')
            ->leftJoin('course_application', 'student_invoices.application_id', '=', 'course_application.course_application_id')
            ->leftjoin('institutes', 'course_application.institute_id', '=', 'institutes.institution_id')
            ->leftjoin('companies', 'companies.company_id', '=', 'institutes.company_id')//Only for the ones that are associated with application
            ->select(['invoices.*', 'student_invoices.*', DB::raw('CONCAT(persons.first_name, " ", persons.last_name) AS client_name'),
                DB::raw('CASE WHEN (ISNULL(course_application.super_agent_id) OR course_application.super_agent_id = 0)
                THEN (companies.invoice_to_name)
                ELSE (SELECT comp.name FROM companies as comp JOIN agents as ag
                    ON ag.company_id = comp.company_id
                    WHERE ag.agent_id = course_application.super_agent_id)
                END
                AS invoice_to')])
            ->find($invoice_id); //dd($student_invoice->toArray());
        return $student_invoice;
    }

    function getPayDetails($invoice_id)
    {
        $details = new \stdClass();
        $details->paid = $this->getPaidAmount($invoice_id);
        $details->outstandingAmount = $this->getOutstandingAmount($invoice_id);
        return $details;
    }

    function editInvoice(array $request, $invoice_id)
    {
        $student_invoice = StudentInvoice::find($invoice_id);
        $invoice = Invoice::find($student_invoice->invoice_id);
        $invoice->amount = $request['amount'];
        $invoice->invoice_date = insert_dateformat($request['invoice_date']);
        $invoice->discount = $request['discount'];
        $invoice->invoice_amount = $request['invoice_amount'];
        $invoice->final_total = $request['final_total'];
        $invoice->total_gst = $request['total_gst'];
        $invoice->description = $request['description'];
        $invoice->due_date = insert_dateformat($request['due_date']);
        $invoice->save();

        return $student_invoice->application_id;
    }

    function getOutstandingPayments()
    {
        $invoices = Client::join('student_invoices', 'student_invoices.client_id', '=', 'clients.client_id')
            ->join('invoices', 'student_invoices.invoice_id', '=', 'invoices.invoice_id')
            ->leftjoin('persons', 'persons.person_id', '=', 'clients.person_id')
            ->where('invoices.due_date', '<', Carbon::now())
            ->select('clients.client_id', DB::raw('CONCAT(persons.first_name, " ", persons.last_name) AS fullname'), DB::raw('SUM(invoices.final_total) as total_amount'))
            ->groupBy('student_invoices.client_id')
            ->get();

        $outstanding_payments = array();

        foreach ($invoices as $key => $invoice) {
            $paid_amount = StudentApplicationPayment::leftJoin('client_payments', 'client_payments.client_payment_id', '=', 'student_application_payments.client_payment_id')
                ->join('payment_invoice_breakdowns', 'client_payments.client_payment_id', '=', 'payment_invoice_breakdowns.payment_id')
                ->join('invoices', 'payment_invoice_breakdowns.invoice_id', '=', 'invoices.invoice_id')
                ->where('invoices.due_date', '<', Carbon::now())
                ->where('client_id', $invoice->client_id)
                ->sum('client_payments.amount');
            $outstanding = $invoice->total_amount - $paid_amount;
            if ($outstanding > 0) {
                $client = new Client();
                $details = $client->getDetails($invoice->client_id);
                $outstanding_payments[$invoice->client_id]['client_name'] = $invoice->fullname;
                $outstanding_payments[$invoice->client_id]['outstanding_amount'] = $outstanding;
                $outstanding_payments[$invoice->client_id]['paid_amount'] = $paid_amount;
                $outstanding_payments[$invoice->client_id]['number'] = $details->number;
                $outstanding_payments[$invoice->client_id]['email'] = $details->email;
            }
        }
        return $outstanding_payments;
    }

    function deleteInvoice($invoice_id, $paymentDelete = false)
    {
        DB::beginTransaction();

        try {
            if ($paymentDelete == false) {
                //deleting only the connections
                PaymentInvoiceBreakdown::where('invoice_id', $invoice_id)->delete();
            } else {
                $payment_ids = PaymentInvoiceBreakdown::where('invoice_id', $invoice_id)->lists('payment_id');
                ClientPayment::whereIn('client_payment_id', $payment_ids)->delete();
                StudentApplicationPayment::whereIn('client_payment_id', $payment_ids)->delete();
                PaymentInvoiceBreakdown::where('invoice_id', $invoice_id)->delete();
            }
            Invoice::where('invoice_id', $invoice_id)->delete();
            StudentInvoice::where('invoice_id', $invoice_id)->delete();
            DB::commit();
            return true;
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            // something went wrong
        }

    }


    function getStudentDetails($invoice_id)
    {
        $invoice = StudentInvoice::leftjoin('clients', 'clients.client_id', '=', 'student_invoices.client_id')
            ->leftjoin('persons', 'persons.person_id', '=', 'clients.person_id')
            ->leftjoin('person_emails', 'persons.person_id', '=', 'person_emails.person_id')
            ->leftjoin('emails', 'emails.email_id', '=', 'person_emails.email_id')
            ->leftjoin('person_phones', 'persons.person_id', '=', 'person_phones.person_id')
            ->leftjoin('phones', 'person_phones.phone_id', '=', 'phones.phone_id')
            ->select([DB::raw('CONCAT(persons.first_name, " ", persons.last_name) AS fullname'), 'emails.email', 'phones.number'])
            ->find($invoice_id);
        return $invoice;
    }
}
