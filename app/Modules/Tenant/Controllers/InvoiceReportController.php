<?php namespace App\Modules\Tenant\Controllers;

use App\Http\Requests;
use App\Modules\Tenant\Models\Application\StudentApplicationPayment;
use App\Modules\Tenant\Models\Client\Client;
use App\Modules\Tenant\Models\Client\ClientPayment;
use App\Modules\Tenant\Models\Institute\Institute;
use App\Modules\Tenant\Models\Invoice\CollegeInvoice;
use App\Modules\Tenant\Models\Invoice\GroupCollegeInvoice;
use App\Modules\Tenant\Models\Invoice\GroupInvoice;
use App\Modules\Tenant\Models\Invoice\Invoice;
use App\Modules\Tenant\Models\Invoice\StudentInvoice;
use App\Modules\Tenant\Models\Payment\CollegePayment;
use App\Modules\Tenant\Models\Payment\SubAgentApplicationPayment;
use App\Modules\Tenant\Models\Report\Report;
use App\Modules\Tenant\Models\User;
use Flash;
use DB;
use Excel;
use PDF;
use Carbon\Carbon;

use Illuminate\Http\Request;

class InvoiceReportController extends BaseController
{

    function __construct(Invoice $invoice, StudentInvoice $student_invoice, Report $report, Institute $institute, Request $request, CollegeInvoice $college_invoice, User $user, GroupInvoice $groupInvoice, Client $client)
    {
        $this->invoice = $invoice;
        $this->student_invoice = $student_invoice;
        $this->college_invoice = $college_invoice;
        $this->report = $report;
        $this->institute = $institute;
        $this->request = $request;
        $this->user = $user;
        $this->groupInvoice = $groupInvoice;
        $this->client = $client;
        parent::__construct();
    }

    public function clientInvoicePending()
    {
        $data['invoice_reports'] = $this->student_invoice->getAll();
        return view("Tenant::InvoiceReport/ClientInvoice/invoice_pending", $data);
    }

    public function clientInvoicePaid()
    {
        $data['invoice_reports'] = $this->student_invoice->getAll(2);
        return view("Tenant::InvoiceReport/ClientInvoice/invoice_paid", $data);
    }


    public function clientInvoiceFuture()
    {
        $data['invoice_reports'] = $this->student_invoice->getAll(3);
        return view("Tenant::InvoiceReport/ClientInvoice/invoice_future", $data);
    }

    public function clientInvoiceSearch()
    {
        $data['status'] = [0 => 'All',
            1 => 'Pending',
            2 => 'Paid',
            3 => 'Future'];

        $data['colleges'] = $this->institute->getList();
        $data['clients'] = $this->client->getClientNameList();

        $data['search_attributes'] = array();

        if ($this->request->isMethod('post')) {
            $data['invoice_reports'] = $this->student_invoice->getFilterResults($this->request->all());
            $data['search_attributes'] = $this->request->all();
            Flash::success(count($data['invoice_reports']) . ' record(s) found.');
        }
        return view('Tenant::InvoiceReport/ClientInvoice/search', $data);
    }


    // college Invoices
    public function collegeInvoicePending()
    {
        $data['invoice_reports'] = $this->college_invoice->getAll();
        return view("Tenant::InvoiceReport/CollegeInvoice/invoice_pending", $data);
    }

    public function CollegeInvoicePaid()
    {
        $data['invoice_reports'] = $this->college_invoice->getAll(2);
        return view("Tenant::InvoiceReport/CollegeInvoice/invoice_paid", $data);
    }

    public function collegeInvoiceFuture()
    {
        $data['invoice_reports'] = $this->college_invoice->getAll(3);
        return view("Tenant::InvoiceReport/CollegeInvoice/invoice_future", $data);
    }

    public function collegeInvoiceGrouped()
    {
        $data['invoice_reports'] = $this->groupInvoice->getAll(); //dd($data['invoice_reports']->toArray());
        return view("Tenant::InvoiceReport/CollegeInvoice/invoice_grouped", $data);
    }

    public function showGroupedInvoices($tenant_id, $grouped_invoice_id)
    {
        $data['invoice_details'] = $this->groupInvoice->getDetails($grouped_invoice_id);
        $data['invoice_ids'] = $this->groupInvoice->getOtherInvoicesList($grouped_invoice_id);
        $data['invoice_reports'] = $this->groupInvoice->getInvoices($grouped_invoice_id); //dd($data['invoice_details']->toArray());
        return view("Tenant::InvoiceReport/CollegeInvoice/show_grouped_invoices", $data);
    }

