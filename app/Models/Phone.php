<?php
namespace App\Model;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;



Class Phone extends Model{
	

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'phones';
	protected $fillable = [ 'number','type','area_code','country_code'];


	

	

	public static function add($request=null){

	$email = Email::create([
                'number'=> $request['number'],
                'type'=> $request['type'],
                'area_code'=> $request['area_code'],
                'country_code'=> $request['country_code'],
            ]);


      return;
	}

	
	public static function view($id=null){
		$results = DB::select('select * from email where id = ?', array($id));
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