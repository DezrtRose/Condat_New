<?php namespace App\Modules\Tenant\Controllers;

use App\Modules\Tenant\Models\Email;
use Illuminate\Http\Request;
use Mail;

class EmailController extends BaseController
{

    function __construct(Request $request)
    {
        $this->request = $request;
        parent::__construct();
    }

    public function index($tenant_id)
    {
        $data['email_list'] = Email::where('email', '!=', '')->lists('email', 'email');
        return view("Tenant::Email/compose", $data);
    }

    function sendMail($tenant_id, $invoice_id)
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

        $param = ['content' => $request_array['body'],
            'subject' => $request_array['subject'],
            'heading' => $company_name,
            'subheading' => 'All your business in one space',
        ];

        $subscribers = Subscriber::active()->get();
        $batch = 0;
        $batch_subscribers = array();
        $batch_subscribers_data = array();
        foreach ($subscribers as $subscriber)
        {
            $batch_subscribers[] = $subscriber->mail;
            $batch_subscribers_data[$subscriber->mail] = array(
                "id" => $subscriber->id,
                "mail" => $subscriber->mail,
                "name" => $subscriber->name
            );
            $batch++;
            if($batch < 999){
                continue;
            }
            $input['to'] = $batch_subscribers;
            $input['vars'] = $batch_subscribers_data;

            $mail = \Mail::send('template.master', $param, function($message) use ($newPdf, $invoice, $request_array, $details){
                $message->to($request_array['to']);
                if(isset($request_array['cc']))
                    $message->cc($request_array['cc']);
                if(isset($request_array['sendBcc']) && $request_array['sendBcc'] == 'on')
                    $message->bcc($this->current_user()->email);
                $message->subject($request_array['subject']);
                $message->from($this->current_user()->email, $details['company_name']);
                $message->attachData($newPdf, format_id($invoice->invoice_id, 'I').'.pdf', ['mime' => 'application/pdf']);
                if(isset($details['email']))
                    $message->replyTo($details['email'], $details['company_name']);
            });
            $batch_subscribers = array();
            $batch_subscribers_data = array();
            $batch = 0;
        }

        if($mail == 1)
            Flash::success('Mail has been sent successfully.');
        else
            Flash::error('An error encountered while sending the mail. Please try again later.');

        return $this->success(['message' => 'Process Complete!']);
        //return redirect()->route('tenant.application.students', [$tenant_id, $invoice->application_id]);
    }

}