    public function collegeInvoiceSearch()
    {
        $data['status'] = [0 => 'All',
            1 => 'Pending',
            2 => 'Paid',
            3 => 'Future'];

        $data['colleges'] = $this->institute->getList();
        $data['clients'] = $this->client->getClientNameList();
        $data['search_attributes'] = array();

        if ($this->request->isMethod('post')) {
            $data['search_attributes'] = $this->request->all();
            $data['invoice_reports'] = $this->college_invoice->getFilterResults($data['search_attributes']);
            Flash::success(count($data['invoice_reports']) . ' record(s) found.');
        }
        return view('Tenant::InvoiceReport/CollegeInvoice/search', $data);
    }

    public function clientPayments()
    {
        $data['payments'] = ClientPayment::leftJoin('clients', 'clients.client_id', '=', 'client_payments.client_id')
            ->leftJoin('student_application_payments', 'client_payments.client_payment_id', '=', 'student_application_payments.client_payment_id')
            ->leftJoin('persons', 'persons.person_id', '=', 'clients.person_id')
            ->leftJoin('payment_invoice_breakdowns', 'client_payments.client_payment_id', '=', 'payment_invoice_breakdowns.payment_id')
            ->select(['client_payments.*', 'payment_invoice_breakdowns.invoice_id', DB::raw('CONCAT(persons.first_name, " ", persons.last_name) AS client_name'), 'student_application_payments.student_payments_id'])
            ->whereRaw('student_application_payments.student_payments_id IS NOT NULL')
            ->get();
        return view("Tenant::InvoiceReport/Payment/clients", $data);
    }

    public function collegePayments()
    {
        $data['payments'] = CollegePayment::leftJoin('college_invoice_payments', 'college_payments.college_payment_id', '=', 'college_invoice_payments.ci_payment_id')
            ->select(['college_payments.*', 'college_invoice_payments.college_invoice_id'])
            ->get();
        return view("Tenant::InvoiceReport/Payment/institutes", $data);
    }

    public function subagentsPayments()
    {
        $data['payments'] = SubAgentApplicationPayment::leftJoin('client_payments', 'client_payments.client_payment_id', '=', 'subagent_application_payments.client_payment_id')
            ->leftJoin('payment_invoice_breakdowns', 'client_payments.client_payment_id', '=', 'payment_invoice_breakdowns.payment_id')
            ->select(['subagent_application_payments.subagent_payments_id', 'subagent_application_payments.course_application_id', 'payment_invoice_breakdowns.invoice_id', 'client_payments.*'])
            ->get();
        return view("Tenant::InvoiceReport/Payment/subagents", $data);
    }

    public function searchPayments()
    {
        $data['type'] = [1 => 'Client',
            2 => 'Institute',
            3 => 'Sub Agent'];

        $data['colleges'] = $this->institute->getList()->toArray();
        $data['clients'] = $this->client->getClientNameList();

        $data['users'] = $this->user->getList();

        $data['search_attributes'] = array();
        if ($this->request->isMethod('post')) {
            $data['search_attributes'] = $this->request->all();
            $data['payments'] = $this->filterPayments($data['search_attributes']);
            Flash::success(count($data['payments']) . ' record(s) found.');
        }
        return view('Tenant::InvoiceReport/Payment/search', $data);
    }

