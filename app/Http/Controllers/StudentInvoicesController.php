<?php

class StudentInvoicesController extendS BaseController{
	public $layout="layout.default";
	
	public function index($id=null){
		$student_invoices=StudentInvoice::where('status_id',$id)->orderBy('id','desc')->paginate(20);
		$view=View::make('student_invoices/index')->with('student_invoices', $student_invoices);
		$this->layout->content=$view;
	}


	public function search(){
		$searchIn=Input::get('searchIn');
		$searchFor=Input::get('searchFor');
		$student_invoices = StudentInvoice::where($searchIn, '=', $searchFor)->orderBy('id','desc')->paginate(20);
		$view=View::make('student_invoices/index')->with('student_invoices', $student_invoices);
		$this->layout->content=$view;
	}


// id is client id
	public function add($id=null){
		$view=View::make('student_invoices/add')->with('college_id',$id);
		$this->layout->content=$view;
	}

	public function save(){
		
		
		$college_id=Input::get('college_id');
		$validator=StudentInvoice::validate(Input::all());

		if ($validator->fails()){
			return Redirect::to("student_invoices/add/$college_id")->withErrors($validator->messages())->withInput();
			
		}
		
		else{
			$array_var=$_POST;
			
			array_shift($array_var);
			$results=StudentInvoice::add($array_var);
			Session::flash('message', "You have successfully added new Student Invoice");
			return Redirect::to("colleges/view/$college_id");
		}
		
	}

	public function view($id=null){
		
		$student_invoices=StudentInvoice::view($id);
		$view=View::make('student_invoices/view')->with('student_invoices_details',$student_invoices);
		
		$this->layout->content=$view;

	}

	public function edit_form($id=null){
		$view=View::make('student_invoices/edit')->with('student_invoices', StudentInvoice::find($id));
		$this->layout->content=$view;
	}

	public function edit()
	{
		
		$array_var=$_POST;
		$id=$array_var['id'];
		array_shift($array_var);

		DB::table('student_invoices')
            ->where('id', $id)
            ->update($array_var);
		return Redirect::to("student_invoices/view/$id");
		

	}

	public function delete($id=null){
		DB::table('student_invoices')->where('id', '=', $id)->delete();
		$this->layout->content="Record successfully deleted";

	}

	public function invoice($id=null){
		$student_invoices=StudentInvoice::view($id);
		return View::make('student_invoices/invoice')->with('student_invoices_details',$student_invoices);
		//$this->layout->content=$view;

	}

	

	
}
?>