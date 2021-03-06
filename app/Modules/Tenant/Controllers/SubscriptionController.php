<?php namespace App\Modules\Tenant\Controllers;

use App\Http\Requests;
use App\Modules\Tenant\Models\Customer;
use App\Modules\Tenant\Models\User;
use Flash;
use DB;
use Illuminate\Http\Request;
use Carbon;
use App\Modules\Agency\Models\AgencySubscription;
use App\Modules\Agency\Models\Company;
use App\Modules\System\Models\Subscription;
use Mockery\Exception;
use Srmklive\PayPal\Services\ExpressCheckout;
use PaypalPayment;
use PayPal\Exception\PayPalConnectionException;

class SubscriptionController extends BaseController
{
    protected $request;
    private $_apiContext;
    public function __construct(Request $request, Subscription $subscription)
    {
        $this->request = $request;
        $this->subscription = $subscription;

        $this->_apiContext = Paypalpayment::ApiContext(
            'AewUoZdjESBeOWRiUxc6GEVZJxQQ0R8nlqiEcrlv7ikbMz4VLf9nFm4dl02KNNvJXq54YzGNy_kntE77',
            'ECojXK1WGugEMBu8ncOITeXK-teXfNilAfTNh9rA019jFnMcolzKf77P4bywwZacQReXoAd-Luub3j0Z');

        /* Sandbox account for info@condat.com.au
         * $this->_apiContext = Paypalpayment::ApiContext(
            'AVK7FeFkmcTBqpuoTpnZGn_8Xnpo_U2BTm_lo-JHUGwXUECVmxqNs2-y40U6oMOxeIOWgKQIYgFQe7GU',
            'EPwdN-9XSul1oTRGy8YTp-q0G8x1d9ZiOnW5bpof40TZ6cEQRLx5OvPpZ-ZZsaktieAxikZafh5LP4sH');*/

        /*$this->_apiContext = Paypalpayment::ApiContext(
            'AVl4CuClCi529x3-AGeOieGhTcZOO16ZOMTgBZ2hIjislH39obSFwHH0iTa9ttnGVAEYzoOV1BcB9avY',
            'EPKODdkv3-wN0LddHx3zPE2aNa1QteOhlq68R2HbHFFRcH_NXVylKpzPFr1t2rNu5eb_hV8I2L6JtYeu');*/

        parent::__construct();
    }

