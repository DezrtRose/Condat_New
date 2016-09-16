<?php

class ContactsController extendS BaseController{
	public $layout="layout.default";
	
	public function index(){

		$contacts = Contact::orderBy('id','desc')->paginate(20);
		$view=View::make('contacts/index')->with('contacts', $contacts);
		$this->layout->content=$view;
	}

	public function search(){
		$searchIn=Input::get('searchIn');
		$searchFor=Input::get('searchFor');
		$contacts = Contact::where($searchIn, '=', $searchFor)->orderBy('id','desc')->paginate(20);
		$view=View::make('contacts/index')->with('contacts', $contacts);
		$this->layout->content=$view;
	}

	public function add($id=null){
		$view=View::make('contacts/add')->with('institute_id',$id);
		$this->layout->content=$view;
	}

	public function save(){
		
		//$this->layout->content="";
		$institute_id=Input::get('institute_id');
		$validator=Contact::validate(Input::all());

		if ($validator->fails()){
			//return Redirect::to('contacts/add')->with_errors($validator->errors);
			return Redirect::to("contacts/add/$institute_id")->withErrors($validator->messages())->withInput();
				//$this->layout->content=$messages;
			
		}
		
		else{
			$array_var=$_POST;
			
			array_shift($array_var);
			$results=Contact::add($array_var);
			Session::flash('message', "You have successfully added new Contact");
			return Redirect::to("institutes/view/$institute_id");
		}
		
	}

	public function view($id=null){
		
		$contacts=Contact::view($id);
		$view=View::make('contacts/view')->with('contacts_details', $contacts);

		$this->layout->content=$view;

	}

	public function edit_form($id=null){
		$view=View::make('contacts/edit')->with('contacts', Contact::find($id));
		$this->layout->content=$view;
	}

	public function edit()
	{
		
		$array_var=$_POST;
		$id=$array_var['id'];
		array_shift($array_var);

		DB::table('contacts')
            ->where('id', $id)
            ->update($array_var);
		$contacts_details=Contact::view($id);
		return Redirect::to("contacts/view/$id");
		

	}

	public function delete($id=null){
		DB::table('contacts')->where('id', '=', $id)->delete();
		$this->layout->content="Record successfully deleted";

	}
}
?>