    public function filterPayments(array $request)
    {
        if($request['type'] == 1) {
            $payments = StudentApplicationPayment::leftJoin('client_payments', 'client_payments.client_payment_id', '=', 'student_application_payments.client_payment_id')
                ->leftJoin('clients', 'clients.client_id', '=', 'client_payments.client_id')
                ->leftJoin('persons', 'persons.person_id', '=', 'clients.person_id')
                ->leftJoin('payment_invoice_breakdowns', 'client_payments.client_payment_id', '=', 'payment_invoice_breakdowns.payment_id')
                ->select([
                    'student_application_payments.student_payments_id',
                    'client_payments.*',
                    'payment_invoice_breakdowns.invoice_id',
                    'course_application_id',
                    DB::raw('CONCAT(persons.first_name, " ", persons.last_name) AS client_name')]);
            if($request['payment_date']) {
                $date_range = explode('-', $request['payment_date']);
                $from = trim($date_range[0]);
                $to = trim($date_range[1]);
                $payments = $payments->whereBetween('client_payments.date_paid', [$from, $to]);
            }
            if($request['from'] && $request['to']) {
                $payments = $payments->whereBetween('client_payments.amount', [$request['from'], $request['to']]);
            } elseif($request['from']) {
                $payments = $payments->where('client_payments.amount', '>=', $request['from']);
            } elseif($request['to']) {
                $payments = $payments->where('client_payments.amount', '<=', $request['to']);
            }
            if(isset($request['client_name'])) {
                $payments = $payments->whereIn('client_payments.client_id', $request['client_name']);
            }
            if(isset($request['added_by'])) {
                $payments = $payments->whereIn('client_payments.added_by', $request['added_by']);
            }
            $payments = $payments->where('client_payments.payment_type', $request['client_payment_type'])->get();
        } elseif ($request['type'] == 2) {
            $payments = CollegePayment::leftJoin('college_invoice_payments', 'college_payments.college_payment_id', '=', 'college_invoice_payments.ci_payment_id')
                ->leftJoin('course_application', 'course_application.course_application_id', '=', 'college_payments.course_application_id')
                ->leftJoin('clients', 'clients.client_id', '=', 'course_application.client_id')
                ->leftJoin('persons', 'persons.person_id', '=', 'clients.person_id')
                ->select([
                    'college_payments.*',
                    'college_invoice_payments.college_invoice_id',
                    DB::raw('CONCAT(persons.first_name, " ", persons.last_name) AS client_name')]);
            if($request['payment_date']) {
                $date_range = explode('-', $request['payment_date']);
                $from = trim($date_range[0]);
                $to = trim($date_range[1]);
                $payments = $payments->whereBetween('college_payments.date_paid', [$from, $to]);
            }
            if($request['from'] && $request['to']) {
                $payments = $payments->whereBetween('college_payments.amount', [$request['from'], $request['to']]);
            } elseif($request['from']) {
                $payments = $payments->where('college_payments.amount', '>=', $request['from']);
            } elseif($request['to']) {
                $payments = $payments->where('college_payments.amount', '<=', $request['to']);
            }
            if(isset($request['client_name'])) {
                $payments = $payments->whereIn('course_application.client_id', $request['client_name']);
            }
            if(isset($request['added_by'])) {
                $payments = $payments->whereIn('college_payments.added_by', $request['added_by']);
            }
            $payments = $payments->where('college_payments.payment_type', $request['college_payment_type'])->get();
        } else {
            $payments = SubAgentApplicationPayment::leftJoin('client_payments', 'client_payments.client_payment_id', '=', 'subagent_application_payments.client_payment_id')
                ->leftJoin('payment_invoice_breakdowns', 'client_payments.client_payment_id', '=', 'payment_invoice_breakdowns.payment_id')
                ->select(['subagent_application_payments.subagent_payments_id', 'subagent_application_payments.course_application_id', 'payment_invoice_breakdowns.invoice_id', 'client_payments.*'])
                ->get();
        }

        return $payments;
    }

    public function groupInvoice()
    {
        $data['search_attributes'] = array();
        $data['invoice_to_list'] = $this->college_invoice->getInvoiceToList()->toArray();
        array_unshift($data['invoice_to_list'], 'All');
        $data['colleges'] = $this->institute->getList();
        $data['clients'] = $this->client->getClientNameList();
        if ($this->request->isMethod('post')) {
            $data['search_attributes'] = $this->request->all();
            $data['invoice_reports'] = $this->college_invoice->getFilterResults($data['search_attributes']);
            Flash::success(count($data['invoice_reports']) . ' record(s) found.');
        } else {
            //$data['invoice_reports'] = $this->college_invoice->getAll();
            $data['invoice_reports'] = array();
        }
        return view("Tenant::InvoiceReport/CollegeInvoice/group_invoice", $data);
    }

    public function createGroupInvoice()
    {
        if ($this->request->isMethod('post')) {
            $this->groupInvoice->add($this->request->all());
            return $this->success(['message' => 'Success']);
        } else {
            return view("Tenant::InvoiceReport/CollegeInvoice/partial/createGroupInvoice");
        }
    }

    public function addMoreGroupInvoice($tenant_id, $group_invoice_id)
    {
        $this->groupInvoice->addMoreInvoices($this->request->all(), $group_invoice_id);
        Flash::success('Invoices added successfully.');
        return  redirect()->route('invoice.grouped.show', [$tenant_id, $group_invoice_id]);
    }

    public function deleteGroupInvoices($tenant_id, $group_invoice_id, $invoice_id)
    {
        $invoice = GroupCollegeInvoice::where('college_invoices_id', $invoice_id)->where('group_invoices_id', $group_invoice_id)->first();
        $invoice->delete();
        return $this->success(['message' => 'Success']);
    }


}//end of controller
