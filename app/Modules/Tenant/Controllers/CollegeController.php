<?php namespace App\Modules\Tenant\Controllers;

use App\Http\Requests;
use App\Modules\Tenant\Models\Course\Course;
use App\Modules\Tenant\Models\Email;
use App\Modules\Tenant\Models\Institute\InstituteAddress;
use App\Modules\Tenant\Models\Setting;
use App\Modules\Tenant\Models\Agent;
use App\Modules\Tenant\Models\Client\Client;
use App\Modules\Tenant\Models\Application\CourseApplication;
use App\Modules\Tenant\Models\Institute\Institute;
use App\Modules\Tenant\Models\Invoice\CollegeInvoice;
use App\Modules\Tenant\Models\Payment\CollegePayment;
use App\Modules\Agency\Models\Agency;
use Carbon;
use Flash;
use DB;
use PDF;

use Illuminate\Http\Request;

class CollegeController extends BaseController
{

    protected $request;/* Validation rules for user create and edit */
    protected $rules = [
        'amount' => 'required|numeric',
        'date_paid' => 'required',
        'payment_method' => 'required|min:2|max:45'
    ];

    function __construct(Client $client, Request $request, CourseApplication $application, CollegePayment $payment, CollegeInvoice $invoice, Agency $agency, Agent $agent, Setting $setting, Course $course)
    {
        $this->client = $client;
        $this->request = $request;
        $this->application = $application;
        $this->invoice = $invoice;
        $this->payment = $payment;
        $this->agency = $agency;
        $this->agent = $agent;
        $this->setting = $setting;
        $this->course = $course;
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
        $data['invoices'] = $this->invoice->getInvoicesData($application_id);
        $data['future_invoices'] = $this->invoice->getInvoicesData($application_id, true);
        $data['application'] = $application = $this->application->getDetails($application_id);
        $data['client'] = $this->client->getDetails($application->client_id);
        return view("Tenant::College/Account/index", $data);
    }

    /*
     * Controllers for payment
     * */
    public function createPayment($tenant_id, $application_id, $type = 1)
    {
        $data['application_id'] = $application_id;
        $data['pay_type'] = $type;
        return view("Tenant::College/Payment/add", $data);
    }

    public function editPayment($tenant_id, $payment_id)
    {
        $data['payment'] = $this->payment->getDetails($payment_id);
        $data['pay_type'] = 1; // Can change to any payment type
        return view("Tenant::College/Payment/edit", $data);
    }

    public function updatePayment($tenant_id, $payment_id)
    {
        $this->validate($this->request, $this->rules);

        $application_id = $this->payment->editPayment($this->request->all(), $payment_id);
        Flash::success('Payment has been updated successfully.');
        return redirect()->route('tenant.application.college', [$tenant_id, $application_id]);
    }

