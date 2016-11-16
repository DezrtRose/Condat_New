<?php namespace App\Modules\Tenant\Controllers;

use App\Http\Requests;
use App\Modules\Tenant\Models\Application\CourseApplication;
use App\Modules\Tenant\Models\Application\StudentApplicationPayment;
use App\Modules\Tenant\Models\Client\Client;
use App\Modules\Tenant\Models\Client\ClientPayment;
use App\Modules\Tenant\Models\Invoice\Invoice;
use App\Modules\Tenant\Models\Invoice\StudentInvoice;
use Flash;
use DB;

use Illuminate\Http\Request;
use Carbon;

class AccountController extends BaseController
{

    protected $request;/* Validation rules for user create and edit */
    protected $rules = [
        'amount' => 'required|numeric',
        'date_paid' => 'required',
        'payment_method' => 'required|min:2|max:45'
    ];

    function __construct(Client $client, Request $request, ClientPayment $payment, StudentInvoice $invoice, CourseApplication $application)
    {
        $this->client = $client;
        $this->request = $request;
        $this->payment = $payment;
        $this->invoice = $invoice;
        $this->application = $application;
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($tenant_id, $client_id)
    {
        $data['client'] = $this->client->getDetails($client_id);
        return view("Tenant::Client/account_summary", $data);
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function createClientInvoice($tenant_id, $client_id)
    {
        $data['client_id'] = $client_id;
        $data['applications'] = $this->application->getClientApplication($client_id);
        return view("Tenant::Client/Invoice/add", $data);
    }

    public function storeClientInvoice($tenant_id, $client_id)
    {
        $rules = [
            'amount' => 'required|numeric',
            'invoice_amount' => 'required|numeric',
            'discount' => 'required|numeric',
            'invoice_date' => 'required',
            'due_date' => 'required'
        ];
        $this->validate($this->request, $rules);
        // if validates
        $created = $this->invoice->add($this->request->all(), $client_id);
        if ($created) {
            Flash::success('Invoice has been created successfully.');
            $invoice = StudentInvoice::join('invoices', 'invoices.invoice_id', '=', 'student_invoices.invoice_id')->find($created);
            $this->client->addLog($client_id, 4, ['{{NAME}}' => get_tenant_name(), '{{DESCRIPTION}}' => $invoice->description, '{{DATE}}' => format_date($invoice->invoice_date), '{{AMOUNT}}' => $invoice->amount, '{{VIEW_LINK}}' => route("tenant.student.invoice", [$tenant_id, $invoice->student_invoice_id])], $invoice->application_id);
        }
        return redirect()->route('tenant.accounts.index', [$tenant_id, $client_id]);
    }

    public function createClientPayment($tenant_id, $client_id)
    {
        $data['client_id'] = $client_id;
        return view("Tenant::Client/Payment/add", $data);
    }

    public function storeClientPayment($tenant_id, $client_id)
    {
        $this->validate($this->request, $this->rules);
        // if validates
        $created = $this->payment->add($this->request->all(), $client_id);
        if ($created) {
            Flash::success('Payment has been added successfully.');
            $payment = ClientPayment::find($created);
            $this->client->addLog($client_id, 5, ['{{NAME}}' => get_tenant_name(), '{{TYPE}}' => $payment->payment_type, '{{DESCRIPTION}}' => $payment->description, '{{DATE}}' => format_date($payment->date_paid), '{{AMOUNT}}' => $payment->amount, '{{VIEW_LINK}}' => '']);
        }
        return redirect()->route('tenant.accounts.index', [$tenant_id, $client_id]);
    }

    public function editClientPayment($tenant_id, $payment_id)
    {
        $data['payment'] = ClientPayment::find($payment_id);
        return view("Tenant::Client/Payment/edit", $data);
    }

    public function updateClientPayment($tenant_id, $payment_id)
    {
        $this->validate($this->request, $this->rules);
        $client_id = $this->payment->edit($this->request->all(), $payment_id);
        if ($client_id)
            Flash::success('Payment has been updated successfully.');
        return redirect()->route('tenant.accounts.index', [$tenant_id, $client_id]);
    }

    public function deleteClientPayment($tenant_id, $payment_id)
    {
        ClientPayment::find($payment_id)->delete();
        Flash::success('Payment has been deleted successfully.');
        return redirect()->back();
    }


    public function showClientInvoice()
    {
        return view("Tenant::Client/index");
    }


    public function showClientPayment()
    {
        return view("Tenant::Client/index");
    }


    /**
     * Get all the payments through ajax request.
     *
     * @return JSON response
     */
    function getPaymentsData($tenant_id, $client_id)
    {
        $payments = ClientPayment::leftJoin('payment_invoice_breakdowns', 'client_payments.client_payment_id', '=', 'payment_invoice_breakdowns.payment_id')
            ->whereIn('payment_type', config('constants.payment_by'))
            ->where('client_payments.client_id', $client_id)
            ->select(['client_payments.*', 'payment_invoice_breakdowns.invoice_id']);

        $datatable = \Datatables::of($payments)
            ->addColumn('action', function ($data) use ($tenant_id) {
                return '<div class="btn-group">
                  <button class="btn btn-primary" type="button">Action</button>
                  <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul role="menu" class="dropdown-menu">
                    <li><a href="' . route("client.payment.edit", [$tenant_id, $data->client_payment_id]) . '">Edit</a></li>
                    <li><a href="' . route("client.payment.delete", [$tenant_id, $data->client_payment_id]) . '" onclick="return confirm(\'Are you sure?\')">Delete</a></li>
                  </ul>
                </div>';
            })
            ->addColumn('invoice_id', function ($data) use ($tenant_id) {
                if (empty($data->invoice_id) || $data->invoice_id == 0)
                    return 'Uninvoiced <a class="btn btn-success btn-xs" data-toggle="modal" data-target="#condat-modal" data-url="' . url($tenant_id . '/account/payment/' . $data->client_payment_id . '/' . $data->client_id . '/assign') . '"><i class="glyphicon glyphicon-plus-sign"></i> Assign to Invoice</a>';
                else
                    return format_id($data->invoice_id, 'I');
            })
            ->editColumn('date_paid', function ($data) {
                return format_date($data->date_paid);
            })
            ->editColumn('client_payment_id', function ($data) {
                return format_id($data->client_payment_id, 'CP');
            });
        return $datatable->make(true);
    }

    /**
     * Assign payment to invoice
     */
    function assignInvoice($tenant_id, $payment_id, $client_id)
    {
        $data['invoice_array'] = $this->invoice->getListByClient($client_id);
        $data['payment_id'] = $payment_id;
        return view("Tenant::Client/Payment/assign", $data);
    }

    /**
     * Get all the invoices through ajax request.
     *
     * @return JSON response
     */
    function getInvoicesData($tenant_id, $client_id)
    {
        $invoices = StudentInvoice::join('invoices', 'student_invoices.invoice_id', '=', 'invoices.invoice_id')
            ->select(['invoices.*', 'student_invoices.student_invoice_id'])
            ->where('student_invoices.client_id', $client_id)
            ->select('student_invoices.student_invoice_id', 'invoices.invoice_id', 'invoices.invoice_date', 'invoices.description', 'invoices.invoice_amount', 'invoices.total_gst', DB::raw('(SELECT
    IF((invoices.`final_total` - SUM(client_payments.amount) > 0 OR ISNULL(SUM(client_payments.amount))), \'Outstanding\', \'Paid\')
  FROM
    client_payments 
    JOIN payment_invoice_breakdowns 
      ON payment_invoice_breakdowns.payment_id = client_payments.client_payment_id 
  WHERE payment_invoice_breakdowns.invoice_id = invoices.invoice_id) AS status'), DB::raw('(SELECT 
    CASE WHEN ((invoices.`final_total` - SUM(client_payments.amount) < 0))
    THEN 0
    WHEN (ISNULL(SUM(client_payments.amount)))
    THEN invoices.`final_total`
    ELSE
    (invoices.`final_total` - SUM(client_payments.amount)) END
  FROM
    client_payments 
    JOIN payment_invoice_breakdowns 
      ON payment_invoice_breakdowns.payment_id = client_payments.client_payment_id 
  WHERE payment_invoice_breakdowns.invoice_id = invoices.invoice_id) AS outstanding_amount'))/*->orderBy('created_at', 'desc')*/
        ;
        $datatable = \Datatables::of($invoices)
            ->addColumn('action', function ($data) use ($tenant_id) {
                return '<div class="btn-group">
                  <button class="btn btn-primary" type="button">Action</button>
                  <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul role="menu" class="dropdown-menu">
                    <li><a href="' . route("tenant.invoice.payments", [$tenant_id, $data->invoice_id, 2]) . '">View Payments</a></li>
                    <li><a href="' . route('tenant.student.invoice', [$tenant_id, $data->student_invoice_id]) . '">View Invoice</a></li>
                    <li><a href="' . route("tenant.student.editInvoice", [$tenant_id, $data->student_invoice_id]) . '">Edit</a></li>
                    <li><a type="button" data-toggle="modal" data-target="#deleteInvoice" id="'.$data->student_invoice_id.'" class="delete-invoice">Delete</a></li>
                  </ul>
                </div>';
            })
            /*->addColumn('status', function ($data) {
                $outstanding = $this->invoice->getOutstandingAmount($data->invoice_id);
                return ($outstanding != 0) ? 'Outstanding' : 'Paid';
            })
            ->addColumn('outstanding_amount', function ($data) {
                $outstanding = $this->invoice->getOutstandingAmount($data->invoice_id);
                if ($outstanding != 0)
                    return $outstanding . ' <a class="btn btn-success btn-xs" data-toggle="modal" data-target="#condat-modal" data-url="' . url('tenant/invoices/' . $data->invoice_id . '/payment/add/2') . '"><i class="glyphicon glyphicon-plus-sign"></i> Add Payment</a>';
                else
                    return 0;
            })*/
            ->editColumn('outstanding_amount', function ($data) use ($tenant_id) {
                if ($data->outstanding_amount != 0)
                    return format_price($data->outstanding_amount) . ' <a class="btn btn-success btn-xs" data-toggle="modal" data-target="#condat-modal" data-url="' . url($tenant_id . '/invoices/' . $data->invoice_id . '/payment/add/2') . '"><i class="glyphicon glyphicon-plus-sign"></i> Add Payment</a>';
                else
                    return format_price(0);
            })
            ->editColumn('invoice_date', function ($data) {
                return format_date($data->invoice_date);
            })
            ->editColumn('total_gst', function ($data) {
                return format_price($data->total_gst);
            })
            ->editColumn('invoice_amount', function ($data) {
                return format_price($data->invoice_amount);
            })
            ->editColumn('invoice_id', function ($data) {
                return format_id($data->invoice_id, 'I');
            });
        return $datatable->make(true);
    }

    /**
     * Get all the future invoices through ajax request.
     *
     * @return JSON response
     */
    function getFutureData($tenant_id, $client_id)
    {
        $invoices = StudentInvoice::join('invoices', 'student_invoices.invoice_id', '=', 'invoices.invoice_id')
            ->join('course_application', 'course_application.course_application_id', '=', 'student_invoices.application_id')
            ->where('course_application.client_id', $client_id)
            ->where('invoices.deleted_at', null)
            ->where('invoice_date', '>=', Carbon\Carbon::now())
            ->select(['invoices.*', 'student_invoices.student_invoice_id',])
            ->orderBy('invoices.created_at', 'desc');

        $datatable = \Datatables::of($invoices)
            ->addColumn('action', function ($data) use ($tenant_id) {
                return '<div class="btn-group">
                  <button class="btn btn-primary" type="button">Action</button>
                  <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul role="menu" class="dropdown-menu">
                    <li><a href="' . route("tenant.invoice.payments", [$tenant_id, $data->invoice_id, 2]) . '">View Payments</a></li>
                    <li><a href="' . route('tenant.student.invoice', [$tenant_id, $data->student_invoice_id]) . '">View Invoice</a></li>
                    <li><a href="' . route("tenant.student.editInvoice", [$tenant_id, $data->student_invoice_id]) . '">Edit</a></li>
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
                    return $outstanding . ' <a class="btn btn-success btn-xs" data-toggle="modal" data-target="#condat-modal" data-url="' . url($tenant_id . '/invoices/' . $data->invoice_id . '/payment/add/2') . '"><i class="glyphicon glyphicon-plus-sign"></i> Add Payment</a>';
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
     * Display the specified resource.
     *
     * @param  int $client_payment_id
     * @return Response
     */
    public function show($tenant_id, $client_id)
    {
        $data['client'] = $this->client->getDetails($client_id);
        return view("Tenant::Client/show", $data);
    }

    public function personal_details($tenant_id, $client_id)
    {
        $data['client'] = $this->client->getDetails($client_id);
        return view("Tenant::Client/personal_details", $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function editInvoice($tenant_id, $invoice_id)
    {
        $data['invoice'] = $invoice = $this->invoice->getDetails($invoice_id);
        $data['client_id'] = $invoice->client_id;
        $data['applications'] = $this->application->getClientApplication($data['client_id']);

        return view("Tenant::Client/Invoice/edit", $data);
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
        return redirect()->route('tenant.application.students', [$tenant_id, $application_id]);
    }

}
