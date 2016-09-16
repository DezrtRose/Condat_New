<?php

class HealthcoversController extendS BaseController{
	public $layout="layout.default";
	
	

	public function index(){

		$healthcovers = Healthcover::orderBy('id','desc')->paginate(20);
		$view=View::make('healthcovers/index')->with('healthcovers', $healthcovers);
		$this->layout->content=$view;
	}

	public function search(){
		$searchIn=Input::get('searchIn');
		$searchFor=Input::get('searchFor');
		$healthcovers = Healthcover::where($searchIn, '=', $searchFor)->orderBy('id','desc')->paginate(20);
		$view=View::make('healthcovers/index')->with('healthcovers', $healthcovers);
		$this->layout->content=$view;
	}

	public function add($id=null){
		$view=View::make('healthcovers/add')->with('client_id',$id);
		$this->layout->content=$view;
	}

	public function save(){
		
		$client_id=Input::get('client_id');

		$validator=Healthcover::validate(Input::all());

		if ($validator->fails()){
			return Redirect::to("healthcovers/add/$client_id")->withErrors($validator->messages())->withInput();
			
		}
		
		else{
			$array_var=$_POST;
			
			array_shift($array_var);
			$results=Healthcover::add($array_var);
			Session::flash('message', "You have successfully added new Healthcover");
			return Redirect::to("clients/view/$client_id");
		}
		
	}

	public function view($id=null){
		
		$healthcovers=Healthcover::view($id);
		$payment_invoices = DB::select("select * from payment_invoices where relation_with='healthcovers' and relation_id = $id");
		$view=View::make('healthcovers/view')->with(array('healthcovers_details'=> $healthcovers,'payment_invoices'=>$payment_invoices));

		$this->layout->content=$view;

	}

	public function edit_form($id=null){
		$view=View::make('healthcovers/edit')->with('healthcovers', Healthcover::find($id));
		$this->layout->content=$view;
	}

	public function edit()
	{
		
		$array_var=$_POST;
		$id=$array_var['id'];
		array_shift($array_var);

		DB::table('healthcovers')
            ->where('id', $id)
            ->update($array_var);
		return Redirect::to("healthcovers/view/$id");
		

	}

	public function delete($id=null){
		DB::table('healthcovers')->where('id', '=', $id)->delete();
		$this->layout->content="Record successfully deleted";

	}

	

	

	

	
}
?>