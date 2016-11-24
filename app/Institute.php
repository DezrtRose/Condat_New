<?php
Class Institute extends Eloquent{
	

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'institutes';

	public function courses()
    {
        return $this->hasMany('Course');
    }

    public function contacts()
    {
        return $this->hasMany('Contact');
    }

    public function addresses()
    {
        return $this->hasMany('Address');
    }


	public static $rules=array(
    		'name' => 'required',
    		'short_name'=> 'required',
    		'phone_no'=>'required | min:1',
    		'email'=>'required | min:6 ',
    		'website'=>'required | min:6 ',
    		'contact_person'=>'required | min:6 '

	);

	public static function validate($data){
		return Validator::make($data,static::$rules);
	}

	public static function getCourses($id=null){
				$courses = DB::select('select id,name from courses where institute_id = ?', array($id));
				return $courses;

	}
	
	public static function view($id=null){
		$results = DB::select('select * from institutes where id = ?', array($id));
		return $results;

	}
	

	public static function add($array=null){
		$results=DB::table('institutes')->insert($array);
		return $results;
	}

}