    public function storePayment($tenant_id, $application_id)
    {
        $this->validate($this->request, $this->rules);
        // if validates
        $created = $this->payment->add($this->request->all(), $application_id);
        if ($created) {
            Flash::success('Payment has added successfully.');
            $payment = $this->payment->getDetails($created);
            $client_id = CourseApplication::find($application_id)->client_id;
            $this->client->addLog($client_id, 5, ['{{NAME}}' => get_tenant_name(), '{{TYPE}}' => $payment->payment_type, '{{DESCRIPTION}}' => $payment->description, '{{DATE}}' => format_date($payment->date_paid), '{{AMOUNT}}' => $payment->amount, '{{VIEW_LINK}}' => url($tenant_id. "/college/payment/receipt/" . $payment->college_payment_id)], $application_id);
        }
        //return redirect()->back();
        return redirect()->route('tenant.application.college', [$tenant_id, $application_id]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function createInvoice($tenant_id, $application_id)
    {
        $data['application_id'] = $application_id;
        $app = CourseApplication::find($application_id);
        if(!empty($app)) {
            $course_id = $app->institution_course_id;
            $course = $this->course->getDetails($course_id);
            $data['commission_percent'] = (!empty($course)) ? $course->commission_percent : 0;
        }
        return view("Tenant::College/Invoice/add", $data);
    }

    public function printInvoice($tenant_id, $invoice_id)
    {
        $data['agency'] = $this->agency->getAgencyDetails('33');
        $data['invoice_id'] = $invoice_id;
        return view("Tenant::College/Invoice/print_invoice", $data);
    }

    function downloadPdf($tenant_id, $invoice_id)
    {
        $data['agency'] = $this->agent->getAgentDetails();
        $data['bank'] = $this->setting->getBankDetails();
        $data['invoice'] = $invoice = $this->invoice->getDetails($invoice_id);
        if (empty($invoice))
            abort(404);
        $data['client_name'] = $this->application->getClientName($invoice->course_application_id);
        $data['pay_details'] = $this->invoice->getPayDetails($invoice_id);
        $super_agent = CourseApplication::find($invoice->course_application_id)->super_agent_id;
        if($super_agent != null && $super_agent != 0)
            $data['invoice_to'] = get_agent_name($super_agent);
        else
            $data['invoice_to'] = $data['invoice']->invoice_to_name;

        $details = $this->getCompanyDetails();
        if(!isset($details['abn'])){
            if(!$this->checkAuthority()) {
                Flash::error('Company details have not been stored yet. Please contact the system administrator to proceed further.');
                return redirect()->route('tenant.application.college', [$tenant_id, $invoice->course_application_id]);
            } else {
                Flash::error('Company details have not been stored yet. Please fill out the form and save it to proceed further.');
                return redirect()->route('tenant.company.edit', $tenant_id);
            }
        }
        $data['pay_details'] = $this->invoice->getPayDetails($invoice->invoice_id);
        $pdf = PDF::loadView('Tenant::College/Invoice/pdf', $data);
        return $pdf->stream();
        //return $pdf->download('invoice.pdf');
    }


    public function storeInvoice($tenant_id, $application_id)
    {
        $rules = [
            'tuition_fee' => 'required|numeric',
            'enrollment_fee' => 'required|numeric',
            'material_fee' => 'required|numeric',
            'coe_fee' => 'required|numeric',
            'other_fee' => 'required|numeric',
            'sub_total' => 'required|numeric',
            'commission_percent' => 'required|numeric',
            'commission_amount' => 'required|numeric',
            'tuition_fee_gst' => 'required|numeric',
            'incentive' => 'required|numeric',
            'incentive_gst' => 'required|numeric',
            'total_commission' => 'required|numeric',
            'invoice_date' => 'required'
        ];
        $this->validate($this->request, $rules);

        $invoice_id = $this->storeInvFunc($tenant_id, $application_id);
        if($this->request->input('submit') == 'Submit') {
            return redirect()->route('tenant.application.college', [$tenant_id, $application_id]);
        } else {
            return redirect()->route('tenant.college.moreInvoice', [$tenant_id, $invoice_id]);
        }
    }

    function storeInvFunc($tenant_id, $application_id)
    {
        $request = $this->request->all();
        // if validates
        $created = $this->invoice->add($request, $application_id);
        if ($created) {
            Flash::success('Invoice has created successfully.');
            $invoice = CollegeInvoice::find($created);
            $client_id = $this->invoice->getClientId($created);
            $this->client->addLog($client_id, 4, ['{{NAME}}' => get_tenant_name(), '{{DESCRIPTION}}' => 'College Invoice', '{{DATE}}' => format_date($invoice->invoice_date), '{{AMOUNT}}' => $invoice->total_commission, '{{VIEW_LINK}}' => route('tenant.college.invoice', [$tenant_id, $invoice->college_invoice_id])], $application_id);
        }
        return $created;
    }


    /**
     * Get all the payments through ajax request.
     *
     * @return JSON response
     */
    function getPaymentsData($tenant_id, $application_id)
    {
        $payments = CollegePayment::where('course_application_id', $application_id)
            ->leftJoin('college_invoice_payments', 'college_payments.college_payment_id', '=', 'college_invoice_payments.ci_payment_id')
            ->select(['college_payments.*', 'college_invoice_payments.college_invoice_id']);

        $datatable = \Datatables::of($payments)
            ->addColumn('action', function ($data) use ($tenant_id) {
                return '<div class="btn-group">
                  <button class="btn btn-primary" type="button">Action</button>
                  <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul role="menu" class="dropdown-menu">
                    <li><a href="'.route('tenant.college.payment.receipt', [$tenant_id, $data->college_payment_id]).'" target="_blank">Print Receipt</a></li>
                    <li><a href="'.route("tenant.application.editPayment", [$tenant_id, $data->college_payment_id]).'">Edit</a></li>
                    <li><a href="'.route("tenant.college.payment.delete", [$tenant_id, $data->college_payment_id]).'" onclick="return confirm(\'Are you sure?\')">Delete</a></li>
                  </ul>
                </div>';
            })
            ->addColumn('invoice_id', function ($data) use($tenant_id) {
                if ((empty($data->college_invoice_id) || $data->college_invoice_id == 0) && $data->payment_type == 'College / Super Agent to Company')
                    return 'Uninvoiced <a class="btn btn-success btn-xs" data-toggle="modal" data-target="#condat-modal" data-url="' . url($tenant_id.'/college/payment/' . $data->college_payment_id . '/' . $data->course_application_id . '/assign') . '"><i class="glyphicon glyphicon-plus-sign"></i> Assign to Invoice</a>';
                elseif ($data->payment_type == 'College / Super Agent to Company' || $data->payment_type == 'Pre Claimed Commission')
                    return format_id($data->college_invoice_id, 'CI');
                else
                    return 'Cannot Be Assigned';
            })
            ->editColumn('date_paid', function ($data) {
                return format_date($data->date_paid);
            })
            ->editColumn('college_payment_id', function ($data) {
                return format_id($data->college_payment_id, 'CP');
            });
        return $datatable->make(true);
    }

    public function deletePayment($tenant_id, $payment_id)
    {
        $course_application_id = $this->payment->deletePayment($payment_id);
        Flash::success('Payment has been deleted successfully.');
        return redirect()->route('tenant.application.college', [$tenant_id, $course_application_id]);
    }

    public function show($tenant_id, $invoice_id)
    {
        $data['agency'] = $this->agent->getAgentDetails();
        $data['bank'] = $this->setting->getBankDetails();
        $data['invoice'] = $invoice = $this->invoice->getDetails($invoice_id); //dd($data['invoice']->toArray());
        if (empty($invoice))
            abort(404);
        $data['client_name'] = $this->application->getClientName($invoice->course_application_id);
        $data['pay_details'] = $this->invoice->getPayDetails($invoice_id);
        $super_agent = CourseApplication::find($invoice->course_application_id)->super_agent_id;
        if($super_agent != null && $super_agent != 0)
            $data['invoice_to'] = get_agent_name($super_agent);
        else
            $data['invoice_to'] = $data['invoice']->invoice_to_name;

        $details = $this->getCompanyDetails();
        if(!isset($details['abn'])){
            if(!$this->checkAuthority()) {
                Flash::error('Company details have not been stored yet. Please contact the system administrator to proceed further.');
                return redirect()->route('tenant.application.college', [$tenant_id, $invoice->course_application_id]);
            } else {
                Flash::error('Company details have not been stored yet. Please fill out the form and save it to proceed further.');
                return redirect()->route('tenant.company.edit', $tenant_id);
            }
        }

        return view("Tenant::College/Invoice/show", $data);
    }

    /**
     * Assign payment to invoice
     */
    function assignInvoice($tenant_id, $payment_id, $application_id)
    {
        $data['invoice_array'] = $this->invoice->getList($application_id);
        $data['payment_id'] = $payment_id;
        $data['college'] = true;
        return view("Tenant::Client/Payment/assign", $data);
    }

    public function editInvoice($tenant_id, $invoice_id)
    {
        $data['invoice'] = $this->invoice->getDetails($invoice_id); //dd($data['invoice']->toArray());
        return view("Tenant::College/Invoice/edit", $data);
    }

    public function updateInvoice($tenant_id, $invoice_id)
    {
        $rules = [
            'tuition_fee' => 'required|numeric',
            'invoice_date' => 'required'
        ];
        $this->validate($this->request, $rules);

        $application_id = $this->invoice->editInvoice($this->request->all(), $invoice_id);
        Flash::success('Invoice has been updated successfully.');
        return redirect()->route('tenant.application.college', [$tenant_id, $application_id->course_application_id]);
    }

    function printReceipt($tenant_id, $payment_id)
    {
        $data['agency'] = $this->agent->getAgentDetails();
        $data['bank'] = $this->setting->getBankDetails();
        $data['payment'] = $this->payment->getDetails($payment_id);

        return view("Tenant::Student/Payment/receipt", $data);
    }

    function createMoreInvoice($tenant_id, $invoice_id)
    {
        $data['invoice'] = $this->invoice->getDetails($invoice_id);
        return view("Tenant::College/Invoice/more", $data);
    }

    function createMoreInvoice1($tenant_id, $application_id)
    {
        $invoice_id = $this->storeInvFunc($tenant_id, $application_id);
        $data['invoice'] = $this->invoice->getDetails($invoice_id);
        return view("Tenant::College/Invoice/more", $data);
    }

    function storeMoreInvoice($tenant_id, $application_id)
    {
        $rules = [
            'start_date' => 'required'
        ];
        $this->validate($this->request, $rules);
        $request = $this->request->all();
        // if validates
        $created = $this->invoice->addMore($request, $application_id, $tenant_id);
        if ($created) {
            Flash::success('Multiple Invoices have been created successfully.');
        }
        return redirect()->route('tenant.application.college', [$tenant_id, $application_id]);
    }

    public function deleteInvoice($tenant_id, $college_invoice_id)
    {
        $course_application_id = $this->invoice->deleteInvoice($college_invoice_id, true);
        Flash::success('Invoice has been deleted successfully.');
        return redirect()->route('tenant.application.college', [$tenant_id, $course_application_id]);
    }

    public function deleteInvoiceOnly($tenant_id, $invoice_id)
    {
        $course_application_id = $this->invoice->deleteInvoice($invoice_id, false);
        Flash::success('Invoice has been deleted successfully.');
        return redirect()->route('tenant.application.college', [$tenant_id, $course_application_id]);
    }

    function mailPdf($tenant_id, $invoice_id)
    {
        $inst_emails = InstituteAddress::where('email', '!=', '')->lists('email', 'email')->all(); //dd($inst_emails->toArray());
        $ag_emails = Agent::where('email', '!=', '')->lists('email', 'email')->all();
        $data['email_list'] = array_merge($inst_emails, $ag_emails);
        $data['invoice'] = $invoice = $this->invoice->getDetails($invoice_id);
        if (empty($invoice))
            abort(404);
        $super_agent = CourseApplication::find($invoice->course_application_id)->super_agent_id;
        if($super_agent != null && $super_agent != 0)
            $data['company_email'] = Agent::find($super_agent)->email;
        else {
            $add = InstituteAddress::where('institute_id', $invoice->institution_id)->orderBy('institute_address_id', 'asc')->first();
            $data['company_email'] = (!empty($add))? $add->email : '';
        }
        return view("Tenant::College/Invoice/mail", $data);
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

        $data['agency'] = $this->agent->getAgentDetails();
        $data['bank'] = $this->setting->getBankDetails();
        $data['invoice'] = $invoice = $this->invoice->getDetails($invoice_id);
        if (empty($invoice))
            abort(404);
        $super_agent = CourseApplication::find($invoice->course_application_id)->super_agent_id;
        if($super_agent != null && $super_agent != 0)
            $data['invoice_to'] = get_agent_name($super_agent);
        else
            $data['invoice_to'] = $data['invoice']->invoice_to_name;
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
        $data['client_name'] = $this->application->getClientName($invoice->course_application_id);
        $data['pay_details'] = $this->invoice->getPayDetails($invoice->invoice_id);
        $pdf = PDF::loadView('Tenant::College/Invoice/pdf', $data);
        $newPdf =  $pdf->stream();

        $company_name = (isset($details['company_name']) && $details['company_name'] != '')? $details['company_name'] : 'Condat Solutions';

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
            Flash::error('An error has been encountered while sending the mail. Please try again later.');

        return $this->success(['message' => 'Process Complete!']);
    }

}
