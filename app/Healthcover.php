<?php
Class Healthcover extends Eloquent{
	

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'healthcovers';


	public static $rules=array(
    		'membership_name' => 'required',
    		'membership_no'=> 'required'

	);

	public static function validate($data){
		return Validator::make($data,static::$rules);
	}


	

	public static function view($id=null){
		$results = DB::select('select * from healthcovers where id = ?', array($id));
		return $results;

	}
	

	public static function add($array=null){
		$results=DB::table('healthcovers')->insert($array);
		return $results;
	}

	

}