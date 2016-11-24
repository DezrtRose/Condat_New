<?php namespace App\Modules\Payment\Controllers;

use App\Http\Requests;
use App\Http\Controllers\BaseController;
use App\Modules\System\Models\SubscriptionPayment;
use Illuminate\Http\Request;
use DB;

class PaymentController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view("Payment::index");
	}

	public function getData()
    {
        $payments = SubscriptionPayment::leftJoin('agency_subscriptions', 'agency_subscriptions.agency_subscription_id', '=', 'subscription_payments.agency_subscription_id')
            ->leftJoin('agencies', 'agencies.agency_id', '=', 'agency_subscriptions.agency_id')
            ->leftJoin('companies', 'companies.agencies_agent_id', '=', 'agencies.agency_id')
            ->select(['subscription_payment_id', 'companies.name as company_name', 'amount', 'payment_date', 'payment_type', DB::raw('case when subscription_id = 1 then "Basic" when subscription_id = 2 then "Standard" else "Premium" end as subscription_id'), 'agency_subscriptions.end_date'])
            ->orderBy('subscription_payments.subscription_payment_id', 'desc');

        $datatable = \Datatables::of($payments)
            ->editColumn('payment_date', function($data){return format_datetime($data->payment_date); })
            ->editColumn('subscription_payment_id', function($data){return format_id($data->subscription_payment_id, 'P'); })
            ->editColumn('amount', function($data){return format_price($data->amount); });
        return $datatable->make(true);
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
