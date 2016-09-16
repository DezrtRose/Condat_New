<?php
namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Person;
use App\Models\Email;
use App\Models\Phone;
use App\Models\Address;



Class Client extends Model{
	

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'clients';
	protected $fillable = [ 'first_name','middle_name','last_name','dob','sex','phone_no','passport_no',
        'email','user_id','reffered_by','person_id', 'street','suburb',
        'state',
        'postcode',
        'country_id',
        'google_map',
        'type'];



	public function colleges()
    {
        return $this->hasMany('College')->orderBy('id','desc');
    }


    public function payments()
    {
        return $this->hasMany('Payment')->orderBy('id','desc');
    }

	

	

	public static function add($request=null){

   

      	$person = Person::create([
            'first_name' => $request['first_name'],
            'middle_name' => $request['middle_name'],
            'last_name' => $request['last_name'],
            'dob' => $request['dob'],
            'sex' => $request['sex'],
            'passport_no' => $request['passport_no'],
                  ]);

        $client=Client::create([
      			'person_id'=>$person->id,
      			'reffered_by'=>$request['reffered_by'],
            'notes'=>$request['notes'],
      			'user_id' =>4,  //change user id value with user session id
            	    ]);


        $email=Email::create([
            'email'=>$request['email'],
        ]);


        $phone=Phone::create([
            'number'=>$request['number'],
            'type'=>$request['type'],
            'area_code'=>$request['area_code'],
            'country_code'=>$request['country_code'],

          ]);

         $address=Address::create([
              'street' => $request['street'],
              'suburb'=> $request['suburb'],
              'state' => $request['state'],
              'postcode'=> $request['postcode'],
              'country_id'=>$request['country_id'],
              'type'=>$request['address_type'],

          ]);
           
        $person_email= DB::table('person_emails')->insert([
              'email_id'=> $email->id,
              'person_id'=> $person->id,
              'is_primary'=>'1',
        ]);

        $person_phone= DB::table('person_phones')->insert([
              'phone_id'=> $phone->id,
              'person_id'=> $person->id,
              'is_primary'=>'1',
        ]);


        $person_address= DB::table('person_addresses')->insert([
              'address_id'=> $address->id,
              'person_id'=> $person->id,
              'is_current'=>TRUE,
        ]);



            

        return;
	}

  public static function edit($request=null){
    DB::table('persons')->where('person_id', $request['person_id'])->update([
                'first_name' => $request['first_name'],
                'middle_name' => $request['middle_name'],
                'last_name' => $request['last_name'],
                'dob' => $request['dob'],
                'sex' => $request['sex'],
                'passport_no' => $request['passport_no'],
              ]);


    
    DB::table('clients')->where('client_id', $request['client_id'])->update([
            'reffered_by'=>$request['reffered_by'],
            'user_id' =>4,  //change user id value with user session id
            'notes'=>$request['notes'],
                  ]);

    return;
  }
	
	public static function view($client_id=null){
    $clients = DB::table('clients')
            ->select('clients.*','persons.*','person_phones.*','person_emails.*','phones.*','emails.*','addresses.*','addresses.type as address_type')
            ->leftJoin('persons', 'clients.person_id', '=', 'persons.person_id')
            ->leftJoin('person_phones','persons.person_id', '=', 'person_phones.person_id')
            ->leftJoin('person_emails','persons.person_id', '=', 'person_emails.person_id')
            ->leftJoin('person_addresses','persons.person_id', '=', 'person_addresses.person_id')
            ->leftJoin('phones','phones.phone_id', '=', 'person_phones.phone_id')
            ->leftJoin('emails','emails.email_id', '=', 'person_emails.email_id')
            ->leftJoin('addresses','addresses.address_id', '=', 'person_addresses.address_id')
            ->orderBy('clients.client_id','desc')
            ->where('clients.client_id',$client_id)
            ->get();
		return $clients[0];

	}
	

	public static function index(){
        $clients = DB::table('clients')
            ->select('clients.*','persons.*','person_phones.*','person_emails.*','phones.*','emails.*','addresses.*')
            ->leftJoin('persons', 'clients.person_id', '=', 'persons.person_id')
            ->leftJoin('person_phones','persons.person_id', '=', 'person_phones.person_id')
            ->leftJoin('person_emails','persons.person_id', '=', 'person_emails.person_id')
            ->leftJoin('person_addresses','persons.person_id', '=', 'person_addresses.person_id')
            ->leftJoin('phones','phones.phone_id', '=', 'person_phones.phone_id')
            ->leftJoin('emails','emails.email_id', '=', 'person_emails.email_id')
            ->leftJoin('addresses','addresses.address_id', '=', 'person_addresses.address_id')
            ->orderBy('clients.client_id','desc')
            ->simplePaginate(15);
        return $clients;
    }

    public static function deleteClient($client_id=null){
      $clients=Client::view($client_id);


      /*
      $person_id=DB::table('clients')->where('client_id', $client_id)->pluck('person_id');
      $address_id=DB::table('person_address')->where('client_id', $client_id)->pluck('person_id');
      $clients=DB::table('clients')->where('client_id', '=', $client_id)->delete();
      $person=DB::table('person')->where('id', '=', $person_id)->delete();
      */
     return $clients;

  }


	

}