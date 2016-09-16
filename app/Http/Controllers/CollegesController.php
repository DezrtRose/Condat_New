<?php

class CollegesController extendS BaseController{
	public $layout="layout.default";

	
	public function index(){

		$colleges = College::orderBy('id','desc')->paginate(20);
		$view=View::make('colleges/index')->with('colleges', $colleges);
		$this->layout->content=$view;
	}


	public function search(){
		$invoice_to=Input::get('invoice_to');
		$added_by=Input::get('added_by');
		$institute_id=Input::get('institute_id');
		$college_status=Input::get('college_status');
		$colleges =College::orderBy('id','desc');





		if($added_by != "0"){
			$colleges=$colleges->where('user_id','=',$added_by);
		}

		if($invoice_to!=null){
			
			$colleges=$colleges->where('invoice_to', 'like', '%'.$invoice_to.'%');
		}

		if($institute_id!="0"){

			$colleges=$colleges->where('institute_id','=',$institute_id);
		}

		if($college_status!="0"){

			$colleges=$colleges->where('college_status_id','=',$college_status);
		}

		

		$colleges=$colleges->paginate(20);

		
		$view=View::make('colleges/applications')->with('applications',$colleges);
		$this->layout->content=$view;
	}


// id is client id
	public function add($id=null){
		$view=View::make('colleges/add')->with('client_id',$id);
		$this->layout->content=$view;
	}

	public function save(){
		
		//$this->layout->content="";
		$client_id=Input::get('client_id');

		$validator=College::validate(Input::all());

		if ($validator->fails()){
			return Redirect::to("colleges/add/$client_id")->withErrors($validator->messages())->withInput();
				//$this->layout->content=$messages;
			
		}
		
		else{
			$array_var=$_POST;
			
			array_shift($array_var);
			$results=College::add($array_var);
			Session::flash('message', "You have successfully added new College");
			return Redirect::to("clients/view/$client_id");
		}
		
	}

	public function view($id=null){
		
		$colleges=College::view($id);
		$invoices = College::find($id)->invoices;
		$payment_invoices = DB::select("select * from payment_invoices where relation_with='colleges' and relation_id = $id");
		$student_invoices = DB::select("select * from student_invoices where college_id=$id");


		//print_r($invoices);
		$view=View::make('colleges/view')->
		with(array('colleges_details'=>$colleges,'invoices'=>$invoices,'payment_invoices'=>$payment_invoices,'student_invoices'=>$student_invoices));
		
		$this->layout->content=$view;

	}

	public function edit_form($id=null){
		$view=View::make('colleges/edit')->with('colleges', College::find($id));
		$this->layout->content=$view;
	}

	public function edit()
	{
		
		$array_var=$_POST;
		$id=$array_var['id'];
		array_shift($array_var);

		DB::table('colleges')
            ->where('id', $id)
            ->update($array_var);
		$colleges_details=College::view($id);
		$invoices = College::find($id)->invoices;
		
		return Redirect::to("colleges/view/$id");
		
		

	}

	public function delete($id=null){
		DB::table('colleges')->where('id', '=', $id)->delete();
		$this->layout->content="Record successfully deleted";

	}

	public function applications($id=null){
		$applications=	DB::select('select * from colleges where college_status_id = ?', array($id));
		$view=View::make('colleges/applications')->with('applications',$applications);
		$this->layout->content=$view;
	}

	public function status_update($id=null,$status_id=null){
		$new_status_id=$status_id+1;
		DB::table('colleges')
            ->where('id', $id)
            ->update(array('college_status_id' =>$new_status_id ));
         return $this->applications($status_id);
	}

	public function studentOutstandingInvoice(){
		

	}
}
?>