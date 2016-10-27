<?php

namespace App\Modules\Tenant\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Tenant\Models\Client\ClientNotes;
use App\Modules\Tenant\Models\Country;
use App\Modules\Tenant\Models\Person\Person;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;

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
		// share list of countries in all views
		View::share('countries', $this->get_country_list());
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
			$profile = Person::find($current_user->person_id);
			$current_user->full_name = $profile->first_name . ' ' . $profile->last_name;
			$current_user->profile = $profile;
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

}