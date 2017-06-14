<?php

namespace App\Modules\Tenant\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Tenant\Models\Client\ClientNotes;
use App\Modules\Tenant\Models\Country;
use App\Modules\Tenant\Models\Invoice\CollegeInvoice;
use App\Modules\Tenant\Models\Invoice\StudentInvoice;
use App\Modules\Tenant\Models\Person\Person;
use App\Modules\Tenant\Models\UserLevel;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use App\Models\Tenant\Setting;

class BaseController extends Controller{

	protected $layout = 'main';
	function __construct()
	{
		// share current route in all views
		View::share('current_url', Route::current()->getPath());
		// share current logged in user details all views
		View::share('current_user', $this->current_user());
		// share current logged in user details all views
		View::share('reminders', $this->getReminders());
		// share random alerts in all views
		View::share('alerts', $this->getNotifications());
		// share list of countries in all views
		View::share('countries', $this->get_country_list());
		// share company details in all views
		View::share('company', $this->getCompanyDetails());
		// get tenant_id
		View::share('tenant_id', \Illuminate\Support\Facades\Request::segment(1));
	}

	/**
	 * get country array
	 * @return array
	 */
	public function get_country_list()
	{
		$list = Country::orderBy('name', 'asc')->lists('name','country_id');
		return $list;
	}

	public function current_user()
	{
		$current_user = auth()->guard('tenants')->user();

		if(!empty($current_user)) {
			$role = UserLevel::find($current_user->role);
			$profile = Person::find($current_user->person_id);
			$current_user->full_name = $profile->first_name . ' ' . $profile->last_name;
			$current_user->first_name = $profile->first_name;
			$current_user->last_name = $profile->last_name;
			$current_user->profile = $profile;
			$current_user->role_type = $role->name;
			$current_user->level_value = $role->value;
			$current_user->level = $role->value;
		}
		return $current_user;
	}

	/**
	 * return success json data to view
	 * @param array $data
	 * @return mixed
	 */
	function success(array $data = array())
	{
		$response = ['status' => 1, 'data' => $data];

		return Response::json($response);
	}


	/**
	 * return failed json data to view
	 * @param array $data
	 * @return mixed
	 */
	function fail(array $data = array())
	{
		$response = ['status' => 0, 'data' => $data];

		return Response::json($response);
	}

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */

	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

	function getReminders()
	{
		$reminders = ClientNotes::join('notes', 'notes.notes_id', '=', 'client_notes.note_id')
            ->join('clients', 'clients.client_id', '=', 'client_notes.client_id')
            ->join('persons', 'clients.person_id', '=', 'persons.person_id')
			->select('notes.*', 'clients.client_id', 'persons.first_name', 'persons.last_name')
			->orderBy('reminder_date', 'desc')
			->where('remind', 1)
			->where('status', 0)
			->whereDate('reminder_date', '<=', Carbon::today())
			->get();

		return $reminders;

	}

	function getNotifications()
	{
		$notification_arr = array();
		$tenant_id = \Illuminate\Support\Facades\Request::segment(1);
		//Student pending invoice
		$studentInvoice = new StudentInvoice();
		$studInvoices = $studentInvoice->getRandomPendingInvoice();
		if(!empty($studInvoices)) {
			foreach($studInvoices as $studInvoice) {
				$desc = (isset($studInvoice->description) && $studInvoice->description != '')? ucfirst($studInvoice->description) : 'Student invoice';
				$notification_arr[] = '<a href="' . route("tenant.invoice.payments", [$tenant_id, $studInvoice->invoice_id, 2]) . '" target="_blank"><i class="fa fa-user text-aqua"></i><strong>'.$desc.'</strong> of <strong>'. $studInvoice->fullname. '</strong> is still outstanding.</a>';
			}
		};//dd($notification_arr);
		$colInvoice = new CollegeInvoice();
		$collegeInvoices = $colInvoice->getRandomPendingInvoice();
		if(!empty($collegeInvoices)) {
			foreach($collegeInvoices as $collegeInvoice) {
				$notification_arr[] = '<a href="' . route("tenant.invoice.payments", [$tenant_id, $collegeInvoice->college_invoice_id, 1]) . '"><i class="fa fa-building text-green"></i>Invoice for <strong>'. $collegeInvoice->institute_name .'</strong> of <strong>'. $collegeInvoice->fullname .'</strong> is outstanding.</a>';
			}
		}
		if(!empty($notification_arr))
			$notification_arr = array_random($notification_arr, 5);
		return $notification_arr;
	}

	function getCompanyDetails()
	{
		$setting = new Setting();
		$company = $setting->getCompany();
		return $company;
	}

	public function checkAuthority()
    {
        $current_user = $this->current_user()->toArray();
        if($current_user['level'] >= '12')
            return true;
        elseif($current_user['level'] >= '8' && $current_user['level'] < '12')
            return false;
        elseif($current_user['level'] >= '4' && $current_user['level'] < '8')
            return false;
    }

}