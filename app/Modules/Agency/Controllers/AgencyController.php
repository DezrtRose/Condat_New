<?php namespace App\Modules\Agency\Controllers;

use App\Http\Requests;
use App\Http\Controllers\BaseController;
use App\Modules\Agency\Models\Agency;
use App\Modules\Agency\Models\Company;
use App\Modules\System\Models\Subscription;
use DB;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Response;
use Srmklive\PayPal\Services\ExpressCheckout;
use Mockery\Exception;

class AgencyController extends BaseController {

	protected $agency;
	protected $request;
	protected $subscription;
	/* Validation rules for agency create and edit */
	protected $rules = [
		'description' => 'min:2',
		'name' => 'required|min:2|max:145',
		'abn' => 'required|min:2|max:145',
		'phone_id' => 'required|min:2|max:145',
        //'g-recaptcha-response' => 'required|recaptcha',
	];

	function __construct(Agency $agency, Subscription $subscription, Request $request)
	{
		$this->agency = $agency;
		$this->request = $request;
		$this->subscription = $subscription;
		parent::__construct();
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view("Agency::index");
	}

	/**
	 * Get all the agencies through ajax request.
	 *
	 * @return JSON response
	 */
	function getData(Request $request)
	{
		$agencies = Agency::leftJoin('companies','agencies.agency_id','=','companies.agencies_agent_id')
            ->leftJoin('agency_subscriptions', function($join) {
                $join->on('agencies.agency_id', '=', 'agency_subscriptions.agency_id');
                $join->on('agency_subscriptions.is_current', '=', DB::raw('1'));
            })
            ->leftJoin('subscription_statuses',
                'agency_subscriptions.subscription_status_id',
                '=',
                'subscription_statuses.status_id')
            ->select(['agencies.agency_id', 'agencies.created_at', 'agencies.status', DB::raw('case when companies.phone_id = 0 then "N/A" else companies.phone_id end as phone_id'), 'company_database_name', 'companies.name', 'companies.email_id', 'end_date', DB::raw('case when subscription_id = 1 then "Basic" when subscription_id = 2 then "Standard" else "Premium" end as subscription_id, subscription_statuses.name as subscription_name')])
            ->groupBy('agency_subscriptions.agency_id');

		$datatable = \Datatables::of($agencies)
			->editColumn('agency_id', function($data){return format_id($data->agency_id, 'A'); })
			->editColumn('end_date', function($data){return format_date($data->end_date); })
			->addColumn('action', function ($data) {
				$status_link = (($data->status == 1) ? '<a data-toggle="tooltip" title="Deactivate Agency" class="btn btn-action-box" onclick="return confirm (\'Are you sure?\')" href ="'. route('agencies.deactivate', $data->agency_id) .'"><i class="fa fa-minus-circle"></i></a>' : '<a data-toggle="tooltip" title="Reactivate Agency" class="btn btn-action-box" onclick="return confirm (\'Are you sure?\')" href ="'. route('agencies.activate', $data->agency_id) .'"><i class="fa fa-plus-circle"></i></a>');
				return '<a data-toggle="tooltip" title="View Agency" class="btn btn-action-box" href ="'. route('agency.show', $data->agency_id) .'"><i class="fa fa-eye"></i></a> <a data-toggle="tooltip" title="Renew Agency Subscription" class="btn btn-action-box" href ="'. route('agency.renew', $data->agency_id) .'"><i class="fa fa-refresh"></i></a> <a data-toggle="tooltip" title="Edit Agency" class="btn btn-action-box" href ="'. route('agency.edit', $data->agency_id) .'"><i class="fa fa-edit"></i></a> ' . $status_link;
			});
		return $datatable->make(true);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('Agency::add');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		/* Additional validations for creating user */
		$this->rules['email_id'] = 'required|email|min:5|max:145|unique:companies,email_id';

		$this->validate($this->request, $this->rules);
		// if validates
		$request = $this->request->all();
		$request['company_database_name'] = $this->createDomain($request['name']);
		$created = $this->agency->add($request);
		if($created)
			Flash::success('Agency has been created successfully.');
		return redirect()->route('agency.index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$data['agency'] = $this->agency->getAgencyDetails($id);
		return view('Agency::show', $data);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$data['agency'] = $this->agency->getAgencyDetails($id);
		$data['subscriptions'] = Subscription::lists('name', 'subscription_id');
		return view('Agency::edit', $data);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
        /* Additional validations for creating user */
        $this->rules['email_id'] = 'required|email|min:5|max:145|unique:companies,email_id,' . $id . ',agencies_agent_id';

        $this->validate($this->request, $this->rules);
        // if validates
        $request = $this->request->all();
        $updated = $this->agency->edit($request, $id);
        if($updated)
            Flash::success('Agency has been updated successfully.');
        return redirect()->route('agency.index');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $agency = Agency::find($id);
        $agency->delete();
        return redirect('agency')->with('message', 'Agency has been removed.');
	}

	/**
	 * Deactivate Agency.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function deactivate($id)
	{
        $agency = Agency::find($id);
        $agency->status = 0;
		$agency->save();
        return redirect()->back()->with('message', 'Agency has been deactivated.');
	}

	/**
	 * Activate Agency.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function activate($id)
	{
        $agency = Agency::find($id);
        $agency->status = 1;
		$agency->save();
        return redirect()->back()->with('message', 'Agency has been activated.');
	}

	/**
	 * get Subdomain suggestion
	 * @param string $company_name
	 * @return mixed
	 */
	public function getDomainSuggestion($company_name = '')
	{
		$domain = $this->createDomain($company_name);
		return Response::json($domain);
	}

	/**
	 * Create APP
	 * @param $string
	 * @return mixed|string
	 */
	function createDomain($string)
	{
		$string = explode(' ', $string);
		$string = strtolower($string[0]);
		$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $string);
		$domain = preg_replace("/[\/_|+ -]+/", '', $clean);

		$domain = $this->checkDomainExists($domain);

		return $domain;
	}

