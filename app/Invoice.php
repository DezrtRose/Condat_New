<?php
Class Invoice extends Eloquent{
	

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'invoices';

	public static $rules=array(
    		'invoice_date' => 'required',
    		'installment_no'=> 'required',
    		'tution_fee' => 'required',
    		'subtotal'=> 'required',
    		'commission_percent' => 'required',
    		'commission'=> 'required',
    		'gst'=> 'required',
    		'totalCommission' => 'required'
    		

	);

	public static function validate($data){
		return Validator::make($data,static::$rules);
	}

	public function college() {
        return $this->belongs_to('College');
    }

    

	public static function view($id=null){
		$results = DB::select('select * from invoices where id = ?', array($id));
		return $results;

	}
	

	public static function add($array=null){
		$results=DB::table('invoices')->insert($array);
		return $results;
	}

	public static function search(){
		$college_invoice=DB::table('colleges')->join('invoices','colleges.id','=','invoices.college_id');
		return $college_invoice;
	}
	

}