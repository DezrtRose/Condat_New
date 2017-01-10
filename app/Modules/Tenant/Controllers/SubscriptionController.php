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
use PaypalPayment;

class SubscriptionController extends BaseController
{
    protected $request;
    private $_apiContext;
    public function __construct(Request $request, Subscription $subscription)
    {
        $this->request = $request;
        $this->subscription = $subscription;
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
        if(!$this->checkAuthority() && $user_id != $this->request->segment(3)) {
            abort(403, 'Unauthorized action.');
        }
        $agency_id = current_tenant_id();
        $data['companyDetails'] = Company::where('agencies_agent_id', $agency_id)->first();

        $data['agency_subscription'] = $agency_subscription = AgencySubscription::where('agency_id', '=', $tenant_id)->where('is_current', '=', 1)->first();
        //dd($agency_subscription->toArray());
            if($agency_subscription->end_date < date('Y-m-d')) {
                return view('Tenant::Subscription/earlyrenew', $data);
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
        $agency_id = current_tenant_id();
        $req = $this->request->all();

        if($req['payment_type'] == 'Credit Card')
            $this->_card_payment($req);
        else
            $this->subscription->renew($req, $agency_id);
    }

    public function _card_payment($request)
    {
        $this->_apiContext = Paypalpayment::ApiContext(config('paypal_payment.account.ClientId'), config('paypal_payment.account.ClientSecret'));
        $subscription_id = $request['subscription_type'];
        //$base_amount = $this->amount($subscription_id);
        $base_amount = 10;
        $amount = ($base_amount * $request['subscription_years']) - (($request['subscription_years'] - 1) / 100) * (($base_amount * $request['subscription_years']) * 5);
        // ### CreditCard
        $card = Paypalpayment::creditCard();
        $card->setType("visa")
            ->setNumber("4758411877817150")
            ->setExpireMonth("05")
            ->setExpireYear("2019")
            ->setCvv2("456")
            ->setFirstName("Joe")
            ->setLastName("Shopper");

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
        $item1->setName('Ground Coffee 40 oz')
            ->setDescription('Ground Coffee 40 oz')
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
            ->setDescription("Payment description")
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
        } catch (\PPConnectionException $ex) {
            return  "Exception: " . $ex->getMessage() . PHP_EOL;
            exit(1);
        }

        dd($payment);
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
            ($update) ? Flash::success('Subscription has been renewed successfully.') : Flash::success('Subscription could not be renewed.');
            return redirect()->route('tenant.user.index', $tenant_id);
        } catch (Exception $e) {
            Flash::success($e->getMessage());
            return redirect()->route('tenant.user.index', $tenant_id);
        }
    }

    public function test()
    {
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