	/**
	 * Check subdomain exist for not
	 * @param string $domain
	 * @return string
	 */
	private function checkDomainExists($domain = '')
	{
		$i = 1;
		$exists = Agency::where('company_database_name', $domain)->first();
		$new_domain = $domain;
		while ($exists) {
			$new_domain = $domain . $i;
			$exists = Agency::where('company_database_name', $new_domain)->first();
			$i++;
		}
		return $new_domain;
	}

	/**
	 * Renew agency subscription
	 *
	 * @param  int  $agency_id
	 * @return Response
	 */
	public function subscriptionRenew($agency_id)
	{
	    $companyDetails = Company::where('agencies_agent_id', $agency_id)->first();
		return view('Agency::renew', compact('companyDetails'));
	}

	/**
	 * Update agency subscription
	 *
	 * @param  int  $agency_id
	 * @return Response
	 */
	public function postSubscriptionRenew($agency_id)
	{
		/*$rules['payment_date'] = 'required';

		$this->validate($this->request, $rules);*/

		$updated = $this->subscription->renew($this->request->all(), $agency_id, $admin = true);
		if($updated)
			Flash::success('Subscription has been renewed successfully.');
        else
            Flash::success('Subscription failed. Please try again later.');

		return redirect()->route('agency.index');
	}

	public function get_subscription_amount(Request $request)
    {
        $resp = false;
        $post = $request->all();
        if(isset($post['subscription_type']) && isset($post['subscription_years'])) {
            $subscription = new Subscription();
            $data = $subscription->find($post['subscription_type']);
            if($data) {
                $resp = ($data->amount * $post['subscription_years']) - (($post['subscription_years'] - 1) / 100) * (($data->amount * $post['subscription_years']) * 5);
            }
        }
        echo $resp;
    }

    public function complete_subscription_paypal()
    {
        try {
            $provider = new ExpressCheckout;
            if(!isset($_GET['token'])) throw new Exception('Paypal account not verified.');
            $payment_data = $provider->getExpressCheckoutDetails($_GET['token']);
            if(!isset($_COOKIE['paypal_payment_data'])) throw new Exception('Payment data not found. Please try again.');
            $data = $_COOKIE['paypal_payment_data'];
            $data = json_decode($data, true);
            unset($_COOKIE['paypal_payment_data']);
            $provider->doExpressCheckoutPayment($data, $payment_data['TOKEN'], $payment_data['PAYERID']);
            $update = $this->subscription->renew_paypal($payment_data['CUSTOM']);
            ($update) ? Flash::success('Subscription has been renewed successfully.') : Flash::success('Subscription could not be renewed.');
            return redirect()->route('agency.index');
        } catch (Exception $e) {
            Flash::success($e->getMessage());
            return redirect()->route('agency.index');
        }
    }
}