    public function checkSubscription($tenant_id)
    {
        $code = 0; // no subscription
        //$agency_id = current_tenant_id();
        $agency_id = $tenant_id;
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

    public function renew($tenant_id)
    {
        $user_id = current_tenant_id();
        /*if(!$this->checkAuthority() && $user_id != $this->request->segment(3)) {
            abort(403, 'Unauthorized action.');
        }*/
        $agency_id = current_tenant_id();
        $data['companyDetails'] = Company::where('agencies_agent_id', $agency_id)->first();

        $data['agency_subscription'] = $agency_subscription = AgencySubscription::where('agency_id', '=', $tenant_id)->where('is_current', '=', 1)->first();
        //dd($agency_subscription->toArray());
            if($agency_subscription->end_date < date('Y-m-d')) {
                return view('Tenant::Subscription/renew', $data);
            } else {
                return view('Tenant::Subscription/earlyrenew', $data);
            }
    }

    public function get_subscription_amount($tenant_id, Request $request)
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

    public function submitRenew($agency_id)
    {
        $renewed = $this->subscription->renew($this->request->all(), $agency_id);
        ($renewed) ? Flash::success('Subscription has been renewed successfully.') : Flash::danger('Subscription could not be renewed. Please contact the system administrator to report the issue.');
        return redirect()->route('tenant.user.index', $agency_id);
    }

    public function _stripe_payment()
    {
        $req = $this->request->all();
        $subscription_id = $req['subscription_type'];

        $data = Subscription::find($subscription_id);
        $amount = ($data->amount * $req['subscription_years']) - (($req['subscription_years'] - 1) / 100) * (($data->amount * $req['subscription_years']) * 5);

        $token = $this->request->input('stripeToken');
        $email = $this->request->input('email');

        \Stripe\Stripe::setApiKey(env('TEST_STRIPE_SECRET_KEY'));
        $amountCents = $amount * 100;

        $emailCheck = Customer::where('email', $email)->value('email');dd('ok');

        // If the email doesn't exist in the database create new customer and customer record
        if (!isset($emailCheck)) {
            // Create a new Stripe customer
            try {
                $customer = \Stripe\Customer::create([
                    'source' => $token,
                    'email' => $email,
                    'metadata' => [
                        "First Name" => $this->current_user()->first_name,
                        "Last Name" => $this->current_user()->last_name
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
                'first_name' => $this->current_user()->first_name,
                'last_name' => $this->current_user()->last_name,
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
            return $charge;
        } catch (\Stripe\Error\Card $e) {
            return redirect()->back()
                ->withErrors($e->getMessage())
                ->withInput();
        }
    }

    public function _card_payment($request)
    {
        $subscription_id = $request['subscription_type'];

        $data = Subscription::find($subscription_id);
        $amount = ($data->amount * $request['subscription_years']) - (($request['subscription_years'] - 1) / 100) * (($data->amount * $request['subscription_years']) * 5);
        // ### CreditCard
        $card = Paypalpayment::creditCard();

        $card->setType($request['card_type'])
            ->setNumber($request['card_number'])
            ->setExpireMonth($request['expiration_month'])
            ->setExpireYear($request['expiration_year'])
            ->setCvv2($request['cvc'])
            ->setFirstName($this->current_user()->first_name)
            ->setLastName($this->current_user()->last_name);

        // ### FundingInstrument
        // A resource representing a Payer's funding instrument.
        // Use a Payer ID (A unique identifier of the payer generated
        // and provided by the facilitator. This is required when
        // creating or using a tokenized funding instrument)
        // and the `CreditCardDetails`
        $fi = Paypalpayment::fundingInstrument();
        $fi->setCreditCard($card);

        // ### Payer
        // A resource representing a Payer that funds a payment
        // Use the List of `FundingInstrument` and the Payment Method
        // as 'credit_card'
        $payer = Paypalpayment::payer();
        $payer->setPaymentMethod("credit_card")
            ->setFundingInstruments(array($fi));

        $item1 = Paypalpayment::item();
        $item1->setName('Condat Solutions')
            ->setDescription('Condat Subscription Renew')
            ->setCurrency('AUD')
            ->setQuantity(1)
            ->setPrice($amount);

        $itemList = Paypalpayment::itemList();
        $itemList->setItems(array($item1));


        $details = Paypalpayment::details();

        //Payment Amount
        $amountObj = Paypalpayment::amount();
        $amountObj->setCurrency("AUD")
            ->setTotal($amount)
            ->setDetails($details);

        // ### Transaction
        // A transaction defines the contract of a
        // payment - what is the payment for and who
        // is fulfilling it. Transaction is created with
        // a `Payee` and `Amount` types

        $transaction = Paypalpayment::transaction();
        $transaction->setAmount($amountObj)
            ->setItemList($itemList)
            ->setDescription("Condat Subscription Renew")
            ->setInvoiceNumber(uniqid());

        // ### Payment
        // A Payment Resource; create one using
        // the above types and intent as 'sale'

        $payment = Paypalpayment::payment();

        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setTransactions(array($transaction));

        try {
            // ### Create Payment
            // Create a payment by posting to the APIService
            // using a valid ApiContext
            // The return object contains the status;
            $payment->create($this->_apiContext);
            return $payment;

        } catch (PayPalConnectionException $ex) {
        //} catch (\PayPalConnectionException $ex) {
            echo $ex->getData();
            return  "Exception: " . $ex->getMessage() . PHP_EOL;
            exit(1);
        }
    }

    public function complete_subscription_paypal($tenant_id)
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
            $update = $this->subscription->renew_paypal($payment_data['CUSTOM'], $tenant_id);
            ($update) ? Flash::success('Subscription has been renewed successfully.') : Flash::danger('Subscription could not be renewed.');
            return redirect()->route('tenant.user.index', $tenant_id);
        } catch (Exception $e) {
            Flash::success($e->getMessage());
            return redirect()->route('tenant.user.index', $tenant_id);
        }
    }

    public function test()
    {
        dd(date('l jS \of F Y h:i:s A'));
        $agency_id = 19;

        // sending email to agency
        $complete_profile_url = url($agency_id.'/login?tenant=' . $agency_id . '&auth_code=');
        $agency_url = route('tenant.login', $agency_id);
        $agency_message = <<<EOD
<strong>Test, </srtong>
<p>Your agency account has been created successfully on Condat Solutions. Please <a href="$complete_profile_url">click here</a> or follow the link below to complete the registration process.</p>
<a href="$complete_profile_url">$complete_profile_url</a>

<p><strong>Login Steps</strong><br/><br/>

Once setup is done you can login to your account.
To access your login page please always follow the link below: <br/>
$agency_url<br/><br/>
Or you can also access your system link from LOG IN section of <a href= "condat.com.au"> condat.com.au</a></p>
EOD;

        $param = ['content' => $agency_message,
            'subject' => 'Agency Created Successfully',
            'heading' => 'Condat Solutions',
            'subheading' => 'Work Smart Work Fast',
        ];
        $data = ['to_email' => 'krita.maharjan@gmail.com',
            'to_name' => "test",
            'subject' => 'Agency Created Successfully',
            'from_email' => env('FROM_EMAIL', 'info@condat.com.au'), //change this later
            'from_name' => 'Condat Solutions', //change this later
        ];

        \Mail::send('template.master', $param, function ($message) use ($data) {
            $message->to($data['to_email'], $data['to_name'])
                ->subject($data['subject'])
                ->from($data['from_email'], $data['from_name']);
        });
    }
}
