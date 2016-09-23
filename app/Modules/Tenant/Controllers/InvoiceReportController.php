<?php namespace App\Modules\Tenant\Controllers;

use App\Http\Requests;
use App\Modules\Tenant\Models\Application\StudentApplicationPayment;
use App\Modules\Tenant\Models\Institute\Institute;
use App\Modules\Tenant\Models\Invoice\CollegeInvoice;
use App\Modules\Tenant\Models\Invoice\GroupInvoice;
use App\Modules\Tenant\Models\Invoice\Invoice;
use App\Modules\Tenant\Models\Invoice\StudentInvoice;
use App\Modules\Tenant\Models\Payment\CollegePayment;
use App\Modules\Tenant\Models\Payment\SubAgentApplicationPayment;
use App\Modules\Tenant\Models\Report\Report;
use App\Modules\Tenant\Models\User;
use Flash;
use DB;
use Carbon\Carbon;

use Illuminate\Http\Request;

class InvoiceReportController extends BaseController
{

    function __construct(Invoice $invoice, StudentInvoice $student_invoice, Report $report, Institute $institute, Request $request, CollegeInvoice $college_invoice, User $user, GroupInvoice $groupInvoice)
    {
        $this->invoice = $invoice;
        $this->student_invoice = $student_invoice;
        $this->college_invoice = $college_invoice;
        $this->report = $report;
        $this->institute = $institute;
        $this->request = $request;
        $this->user = $user;
        $this->groupInvoice = $groupInvoice;
        parent::__construct();
    }

    public function clientInvoicePending()
    {
        $data['invoice_reports'] = $this->student_invoice->getAll();
        return view("Tenant::InvoiceReport/ClientInvoice/invoice_pending", $data);
    }

    public function clientInvoicePaid()
    {
        $data['invoice_reports'] = $this->invoice->getInvoiceDetails();

        $data['date'] = Carbon::now();

        return view("Tenant::InvoiceReport/ClientInvoice/invoice_paid", $data);

    }


    public function clientInvoiceFuture()
    {
        $data['invoice_reports'] = $this->invoice->getInvoiceDetails();

        $data['date'] = Carbon::now();

        return view("Tenant::InvoiceReport/ClientInvoice/invoice_future", $data);
    }

    public function clientInvoiceSearch()
    {
        $data['status'] = [0 => 'All',
            1 => 'Pending',
            2 => 'Paid',
            3 => 'Future'];

        $data['colleges'] = $this->institute->getList();

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

    public function showGroupedInvoices($grouped_invoice_id)
    {
        $data['invoice_details'] = GroupInvoice::find($grouped_invoice_id);
        $data['invoice_reports'] = $this->groupInvoice->getInvocies($grouped_invoice_id); //dd($data['invoice_reports']->toArray());
        return view("Tenant::InvoiceReport/CollegeInvoice/show_grouped_invoices", $data);
    }

    public function collegeInvoiceSearch()
    {
        $data['status'] = [0 => 'All',
            1 => 'Pending',
            2 => 'Paid',
            3 => 'Future'];

        $data['colleges'] = $this->institute->getList();
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
        $data['payments'] = StudentApplicationPayment::leftJoin('client_payments', 'client_payments.client_payment_id', '=', 'student_application_payments.client_payment_id')
            ->leftJoin('clients', 'clients.client_id', '=', 'client_payments.client_id')
            ->leftJoin('persons', 'persons.person_id', '=', 'clients.person_id')
            ->leftJoin('payment_invoice_breakdowns', 'client_payments.client_payment_id', '=', 'payment_invoice_breakdowns.payment_id')
            ->select(['student_application_payments.student_payments_id', 'client_payments.*', 'payment_invoice_breakdowns.invoice_id', 'course_application_id', DB::raw('CONCAT(persons.first_name, " ", persons.last_name) AS client_name')])
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
        array_unshift($data['colleges'], 'All');

        $data['users'] = $this->user->getList();

        $data['search_attributes'] = array();
        if ($this->request->isMethod('post')) {
            $data['search_attributes'] = $this->request->all();
            Flash::success(count($data['applications']) . ' record(s) found.');
        }
        return view('Tenant::InvoiceReport/Payment/search', $data);
    }

    public function groupInvoice()
    {
        $data['search_attributes'] = array();
        $data['invoice_to_list'] = $this->college_invoice->getInvoiceToList()->toArray();
        array_unshift($data['invoice_to_list'], 'All');
        $data['colleges'] = $this->institute->getList();
        if ($this->request->isMethod('post')) {
            $data['search_attributes'] = $this->request->all();
            $data['invoice_reports'] = $this->college_invoice->getFilterResults($data['search_attributes']);
            Flash::success(count($data['invoice_reports']) . ' record(s) found.');
        } else {
            $data['invoice_reports'] = $this->college_invoice->getAll();
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


}//end of controller
