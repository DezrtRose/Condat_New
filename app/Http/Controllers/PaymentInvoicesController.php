<?php

class PaymentInvoicesController extendS BaseController{
	public $layout="layout.default";
	
	public function index($id=null){
		$payment_invoices=PaymentInvoice::where('status_id',$id)->orderBy('id','desc')->paginate(20);
		$view=View::make('payment_invoices/index')->with('payment_invoices', $payment_invoices);
		$this->layout->content=$view;
	}


	public function search(){
		$searchIn=Input::get('searchIn');
		$searchFor=Input::get('searchFor');
		$payment_invoices = PaymentInvoice::where($searchIn, '=', $searchFor)->orderBy('id','desc')->paginate(20);
		$view=View::make('payment_invoices/index')->with('payment_invoices', $payment_invoices);
		$this->layout->content=$view;
	}


// id is client id
	public function add($id=null){
		// for max amount to enter
		$total=DB::table('payments')->where('id', $id)->pluck('amount') ;
		$amount_used=DB::table('payment_invoices')->where('payment_id',$id)->sum('amount');
		

		$amount_tobeused=$total-$amount_used;

		$view=View::make('payment_invoices/add')->with(array('payment_id'=>$id,'maxamount'=>$amount_tobeused));
		$this->layout->content=$view;
	}

	public function save(){
		
		
		$payment_id=Input::get('payment_id');
		$validator=PaymentInvoice::validate(Input::all());

		if ($validator->fails()){
			return Redirect::to("payment_invoices/add/$payment_id")->withErrors($validator->messages())->withInput();
			
		}
		
		else{
			$array_var=$_POST;
			
			array_shift($array_var);
			$results=PaymentInvoice::add($array_var);
			Session::flash('message', "You have successfully added new PaymentInvoice");
			return Redirect::to("payments/view/$payment_id");
		}
		
	}

	public function view($id=null){
		
		$payment_invoices=PaymentInvoice::view($id);
		$view=View::make('payment_invoices/view')->with('payment_invoices_details',$payment_invoices);
		
		$this->layout->content=$view;

	}

	public function edit_form($id=null){
		$view=View::make('payment_invoices/edit')->with('payment_invoices', PaymentInvoice::find($id));
		$this->layout->content=$view;
	}

	public function edit()
	{
		
		$array_var=$_POST;
		$id=$array_var['id'];
		array_shift($array_var);

		DB::table('payment_invoices')
            ->where('id', $id)
            ->update($array_var);
        return Redirect::to("payment_invoices/view/$id");
		
		

	}

	public function delete($id=null){
		DB::table('payment_invoices')->where('id', '=', $id)->delete();
		$this->layout->content="Record successfully deleted";

	}

	public function invoice($id=null){
		$payment_invoices=PaymentInvoice::view($id);
		return View::make('payment_invoices/invoice')->with('payment_invoices_details',$payment_invoices);
		//$this->layout->content=$view;

	}

	function getInvoices($option=null){
		$payment_id=Input::get('payment_id');
		$client_id=DB::table('payments')->where('id',$payment_id)->pluck('client_id');
		$invoices=PaymentInvoice::getInvoices($client_id,$option);
		return View::make('payment_invoices/getInvoices')->with(array('invoices'=>$invoices,'option'=>$option));
		
	
	}

	function getInvoicesId($id=null){
		$payment_id=Input::get('payment_id');
		$client_id=DB::table('payments')->where('id',$payment_id)->pluck('client_id');
		$option=$id;
		$invoices=PaymentInvoice::getInvoices($client_id,$option);
		return $invoices;
		
	
	}


	
}
?>