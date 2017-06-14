<?php namespace App\Modules\System\Models;

use App\Modules\Agency\Models\AgencySubscription;
use App\Modules\System\Models\Customer;
use App\Modules\Tenant\Models\User;
use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;
use Srmklive\PayPal\Services\ExpressCheckout;
use Flash;

class Subscription extends Model
{

    protected $table = "subscriptions";
    protected $primaryKey = "subscription_id";
    protected $connection = 'master';
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

    function renew_bck(array $request, $agency_id)
    {
        DB::beginTransaction();
        try {
            $subscription_id = $request['subscription_type'];
            $base_amount = $this->amount($subscription_id);
            $amount = ($base_amount * $request['subscription_years']) - (($request['subscription_years'] - 1) / 100) * (($base_amount * $request['subscription_years']) * 5);
            if ($request['payment_type'] == 'Paypal') {
                $return_url = isset($request['return_url']) ? $request['return_url'] : '';
                $paypal_parameters = $request;
                $paypal_parameters['total_amount'] = $amount;
                $paypal_parameters['return_url'] = $return_url;
                $paypal_parameters['agency_id'] = $agency_id;
                return $this->_process_paypal($paypal_parameters);
            } else {
                $previous_sub = AgencySubscription::where('agency_id', $agency_id)->orderBy('agency_subscription_id', 'desc')->first();
                $expiry_date = get_expiry_date(null, $request['subscription_years']);
                $subscription_type = 1;
                if (!empty($previous_sub)) {
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
                    'subscription_id' => $subscription_id
                ]);

                SubscriptionPayment::create([
                    'amount' => $amount,
                    'payment_date' => get_today_date(),
                    'payment_type' => $request['payment_type'],
                    'agency_subscription_id' => $agency_subs->agency_subscription_id
                ]);
                DB::commit();
                return true;
            }
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
        }
    }

    function renew(array $request, $agency_id, $admin = false)
    {
        DB::beginTransaction();
        try {
            $subscription_id = $request['subscription_type'];
            $base_amount = $this->amount($subscription_id);
            $amount = ($base_amount * $request['subscription_years']) - (($request['subscription_years'] - 1) / 100) * (($base_amount * $request['subscription_years']) * 5);

            $previous_sub = AgencySubscription::where('agency_id', $agency_id)->orderBy('agency_subscription_id', 'desc')->first();
            $expiry_date = get_expiry_date(null, $request['subscription_years']);
            $subscription_type = 1;

            $stripe_parameters = $request;
            $stripe_parameters['total_amount'] = $amount;
            $stripe_parameters['agency_id'] = $agency_id;

            if($request['payment_type'] == 'Credit Card')
                $charge_id = $this->_stripe_payment($stripe_parameters, $admin);

            if (!empty($previous_sub)) {
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
                'subscription_status_id' => $subscription_type, // 1 = trail, 2 = paid Check this later
                'subscription_id' => $subscription_id
            ]);

            SubscriptionPayment::create([
                'amount' => $amount,
                'payment_date' => get_today_date(),
                'payment_type' => $request['payment_type'],
                'agency_subscription_id' => $agency_subs->agency_subscription_id,
                'stripe_transaction_id' => isset($charge_id)? $charge_id : null
            ]);
            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
        }
    }

    public function _stripe_payment(array $req, $admin)
    {
        $amount = $req['total_amount'];
        $token = $req['stripeToken'];
        $email = $req['stripeEmail'];

        $adminUser = new \App\Modules\User\Models\User();
        $current_user = ($admin == true)? $adminUser->getProfile(current_user_id()): User::with('profile')->find(current_tenant_id());

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        $amountCents = $amount * 100;

        $emailCheck = Customer::where('email', $email)->value('email');

        // If the email doesn't exist in the database create new customer and customer record
        if (!isset($emailCheck)) {
            // Create a new Stripe customer
            try {
                $customer = \Stripe\Customer::create([
                    'source' => $token,
                    'email' => $email,
                    'metadata' => [
                        "First Name" => $current_user->profile->first_name,
                        "Last Name" => $current_user->profile->last_name
                    ]
                ]);
            } catch (\Stripe\Error\Card $e) {
                return redirect()->back()
                    ->withErrors($e->getMessage())
                    ->withInput();
            }

            $customerID = $customer->id;

            // Create a customer in the database with Stripe ID
            Customer::create([
                'first_name' => $current_user->profile->first_name,
                'last_name' => $current_user->profile->last_name,
                'email' => $email,
                'stripe_customer_id' => $customerID,
            ]);
        } else {
            $customerID = Customer::where('email', $email)->value('stripe_customer_id');
        }
        // Charging the Customer with the selected amount
        try {
            // Charging the Customer with the selected amount
            $charge = \Stripe\Charge::create([
                'amount' => $amountCents,
                'currency' => 'aud',
                'customer' => $customerID,
                'metadata' => [
                    'product_name' => 'Condat Solutions Subscription Renew'
                ]
            ]);
            return $charge->id;
        } catch (\Stripe\Error\Card $e) {
            return redirect()->back()
                ->withErrors($e->getMessage())
                ->withInput();
        }
    }

    function _process_paypal($parameters)
    {
        $provider = new ExpressCheckout;
        $data = $parameters;
        $data['custom'] = implode('-', $parameters);
        $data['invoice_id'] = uniqid();
        $data['invoice_description'] = "Order Invoice";
        $data['items'] = [
            [
                'name' => 'Subscription for ' . $parameters['subscription_years'] . ' year(s)',
                'price' => $parameters['total_amount'],
                'qty' => 1
            ]
        ];

        $data['cancel_url'] = $_SERVER['HTTP_REFERER'];

        $data['total'] = $parameters['total_amount'];
        setcookie('paypal_payment_data', json_encode($data), time() + 3600, '/');

        $response = $provider->setExpressCheckout($data, true);
        if (isset($response['paypal_link'])) {
            header('location: ' . $response['paypal_link']);
            die;
        } else {
            return false;
        }
    }

    function activateTrail(array $request, $agency_id)
    {
        DB::beginTransaction();
        try {
            //$subscription_id = 1;
            $subscription_id = $request['subscription_type'];

            $previous_sub = AgencySubscription::where('agency_id', $agency_id)->orderBy('agency_subscription_id', 'desc')->first();
            if (!empty($previous_sub)) {
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

    function renew_paypal($data, $tenant_id = null)
    {
        DB::beginTransaction();
        try {
            $post_data = explode('-', $data);
            $subscription_id = $post_data[4];
            $subscription_years = $post_data[2];
            $payment_type = $post_data[3];
            $agency_id = ($tenant_id != null) ? $tenant_id : $post_data[6];
            $amount = $post_data[5];
            $previous_sub = AgencySubscription::where('agency_id', $agency_id)->orderBy('agency_subscription_id', 'desc')->first();
            $expiry_date = get_expiry_date(null, $subscription_years);
            $subscription_type = 2;
            if (!empty($previous_sub)) {
                $previous_sub->is_current = 0;
                $previous_sub->save();
                $old_end_date = new Carbon($previous_sub->end_date);
                $today = new Carbon();
                $remaining_months = $old_end_date->diffInMonths($today);
                $expiry_date = get_expiry_date(null, $subscription_years);
                $expiry_date = $expiry_date->addMonths($remaining_months);
                $subscription_type = 2;
            }

            $agency_subs = AgencySubscription::create([
                'agency_id' => $agency_id,
                'is_current' => 1,
                'start_date' => get_today_date(),
                'end_date' => $expiry_date,
                'subscription_status_id' => $subscription_type, // 1 = trail, 2 = paid
                'subscription_id' => $subscription_id
            ]);

            SubscriptionPayment::create([
                'amount' => $amount,
                'payment_date' => get_today_date(),
                'payment_type' => $payment_type,
                'agency_subscription_id' => $agency_subs->agency_subscription_id
            ]);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
        }
    }

}
