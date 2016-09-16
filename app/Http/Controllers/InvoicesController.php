<?php

class InvoicesController extendS BaseController{
	public $layout="layout.default";
	
	public function index($id=null){
		//$invoices=Invoice::where('status_id',$id)->orderBy('id','desc')->paginate(20);
		$invoices=DB::table('invoices')
		->join('colleges', 'invoices.college_id', '=', 'colleges.id')
		->select('colleges.id as college_id','invoices.id as invoice_id','invoices.user_id as added_by','invoices.*','colleges.*');
		$invoices=$invoices->where('status_id','=',$id);
		$invoices=$invoices->get();
		$view=View::make('invoices/index')->with('invoices', $invoices);
		$this->layout->content=$view;
	}


	public function search(){
		
		$invoices=DB::table('invoices')
		->join('colleges', 'invoices.college_id', '=', 'colleges.id')
		->select('invoices.user_id as college_id','invoices.user_id as added_by','invoices.id as invoice_id','invoices.*','colleges.*');
		
		$invoice_to=Input::get('invoice_to');
		$added_by=Input::get('added_by');
		$institute_id=Input::get('institute_id');
		$invoice_status=Input::get('invoice_status');
		
		$dateFrom=date("Y-m-d", strtotime(Input::get('date_from')));
		$dateTo=date("Y-m-d", strtotime(Input::get('date_to')));

		$filter_type=Input::get('filter_type');

		$invoices=$invoices->where("invoices.$filter_type",'>',$dateFrom)->where("invoices.$filter_type",'<=',$dateTo);

		if($added_by != "0"){
			$invoices=$invoices->where('invoices.user_id','=',$added_by);	
			
		}

		if($invoice_to!=null){
			
			$invoices=$invoices->where('invoice_to', 'like', '%'.$invoice_to.'%');
		}

		if($institute_id!="0"){

			$invoices=$invoices->where('invoices.college_id','=',$institute_id);
		}

		if($invoice_status!="0"){

			$invoices=$invoices->where('status_id','=',$invoice_status);
		}
		$invoices=$invoices->get();

		
		//$invoices=$invoices->paginate(20);
		
		$view=View::make('invoices/index')->with('invoices',$invoices);
		$this->layout->content=$view;
	
	}


// id is client id
	public function add($id=null){
		$view=View::make('invoices/add')->with('college_id',$id);
		$this->layout->content=$view;
	}

	public function save(){
		
		
		$college_id=Input::get('college_id');
		$validator=Invoice::validate(Input::all());

		if ($validator->fails()){
			return Redirect::to("invoices/add/$college_id")->withErrors($validator->messages())->withInput();
			
		}
		
		else{
			$array_var=$_POST;
			
			array_shift($array_var);
			$results=Invoice::add($array_var);
			Session::flash('message', "You have successfully added new Invoice");
			return Redirect::to("colleges/view/$college_id");
		}
		
	}

	public function view($id=null){
		
		$invoices=Invoice::view($id);
		$view=View::make('invoices/view')->with('invoices_details',$invoices);
		
		$this->layout->content=$view;

	}

	public function edit_form($id=null){
		$view=View::make('invoices/edit')->with('invoices', Invoice::find($id));
		$this->layout->content=$view;
	}

	public function edit()
	{
		
		$array_var=$_POST;
		$id=$array_var['id'];
		array_shift($array_var);

		DB::table('invoices')
            ->where('id', $id)
            ->update($array_var);
		return Redirect::to("invoices/view/$id");
		

	}

	public function delete($id=null){
		DB::table('invoices')->where('id', '=', $id)->delete();
		$this->layout->content="Record successfully deleted";

	}

	public function invoice($id=null){
		$invoices=Invoice::view($id);
		return View::make('invoices/invoice')->with('invoices_details',$invoices);
		//$this->layout->content=$view;

	}

	public function unclaimed($id=null){
		DB::table('invoices')
            ->where('id', $id)
            ->update(array('status_id' => 1));
        return Redirect::to("invoices/2");

	}

	public function claimed($id=null){
		$date=date ( "d-M-Y");
		DB::table('invoices')
            ->where('id', $id)
            ->update(array('status_id' => 2,'claimed_date'=>$date));
        return Redirect::to("invoices/1");

		
	}

	public function cancelled($id=null){
		
	}

	public function refunded($id=null){
		
	}
}
?>