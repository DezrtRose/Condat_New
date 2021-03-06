<?php namespace App\Modules\Tenant\Models\Invoice;

use App\Modules\Tenant\Models\Client\Client;
use App\Modules\Tenant\Models\College\OtherCommission;
use App\Modules\Tenant\Models\College\TuitionCommission;
use App\Modules\Tenant\Models\Payment\CollegePayment;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use DB;

class CollegeInvoice extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'college_invoices';

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'college_invoice_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['course_application_id', 'total_commission', 'total_gst', 'final_total', 'due_date', 'installment_no', 'invoice_date'];

    function add(array $request, $application_id)
    {
        DB::beginTransaction();

        try {
            $college_invoice = CollegeInvoice::create([
                'course_application_id' => $application_id,
                'total_commission' => $request['total_commission'],
                'total_gst' => $request['total_gst'],
                'final_total' => $request['final_total'],
                'installment_no' => $request['installment_no'],
                'invoice_date' => insert_dateformat($request['invoice_date'])
            ]);

            if (isset($request['tuition_fee'])) {
                $ci_commission = TuitionCommission::create([
                    'tuition_fee' => $request['tuition_fee'],
                    'enrollment_fee' => $request['enrollment_fee'],
                    'material_fee' => $request['material_fee'],
                    'coe_fee' => $request['coe_fee'],
                    'other_fee' => $request['other_fee'],
                    'sub_total' => $request['sub_total'],
                    'description' => $request['description'],
                    'commission_percent' => $request['commission_percent'],
                    'commission_amount' => $request['commission_amount'],
                    'commission_gst' => $request['tuition_fee_gst'],
                    'college_invoice_id' => $college_invoice->college_invoice_id
                ]);
            }

            if (isset($request['incentive'])) {
                $ci_commission = OtherCommission::create([
                    'amount' => $request['incentive'],
                    'gst' => $request['incentive_gst'],
                    'description' => $request['other_description'],
                    'college_invoice_id' => $college_invoice->college_invoice_id
                ]);
            }

            DB::commit();
            return $college_invoice->college_invoice_id;
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            // something went wrong
        }
    }

    function addMore(array $request, $application_id, $tenant_id)
    {
        DB::beginTransaction();

        try {
            for($i = 0; $i < $request['num']; $i++)
            {
                $added_months = $i * $request['duration'];
                $invoice_date = Carbon::createFromFormat('d/m/Y', $request['start_date'])->addMonths($added_months);

                $college_invoice = CollegeInvoice::create([
                    'course_application_id' => $application_id,
                    'total_commission' => $request['total_commission'],
                    'total_gst' => $request['total_gst'],
                    'final_total' => $request['final_total'],
                    'installment_no' => $i+1,
                    'invoice_date' => $invoice_date
                ]);


                if (isset($request['tuition_fee'])) {
                    $ci_commission = TuitionCommission::create([
                        'tuition_fee' => $request['tuition_fee'],
                        'enrollment_fee' => $request['enrollment_fee'],
                        'material_fee' => $request['material_fee'],
                        'coe_fee' => $request['coe_fee'],
                        'other_fee' => $request['other_fee'],
                        'sub_total' => $request['sub_total'],
                        'description' => $request['description'],
                        'commission_percent' => $request['commission_percent'],
                        'commission_amount' => $request['commission_amount'],
                        'commission_gst' => $request['tuition_fee_gst'],
                        'college_invoice_id' => $college_invoice->college_invoice_id
                    ]);
                }

                if (isset($request['incentive'])) {
                    $ci_commission = OtherCommission::create([
                        'amount' => $request['incentive'],
                        'gst' => $request['incentive_gst'],
                        'description' => $request['description'],
                        'college_invoice_id' => $college_invoice->college_invoice_id
                    ]);
                }
                $client_id = $this->getClientId($college_invoice->college_invoice_id);
                $client = new Client();
                $client->addLog($client_id, 4, ['{{NAME}}' => get_tenant_name(), '{{DESCRIPTION}}' => 'College Invoice', '{{DATE}}' => format_date($college_invoice->invoice_date), '{{AMOUNT}}' => $college_invoice->total_commission, '{{VIEW_LINK}}' => route('tenant.college.invoice', [$tenant_id, $college_invoice->college_invoice_id])], $application_id);
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

    function getDetails($invoice_id)
    {
        $college_invoice = CollegeInvoice::leftJoin('ci_tuition_commissions', 'ci_tuition_commissions.college_invoice_id', '=', 'college_invoices.college_invoice_id')
            ->leftJoin('ci_other_commissions', 'ci_other_commissions.college_invoice_id', '=', 'college_invoices.college_invoice_id')
            ->leftJoin('course_application', 'college_invoices.course_application_id', '=', 'course_application.course_application_id')
            ->leftjoin('institutes', 'course_application.institute_id', '=', 'institutes.institution_id')
            ->leftjoin('companies', 'companies.company_id', '=', 'institutes.company_id')
            ->select('college_invoices.*', 'college_invoices.college_invoice_id as invoice_id', 'ci_tuition_commissions.*', 'institutes.institution_id', 'ci_tuition_commissions.commission_gst as tuition_fee_gst', 'ci_other_commissions.amount as incentive', 'ci_other_commissions.gst as incentive_gst', 'ci_other_commissions.description as other_description', 'companies.invoice_to_name', 'companies.name as company_name')
            ->find($invoice_id);
        return $college_invoice;
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
        $invoices = CollegeInvoice::select('final_total')
            ->where('course_application_id', $application_id)
            ->orderBy('created_at', 'desc')
            ->sum('final_total');
        return $invoices;
    }

    function getTotalPaid($application_id)
    {
        $payments = CollegePayment::join('college_invoice_payments', 'college_payments.college_payment_id', '=', 'college_invoice_payments.ci_payment_id')
            ->where('course_application_id', $application_id)
            ->sum('amount');
        return $payments;
    }

    function getList($application_id)
    {
        $invoices = CollegeInvoice::select('total_commission', 'college_invoice_id')
            ->where('course_application_id', $application_id)
            ->orderBy('created_at', 'desc')
            ->get();
        //->lists('invoice_details', 'invoices.invoice_id');
        $invoice_list = array();
        foreach ($invoices as $key => $invoice) {
            $formatted_id = format_id($invoice->college_invoice_id, 'CI');
            $invoice_list[$invoice->college_invoice_id] = $formatted_id . ', $' . $invoice->total_commission;
        }
        return $invoice_list;
    }

    function getClientId($invoice_id)
    {
        $client = CollegeInvoice::join('course_application', 'college_invoices.course_application_id', '=', 'course_application.course_application_id')
            ->select('client_id')
            ->find($invoice_id);
        return $client->client_id;
    }

    function getPaidAmount($invoice_id)
    {
        $paid = CollegePayment::join('college_invoice_payments', 'college_payments.college_payment_id', '=', 'college_invoice_payments.ci_payment_id')
            ->where('college_invoice_payments.college_invoice_id', $invoice_id)
            ->sum('college_payments.amount');
        return $paid;
    }

    //remaining
    function getOutstandingAmount($invoice_id)
    {
        $paid = $this->getPaidAmount($invoice_id);
        $col_inv = CollegeInvoice::find($invoice_id);
        $final_total = (!empty($col_inv))? $col_inv->final_total : 0;
        $outstanding = ($final_total - $paid > 0) ? $final_total - $paid : 0;
        return $outstanding;
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
        DB::beginTransaction();

        try {
            $college_invoice = CollegeInvoice::find($invoice_id); //dd($college_invoice->toArray());
            $college_invoice->total_commission = $request['total_commission'];
            $college_invoice->total_gst = $request['total_gst'];
            $college_invoice->final_total = $request['final_total'];
            $college_invoice->installment_no = $request['installment_no'];
            $college_invoice->invoice_date = insert_dateformat($request['invoice_date']);
            $college_invoice->save();

            if (isset($request['tuition_fee'])) {
                $ci_commission = TuitionCommission::find(['college_invoice_id' => $invoice_id])->first();
                if ($ci_commission) {
                    $ci_commission->tuition_fee = $request['tuition_fee'];
                    $ci_commission->enrollment_fee = $request['enrollment_fee'];
                    $ci_commission->material_fee = $request['material_fee'];
                    $ci_commission->coe_fee = $request['coe_fee'];
                    $ci_commission->other_fee = $request['other_fee'];
                    $ci_commission->sub_total = $request['sub_total'];
                    $ci_commission->description = $request['description'];
                    $ci_commission->commission_percent = $request['commission_percent'];
                    $ci_commission->commission_amount = $request['commission_amount'];
                    $ci_commission->commission_gst = $request['tuition_fee_gst'];
                    $ci_commission->save();
                } else {
                    $ci_commission = TuitionCommission::create([
                        'tuition_fee' => $request['tuition_fee'],
                        'enrollment_fee' => $request['enrollment_fee'],
                        'material_fee' => $request['material_fee'],
                        'coe_fee' => $request['coe_fee'],
                        'other_fee' => $request['other_fee'],
                        'sub_total' => $request['sub_total'],
                        'description' => $request['description'],
                        'commission_percent' => $request['commission_percent'],
                        'commission_amount' => $request['commission_amount'],
                        'commission_gst' => $request['tuition_fee_gst'],
                        'college_invoice_id' => $invoice_id
                    ]);
                }
            }

            if (isset($request['incentive'])) {
                $ci_commission = OtherCommission::find(['college_invoice_id' => $invoice_id])->first();
                if ($ci_commission) {
                    $ci_commission->amount = $request['incentive'];
                    $ci_commission->gst = $request['incentive_gst'];
                    $ci_commission->description = $request['other_description'];
                    $ci_commission->save();
                } else {
                    $ci_commission = OtherCommission::create([
                        'amount' => $request['incentive'],
                        'gst' => $request['incentive_gst'],
                        'description' => $request['description'],
                        'college_invoice_id' => $college_invoice->college_invoice_id
                    ]);
                }
            }

            DB::commit();
            return $college_invoice;
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            // something went wrong
        }
    }

    function getAll($status = 1)
    {
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
            ->select(['college_invoices.college_invoice_id', 'companies.invoice_to_name',
                DB::raw('CONCAT(persons.first_name, " ", persons.last_name) AS fullname'),
                'email', 'phones.number', 'companies.name as institute_name', 'college_invoices.final_total', 'college_invoices.college_invoice_id as invoice_id', 'college_invoices.final_total', 'college_invoices.total_gst', 'college_invoices.total_commission', 'college_invoices.invoice_date', DB::raw('IFNULL(SUM(college_payments.amount), 0) AS total_paid'), 'companies.name as institute_name', 'courses.name as course_name',
                DB::raw('CASE WHEN (ISNULL(course_application.super_agent_id) OR course_application.super_agent_id = 0)
                THEN (companies.invoice_to_name)
                ELSE (SELECT comp.name FROM companies as comp JOIN agents as ag
                    ON ag.company_id = comp.company_id
                    WHERE ag.agent_id = course_application.super_agent_id)
                END
                AS invoice_to')])
            ->orderBy('college_invoices.college_invoice_id', 'desc')
            //->where('college_invoices.invoice_date', '<=', get_today_datetime())
            ->groupBy('college_invoices.college_invoice_id');

        if ($status == 1) { // Pending
            $invoices_query = $invoices_query->havingRaw('college_invoices.total_commission - IFNULL(SUM(college_payments.amount), 0) > 0')->where('college_invoices.invoice_date', '<=', get_today_datetime());
        } elseif ($status == 2) { // Paid
            $invoices_query = $invoices_query->havingRaw('college_invoices.total_commission - IFNULL(SUM(college_payments.amount), 0) <= 0');
        } elseif ($status == 3) { // Future
            $invoices_query = $invoices_query->where('college_invoices.invoice_date', '>', get_today_datetime());
        }

        $invoices = $invoices_query->get();
        //dd($invoices->toArray());
        return $invoices;
    }

    function getRandomPendingInvoice()
    {
        $invoice = CollegeInvoice::leftjoin('college_invoice_payments', 'college_invoice_payments.college_invoice_id', '=', 'college_invoices.college_invoice_id')
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
            ->select(['college_invoices.college_invoice_id', 'companies.invoice_to_name',
                DB::raw('CONCAT(persons.first_name, " ", persons.last_name) AS fullname'),
                'email', 'phones.number', 'companies.name as institute_name', 'college_invoices.final_total', 'college_invoices.college_invoice_id as invoice_id', 'college_invoices.final_total', 'college_invoices.total_gst', 'college_invoices.total_commission', 'college_invoices.invoice_date', DB::raw('IFNULL(SUM(college_payments.amount), 0) AS total_paid'), 'companies.name as institute_name', 'courses.name as course_name',
                DB::raw('CASE WHEN (ISNULL(course_application.super_agent_id) OR course_application.super_agent_id = 0)
                THEN (companies.invoice_to_name)
                ELSE (SELECT comp.name FROM companies as comp JOIN agents as ag
                    ON ag.company_id = comp.company_id
                    WHERE ag.agent_id = course_application.super_agent_id)
                END
                AS invoice_to')])
            ->groupBy('college_invoices.college_invoice_id')
            ->havingRaw('college_invoices.total_commission - IFNULL(SUM(college_payments.amount), 0) > 0')
            ->where('college_invoices.invoice_date', '<=', get_today_datetime())
            ->inRandomOrder()
            ->take(5)
            ->get();

        return $invoice;
    }

    function getInvoicesData($application_id, $future = false)
    {
        $invoices_query = CollegeInvoice::leftjoin('college_invoice_payments', 'college_invoice_payments.college_invoice_id', '=', 'college_invoices.college_invoice_id')
            ->leftjoin('college_payments', 'college_payments.college_payment_id', '=', 'college_invoice_payments.ci_payment_id')
            ->leftJoin('course_application', 'course_application.course_application_id', '=', 'college_invoices.course_application_id')
            ->select(['college_invoices.college_invoice_id', 'college_invoices.final_total', 'college_invoices.college_invoice_id as invoice_id', 'college_invoices.final_total', 'college_invoices.total_gst', 'college_invoices.total_commission', 'college_invoices.invoice_date', DB::raw('IFNULL(SUM(college_payments.amount), 0) AS total_paid'), DB::raw('college_invoices.final_total - IFNULL(SUM(college_payments.amount), 0) AS outstanding_amount')])
            ->where('course_application.course_application_id', $application_id)
            ->orderBy('college_invoices.college_invoice_id', 'desc')
            ->groupBy('college_invoices.college_invoice_id');

        if ($future == true) // Future Invoice
            $invoices_query = $invoices_query->where('invoice_date', '>=', Carbon::now());

        $invoices = $invoices_query->get();

        //dd($invoices->toArray());
        return $invoices;
    }

    function getFilterResults(array $request, $status = 1)
    {
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
            ->select(['college_invoices.college_invoice_id', DB::raw('CONCAT(persons.first_name, " ", persons.last_name) AS fullname'), 'email', 'phones.number', 'companies.name as institute_name', 'college_invoices.final_total', 'college_invoices.college_invoice_id as invoice_id', 'college_invoices.final_total', 'college_invoices.total_gst', 'college_invoices.total_commission', 'college_invoices.invoice_date', DB::raw('IFNULL(SUM(college_payments.amount), 0) AS total_paid'), 'companies.name as institute_name', 'courses.name as course_name', 'course_application.super_agent_id',
                DB::raw('CASE WHEN (ISNULL(course_application.super_agent_id) OR course_application.super_agent_id = 0)
                THEN (companies.invoice_to_name)
                ELSE (SELECT comp.name FROM companies as comp JOIN agents as ag
                    ON ag.company_id = comp.company_id
                    WHERE ag.agent_id = course_application.super_agent_id)
                END
                AS invoice_to')])
            ->orderBy('college_invoices.college_invoice_id', 'desc')
            //->where('college_invoices.invoice_date', '<=', get_today_datetime())
            ->groupBy('college_invoices.college_invoice_id');

        if (isset($request['client_name']) && $request['client_name'] != '')
            $invoices_query = $invoices_query->whereIn('course_application.client_id', $request['client_name']);

        if ($status == 1) { // Pending
            $invoices_query = $invoices_query->havingRaw('college_invoices.total_commission - IFNULL(SUM(college_payments.amount), 0) > 0'); //->where('college_invoices.invoice_date', '<=', get_today_datetime());
        } elseif ($status == 2) { // Paid
            $invoices_query = $invoices_query->havingRaw('college_invoices.total_commission - IFNULL(SUM(college_payments.amount), 0) <= 0');
        } elseif ($status == 3) { // Future
            $invoices_query = $invoices_query->where('college_invoices.invoice_date', '>', get_today_datetime());
        }

        if ($request['invoice_date'] != '') {
            $dates = explode(' - ', $request['invoice_date']);
            $invoices_query = $invoices_query->whereBetween('college_invoices.invoice_date', array(insert_dateformat($dates[0]), insert_dateformat($dates[1])));
        }

        if (isset($request['college_name']) && !empty($request['college_name']))
            $invoices_query = $invoices_query->whereIn('course_application.institute_id', $request['college_name']);

        if ($request['from'] != '' && $request['to'] != '')
            $invoices_query = $invoices_query->whereBetween('college_invoices.final_total', [$request['from'], $request['to']]);
        elseif ($request['from'])
            $invoices_query = $invoices_query->where('college_invoices.final_total', '>=', $request['from']);
        elseif ($request['to'])
            $invoices_query = $invoices_query->where('college_invoices.final_total', '<=', $request['to']);

        if ($request['invoice_to'] != 0)
            $invoices_query = $invoices_query->where('course_application.super_agent_id', $request['invoice_to']);

        $invoices = $invoices_query->get();

        /*if (isset($request['invoice_to']) && $request['invoice_to'] && $request['invoice_to'] != 0) {
            foreach ($invoices as $key => $invoice) {
                if ($invoice->invoice_to != $request['invoice_to'])
                    unset($invoices[$key]);
            }
        }*/
        return $invoices;
    }

    function getInvoiceToList()
    {
        $list = CollegeInvoice::leftjoin('college_invoice_payments', 'college_invoice_payments.college_invoice_id', '=', 'college_invoices.college_invoice_id')
            ->leftJoin('course_application', 'course_application.course_application_id', '=', 'college_invoices.course_application_id')
            ->leftjoin('agents', 'agents.agent_id', '=', 'course_application.super_agent_id')
            ->leftjoin('companies', 'companies.company_id', '=', 'agents.company_id')
            ->select('course_application.super_agent_id AS invoice_to', 'companies.name')
            ->whereNotNull('course_application.super_agent_id')
            ->where('course_application.super_agent_id', '!=', '0')
            ->orderBy('invoice_to', 'asc')
            ->groupBy('invoice_to')
            ->lists('name', 'invoice_to');
        return $list;
    }

    function getInvoiceToList_bck()
    {
        $list = CollegeInvoice::leftjoin('college_invoice_payments', 'college_invoice_payments.college_invoice_id', '=', 'college_invoices.college_invoice_id')
            ->leftJoin('course_application', 'course_application.course_application_id', '=', 'college_invoices.course_application_id')
            ->leftjoin('courses', 'course_application.institution_course_id', '=', 'courses.course_id')
            ->leftjoin('institute_courses', 'institute_courses.course_id', '=', 'courses.course_id')
            ->leftjoin('institutes', 'institute_courses.institute_id', '=', 'institutes.institution_id')
            ->leftjoin('companies', 'companies.company_id', '=', 'institutes.company_id')
            ->select(DB::raw('CASE WHEN (ISNULL(course_application.super_agent_id) OR course_application.super_agent_id = 0)
                THEN (companies.invoice_to_name)
                ELSE (SELECT comp.name FROM companies as comp JOIN agents as ag
                    ON ag.company_id = comp.company_id
                    WHERE ag.agent_id = course_application.super_agent_id)
                END
                AS invoice_to')
            )
            ->orderBy('invoice_to', 'asc')
            ->groupBy('invoice_to')
            ->lists('invoice_to', 'invoice_to');

        return $list;
    }

    function deleteInvoice($college_invoice_id, $paymentDelete = false)
    {
        DB::beginTransaction();

        try {
            $invoice = CollegeInvoice::find($college_invoice_id);
            $course_application_id = $invoice->course_application_id;
            CollegeInvoice::where('college_invoice_id', $college_invoice_id)->delete();
            TuitionCommission::where('college_invoice_id', $college_invoice_id)->delete();
            OtherCommission::where('college_invoice_id', $college_invoice_id)->delete();
            GroupCollegeInvoice::where('college_invoices_id', $college_invoice_id)->delete();

            $payments = new CollegePayment();
            if ($paymentDelete == false) {
                //deleting only the connections
                $payments->deleteInvoicePaymentLink($college_invoice_id);
            } else {
                $payments->deleteInvoicePayment($college_invoice_id);
            }

            DB::commit();
            return $course_application_id;
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            // something went wrong
        }
    }
}
