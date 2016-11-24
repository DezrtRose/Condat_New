<?php
namespace App\Model;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;



Class Person extends Model{
	

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'persons';
	protected $fillable = ['first_name', 'middle_name', 'last_name', 'dob', 'sex', 'passport_no'];


	public function email()
    {
        return $this->hasMany('Email')->orderBy('id','desc');
    }


    public function phone()
    {
        return $this->hasMany('Phone')->orderBy('id','desc');
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


      return;
	}

	
	public static function view($id=null){
		$results = DB::select('select * from clients where id = ?', array($id));
		return $results;

	}
	

	public static function index(){
        $clients = DB::table('clients')
            ->select('clients.*','person.*')
            ->leftJoin('person', 'clients.person_id', '=', 'person.id')
            ->orderBy('clients.client_id','desc')
            ->simplePaginate(15);
            

        return $clients;
    }

	

	

}