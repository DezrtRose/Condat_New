<?php
Class Course extends Eloquent{
	

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'courses';


	public static $rules=array(
    		'name' => 'required',
    		'level'=> 'required',
    		'total_fee'=>'required | min:1',
    		'subject_fee'=>'required | min:1 ',
    		'institute_id'=>'required | min:1 ',
    		'commission_percent'=>'required'

	);

	public static function validate($data){
		return Validator::make($data,static::$rules);
	}


	

	

	public static function view($id=null){
		$results = DB::select('select * from courses where id = ?', array($id));
		return $results;

	}
	

	public static function add($array=null){
		$results=DB::table('courses')->insert($array);
		return $results;
	}

	

}