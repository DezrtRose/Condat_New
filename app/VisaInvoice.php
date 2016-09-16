<?php
Class VisaInvoice extends Eloquent{
	

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'visa_invoices';

	public static $rules=array(
    		'amount' => 'required',
    		'gst'=>'required',
    		'date'=>'required'

	);

	public static function validate($data){
		return Validator::make($data,static::$rules);
	}



	public static function view($id=null){
		$results = DB::select('select * from visa_invoices where id = ?', array($id));
		return $results;

	}
	

	public static function add($array=null){
		$results=DB::table('visa_invoices')->insert($array);
		return $results;
	}

	

}