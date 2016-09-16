<?php

class InstitutesController extendS BaseController{
	public $layout="layout.default";

	public function testing(){
		$courses = Institute::find(1)->courses;
		
		$this->layout->content=$courses;

	}
	
	public function index(){

		$institutes = Institute::orderBy('id','desc')->paginate(20);
		$view=View::make('institutes/index')->with('institutes', $institutes);
		$this->layout->content=$view;
	}


	public function search(){
		$searchIn=Input::get('searchIn');
		$searchFor=Input::get('searchFor');
		$institutes = Institute::where($searchIn,'like', '%'.$searchFor.'%')->orderBy('id','desc')->paginate(20);
		$view=View::make('institutes/index')->with('institutes', $institutes);
		$this->layout->content=$view;
	}

	public function add(){
		$view=View::make('institutes/add');
		$this->layout->content=$view;
	}

	public function save(){
		
		

		$validator=Institute::validate(Input::all());

		if ($validator->fails()){
			return Redirect::to('institutes/add')->withErrors($validator->messages())->withInput();
				//$this->layout->content=$messages;
			
		}
		
		else{
			$array_var=$_POST;
			
			array_shift($array_var);
			$results=Institute::add($array_var);
			Session::flash('message', "You have successfully added new Institute");
			$this->index();
		}
		
	}

	public function view($id=null){
		
		$institutes=Institute::view($id);
		$courses = Institute::find($id)->courses;
		$contacts = Institute::find($id)->contacts;
		$addresses = Institute::find($id)->addresses;


		$view=View::make('institutes/view')->with(array(
				'institutes_details' => $institutes,
				'courses'=>$courses,
				'contacts'=>$contacts,
				'addresses'=>$addresses
				));
		
		$this->layout->content=$view;

	}

	public function edit_form($id=null){
		$view=View::make('institutes/edit')->with('institutes', Institute::find($id));
		$this->layout->content=$view;
	}

	public function edit()
	{
		
		$array_var=$_POST;
		$id=$array_var['id'];
		array_shift($array_var);

		DB::table('institutes')
            ->where('id', $id)
            ->update($array_var);
		return Redirect::to("institutes/view/$id");
		

	}

	public function delete($id=null){
		DB::table('institutes')->where('id', '=', $id)->delete();
		$this->layout->content="Record successfully deleted";

	}

	function getCourses($id=null){
		$courses=Institute::getCourses($id);
		return $courses;
	}

	function getInvoiceTo($id=null){
		$invoice_to = DB::select('select invoice_to from institutes where id = ?', array($id));
		return ($invoice_to);
	}
}
?>