<?php namespace App\Modules\Connect\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Modules\Agency\Models\Company;
use Mail;
use Flash;

class ConnectController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
	    $companies = Company::get();
        $email_ids = [];
        foreach($companies as $company) {
            $email_ids += [
                $company->company_id => $company->name . " (" . $company->email_id . ")",
            ];
        }
		return view("Connect::index", compact('email_ids'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function sendEmail(Request $request)
	{
		$post = $request->all(); //dd($post['email_ids']);
        foreach($post['email_ids'] as $email_id) {
			$data = array();
			$company = Company::find($email_id);
			$data[0] = $company->name;
			$data[1] = $company->email_id;
            //$data = explode('-', $email_id);
            $param = [
                'content'    => $post['message'],
                'subject'    => $post['subject'],
                'heading'    => 'Condat Solutions',
                'subheading' => 'All your business in one space',
            ];
            $data = [
                'to_email'   => $data[1],
                'to_name'    => $data[0],
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
        Flash::success('Email has been sent to client(s).');
        return redirect()->route('connect.index');
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
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
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

}
