<?php
Class College extends Eloquent{
	

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'colleges';

	



	public static $rules=array(
    		'total_tution_fee' => 'required',
    		'total_discount'=> 'required'

	);

	public static function validate($data){
		return Validator::make($data,static::$rules);
	}


	public function invoices()
    {
        return $this->hasMany('Invoice');
    }

    public function payment_invoices()
    {
        return $this->hasMany('PaymentInvoice');
    }

	

	public static function view($id=null){
		$results = DB::select('select * from colleges where id = ?', array($id));
		return $results;

	}
	

	public static function add($array=null){
		$results=DB::table('colleges')->insert($array);
		return $results;
	}

	public static function studentOutstandingInvoice($id=null){
		$table='colleges';
		$student_invoices_total = DB::select("select sum(payable_amount) as invoices_total from student_invoices where college_id = $id ");
		$student_payments_total = DB::select("select sum(amount) as payments_total from payment_invoices where relation_with='colleges' and relation_id = $id");
		$studentOutstandingInvoice=$student_invoices_total[0]->invoices_total-$student_payments_total[0]->payments_total;
		return $studentOutstandingInvoice;

	}

}