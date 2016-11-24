<?php

class PaymentsController extendS BaseController{
	public $layout="layout.default";
	
	public function index(){

		$payments = Payment::orderBy('id','desc')->paginate(20);
		$view=View::make('payments/index')->with('payments', $payments);
		$this->layout->content=$view;
	}

	public function client_payments($id=null){

		$payments = Payment::orderBy('id','desc')->where('client_id', $id)->paginate(20);
		$view=View::make('payments/index')->with(array('payments'=> $payments,'client_id'=>$id));
		$this->layout->content=$view;
	}

	public function search(){
		$searchIn=Input::get('searchIn');
		$searchFor=Input::get('searchFor');
		$payments = Payment::where($searchIn, '=', $searchFor)->orderBy('id','desc')->paginate(20);
		$view=View::make('payments/index')->with('payments', $payments);
		$this->layout->content=$view;

		
	}

	public function add($id=null){
		$view=View::make('payments/add')->with('client_id',$id);
		$this->layout->content=$view;
	}

	public function save(){


		
		$client_id=Input::get('client_id');
		

		
		$validator=Payment::validate(Input::all());

		if ($validator->fails()){
			return Redirect::to("payments/add/$client_id")->withErrors($validator->messages())->withInput();
				
			
		}
		
		else{
			$array_var=$_POST;
			
			array_shift($array_var);
			$results=Payment::add($array_var);
			Session::flash('message', "You have successfully added new client");
			return Redirect::to("clients/view/$client_id");
		}
		
		
	}

	public function view($id=null){
		
		$payments=Payment::view($id);
		$payment_invoices =DB::select('select * from payment_invoices where payment_id = ?', array($id));// Payment::find(1)->payment_invoices;
		$view=View::make('payments/view')->with(array('payments_details' => $payments,'payment_invoices'=>$payment_invoices));

		$this->layout->content=$view;

	}

	public function edit_form($id=null){
		$view=View::make('payments/edit')->with('payments', Payment::find($id));
		$this->layout->content=$view;
	}

	public function edit()
	{
		
		$array_var=$_POST;
		$id=$array_var['id'];
		array_shift($array_var);

		DB::table('payments')
            ->where('id', $id)
            ->update($array_var);
		
		return Redirect::to("colleges/view/$id");
		

	}

	public function delete($id=null){
		DB::table('payments')->where('id', '=', $id)->delete();
		$this->layout->content="Record successfully deleted";

	}
}
?>