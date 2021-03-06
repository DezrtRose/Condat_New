<?php namespace App\Modules\Frontend\Controllers;

use App\Http\Controllers\BaseController;
use App\Http\Requests;
use App\Modules\Agency\Models\Agency;
use App\Modules\System\Models\Subscription;
use Illuminate\Http\Request;
use Flash;
use Mail;

class FrontendController extends BaseController {

    protected $request;

    function __construct(Agency $agency, Request $request)
    {
        $this->agency = $agency;
        $this->request = $request;
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view("Frontend::index");
    }

    /**
     * Show the form for creating a new agency.
     * @param $subscription
     * @return Response
     */
    public function register(Subscription $subscription)
    {
        /*$agency_message = "Test message";

        $param = ['content' => $agency_message,
            'subject' => 'Profile complete',
            'heading' => 'Condat Solutions',
            'subheading' => 'All your business in one space',
        ];
        $data = ['to_email' => 'satshanker.01@gmail.com',
            'to_name' => '',
            'subject' => 'Profile complete',
            'from_email' => 'info@condat.com.au', //change this later
            'from_name' => 'Condat Solutions', //change this later
        ];

        Mail::send('template.master', $param, function ($message) use ($data) {
            $message->to($data['to_email'], $data['to_name'])
                ->subject($data['subject'])
                ->from($data['from_email'], $data['from_name']);
        });*/
        $subscriptions = $subscription->lists('name', 'subscription_id');
        return view('Frontend::Agency/add', compact('subscriptions'));
    }

    /**
     * Store a newly created agency in storage.
     *
     * @return Response
     */
    public function store()
    {
        $rules = [
            'description' => 'min:2',
            'name' => 'required|min:2|max:145',
            'abn' => 'required|min:2|max:145',
            'phone_id' => 'required|min:2|max:145',
            'email_id' => 'required|email|min:5|max:145|unique:companies',
            'g-recaptcha-response' => 'required|recaptcha',
        ];

        $this->validate($this->request, $rules);
        // if validates
        $request = $this->request->all();
        $created = $this->agency->add($request);
        if($created)
            Flash::success('Agency has been registered successfully. Please check your email for further set up details.');
        return redirect()->route('frontend.agency');
    }

    /**
     * Create APP
     * @param $stringy
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

    public function contact(Request $request)
    {
        $rules = [
            'name' => 'required|min:2|max:145',
            'subject' => 'required|min:2',
            'email' => 'required|email|min:5',
            'message' => 'required',
            'g-recaptcha-response' => 'required|recaptcha',
        ];
        $this->validate($this->request, $rules);

        $admin_email = 'support@condat.com.au';
        $formData = $request->all();

        $message = $formData['message'];

        $param = ['content' => $message,
            'subject' => $formData['subject'],
            'heading' => 'Condat Solutions',
            'subheading' => 'All your business in one space',
        ];
        $data = ['to_email' => $admin_email,
            'to_name' => '',
            'subject' => $formData['subject'],
            'from_email' => env('FROM_EMAIL', 'info@condat.com.au'),
            'from_name' => 'Condat Solutions',
            'reply_to' => $formData['email']
        ];

        $status = Mail::send('template.master', $param, function ($message) use ($data) {
            $message->to($data['to_email'], $data['to_name'])
                ->subject($data['subject'])
                ->replyTo($data['reply_to'])
                ->from($data['from_email'], $data['from_name']);
        });

        echo $status ? 'Thank you for contacting us. We will get back to you soon.' : 'Could not deliver your message. Please try again later.';die;
    }

}
