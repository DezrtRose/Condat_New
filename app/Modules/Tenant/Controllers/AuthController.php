<?php namespace App\Modules\Tenant\Controllers;

use App\Http\Requests;
use App\Modules\Agency\Models\AgencySubscription;
use App\Modules\Tenant\Models\Address;
use App\Modules\Tenant\Models\Person\Person;
use App\Modules\Tenant\Models\Person\PersonAddress;
use App\Modules\Tenant\Models\Person\PersonPhone;
use App\Modules\Tenant\Models\Phone;
use App\Modules\Tenant\Models\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Flash;
use Mail;

class AuthController extends BaseController {

    protected $auth;

    function __construct(Guard $auth)
    {
        parent::__construct();
        $this->auth = $auth;
    }

    public function getLogin($tenant_id, Request $request)
    {
        $url_query = $request->all();
        if(isset($url_query['auth_code']) && $url_query['auth_code'] != '') {
            $agent_data = User::join('persons', 'persons.person_id', '=', 'users.person_id')
                ->where([
                    ['auth_code', '=', $url_query['auth_code']],
                    ['password', '=', '']
                ])->first();
            if($agent_data) {
                return view('Auth::setup', compact('agent_data'));
            }
            Flash::success('User not found. Or password already set.');
        }
        return view('Auth::login');
    }

    public function postLogin($tenant_id, Request $request, User $tenantUser)
    {
        $rules = array('email' => 'required', 'password' => 'required');
        $this->validate($request, $rules);


        $credentials = $request->only('email', 'password');
        if (auth()->guard('tenants')->attempt($credentials, $request->has('remember'))) {

            //Check if subscription has exceeded the date
            $agency_subscription = AgencySubscription::where('agency_id', '=', $tenant_id)->where('is_current', '=', 1)->first();

            if($agency_subscription) {
                if($agency_subscription->end_date < date('Y-m-d')) {
                    Flash::error('The subscription date has been exceeded. Please renew your subscription to access the features.');
                    return redirect()->route('tenant.subscription.renew', $tenant_id);
                }
            }
            return $tenantUser->redirectIfValid(auth()->guard('tenants')->user(), $tenant_id);
        }
        return redirect()->route('tenant.login', $tenant_id)->with('message', 'These credentials do not match our records.')->withInput($request->only('email', 'remember'));
    }

    public function logout($tenant_id)
    {
        auth()->logout();
        return redirect()->route('tenant.login', $tenant_id);
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRegister()
    {
        return view('Auth::register');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postRegister(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $created = Auth::login($this->create($request->all()));
        if($created) {

        }

        return redirect('dashboard');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'given_name' => 'required|max:255',
            'surname' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'given_name' => $data['given_name'],
            'surname' => $data['surname'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'status' => 0 //pending
        ]);
    }

    public function complete($tenant_id, Request $request)
    {
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone_id' => 'required',
            'password' => 'required',
            'repassword' => 'required',
            'sex' => 'required'
        ];

        $this->validate($request, $rules);

        $profile_data = $request->all();
        $user = User::where('email', $profile_data['email'])->first();
        $user->password = bcrypt($profile_data['password']);
        $user->status = 1;
        $user->save();

        $person = Person::find($user->person_id);
        $person->first_name = $profile_data['first_name'];
        $person->last_name = $profile_data['last_name'];
        $person->sex = $profile_data['sex'];
        $person->save();

        $person_phone = PersonPhone::where(['person_id' => $user->person_id])->first();
        if($person_phone) {
            $phone = Phone::find($person_phone->phone_id);
            $phone->number = $profile_data['phone_id'];
            $phone->type = 1;
            $phone->save();
        } else {
            $phone = Phone::create(['number' => $profile_data['phone_id']]);
            PersonPhone::create([
                'person_id' => $person->person_id,
                'phone_id' => $phone->phone_id
            ]);
        }

        $address = Address::create([
            'street' => $profile_data['street'],
            'suburb' => $profile_data['suburb'],
            'postcode' => $profile_data['postcode'],
            'state' => $profile_data['state'],
            'country_id' => $profile_data['country_id']
        ]);

        PersonAddress::create([
            'address_id' => $address->address_id,
            'person_id' => $person->person_id
        ]);

        $login_url = url($profile_data['tenant'].'/login');
        $agency_message = <<<EOD
<p>Your profile is complete. <a href="{$login_url}">Click Here</a> to login to your account.</p>
EOD;

        $param = ['content' => $agency_message,
            'subject' => 'Profile complete',
            'heading' => 'Condat Solutions',
            'subheading' => 'All your business in one space',
        ];
        $data = ['to_email' => $profile_data['email'],
            'to_name' => '',
            'subject' => 'Profile complete',
            'from_email' => env('FROM_EMAIL', 'info@condat.com.au'), //change this later
            'from_name' => 'Condat Solutions', //change this later
        ];

        /*Mail::send('template.master', $param, function ($message) use ($data) {
            $message->to($data['to_email'], $data['to_name'])
                ->subject($data['subject'])
                ->from($data['from_email'], $data['from_name']);
        });*/

        Flash::success('Profile has been completed. Please login.');
        return redirect()->route('tenant.login', $tenant_id);
    }

}
