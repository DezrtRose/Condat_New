<?php
Class PaymentInvoice extends Eloquent{
	

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'payment_invoices';

	public static $rules=array(
    		'amount' => 'required',
    		'date'=> 'required',
    		'relation_id'=>'required'

	);

	public static function validate($data){
		return Validator::make($data,static::$rules);
	}



	public static function view($id=null){
		$results = DB::select('select * from payment_invoices where id = ?', array($id));
		return $results;

	}
	

	public static function add($array=null){
		$results=DB::table('payment_invoices')->insert($array);
		return $results;
	}

	public static function getInvoices($client_id=null, $option=null){
		if($option=='colleges'){
				$colleges = DB::select('select * from colleges where client_id = ?', array($client_id));
				return $colleges;
				}
		elseif ($option=='visas'){
				$visas = DB::select('select *  from visas where client_id = ?', array($client_id));
				return $visas;
				}
		elseif($option=='healthcovers'){
				$healthcovers = DB::select('select * from healthcovers where  client_id = ?', array($client_id));
				return $healthcovers;
				}
		

	}
	

}