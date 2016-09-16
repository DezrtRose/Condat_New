\<?php
namespace App\Model;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


Class Company extends Model{
	

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'companies';
	protected $fillable = [ 'name','abn','acn','website','invoice_to_name'];


	public function branches()
    {
        return $this->hasMany('company_branches')->orderBy('id','desc');
    }

	

	

	public static function add($request=null){

	$companies = Company::create([
                'name' => $request['name'],
                'abn' => $request['abn'],
                'acn' => $request['acn'],
                'website' => $request['website'],
                'invoice_to_name' => $request['invoice_to_name'],
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