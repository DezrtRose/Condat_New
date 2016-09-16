<?php
namespace App\Model;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;



Class Email extends Model{
	

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'emails';
	protected $fillable = [ 'email'];


	

	

	public static function add($request=null){

	$email = Email::create([
                'email' => $request['email'],
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