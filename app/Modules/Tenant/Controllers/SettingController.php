<?php namespace App\Modules\Tenant\Controllers;

use App\Http\Requests;
use App\Modules\Tenant\Models\Email;
use App\Modules\Tenant\Models\Setting;
use App\Modules\Tenant\Models\Agent;
use Flash;
use Mail;

use Illuminate\Http\Request;

class SettingController extends BaseController {

	function __construct(Request $request, Agent $agent, Setting $setting)
	{
		$this->request = $request;
		$this->agent = $agent;
		$this->setting = $setting;
		parent::__construct();
	}

	/**
	 * Get Company Profile
	 */
	public function company()
	{
        $user_id = current_tenant_id();
        if(!$this->checkAuthority() && $user_id != $this->request->segment(3)) {
            abort(403, 'Unauthorized action.');
        }
		$data['company_data'] = (object) $this->setting->getCompany();
		return view('Tenant::Settings/company', $data);
	}

	/**
	 * Get Bank Account Details
	 */
	public function bank()
	{
        $user_id = current_tenant_id();
        if(!$this->checkAuthority() && $user_id != $this->request->segment(3)) {
            abort(403, 'Unauthorized action.');
        }
		$data['bank'] = $this->setting->getBankDetails();
		return view('Tenant::Settings/bank', $data);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the company in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function updateCompany($tenant_id)
	{
		$company_rules = [
			'phone_number' => 'required',
			'email' => 'email|required',
			'company_name' => 'required',
		];

		$this->validate($this->request, $company_rules);
		// if validates
        $company_data = $this->request->all();
        unset($company_data['_token']);
		$this->setting->saveSetup('company', serialize($company_data));
        Flash::success('Company details has been updated successfully!');
		return redirect()->route('tenant.company.edit', $tenant_id);
	}

	/**
	 * Update the bank details in storage.
	 *
	 * @return Response
	 */
	public function updateBank()
	{
		$bank_rules = [
			'number' => 'required',
			'account_name' => 'required',
			'name' => 'required',
		];

		$this->validate($this->request, $bank_rules);
		// if validates
		$all = $this->request->except('_token');
		$this->setting->saveSetup('bank', @serialize($all));
		Flash::success('Bank details has been updated successfully!');
		return redirect()->route('tenant.bank.edit');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	public function send_email($tenant_id)
    {
        $user_id = current_tenant_id();
        if(!$this->checkAuthority() && $user_id != $this->request->segment(3)) {
            abort(403, 'Unauthorized action.');
        }
        $emails = Email::get();
        $email_ids = [];
        foreach($emails as $email) {
            $email_ids += [
                $email->email => $email->email,
            ];
        }
        return view('Tenant::Settings/send_email', compact('email_ids'));
    }

	public function send_email_post($tenant_id)
    {
        $post = $this->request->all();
        foreach($post['email_ids'] as $email_id) {
            $param = [
                'content'    => $post['body'],
                'subject'    => $post['subject'],
                'heading'    => 'Condat Solutions',
                'subheading' => 'All your business in one space',
            ];
            $data = [
                'to_email'   => $email_id,
                'to_name'    => '',
                'subject'    => $post['subject'],
                'from_email' => env('FROM_EMAIL', 'info@condat.com.au'), //change this later
                'from_name'  => 'Condat Solutions', //change this later
            ];
            Mail::send('template.master', $param, function ($message) use ($data) {
                $message->to($data['to_email'], $data['to_name'])
                    ->subject($data['subject'])
                    ->from($data['from_email'], $data['from_name']);
            });
        }
        Flash::success('Email has been sent.');
        return redirect()->route('tenant.bulkemail.view', $tenant_id);
    }

}
