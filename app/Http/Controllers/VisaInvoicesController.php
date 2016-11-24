<?php

class VisaInvoicesController extendS BaseController{
	public $layout="layout.default";
	
	public function index($id=null){
		$visa_invoices=VisaInvoice::where('status_id',$id)->orderBy('id','desc')->paginate(20);
		$view=View::make('visa_invoices/index')->with('visa_invoices', $visa_invoices);
		$this->layout->content=$view;
	}


	public function search(){
		$searchIn=Input::get('searchIn');
		$searchFor=Input::get('searchFor');
		$visa_invoices = VisaInvoice::where($searchIn, '=', $searchFor)->orderBy('id','desc')->paginate(20);
		$view=View::make('visa_invoices/index')->with('visa_invoices', $visa_invoices);
		$this->layout->content=$view;
	}


// id is client id
	public function add($id=null){
		$view=View::make('visa_invoices/add')->with('visa_id',$id);
		$this->layout->content=$view;
	}

	public function save(){
		
		
		$visa_id=Input::get('visa_id');
		$validator=VisaInvoice::validate(Input::all());

		if ($validator->fails()){
			return Redirect::to("visa_invoices/add/$visa_id")->withErrors($validator->messages())->withInput();
			
		}
		
		else{
			$array_var=$_POST;
			
			array_shift($array_var);
			$results=VisaInvoice::add($array_var);
			Session::flash('message', "You have successfully added new visa Invoice");
			return Redirect::to("visas/view/$visa_id");
		}
		
	}

	public function view($id=null){
		
		$visa_invoices=VisaInvoice::view($id);
		$view=View::make('visa_invoices/view')->with('visa_invoices_details',$visa_invoices);
		
		$this->layout->content=$view;

	}

	public function edit_form($id=null){
		$view=View::make('visa_invoices/edit')->with('visa_invoices', VisaInvoice::find($id));
		$this->layout->content=$view;
	}

	public function edit()
	{
		
		$array_var=$_POST;
		$id=$array_var['id'];
		array_shift($array_var);

		DB::table('visa_invoices')
            ->where('id', $id)
            ->update($array_var);
		return Redirect::to("visa_invoices/view/$id");
		

	}

	public function delete($id=null){
		DB::table('visa_invoices')->where('id', '=', $id)->delete();
		$this->layout->content="Record successfully deleted";

	}

	public function invoices($id=null){
		$visa_invoices=VisaInvoice::view($id);
		return View::make('visa_invoices/invoices')->with('visa_invoices_details',$visa_invoices);
		//$this->layout->content=$view;

	}

	

	
}
?>