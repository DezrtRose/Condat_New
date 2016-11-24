<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


Class Address extends Model{
	

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'addresses';
    protected $primaryKey = 'address_id';
	protected $fillable = ['line1', 'line2', 'street', 'suburb', 'state', 'postcode','country_id', 'google_map','type'];
	public $timestamps = false;

	public static $rules=array(
			'line1' => 'required',
			'line2' => 'required',
			'street' => 'required',
			'suburb'=> 'required',
    		'state' => 'required',
    		'postcode'=> 'required',
    		'country_id'=>'required',
    		'google_map'=>'required',
    		'type'=>'required',
	);

	public static function validate($data){
		return Validator::make($data,static::$rules);
	}

	public static function view($id=null){
		$results = DB::select('select * from addresses where id = ?', array($id));
		return $results;

	}

	public static function add($array=null){
		$results=DB::table('addresses')->insert($array);
		return $results;
	}

}