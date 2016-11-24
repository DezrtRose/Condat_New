<?php
Class Contact extends Eloquent{
	

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'contacts';


	public static $rules=array(
    		'name' => 'required',
    		'department'=> 'required',
    		'phone_no'=>'required | min:1',
    		'email'=>'required | min:2 ',
    		'institute_id'=>'required | min:1 '

	);

	public static function validate($data){
		return Validator::make($data,static::$rules);
	}


	public static function view($id=null){
		$results = DB::select('select * from contacts where id = ?', array($id));
		return $results;

	}
	

	public static function add($array=null){
		$results=DB::table('contacts')->insert($array);
		return $results;
	}

	

}