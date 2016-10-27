<?php namespace App\Modules\Tenant\Controllers;

use App\Http\Requests;
use Flash;
use DB;
use Illuminate\Http\Request;
use Carbon;
use App\Modules\Agency\Models\AgencySubscription;
use Illuminate\Support\Facades\Auth;
use App\Modules\Agency\Models\Company;
use App\Modules\System\Models\Subscription;
use Mockery\Exception;
use Srmklive\PayPal\Services\ExpressCheckout;

class SubscriptionController extends BaseController
{
    protected $request;
    public function __construct(Request $request, Subscription $subscription)
    {
        $this->request = $request;
        $this->subscription = $subscription;
        parent::__construct();
    }

    public function checkSubscription($tenant_id)
    {
        $code = 0; // no subscription
        $agency_id = current_tenant_id();
        //$agency_id = $tenant_id;
        $agency_subscription = AgencySubscription::where('agency_id', '=', $agency_id)
        ->where('is_current', '=', 1)->first();

        if($agency_subscription) {
            $code = 1; // subscription not expired
            if($agency_subscription->end_date < date('Y-m-d')) {
                $code = 2; // subscription expired
            }
        }

        return $code;
    }

    public function renew()
    {
        $agency_id = current_tenant_id();
        $companyDetails = Company::where('agencies_agent_id', $agency_id)->first();
        return view('Tenant::Subscription/renew', compact('companyDetails'));
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

    public function submitRenew()
    {
        $agency_id = current_tenant_id();
        $this->subscription->renew($this->request->all(), $agency_id);
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
            return redirect()->route('tenant.client.index');
        } catch (Exception $e) {
            Flash::success($e->getMessage());
            return redirect()->route('tenant.client.index');
        }
    }
}
