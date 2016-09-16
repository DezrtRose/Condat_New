<?php

class CoursesController extendS BaseController{
	public $layout="layout.default";
	
	public function index(){

		$courses = Course::orderBy('id','desc')->paginate(20);
		$view=View::make('courses/index')->with('courses', $courses);
		$this->layout->content=$view;
	}

	public function search(){
		$searchIn=Input::get('searchIn');
		$searchFor=Input::get('searchFor');
		$courses = Course::where($searchIn, '=', $searchFor)->orderBy('id','desc')->paginate(20);
		$view=View::make('courses/index')->with('courses', $courses);
		$this->layout->content=$view;
	}

	public function add($id=null){
		$view=View::make('courses/add')->with('institute_id',$id);
		$this->layout->content=$view;
	}

	public function save(){
		
		//$this->layout->content="";
		$institute_id=Input::get('institute_id');
		$validator=Course::validate(Input::all());
		

		if ($validator->fails()){
			//return Redirect::to('courses/add')->with_errors($validator->errors);
			return Redirect::to("courses/add/$institute_id")->withErrors($validator->messages())->withInput();
				//$this->layout->content=$messages;
			
		}
		
		else{
			$array_var=$_POST;
			
			array_shift($array_var);
			$results=Course::add($array_var);
			Session::flash('message', "You have successfully added new Course");
			return Redirect::to("institutes/view/$institute_id");
		}
		
	}

	public function view($id=null){
		
		$courses=Course::view($id);
		
		$view=View::make('courses/view')->with('courses_details', $courses);

		$this->layout->content=$view;

	}

	public function edit_form($id=null){
		$view=View::make('courses/edit')->with('courses', Course::find($id));
		$this->layout->content=$view;
	}

	public function edit()
	{
		
		$array_var=$_POST;
		$id=$array_var['id'];
		array_shift($array_var);

		DB::table('courses')
            ->where('id', $id)
            ->update($array_var);
		$courses_details=Course::view($id);
		return Redirect::to("courses/view/$id");
		

	}

	public function delete($id=null){
		DB::table('courses')->where('id', '=', $id)->delete();
		$this->layout->content="Record successfully deleted";

	}

	public function getCourseInfo($id=null){
		$courses = DB::select('select * from courses where id = ?', array($id));
		return $courses;
	}
}
?>