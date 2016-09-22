<?php namespace App\Modules\System\Models;

use App\Modules\Agency\Models\AgencySubscription;
use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;
use Srmklive\PayPal\Services\ExpressCheckout;

class Subscription extends Model
{

    protected $table = "subscriptions";
    protected $primaryKey = "subscription_id";

    protected $fillable = array('name', 'description', 'amount');

    public $timestamps = false;

    function scopeByName($query, $name)
    {
        return $query->where('name', $name)->first();
    }

    function scopeAmount($query, $id)
    {
        return $query->find($id)->first()->amount;
    }

    function getAll()
    {
        $subscriptions = array();
        $subscriptions['basic'] = $this->byName('basic');
        $subscriptions['standard'] = $this->byName('standard');
        $subscriptions['premium'] = $this->byName('premium');
        return $subscriptions;
    }

    function renew(array $request, $agency_id)
    {
        DB::beginTransaction();
        try {
            $subscription_id = $request['subscription_type'];

            $previous_sub = AgencySubscription::where('agency_id', $agency_id)->orderBy('agency_subscription_id', 'desc')->first();
            $expiry_date = get_expiry_date(null, $request['subscription_years']);
            $subscription_type = 1;
            if(!empty($previous_sub)) {
                $previous_sub->is_current = 0;
                $previous_sub->save();
                $old_end_date = new Carbon($previous_sub->end_date);
                $today = new Carbon();
                $remaining_months = $old_end_date->diffInMonths($today);
                $expiry_date = get_expiry_date(null, $request['subscription_years']);
                $expiry_date = $expiry_date->addMonths($remaining_months);
                $subscription_type = 2;
            }

            $agency_subs = AgencySubscription::create([
                'agency_id' => $agency_id,
                'is_current' => 1,
                'start_date' => get_today_date(),
                'end_date' => $expiry_date,
                'subscription_status_id' => $subscription_type, // 1 = trail, 2 = paid
                'subscription_id' => $subscription_id,
            ]);

            $amount = $this->amount($subscription_id);

            SubscriptionPayment::create([
                'amount' => $amount,
                'payment_date' => get_today_date(),
                'payment_type' => $request['payment_type'],
                'agency_subscription_id' => $agency_subs->agency_subscription_id
            ]);
            DB::commit();
            if($request['payment_type'] == 'Card' || $request['payment_type'] == 'Paypal') {
                $this->_process_paypal($amount, $request['subscription_years']);
            }
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
        }
    }

    function _process_paypal($amount, $subscription_years)
    {
        $provider = new ExpressCheckout;
        $data = [];
        $data['items'] = [
            [
                'name' => 'Subscription for ' . $subscription_years . ' year(s)',
                'price' => $amount,
                'qty' => 1
            ]
        ];

        $data['invoice_id'] = 1;
        $data['invoice_description'] = "Order #$data[invoice_id] Invoice";
        $data['return_url'] = url('/agency');
        $data['cancel_url'] = url('/subscription/83/renew');

        $total = 0;
        foreach($data['items'] as $item) {
            $total += $item['price'];
        }

        $data['total'] = $total;

        $response = $provider->setExpressCheckout($data, true);
        header('location: ' . $response['paypal_link']);die;
    }

    function activateTrail(array $request, $agency_id)
    {
        DB::beginTransaction();
        try {
            $subscription_id = 1;

            $previous_sub = AgencySubscription::where('agency_id', $agency_id)->orderBy('agency_subscription_id', 'desc')->first();
            if(!empty($previous_sub)) {
                $previous_sub->is_current = 0;
                $previous_sub->save();
            }

            AgencySubscription::create([
                'agency_id' => $agency_id,
                'is_current' => 1,
                'start_date' => get_today_date(),
                'end_date' => get_expiry_date(),
                'subscription_status_id' => 1, // 1 = trail, 2 = paid
                'subscription_id' => $subscription_id,
            ]);

            /*$amount = $this->amount($subscription_id);

            SubscriptionPayment::create([
                'amount' => $amount,
                'payment_date' => '',
                'payment_type' => '',
                'agency_subscription_id' => $agency_subs->agency_subscription_id
            ]);*/
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
        }
    }

}
