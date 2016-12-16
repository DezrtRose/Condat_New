<?php namespace App\Modules\Tenant\Controllers;

use App\Http\Requests;
use App\Modules\Tenant\Models\Setting;
use App\Modules\Tenant\Models\Agent;
use App\Modules\Tenant\Models\Payment\SubAgentApplicationPayment;
use App\Modules\Tenant\Models\Client\Client;
use App\Modules\Tenant\Models\Application\CourseApplication;
use App\Modules\Tenant\Models\Invoice\SubAgentInvoice;
use Flash;
use DB;
use Carbon;

use Illuminate\Http\Request;

class SubAgentController extends BaseController
{

    protected $request;/* Validation rules for user create and edit */
    protected $rules = [
        'amount' => 'required|numeric',
        'date_paid' => 'required',
        'payment_method' => 'required|min:2|max:45'
    ];

    function __construct(Client $client, Request $request, CourseApplication $application, SubAgentApplicationPayment $payment, SubAgentInvoice $invoice, Agent $agent, Setting $setting)
    {
        $this->client = $client;
        $this->request = $request;
        $this->application = $application;
        $this->invoice = $invoice;
        $this->payment = $payment;
        $this->agent = $agent;
        $this->setting = $setting;
        parent::__construct();
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($tenant_id, $application_id)
    {
        //$data['stats'] = $this->invoice->getStats($application_id);
        $data['application'] = $application = $this->application->getDetails($application_id);
        //$data['invoice_array'] = $this->invoice->getList($application_id);
        $data['client'] = $this->client->getDetails($application->client_id);
        return view("Tenant::SubAgent/Account/index", $data);
    }

    /*
     * Controllers for payment
     * */
    public function createPayment($tenant_id, $application_id)
    {
        $data['application_id'] = $application_id;
        return view("Tenant::SubAgent/Payment/add", $data);
    }

    public function storePayment($tenant_id, $application_id)
    {
        $this->validate($this->request, $this->rules);
        // if validates
        $created = $this->payment->add($this->request->all(), $application_id);
        if ($created) {
            Flash::success('Payment has been added successfully.');
            $payment = $this->payment->getDetails($created);
            $this->client->addLog($payment->client_id, 5, ['{{NAME}}' => get_tenant_name(), '{{TYPE}}' => $payment->payment_type, '{{DESCRIPTION}}' => $payment->description, '{{DATE}}' => format_date($payment->date_paid), '{{AMOUNT}}' => $payment->amount, '{{VIEW_LINK}}' => route('subagents.payment.view', [$tenant_id, $payment->subagent_payments_id])], $payment->course_application_id);
        }
        return redirect()->route('tenant.application.subagents', [$tenant_id, $application_id]);
    }

    public function editPayment($tenant_id, $payment_id)
    {
        $data['payment'] = $this->payment->getDetails($payment_id);
        return view("Tenant::SubAgent/Payment/edit", $data);
    }

    public function updatePayment($tenant_id, $payment_id)
    {
        $this->validate($this->request, $this->rules);

        $application_id = $this->payment->editPayment($this->request->all(), $payment_id);
        Flash::success('Payment has been updated successfully.');
        return redirect()->route('tenant.application.subagents', [$tenant_id, $application_id]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function createInvoice($tenant_id, $application_id)
    {
        $data['application_id'] = $application_id;
        return view("Tenant::SubAgent/Invoice/add", $data);
    }

    public function storeInvoice($tenant_id, $application_id)
    {
        $rules = [
            'invoice_amount' => 'required|numeric',
            'invoice_date' => 'required',
            'due_date' => 'required'
        ];
        $this->validate($this->request, $rules);
        // if validates
        $created = $this->invoice->add($this->request->all(), $application_id);
        if ($created) {
            Flash::success('Invoice has been created successfully.');
            $client_id = CourseApplication::find($application_id)->client_id;
            $invoice = SubAgentInvoice::join('invoices', 'invoices.invoice_id', '=', 'subagent_invoices.invoice_id')->find($created);
            $this->client->addLog($client_id, 4, ['{{NAME}}' => get_tenant_name(), '{{DESCRIPTION}}' => $invoice->description, '{{DATE}}' => format_date($invoice->invoice_date), '{{AMOUNT}}' => $invoice->amount, '{{VIEW_LINK}}' => route("tenant.subagents.invoice", $invoice->subagent_invoice_id)], $invoice->course_application_id);
        }
        return redirect()->route('tenant.application.subagents', [$tenant_id, $application_id]);
    }


    /**
     * Get all the payments through ajax request.
     *
     * @return JSON response
     */
    function getPaymentsData($tenant_id, $application_id)
    {
        $payments = SubAgentApplicationPayment::leftJoin('client_payments', 'client_payments.client_payment_id', '=', 'subagent_application_payments.client_payment_id')
            ->leftJoin('payment_invoice_breakdowns', 'client_payments.client_payment_id', '=', 'payment_invoice_breakdowns.payment_id')
            ->where('course_application_id', $application_id)
            ->select(['subagent_application_payments.subagent_payments_id', 'subagent_application_payments.course_application_id', 'payment_invoice_breakdowns.invoice_id', 'client_payments.*']);

        $datatable = \Datatables::of($payments)
            ->addColumn('action', function($data) use ($tenant_id) {
                return '<div class="btn-group">
                  <button class="btn btn-primary" type="button">Action</button>
                  <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul role="menu" class="dropdown-menu">
                    <li><a target="_blank" href="'.route('tenant.subagent.payments.receipt', [$tenant_id, $data->subagent_payments_id]).'">Print Receipt</a></li>
                    <li><a href="'.route("application.subagents.editPayment", [$tenant_id, $data->subagent_payments_id]).'">Edit</a></li>
                    <li><a href="'.route('application.subagent.deletePayment', [$tenant_id, $data->client_payment_id]).'">Delete</a></li>
                  </ul>
                </div>';
            })
            //->addColumn('invoice_id', 'Uninvoiced <button class="btn btn-success btn-xs"  data-toggle="modal" data-target="#invoiceModal"><i class="glyphicon glyphicon-plus-sign"></i> Assign to Invoice</button>')
            ->addColumn('invoice_id', function($data) use ($tenant_id) {
                if(empty($data->invoice_id) || $data->invoice_id == 0)
                    return 'Uninvoiced <a class="btn btn-success btn-xs" data-toggle="modal" data-target="#condat-modal" data-url="'.url($tenant_id.'/payment/'.$data->client_payment_id.'/'.$data->course_application_id.'/assign').'"><i class="glyphicon glyphicon-plus-sign"></i> Assign to Invoice</a>';
                else
                    return format_id($data->invoice_id, 'I');
            })
            ->editColumn('date_paid', function ($data) {
                return format_date($data->date_paid);
            })
            ->editColumn('subagent_payments_id', function ($data) {
                return format_id($data->subagent_payments_id, 'SAP');
            });
        return $datatable->make(true);
    }

    /**
     * Get all the invoices through ajax request.
     *
     * @return JSON response
     */
    function getInvoicesData($tenant_id, $application_id)
    {
        $invoices = SubAgentInvoice::join('invoices', 'subagent_invoices.invoice_id', '=', 'invoices.invoice_id')
            ->select(['invoices.*', 'subagent_invoices.subagent_invoice_id'])
            ->where('subagent_invoices.course_application_id', $application_id)
            ->orderBy('created_at', 'desc');
        $datatable = \Datatables::of($invoices)
            ->addColumn('action', function ($data) use ($tenant_id) {
                return '<div class="btn-group">
                  <button class="btn btn-primary" type="button">Action</button>
                  <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul role="menu" class="dropdown-menu">
                    <li><a href="'.route("tenant.invoice.payments", [$tenant_id, $data->invoice_id, 3]).'">View Payments</a></li>
                    <li><a href="http://localhost/condat/tenant/contact/2">View</a></li>
                    <li><a href="'.route("tenant.subagents.editInvoice", [$tenant_id, $data->subagent_invoice_id]).'">Edit</a></li>
                    <li><a href="http://localhost/condat/tenant/contact/2">Delete</a></li>
                  </ul>
                </div>';
            })
            ->addColumn('status', function ($data) {
                $outstanding = $this->invoice->getOutstandingAmount($data->invoice_id);
                return ($outstanding != 0) ? 'Outstanding' : 'Paid';
            })
            ->addColumn('outstanding_amount', function ($data) use ($tenant_id) {
                $outstanding = $this->invoice->getOutstandingAmount($data->invoice_id);
                if ($outstanding != 0)
                    return $outstanding . ' <a class="btn btn-success btn-xs" data-toggle="modal" data-target="#condat-modal" data-url="' . url($tenant_id.'/invoices/' . $data->invoice_id . '/payment/add/3') . '"><i class="glyphicon glyphicon-plus-sign"></i> Add Payment</a>';
                else
                    return 0;
            })
            ->editColumn('invoice_date', function ($data) {
                return format_date($data->invoice_date);
            })
            ->editColumn('invoice_id', function ($data) {
                return format_id($data->invoice_id, 'I');
            });
        return $datatable->make(true);
    }

    /**
     * Get all the invoices through ajax request.
     *
     * @return JSON response
     */
    function getFutureData($tenant_id, $application_id)
    {
        $invoices = SubAgentInvoice::join('invoices', 'subagent_invoices.invoice_id', '=', 'invoices.invoice_id')
            ->select(['invoices.*', 'subagent_invoices.subagent_invoice_id'])
            ->where('subagent_invoices.course_application_id', $application_id)
            ->where('invoice_date', '>=', Carbon\Carbon::now())
            ->orderBy('created_at', 'desc');
        $datatable = \Datatables::of($invoices)
            ->addColumn('action', function ($data) use ($tenant_id) {
                return '<div class="btn-group">
                  <button class="btn btn-primary" type="button">Action</button>
                  <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul role="menu" class="dropdown-menu">
                    <li><a href="'.route("tenant.invoice.payments", [$tenant_id, $data->invoice_id, 3]).'">View Payments</a></li>
                    <li><a href="http://localhost/condat/tenant/contact/2">View</a></li>
                    <li><a href="'.route("tenant.subagents.editInvoice", [$tenant_id, $data->subagent_invoice_id]).'">Edit</a></li>
                    <li><a href="http://localhost/condat/tenant/contact/2">Delete</a></li>
                  </ul>
                </div>';
            })
            ->addColumn('status', function ($data) {
                $outstanding = $this->invoice->getOutstandingAmount($data->invoice_id);
                return ($outstanding != 0) ? 'Outstanding' : 'Paid';
            })
            ->addColumn('outstanding_amount', function ($data) use ($tenant_id) {
                $outstanding = $this->invoice->getOutstandingAmount($data->invoice_id);
                if ($outstanding != 0)
                    return $outstanding . ' <a class="btn btn-success btn-xs" data-toggle="modal" data-target="#condat-modal" data-url="' . url($tenant_id.'/invoices/' . $data->invoice_id . '/payment/add/3') . '"><i class="glyphicon glyphicon-plus-sign"></i> Add Payment</a>';
                else
                    return 0;
            })
            ->editColumn('invoice_date', function ($data) {
                return format_date($data->invoice_date);
            })
            ->editColumn('invoice_id', function ($data) {
                return format_id($data->invoice_id, 'I');
            });
        return $datatable->make(true);
    }

    /**
     * Assign payment to invoice
     */
    function assignInvoice($tenant_id, $payment_id, $application_id)
    {
        $data['invoice_array'] = $this->invoice->getList($application_id);
        $data['payment_id'] = $payment_id;
        return view("Tenant::Client/Payment/assign", $data);
    }

    public function editInvoice($tenant_id, $invoice_id)
    {
        $data['invoice'] = $this->invoice->getDetails($invoice_id);
        return view("Tenant::SubAgent/Invoice/edit", $data);
    }

    public function updateInvoice($tenant_id, $invoice_id)
    {
        $rules = [
            'invoice_amount' => 'required|numeric',
            'invoice_date' => 'required',
            'due_date' => 'required'
        ];
        $this->validate($this->request, $rules);

        $application_id = $this->invoice->editInvoice($this->request->all(), $invoice_id);
        Flash::success('Invoice has been updated successfully.');
        return redirect()->route('tenant.application.subagents', [$tenant_id, $application_id]);
    }

    function printReceipt($tenant_id, $payment_id)
    {
        $data['agency'] = $this->agent->getAgentDetails();
        $data['bank'] = $this->setting->getBankDetails();
        $data['payment'] = $this->payment->getDetails($payment_id);
        $data['sub_agent_id'] = CourseApplication::find($data['payment']->course_application_id)->sub_agent_id;

        return view("Tenant::SubAgent/Payment/receipt", $data);
    }

    public function deletePayment($tenant_id, $payment_id)
    {
        $this->payment->deletePayment($payment_id);
        Flash::success('Payment has been deleted successfully.');
        return redirect()->back();
    }

}
