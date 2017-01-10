<?php namespace App\Modules\Dashboard\Controllers;

use App\Http\Requests;
use App\Http\Controllers\BaseController;

use App\Modules\Agency\Models\Agency;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class DashboardController extends BaseController {

	function __construct()
	{
		parent::__construct();
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view("Dashboard::index");
	}

	/**
	 * Get new agencies registered within a month through ajax request.
	 *
	 * @return JSON response
	 */
	function getNewAgencyData(Request $request)
	{
		$agencies = Agency::withTrashed()
            ->leftJoin('companies','agencies.agency_id','=','companies.agencies_agent_id')
            ->leftJoin('agency_subscriptions', function($join) {
                $join->on('agencies.agency_id', '=', 'agency_subscriptions.agency_id');
                $join->on('agency_subscriptions.is_current', '=', DB::raw('1'));
            })
            ->leftJoin('subscription_statuses',
                'agency_subscriptions.subscription_status_id',
                '=',
                'subscription_statuses.status_id')
			->select(['agencies.agency_id', 'agencies.created_at', DB::raw('case when companies.phone_id = 0 then "N/A" else companies.phone_id end as phone_id'), 'companies.name', 'companies.email_id', 'end_date', DB::raw('case when subscription_id = 1 then "Basic" when subscription_id = 2 then "Standard" else "Premium" end as subscription_id, subscription_statuses.name as subscription_name')])
			->where('agencies.created_at', '>', Carbon::now()->subMonth(2))
            ->groupBy('agencies.agency_id');

		$datatable = \Datatables::of($agencies)
            ->editColumn('agency_id', function($data){return format_id($data->agency_id, 'A'); })
            ->editColumn('end_date', function($data){return format_date($data->end_date); })
            ->addColumn('action', '<a data-toggle="tooltip" title="View Agency" class="btn btn-action-box" href ="{{ route( \'agency.show\', $agency_id) }}"><i class="fa fa-eye"></i></a> <a data-toggle="tooltip" title="Renew Agency Subscription" class="btn btn-action-box" href ="{{ route( \'agency.renew\', $agency_id) }}"><i class="fa fa-refresh"></i></a> <a data-toggle="tooltip" title="Edit Agency" class="btn btn-action-box" href ="{{ route( \'agency.edit\', $agency_id) }}"><i class="fa fa-edit"></i></a> 
<form action="{{ route( \'agency.destroy\', $agency_id) }}" method="post">
    {{ method_field(\'DELETE\') }}
    {{ csrf_field() }}
    <button data-toggle="tooltip" title="Deactivate Agency" type="submit" class="delete-agency btn btn-action-box"><i class="fa fa-minus-circle"></i></button>
</form>');
		return $datatable->make(true);
	}

	/**
	 * Get expiring agencies through ajax request.
	 *
	 * @return JSON response
	 */
	function getExpiringAgencyData(Request $request)
	{
		$agencies = Agency::withTrashed()
            ->leftJoin('companies','agencies.agency_id','=','companies.agencies_agent_id')
            ->leftJoin('agency_subscriptions', function($join) {
                $join->on('agencies.agency_id', '=', 'agency_subscriptions.agency_id');
                $join->on('agency_subscriptions.is_current', '=', DB::raw('1'));
            })
            ->leftJoin('subscription_statuses',
                'agency_subscriptions.subscription_status_id',
                '=',
                'subscription_statuses.status_id')
			->select(['agencies.agency_id', 'agencies.created_at', DB::raw('case when companies.phone_id = 0 then "N/A" else companies.phone_id end as phone_id'), 'companies.name', 'companies.email_id', 'end_date', DB::raw('case when subscription_id = 1 then "Basic" when subscription_id = 2 then "Standard" else "Premium" end as subscription_id, subscription_statuses.name as subscription_name')])
			->where('agency_subscriptions.end_date', '<', Carbon::now()->addMonths(2))
            ->groupBy('agencies.agency_id');

        $datatable = \Datatables::of($agencies)
			->editColumn('agency_id', function($data){return format_id($data->agency_id, 'A'); })
			->editColumn('end_date', function($data){return format_date($data->end_date); })
			->addColumn('action', '<a data-toggle="tooltip" title="View Agency" class="btn btn-action-box" href ="{{ route( \'agency.show\', $agency_id) }}"><i class="fa fa-eye"></i></a> <a data-toggle="tooltip" title="Renew Agency Subscription" class="btn btn-action-box" href ="{{ route( \'agency.renew\', $agency_id) }}"><i class="fa fa-refresh"></i></a> <a data-toggle="tooltip" title="Edit Agency" class="btn btn-action-box" href ="{{ route( \'agency.edit\', $agency_id) }}"><i class="fa fa-edit"></i></a> 
<form action="{{ route( \'agency.destroy\', $agency_id) }}" method="post">
    {{ method_field(\'DELETE\') }}
    {{ csrf_field() }}
    <button data-toggle="tooltip" title="Deactivate Agency" type="submit" class="delete-agency btn btn-action-box"><i class="fa fa-minus-circle"></i></button>
</form>');
		return $datatable->make(true);
	}

	/**
	 * Get expired agencies through ajax request.
	 *
	 * @return JSON response
	 */
	function getExpiredAgencyData(Request $request)
	{
		$agencies = Agency::withTrashed()
            ->leftJoin('companies','agencies.agency_id','=','companies.agencies_agent_id')
            ->leftJoin('agency_subscriptions', function($join) {
                $join->on('agencies.agency_id', '=', 'agency_subscriptions.agency_id');
                $join->on('agency_subscriptions.is_current', '=', DB::raw('1'));
            })
            ->leftJoin('subscription_statuses',
                'agency_subscriptions.subscription_status_id',
                '=',
                'subscription_statuses.status_id')
			->select(['agencies.agency_id', 'agencies.created_at', DB::raw('case when companies.phone_id = 0 then "N/A" else companies.phone_id end as phone_id'), 'companies.name', 'companies.email_id', 'end_date', DB::raw('case when subscription_id = 1 then "Basic" when subscription_id = 2 then "Standard" else "Premium" end as subscription_id, subscription_statuses.name as subscription_name')])
			->where('agency_subscriptions.end_date', '<', Carbon::now())
            ->groupBy('agencies.agency_id');

        $datatable = \Datatables::of($agencies)
			->editColumn('agency_id', function($data){return format_id($data->agency_id, 'A'); })
            ->editColumn('end_date', function($data){return format_date($data->end_date); })
            ->addColumn('action', '<a data-toggle="tooltip" title="View Agency" class="btn btn-action-box" href ="{{ route( \'agency.show\', $agency_id) }}"><i class="fa fa-eye"></i></a> <a data-toggle="tooltip" title="Renew Agency Subscription" class="btn btn-action-box" href ="{{ route( \'agency.renew\', $agency_id) }}"><i class="fa fa-refresh"></i></a> <a data-toggle="tooltip" title="Edit Agency" class="btn btn-action-box" href ="{{ route( \'agency.edit\', $agency_id) }}"><i class="fa fa-edit"></i></a> 
<form action="{{ route( \'agency.destroy\', $agency_id) }}" method="post">
    {{ method_field(\'DELETE\') }}
    {{ csrf_field() }}
    <button data-toggle="tooltip" title="Deactivate Agency" type="submit" class="delete-agency btn btn-action-box"><i class="fa fa-minus-circle"></i></button>
</form>');
		return $datatable->make(true);
	}
}
