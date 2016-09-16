<?php
namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


Class Agency extends Model{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'agencies';
	protected $fillable = [ 'company_id','description','first_name','last_name','name','abn','website','user_name','password',
  'standard_subscription_id','start_date','end_date','subscription_status_id','number', 'type','area_code','country_code','company_number', 'company_phone_type','company_area_code','company_country_code'];




	
	public static function index(){
	    $agency = DB::table('agencies')
	        ->select('agencies.*','companies.*','agency_subscriptions.*','phones.*')
	        ->leftJoin('companies', 'agencies.company_id', '=', 'companies.company_id')
	        ->leftJoin('agency_subscriptions','agency_subscriptions.agency_id', '=', 'agencies.agency_id') 
	        ->leftJoin('company_default_contacts','company_default_contacts.company_id', '=', 'companies.company_id')
	        ->leftJoin('phones','phones.phone_id', '=', 'company_default_contacts.phone_id')
          ->orderBy('agencies.agency_id','desc')
	        ->simplePaginate(15);
	    return $agency;
    
	}
	

	public static function add($array=null){
		$results=DB::table('agency')->insert($array);
		return $results;
	}

	public static function registration($request=null){
        $person = Person::create([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
                  ]);

        $company = Company::create([
                'name' => $request['name'],
                'abn' => $request['abn'],
                'website' => $request['website'],
            ]);

        $user = User::create([
            'user_name' => $request['user_name'],
            'password' => $request['password'],
            'person_id'=> $person->id,
            'timezone'=> 'sydney',
            'is_disabled'=>'0',
            'is_active'=>'1',
                  ]);

         $agency= Agency::create([
            'company_id' => $company->id,
              
        ]);

        $agency_subscriptions= AgencySubscription::create([
              'agency_id'=> $agency->id,
              'standard_subscription_id'=> $request['standard_subscription_id'],
              'start_date'=>$request['start_date'], 
              'end_date'=>$request['end_date'],
              'is_current'=>'1',
              'subscription_status_id'=>$request['subscription_status_id'],
              
        ]);  



         $agency_user= DB::table('agency_users')->insert([
              'agency_id'=> $agency->id,
              'user_id'=> $user->id,
              'level_id'=>'4',
        ]);

        $phone=Phone::create([
            'number'=>$request['number'],
            'type'=>$request['type'],
            'area_code'=>$request['area_code'],
            'country_code'=>$request['country_code'],

          ]);

        $person_phone= DB::table('person_phones')->insert([
              'phone_id'=> $phone->id,
              'person_id'=> $person->id,
              'is_primary'=>'1',
        ]);

        $com_phone=Phone::create([
            'number'=>$request['company_number'],
            'type'=>$request['company_phone_type'],
            'area_code'=>$request['company_area_code'],
            'country_code'=>$request['company_country_code'],

          ]);
        $company_phone= DB::table('company_default_contacts')->insert([
              'phone_id'=> $com_phone->id,
              'company_id'=> $company->id,
        ]);

        


        return ;
    }


    public static function view($agency_id=null){
      $agency = DB::table('agencies')
          ->select('agencies.*','companies.*','agency_subscriptions.*','phones.*')
          ->leftJoin('companies', 'agencies.company_id', '=', 'companies.company_id')
          ->leftJoin('agency_subscriptions','agency_subscriptions.agency_id', '=', 'agencies.agency_id') 
          ->leftJoin('company_default_contacts','company_default_contacts.company_id', '=', 'companies.company_id')
          ->leftJoin('phones','phones.phone_id', '=', 'company_default_contacts.phone_id')
          ->orderBy('agencies.agency_id','desc')
          ->where('agencies.agency_id',$agency_id)
          ->get();
      return $agency['0'];
    
  }

  public static function agency_super_admins($agency_id=null){
      $agency_users=DB::table('agency_users')
          ->select('agency_users.*','users.*','persons.*','phones.*','person_phones.*')
          ->leftJoin('users','users.user_id', '=', 'agency_users.user_id')->where('agency_users.level_id','4')
          ->leftJoin('persons', 'users.person_id', '=', 'persons.person_id')
          ->leftJoin('person_phones','persons.person_id', '=', 'person_phones.person_id')
          ->leftJoin('phones','phones.phone_id', '=', 'person_phones.phone_id')
          ->where('agency_users.agency_id',$agency_id)
          ->get();
      return $agency_users;
  }

  public static function edit($request=null){
        $agency_update= DB::table('companies')->where('company_id', $request['company_id'])->update([
            'name' => $request['name'],
            'abn' => $request['abn'],
            'website' => $request['website'],
            ]);

        $phone_update=DB::table('phones')->where('phone_id', $request['phone_id'])->update([
            'number'=>$request['number'],
            'type'=>$request['type'],
            'area_code'=>$request['area_code'],
            'country_code'=>$request['country_code'],

          ]);
        return ;
  }

}