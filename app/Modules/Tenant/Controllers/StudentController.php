<?php namespace App\Modules\Tenant\Controllers;

use App\Http\Requests;
use App\Modules\Tenant\Models\Application\StudentApplicationPayment;
use App\Modules\Tenant\Models\Client\Client;
use App\Modules\Tenant\Models\Application\CourseApplication;
use App\Modules\Tenant\Models\Client\ClientPayment;
use App\Modules\Tenant\Models\Email;
use App\Modules\Tenant\Models\Invoice\CollegeInvoicePayment;
use App\Modules\Tenant\Models\Invoice\Invoice;
use App\Modules\Tenant\Models\Invoice\StudentInvoice;
use App\Modules\Tenant\Models\Agent;
use App\Modules\Tenant\Models\Payment\CollegePayment;
use App\Modules\Tenant\Models\Setting;
use Flash;
use DB;
use PDF;
use Carbon;

use Illuminate\Http\Request;

class StudentController extends BaseController
{

    protected $request;/* Validation rules for user create and edit */
    protected $rules = [
        'amount' => 'required|numeric',
        'date_paid' => 'required',
        'payment_method' => 'required|min:2|max:45'
    ];

    function __construct(Client $client, Request $request, CourseApplication $application, StudentApplicationPayment $payment, StudentInvoice $invoice, Agent $agent, Setting $setting)
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
        $data['stats'] = $this->invoice->getStats($application_id);
        $data['application'] = $application = $this->application->getDetails($application_id);
        $data['client'] = $this->client->getDetails($application->client_id);
        return view("Tenant::Student/Account/index", $data);
    }

    /*
     * Controllers for payment
     * */
    public function createPayment($tenant_id, $application_id)
    {
        $data['application_id'] = $application_id;
        return view("Tenant::Student/Payment/add", $data);
    }

    public function storePayment($tenant_id, $application_id)
    {
        $this->validate($this->request, $this->rules);
        // if validates
        $created = $this->payment->add($this->request->all(), $application_id);
        if ($created) {
            Flash::success('Payment has been added successfully.');
            $payment = $this->payment->getDetails($created);
            $this->client->addLog($payment->client_id, 5, ['{{NAME}}' => get_tenant_name(), '{{TYPE}}' => $payment->payment_type, '{{DESCRIPTION}}' => $payment->description, '{{DATE}}' => format_date($payment->date_paid), '{{AMOUNT}}' => $payment->amount, '{{VIEW_LINK}}' => url($tenant_id."/students/payment/receipt/" . $payment->client_payment_id)], $payment->course_application_id);
        }
        return redirect()->route('tenant.application.students', [$tenant_id, $application_id]);
    }

    public function editPayment($tenant_id, $payment_id)
    {
        $data['payment'] = $this->payment->getStudentPaymentDetails($payment_id);
        return view("Tenant::Student/Payment/edit", $data);
    }

    public function updatePayment($tenant_id, $payment_id)
    {
        $this->validate($this->request, $this->rules);

        $application_id = $this->payment->editPayment($this->request->all(), $payment_id);
        Flash::success('Payment has been updated successfully.');
        return redirect()->route('tenant.application.students', [$tenant_id, $application_id]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function createInvoice($tenant_id, $application_id)
    {
        $data['application_id'] = $application_id;
        return view("Tenant::Student/Invoice/add", $data);
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
        $request = $this->request->all();
        $request['application_id'] = $application_id;
        $client_id = CourseApplication::find($application_id)->client_id;
        $created = $this->invoice->add($request, $client_id);
        if ($created) {
            Flash::success('Invoice has been created successfully.');
            $invoice = StudentInvoice::join('invoices', 'invoices.invoice_id', '=', 'student_invoices.invoice_id')->find($created);
            $this->client->addLog($client_id, 4, ['{{NAME}}' => get_tenant_name(), '{{DESCRIPTION}}' => $invoice->description, '{{DATE}}' => format_date($invoice->invoice_date), '{{AMOUNT}}' => $invoice->amount, '{{VIEW_LINK}}' => route("tenant.student.invoice", [$tenant_id, $invoice->student_invoice_id])], $invoice->application_id);
        }
        return redirect()->route('tenant.application.students', [$tenant_id, $application_id]);
    }


    /**
     * Get all the payments through ajax request.
     *
     * @return JSON response
     */
    function getPaymentsData($tenant_id, $application_id)
    {
        $payments = StudentApplicationPayment::leftJoin('client_payments', 'client_payments.client_payment_id', '=', 'student_application_payments.client_payment_id')
            ->leftJoin('payment_invoice_breakdowns', 'client_payments.client_payment_id', '=', 'payment_invoice_breakdowns.payment_id')
            ->where('course_application_id', $application_id)
            ->select(['student_application_payments.student_payments_id', 'client_payments.*', 'payment_invoice_breakdowns.invoice_id', 'course_application_id']);

        $datatable = \Datatables::of($payments)
            ->addColumn('action', function ($data) use ($tenant_id) {
                return '<div class="btn-group">
                  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Action <span class="caret"></span>
                  </button>
                  <ul role="menu" class="dropdown-menu">
                    <li><a href="' . url($tenant_id . "/students/payment/receipt/" . $data->client_payment_id) . '" target="_blank">Print Receipt</a></li>
                    <li><a href="' . route("application.students.editPayment", [$tenant_id, $data->student_payments_id]) . '">Edit</a></li>
                    <li><a href="' . route("application.students.deletePayment", [$tenant_id, $data->client_payment_id]) . '" onclick="return confirm(\'Are you sure?\')">Delete</a></li>
                  </ul>
                </div>';
            })
            ->addColumn('invoice_id', function ($data) use ($tenant_id) {
                if (empty($data->invoice_id) || $data->invoice_id == 0)
                    return 'Uninvoiced <a class="btn btn-success btn-xs" data-toggle="modal" data-target="#condat-modal" data-url="' . url($tenant_id . '/student/payment/' . $data->client_payment_id . '/' . $data->course_application_id . '/assign') . '"><i class="glyphicon glyphicon-plus-sign"></i> Assign to Invoice</a>';
                else
                    return format_id($data->invoice_id, 'I');
            })
            ->editColumn('date_paid', function ($data) {
                return format_date($data->date_paid);
            })
            ->editColumn('student_payments_id', function ($data) {
                return format_id($data->client_payment_id, 'CP');
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
        /*$invoices = StudentInvoice::join('course_application', 'course_application.course_application_id', '=', 'college_invoices.course_application_id')
            ->where('course_application.course_application_id', $application_id)
            ->select(['college_invoices.*'])
            ->orderBy('college_invoices.created_at', 'desc');*/

        $invoices = StudentInvoice::join('invoices', 'student_invoices.invoice_id', '=', 'invoices.invoice_id')
            ->select(['invoices.*', 'student_invoices.student_invoice_id'])
            ->where('student_invoices.application_id', $application_id)
            ->where('invoices.deleted_at', null)
            ->where('invoices.deleted_at', null);
        $datatable = \Datatables::of($invoices)
            ->addColumn('action', function ($data) use ($tenant_id) {
                return '<div class="btn-group">
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Action <span class="caret"></span>
                  </button>
                  <ul role="menu" class="dropdown-menu">
                    <li><a href="' . route("tenant.invoice.payments", [$tenant_id, $data->invoice_id, 2]) . '">View Payments</a></li>
                    <li><a href="' . route('tenant.student.invoice', [$tenant_id, $data->student_invoice_id]) . '" target="_blank">Print Invoice</a></li>
                    <li><a href="' . route('tenant.student.pdf', [$tenant_id, $data->student_invoice_id]) . '" target="_blank">Download PDF</a></li>
                    <li><a href="#" data-toggle="modal" data-target="#condat-modal" data-url="' . route('tenant.student.mail', [$tenant_id, $data->student_invoice_id]) . '">Mail Invoice</a></li>
                    <li><a href="' . route("tenant.student.editInvoice", [$tenant_id, $data->student_invoice_id]) . '">Edit</a></li>
                    <li><a type="button" data-toggle="modal" data-target="#deleteInvoice" id="'.$data->invoice_id.'" class="delete-invoice">Delete</a></li>
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
                    return format_price($outstanding) . ' <a class="btn btn-success btn-xs" data-toggle="modal" data-target="#condat-modal" data-url="' . url($tenant_id . '/invoices/' . $data->invoice_id . '/payment/add/2') . '"><i class="glyphicon glyphicon-plus-sign"></i> Add Payment</a>';
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
            ->editColumn('discount', function ($data) {
                return format_price($data->discount);
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
    function getRecentData($tenant_id, $application_id)
    {
        /*$invoices = StudentInvoice::join('course_application', 'course_application.course_application_id', '=', 'college_invoices.course_application_id')
            ->where('course_application.course_application_id', $application_id)
            ->select(['college_invoices.*'])
            ->orderBy('college_invoices.created_at', 'desc');*/

        $invoices = StudentInvoice::join('invoices', 'student_invoices.invoice_id', '=', 'invoices.invoice_id')
            ->select(['invoices.*', 'student_invoices.student_invoice_id'])
            ->where('invoice_date', '>=', Carbon\Carbon::now())
            ->where('student_invoices.application_id', $application_id)
            ->where('invoices.deleted_at', null);
        $datatable = \Datatables::of($invoices)
            ->addColumn('action', function ($data) use ($tenant_id) {
                return '<div class="btn-group">
                  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Action <span class="caret"></span>
                  </button>
                  <ul role="menu" class="dropdown-menu">
                    <li><a href="' . route("tenant.invoice.payments", [$tenant_id, $data->student_invoice_id, 2]) . '">View payments</a></li>
                    <li><a href="' . route('tenant.student.invoice', [$tenant_id, $data->student_invoice_id]) . '">Print Invoice</a></li>
                    <li><a href="' . route("tenant.student.editInvoice", [$tenant_id, $data->student_invoice_id]) . '">Edit</a></li>
                    <li><a href="' . route("tenant.student.deleteInvoice", [$tenant_id, $data->invoice_id]) . '" onclick="return confirm(\'Are you sure you want to delete the record?\')">Delete</a></li>
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
                    return format_price($outstanding) . ' <a class="btn btn-success btn-xs" data-toggle="modal" data-target="#condat-modal" data-url="' . url($tenant_id . '/invoices/' . $data->invoice_id . '/payment/add/2') . '"><i class="glyphicon glyphicon-plus-sign"></i> Add Payment</a>';
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
            ->editColumn('discount', function ($data) {
                return format_price($data->discount);
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

    function printReceipt($tenant_id, $payment_id)
    {
        $data['agency'] = $this->agent->getAgentDetails();
        $data['bank'] = $this->setting->getBankDetails();
        $data['payment'] = $this->payment->getDetails($payment_id);

        return view("Tenant::Student/Payment/receipt", $data);
    }

    function downloadPdf($tenant_id, $invoice_id)
    {
        $data['agency'] = $this->agent->getAgentDetails();
        $data['bank'] = $this->setting->getBankDetails();
        $data['invoice'] = $invoice = $this->invoice->getDetails($invoice_id);
        $details = $this->getCompanyDetails();
        if(!isset($details['abn'])){
            if(!$this->checkAuthority()) {
                Flash::error('Company details have not been stored yet. Please contact the system administrator to proceed further.');
                return redirect()->route('tenant.application.students', [$tenant_id, $invoice->application_id]);
            } else {
                Flash::error('Company details have not been stored yet. Please fill out the form and save it to proceed further.');
                return redirect()->route('tenant.company.edit', $tenant_id);
            }
        }
        //$data['client_name'] = $this->application->getClientName($invoice->course_application_id);
        $data['pay_details'] = $this->invoice->getPayDetails($invoice->invoice_id);
        $pdf = PDF::loadView('Tenant::Student/Invoice/pdf', $data);
        return $pdf->stream();
        //return $pdf->download('invoice.pdf');

        //return view("Tenant::Student/Payment/receipt", $data);
    }

    public function show($tenant_id, $invoice_id)
    {
        $data['agency'] = $this->agent->getAgentDetails();
        $data['bank'] = $this->setting->getBankDetails();
        $data['invoice'] = $invoice = $this->invoice->getDetails($invoice_id);
        if (empty($invoice))
            abort(404);
        $details = $this->getCompanyDetails();
        if(!isset($details['abn'])){
            if(!$this->checkAuthority()) {
                Flash::error('Company details have not been stored yet. Please contact the system administrator to proceed further.');
                return redirect()->route('tenant.application.students', [$tenant_id, $invoice->application_id]);
            } else {
                Flash::error('Company details have not been stored yet. Please fill out the form and save it to proceed further.');
                return redirect()->route('tenant.company.edit', $tenant_id);
            }
        }
        //$data['client_name'] = $this->application->getClientName($invoice->course_application_id);
        $data['pay_details'] = $this->invoice->getPayDetails($invoice->invoice_id);
        return view("Tenant::Student/Invoice/show", $data);
    }

    public function editInvoice($tenant_id, $invoice_id)
    {
        $data['invoice'] = $this->invoice->getDetails($invoice_id);
        return view("Tenant::Student/Invoice/edit", $data);
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
        if($application_id == 0 || $application_id == null) {
            $client_id = StudentInvoice::find($invoice_id)->client_id;
            return redirect()->route('tenant.accounts.index', [$tenant_id, $client_id]);
        }
        else
            return redirect()->route('tenant.application.students', [$tenant_id, $application_id]);
    }

    public function deleteInvoice($tenant_id, $invoice_id)
    {
        $this->invoice->deleteInvoice($invoice_id, true);
        Flash::success('Invoice and payments have been deleted successfully.');
        return redirect()->back();
    }

    public function deleteInvoiceOnly($tenant_id, $invoice_id)
    {
        $this->invoice->deleteInvoice($invoice_id, false);
        Flash::success('Invoice has been deleted successfully.');
        return redirect()->back();
    }

    public function deletePayment($tenant_id, $payment_id)
    {
        $this->payment->deletePayment($payment_id);
        Flash::success('Payment has been deleted successfully.');
        return redirect()->back();
    }

    function mailPdf($tenant_id, $invoice_id)
    {
        $data['email_list'] = Email::where('email', '!=', '')->lists('email', 'email');
        $data['student'] = $this->invoice->getStudentDetails($invoice_id);
        $data['invoice'] = $this->invoice->getDetails($invoice_id);
        return view("Tenant::Student/Invoice/mail", $data);
    }

    function postMailPdf($tenant_id, $invoice_id)
    {
        $rules = [
            'to' => 'required|array|min:1',
            'subject' => 'required',
        ];
        $request_array = $this->request->all(); //dd($request_array);
        $validator = \Validator::make($request_array, $rules);
        if ($validator->fails())
            return $this->fail(['errors' => $validator->getMessageBag()->toArray()]);

        /*if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }*/

        $data['agency'] = $this->agent->getAgentDetails();
        $data['bank'] = $this->setting->getBankDetails();
        $data['invoice'] = $invoice = $this->invoice->getDetails($invoice_id);
        $details = $this->getCompanyDetails();
        if(!isset($details['abn'])){
            if(!$this->checkAuthority()) {
                Flash::error('Company details have not been stored yet. Please contact the system administrator to proceed further.');
                return redirect()->route('tenant.application.students', [$tenant_id, $invoice->application_id]);
            } else {
                Flash::error('Company details have not been stored yet. Please fill out the form and save it to proceed further.');
                return redirect()->route('tenant.company.edit', $tenant_id);
            }
        }
        //$data['client_name'] = $this->application->getClientName($invoice->course_application_id);
        $data['pay_details'] = $this->invoice->getPayDetails($invoice->invoice_id);
        $pdf = PDF::loadView('Tenant::Student/Invoice/pdf', $data);
        $newPdf =  $pdf->stream();

        $company_name = (isset($details['company_name']) && $details['company_name'] != '')? $details['company_name'] : 'Condat Solutions';

        $content = <<<EOD
<strong>Dear {$invoice->client_name}, </strong>
<p>You've received a mail for student invoice. <br/>
Please refer the attached document for more details.</p>
<p>
Regards,<br>
{$company_name}<br>
</p>
EOD;

        $param = ['content' => $request_array['body'],
            'subject' => $request_array['subject'],
            'heading' => $company_name,
            'subheading' => 'All your business in one space',
        ];

        $mail = \Mail::send('template.master', $param, function($message) use ($newPdf, $invoice, $request_array, $details)
        {
            $message->to($request_array['to']);
            if(isset($request_array['cc']))
                $message->cc($request_array['cc']);
            if(isset($request_array['sendBcc']) && $request_array['sendBcc'] == 'on')
                $message->bcc($this->current_user()->email);
            $message->subject($request_array['subject']);
            //$message->from($this->current_user()->email, $details['company_name']);
            $message->from('noreply@condat.com.au', $details['company_name']);
            $message->attachData($newPdf, format_id($invoice->invoice_id, 'I').'.pdf', ['mime' => 'application/pdf']);
            if(isset($details['email']))
                $message->replyTo($details['email'], $details['company_name']);
        });

        if($mail)
            Flash::success('Mail has been sent successfully.');
        else
            Flash::error('An error encountered while sending the mail. Please try again later.');

        return $this->success(['message' => 'Process Complete!']);
        //return redirect()->route('tenant.application.students', [$tenant_id, $invoice->application_id]);
    }

}
