<?php
Class Visa extends Eloquent{
	

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'visas';


	public static $rules=array(
    		'visa_type_id' => 'required',
    		'subclass'=> 'required',
    		'total_charge'=>'required'



	);

	public static function validate($data){
		return Validator::make($data,static::$rules);
	}


	

	public static function view($id=null){
		$results = DB::select('select * from visas where id = ?', array($id));
		return $results;

	}
	

	public static function add($array=null){
		$results=DB::table('visas')->insert($array);
		return $results;
	}

	public static function visaOutstandingInvoice($id=null){
		$visa_invoices_total = DB::select("select sum(grand_total) as visa_total from visa_invoices where visa_id = $id ");
		$student_payments_total = DB::select("select sum(amount) as payments_total from payment_invoices where relation_with='visas' and relation_id = $id");
		$visaOutstandingInvoice=$visa_invoices_total[0]->visa_total-$student_payments_total[0]->payments_total;
		return $visaOutstandingInvoice;

	}

	

}