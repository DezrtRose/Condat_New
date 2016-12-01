<?php namespace App\Modules\Tenant\Models;

use App\Modules\Tenant\Models\Person\PersonAddress;
use App\Modules\Tenant\Models\Person\PersonEmail;
use App\Modules\Tenant\Models\Person\PersonPhone;
use App\Modules\Tenant\Models\Phone;
use App\Modules\Tenant\Models\Person\Person;
use Illuminate\Http\Request;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use App\Models\Tenant\Profile;
use Illuminate\Support\Facades\Request as FacadeRequest;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{

    use Authenticatable, CanResetPassword;


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';
    protected $primaryKey = 'user_id';

    protected $connection = "tenant";

    /* Change the authentication guard to tenants */
    protected $guard = "tenants";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['email', 'password', 'status', 'activation_key', 'domain', 'role', 'permissions', 'person_id'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function profile()
    {
        return $this->belongsTo('App\Modules\Tenant\Models\Person\Person', 'person_id');
    }

    function redirectIfValid($user, $tenant_id)
    {
        /*if ($user->status == 0) {
            \Auth::logout();
            return redirect()->route('system.login')->withInput()->with('message', 'Your account has not been activated.');
        } else*/
        if ($user->status == 2) {
            \Auth::logout();
            return redirect()->route('tenant.login', $tenant_id)->withInput()->with('message', 'Your account has been suspended.');
        } elseif ($user->status == 3) {
            \Auth::logout();
            return redirect()->route('tenant.login', $tenant_id)->withInput()->with('message', 'Your account has been permanently blocked.');
        }
        if($user->role == 2) //Accountant
            return redirect()->route('client.invoice.pending', $tenant_id);
        else
            return redirect()->route('users.dashboard', $tenant_id);
    }

    function saveUser($email = '', $details = array())
    {
        $setup = User::firstOrCreate(['email' => $email]);
        $setup->fullname = $details['fullname'];
        $setup->password = bcrypt($details['password']);
        $setup->save();
        Profile::firstOrCreate(['user_id' => $setup->id]);
    }

    function role()
    {
        return isset($this->role[$this->role]) ? $this->role[$this->role] : 'Unknown';
    }

    function withGuid($guid)
    {
        return User::with('Profile')->where('guid', $guid)->first();
    }

    public function getUserDetails($guid = '')
    {
        $details = DB::table('fb_users')
            ->join('fb_profile', 'fb_users.id', '=', 'fb_profile.user_id')
            ->where('fb_users.guid', $guid)
            ->first();

        $details->permissions = ($details->permissions != '') ? @unserialize($details->permissions) : '';

        return $details;
    }

    /*
     * Add client info
     * Output client id
     */
    function add(array $request)
    {
        DB::beginTransaction();

        try {
            // Saving client profile
            $person = Person::create([
                'first_name' => $request['first_name'],
                'middle_name' => $request['middle_name'],
                'last_name' => $request['last_name'],
                'dob' => insert_dateformat($request['dob']),
                'sex' => $request['sex']
            ]);

            $user = User::create([
                'role' => $request['role'], // 1 : admin, 2 :staff, 3 : accountant Fix this later
                'status' => 0, // Pending
                'person_id' => $person->person_id,
                'email' => $request['email']
            ]);
            $user->auth_code = md5($user->user_id);
            $user->save();

            /*$email = Email::create([
                'email' => $request['email']
            ]);

            PersonEmail::create([
                'person_id' => $person->person_id,
                'email_id' => $email->email_id,
                'is_primary' => 1
            ]);*/


            // Add address
            $address = Address::create([
                'street' => $request['street'],
                'suburb' => $request['suburb'],
                'postcode' => $request['postcode'],
                'state' => $request['state'],
                'country_id' => $request['country_id'],
            ]);

            PersonAddress::create([
                'address_id' => $address->address_id,
                'person_id' => $person->person_id,
                'is_current' => 1
            ]);

            // Add Phone Number
            $phone = new Phone();
            $phone_id = $phone->add($request['number']);
            PersonPhone::create([
                'phone_id' => $phone_id,
                'person_id' => $person->person_id,
                'is_primary' => 1
            ]);

            DB::commit();
            return $user->user_id;
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            // something went wrong
        }
    }

    public function addUserDetails($details)
    {
        if (isset($details['permissions'])) {
            $per = serialize($details['permissions']);
        } else {
            $per = '';
        }
        $user = User::create([
            'fullname' => $details['fullname'],
            'password' => \Hash::make($details['password']),
            'role' => 2, //sub-user
            'first_time' => 1,
            'email' => $details['email'],
            'status' => 0, //pending
            'activation_key' => \FB::uniqueKey(15, 'fb_users', 'activation_key'),
            'permissions' => $per
        ]);

        $user_id = $user->id;

        $fileName = null;
        if (FacadeRequest::hasFile('photo')) {
            $file = FacadeRequest::file('photo');
            $fileName = \FB::uploadFile($file);
        }

        $email_setting_details = $details->only('incoming_server', 'outgoing_server', 'email_username', 'email_password');
        $personal_email_setting = json_encode($email_setting_details);

        $profile = Profile::create([
            'user_id' => $user_id,
            'phone' => $details['phone'],
            'address' => $details['address'],
            'postcode' => $details['postcode'],
            'town' => $details['town'],
            'comment' => $details['comment'],
            'tax_card' => $details['tax_card'],
            'photo' => $fileName,
            'social_security_number' => $details['social_security_number'],
            'smtp' => $personal_email_setting
        ]);

        $this->sendConfirmationMail($user->activation_key, $details['fullname'], $details['email']);

        $added_user['data'] = $this->toFomatedData($user);
        $added_user['template'] = $this->getTemplate($user);

        return $added_user;
    }

    /**
     * Send activation code in user's email
     * @param string $activation_key
     * @param string $username
     * @param string $email
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function sendConfirmationMail($activation_key = '', $username = '', $email = '')
    {
        //$link = \URL::route('subuser.register.confirm', $activation_key); //change this
        $link = tenant_route('subuser.register.confirm', array('confirmationCode' => $activation_key)); //change this
        \FB::sendEmail($email, $username, 'confirmation_email', ['{{NAME}}' => $username, '{{ACTIVATION_URL}}' => $link . " "]);
        $message = 'User created successfully.';
        \Flash::success($message);
    }


    public function edit(array $request, $user_id)
    {
        DB::beginTransaction();

        try {
            $user = User::find($user_id);
            isset($request['role'])? $user->role = $request['role'] : '';
            $user->email = $request['email'];
            $user->save();

            //$person_email = PersonEmail::firstOrCreate(['person_id' => $user->person_id]);

            //for when not saved, remove this when no old records
            /*if ($person_email->email_id != 0) {
                $email = Email::find($person_email->email_id);
                $email->email = $request['email'];
                $email->save();

            } else { //remove this one
                $email = Email::create([
                    'email' => $request['email']
                ]);
                $person_email->email_id = $email->email_id;
                $person_email->save();
            }*/

            $person = Person::find($user->person_id);
            $person->first_name = $request['first_name'];
            $person->middle_name = $request['middle_name'];
            $person->last_name = $request['last_name'];
            $person->dob = insert_dateformat($request['dob']);
            $person->sex = $request['sex'];
            $person->save();

            $person_add = PersonAddress::where('person_id', $person->person_id)->first();
            if (empty($person_add)) {
                $address = Address::create();
                PersonAddress::create([
                    'person_id' => $person->person_id,
                    'is_current' => 1,
                    'address_id' => $address->address_id
                ]);
            } else {
                $address = Address::find($person_add->address_id);
            }
            $address->street = $request['street'];
            $address->suburb = $request['suburb'];
            $address->postcode = $request['postcode'];
            $address->state = $request['state'];
            $address->country_id = $request['country_id'];
            $address->save();

            // Add Phone Number
            $person_ph = PersonPhone::where('person_id', $person->person_id)->first();
            if (empty($person_ph)) {
                $phone = Phone::create();
                PersonPhone::create([
                    'person_id' => $person->person_id,
                    'is_primary' => 1,
                    'phone_id' => $phone->phone_id
                ]);
            } else {
                $phone = Phone::find($person_ph->phone_id);
            }
            $phone->number = $request['number'];
            $phone->save();

            DB::commit();
            return $user->user_id;
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            // something went wrong
        }
    }

    public function getTemplate($details = '')
    {
        $details->fullname = "<a href='" . tenant()->url('user') . "/" . $details->guid . "'>" . $details->fullname . "</a>";
        if ($details->status == 1)
            $details->status = '<span class="label label-success">Active</span>';
        elseif ($details->status == 2)
            $details->status = '<span class="label label-warning">Suspended</span>';
        elseif ($details->status == 3)
            $details->status = '<span class="label label-danger">Blocked</span>';
        else
            $details->status = '<span class="label label-warning">Pending</span>';

        $details->created = $details->created_at->format('d-M-Y h:i:s A');
        $details->days = '<a href="#" title="Register vacation" data-original-title="Edit" class="btn btn-box-tool" data-toggle="modal" data-url="' . tenant()->url('user/registerDays/vacation') . "/" . $details->guid . '" data-target="#fb-modal">Vacation</a><a href="#" title="Register Sick days" data-original-title="Edit" class="btn btn-box-tool" data-toggle="modal" data-url="' . tenant()->url('user/registerDays/sick') . "/" . $details->guid . '" data-target="#fb-modal">Sick</a>';


        $template = "<td>" . $details->fullname . "</td>
                     <td>" . $details->created . "</td>
                     <td>" . $details->email . "</td>
                     <td>" . $details->status . "</td>
                     <td>" . $details->days . "</td>";

        return $template;
    }

    function toFomatedData($data)
    {
        foreach ($data as $k => &$items) {
            $this->toArray();
        }

        return $data;
    }

    function isAdmin()
    {
        return ($this->role == 1) ? true : false;
    }

    function isUser()
    {
        return ($this->role == 2) ? true : false;
    }

    /*
     * Update user info
     * Output Response
     */
    function getDetails($user_id)
    {
        $user = User::join('persons', 'persons.person_id', '=', 'users.person_id')
            ->leftJoin('person_addresses', 'person_addresses.person_id', '=', 'persons.person_id')
            ->leftJoin('addresses', 'addresses.address_id', '=', 'person_addresses.address_id')
            ->leftJoin('person_phones', 'person_phones.person_id', '=', 'persons.person_id')
            ->leftJoin('phones', 'phones.phone_id', '=', 'person_phones.phone_id')
            ->where('users.user_id', $user_id)//and user for email?
            ->first();
        return $user;
    }

    public function activeClient()
    {
        $activeClient = DB::table('active_clients')
            ->leftJoin('clients', 'active_clients.client_id', '=', 'clients.client_id')
            ->leftJoin('persons', 'persons.person_id', '=', 'clients.person_id')
            ->leftJoin('person_addresses', 'person_addresses.person_id', '=', 'persons.person_id')
            ->leftJoin('addresses', 'addresses.address_id', '=', 'person_addresses.address_id')
            ->leftJoin('person_phones', 'person_phones.person_id', '=', 'persons.person_id')
            ->leftJoin('phones', 'phones.phone_id', '=', 'person_phones.phone_id')
            ->leftJoin('person_emails', 'person_emails.person_id', '=', 'persons.person_id')
            ->leftJoin('emails', 'emails.email_id', '=', 'person_emails.email_id')
            //->leftJoin('users', 'users.user_id', '=', 'clients.user_id')
            ->where('active_clients.user_id', current_tenant_id())
            ->get();
        return $activeClient;
    }

    function getList()
    {
        $users = User::join('persons', 'persons.person_id', '=', 'users.person_id')
            ->select('users.user_id', DB::raw('CONCAT(persons.first_name, " ", persons.last_name) AS full_name'))
            ->orderBy('full_name')
            ->lists('full_name', 'user_id');
        return $users;
    }
}
