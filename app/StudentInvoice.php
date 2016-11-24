<?php
Class StudentInvoice extends Eloquent{
	

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'student_invoices';

	public static $rules=array(
    		'amount' => 'required',
    		'payable_amount'=> 'required'

	);

	public static function validate($data){
		return Validator::make($data,static::$rules);
	}



	public static function view($id=null){
		$results = DB::select('select * from student_invoices where id = ?', array($id));
		return $results;

	}
	

	public static function add($array=null){
		$results=DB::table('student_invoices')->insert($array);
		return $results;
	}

	

}