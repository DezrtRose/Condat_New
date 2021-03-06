<?php namespace App\Modules\Tenant\Models\Client;

use App\Modules\Tenant\Models\Application\StudentApplicationPayment;
use App\Modules\Tenant\Models\Email;
use App\Modules\Tenant\Models\Person\PersonEmail;
use App\Modules\Tenant\Models\Person\PersonPhone;
use App\Modules\Tenant\Models\Phone;
use App\Modules\Tenant\Models\Photo;
use App\Modules\Tenant\Models\Timeline\ClientTimeline;
use App\Modules\Tenant\Models\Timeline\Timeline;
use App\Modules\Tenant\Models\Timeline\TimelineType;
use App\Modules\Tenant\Models\User;
use App\Modules\Tenant\Models\Address;
use App\Modules\Tenant\Models\Person\Person;
use App\Modules\Tenant\Models\Person\PersonAddress;
use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon;
use File;

class Client extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'clients';

    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'client_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['added_by', 'user_id', 'person_id', 'description', 'referred_by'];

    /**
     * Get the person record associated with the client.
     */
    public function person()
    {
        return $this->belongsTo('App\Modules\Tenant\Models\Person\Person', 'person_id');
    }

    /**
     * Get the user record associated with the client.
     */
    public function user()
    {
        return $this->belongsTo('App\Modules\Tenant\Models\User');
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
                'sex' => $request['sex'],
                'passport_no' => $request['passport_no']
            ]);

            /*$user = User::create([
                'email' => $request['email'],
                'role' => 0, // 0 : client, 1 : admin, 2 : super-admin
                'status' => 0, // Pending
                'person_id' => $person->person_id, // pending
            ]);*/

            $email = Email::create([
                'email' => $request['email']
            ]);

            PersonEmail::create([
                'person_id' => $person->person_id,
                'email_id' => $email->email_id,
                'is_primary' => 1
            ]);

            $client = Client::create([
                //'user_id' => $user->user_id,
                'person_id' => $person->person_id,
                'added_by' => current_tenant_id(),
                'referred_by' => $request['referred_by'],
                'description' => $request['description'],
            ]);

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
            return $client->client_id;
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            // something went wrong
        }
    }

    /*
     * Update client info
     * Output boolean
     */
    function edit(array $request, $client_id)
    {
        DB::beginTransaction();

        try {

            $client = Client::find($client_id);
            $client->referred_by = $request['referred_by'];
            $client->description = $request['description'];
            $client->save();
            // Saving client profile
            $person = Person::find($client->person_id);
            $person->first_name = $request['first_name'];
            $person->middle_name = $request['middle_name'];
            $person->last_name = $request['last_name'];
            $person->dob = insert_dateformat($request['dob']);
            $person->sex = $request['sex'];
            $person->passport_no = $request['passport_no'];
            $person->save();

            $person_email = PersonEmail::firstOrCreate(['person_id' => $client->person_id]);

            //for when not saved, remove this when no old records
            if ($person_email->email_id != 0) {
                $email = Email::find($person_email->email_id);
                $email->email = $request['email'];
                $email->save();

            } else { //remove this one
                $email = Email::create([
                    'email' => $request['email']
                ]);
                $person_email->email_id = $email->email_id;
                $person_email->save();
            }
            $person_address = PersonAddress::where('person_id', $client->person_id)->first();
            $address = Address::find($person_address->address_id);

            // Edit address
            $address->street = $request['street'];
            $address->suburb = $request['suburb'];
            $address->postcode = $request['postcode'];
            $address->state = $request['state'];
            $address->country_id = $request['country_id'];
            $address->save();

            $person_phone = PersonPhone::where('person_id', $client->person_id)->first();
            $phone = Phone::find($person_phone->phone_id);

            // Edit phone
            $phone->number = $request['number'];
            $phone->save();

            DB::commit();
            return true;
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            //return false;
            dd($e);
            // something went wrong
        }
    }

    /*
     * Update client info
     * Output Response
     */
    function getDetails($client_id)
    {
        $client = Client::leftJoin('persons', 'persons.person_id', '=', 'clients.person_id')
            ->leftJoin('person_addresses', 'person_addresses.person_id', '=', 'persons.person_id')
            ->leftJoin('addresses', 'addresses.address_id', '=', 'person_addresses.address_id')
            ->leftJoin('person_phones', 'person_phones.person_id', '=', 'persons.person_id')
            ->leftJoin('phones', 'phones.phone_id', '=', 'person_phones.phone_id')
            ->leftJoin('photos', 'photos.photo_id', '=', 'persons.photo_id')
            ->leftJoin('person_emails', 'person_emails.person_id', '=', 'persons.person_id')
            ->leftJoin('emails', 'emails.email_id', '=', 'person_emails.email_id')
            ->where('clients.client_id', $client_id)
            ->first(); //dd($client->toArray());
        return $client;
    }

    function duePayment($client_id)
    {
        $paid_amount = ClientPayment::leftJoin('student_application_payments', 'client_payments.client_payment_id', '=', 'student_application_payments.client_payment_id')
            ->join('payment_invoice_breakdowns', 'client_payments.client_payment_id', '=', 'payment_invoice_breakdowns.payment_id')
            ->where('client_id', $client_id)
            ->sum('client_payments.amount');
        $invoice_amount = $this->getInvoiceAmount($client_id);
        $outstanding = $invoice_amount - $paid_amount;
        return $outstanding;
    }

    function getInvoiceAmount($client_id)
    {
        $invoice_amount = Client::join('student_invoices', 'student_invoices.client_id', '=', 'clients.client_id')
            ->join('invoices', 'student_invoices.invoice_id', '=', 'invoices.invoice_id')
            ->leftjoin('persons', 'persons.person_id', '=', 'clients.person_id')
            ->where('clients.client_id', $client_id)
            ->sum('final_total');
        return $invoice_amount;
    }

    /*
     * Add logs for timeline
     */
    function addLog($client_id, $type_id, array $param = array(), $app_id = null)
    {
        $message = $this->getTimelineTemplate($type_id, $param);

        $timeline = Timeline::create([
            //'client_id' => $client_id,
            'created_date' => Carbon\Carbon::today(),
            'timeline_type_id' => $type_id,
            'message' => $message,
            'added_by' => current_tenant_id(),
            'created_at' => Carbon\Carbon::now()
        ]);

        ClientTimeline::create([
            'client_id' => $client_id,
            'timeline_id' => $timeline->timeline_id,
            'application_id' => $app_id,
        ]);
    }

    /**
     * Get Template setting from database
     * @param $templateKey
     * @param $param
     * @return \stdClass
     */
    function getTimelineTemplate($type_id, $param)
    {
        $message = '';
        $template = TimelineType::find($type_id);
        if (!empty($template)) {
            $header = str_replace(array_keys($param), array_values($param), $template->header);
            $body = str_replace(array_keys($param), array_values($param), $template->body);
            $footer = str_replace(array_keys($param), array_values($param), $template->footer);
            $add_class = ($template->body == null && $template->footer == null) ? ' no-border' : '';
            $message = '<h3 class="timeline-header' . $add_class . '">' . $header . '</h3>';
            $message .= ($template->body != null) ? '<div class="timeline-body">' . $body . '</div>' : '';
            $message .= ($template->footer != null) ? '<div class="timeline-footer">' . $footer . '</div>' : '';
        }
        return $message;
    }

    function getEmail($client_id)
    {
        $email = Client::leftJoin('persons', 'persons.person_id', '=', 'clients.person_id')
            ->leftJoin('person_emails', 'person_emails.person_id', '=', 'persons.person_id')
            ->leftJoin('emails', 'emails.email_id', '=', 'person_emails.email_id')
            ->find($client_id);
        return !empty($email) ? $email->email : '';
    }

    function uploadImage($client_id, $file, array $request)
    {
        DB::beginTransaction();
        try {
            $client = Client::find($client_id);
            $person = Person::find($client->person_id);
            $photo = Photo::create([
                'title' => $request['title'],
                'filename' => $file['fileName'],
                'shelf_location' => $file['pathName'],
                'user_id' => current_tenant_id()
            ]);

            $person->photo_id = $photo->photo_id;
            $person->save();

            DB::commit();
            return $photo->photo_id;
        } catch (Exception $e) {
            File::delete(tenant()->folder('customer')->path($file['fileName']));
            DB::rollback();
            dd($e);
            return false;
        }

    }

    function getClientNameList()
    {
        $list = Client::join('persons', 'persons.person_id', '=', 'clients.person_id')
            ->select('client_id', DB::raw('CONCAT(persons.first_Name, " ", persons.last_Name) AS full_name'))
            ->orderBy('full_name', 'asc')
            ->lists('full_name', 'client_id');
        return $list;
    }

    function getList()
    {
        $clients = Client::leftJoin('persons', 'clients.person_id', '=', 'persons.person_id')
            ->leftJoin('person_emails', 'person_emails.person_id', '=', 'persons.person_id')
            ->leftJoin('emails', 'emails.email_id', '=', 'person_emails.email_id')
            ->leftJoin('person_addresses', 'person_addresses.person_id', '=', 'persons.person_id')
            ->leftJoin('addresses', 'addresses.address_id', '=', 'person_addresses.address_id')
            ->join('users', 'clients.added_by', '=', 'users.user_id')
            ->join('persons as user_profile', 'user_profile.person_id', '=', 'users.person_id')
            ->leftJoin('person_phones', 'person_phones.person_id', '=', 'persons.person_id')
            ->leftJoin('phones', 'phones.phone_id', '=', 'person_phones.phone_id')
            ->leftJoin('active_clients', function ($q) {
                $q->on('active_clients.client_id', '=', 'clients.client_id');
                $q->where('active_clients.user_id', '=', current_tenant_id());
            })
            ->select(['clients.client_id', 'clients.added_by', 'clients.added_by', 'clients.referred_by', 'emails.email', 'phones.number', 'clients.created_at', DB::raw('CONCAT(persons.first_name, " ", persons.last_name) AS fullname'), DB::raw('CONCAT(user_profile.first_name, " ", user_profile.last_name) AS added_by'), 'active_clients.id as active_id', 'addresses.country_id'])
            ->get();
        return $clients;
    }


    /*
     * Import client info
     * Output client id
     */
    function import(array $request)
    {
        // Saving client profile
        $person = Person::create([
            'first_name' => $request['first_name'],
            'middle_name' => ($request['middle_name'] == null) ? '' : $request['middle_name'],
            'last_name' => $request['last_name'],
            'dob' => ($request['dob'] == null) ? '' : insert_dateformat($request['dob']),
            'sex' => ($request['sex'] == null) ? 'Male' : $request['sex'],
            'passport_no' => ($request['passport_no'] == null) ? '' : $request['passport_no']
        ]);

        /*$user = User::create([
            'email' => $request['email'],
            'role' => 0, // 0 : client, 1 : admin, 2 : super-admin
            'status' => 0, // Pending
            'person_id' => $person->person_id, // pending
        ]);*/

        $email = Email::create([
            'email' => ($request['email'] == null) ? '' : $request['email']
        ]);

        PersonEmail::create([
            'person_id' => $person->person_id,
            'email_id' => $email->email_id,
            'is_primary' => 1
        ]);

        $client = Client::create([
            //'user_id' => $user->user_id,
            'person_id' => $person->person_id,
            'added_by' => current_tenant_id(),
            'referred_by' => ($request['referred_by'] == null) ? '' : $request['referred_by'],
            'description' => ($request['description'] == null) ? '' : $request['description'],
        ]);

        // Add address
        $address = Address::create([
            'street' => ($request['street'] == null) ? '' : $request['street'],
            'suburb' => ($request['suburb'] == null) ? '' : $request['suburb'],
            'postcode' => ($request['postcode'] == null) ? '' : $request['postcode'],
            'state' => ($request['state'] == null) ? '' : $request['state'],
            'country_id' => ($request['country'] == null) ? '263' : get_country_id($request['country']),
        ]);

        PersonAddress::create([
            'address_id' => $address->address_id,
            'person_id' => $person->person_id,
            'is_current' => 1
        ]);

        // Add Phone Number
        $phone = new Phone();
        $number = ($request['phone'] == null) ? '' : $request['phone'];
        $phone_id = $phone->add($number);
        PersonPhone::create([
            'phone_id' => $phone_id,
            'person_id' => $person->person_id,
            'is_primary' => 1
        ]);

        return $client->client_id;
    }
}
