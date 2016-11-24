<?php
Class Payment extends Eloquent{
	

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'payments';


	public static $rules=array(
    		'amount' => 'required',
    		'date'=> 'required'
	);

	 public function payment_invoices()
    {
        return $this->hasMany('PaymentInvoice')->orderBy('id','desc');
    }

	public static function validate($data){
		return Validator::make($data,static::$rules);
	}


	public static function view($id=null){
		$results = DB::select('select * from payments where id = ?', array($id));
		return $results;

	}
	

	public static function add($array=null){
		$results=DB::table('payments')->insert($array);
		return $results;
	}

	

}