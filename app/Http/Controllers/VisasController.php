<?php

class VisasController extendS BaseController{
	public $layout="layout.default";
	
	

	public function index(){

		//$visas = Visa::all();
		$visas = Visa::orderBy('id','desc')->paginate(20);
		$view=View::make('visas/index')->with('visas', $visas);
		$this->layout->content=$view;
	}

	public function search(){
		$visa_type_id=Input::get('visa_types');
		$added_by=Input::get('added_by');
		$subclass=Input::get('subclass');
		$visa_status_id=Input::get('visa_status');
		$visas =Visa::orderBy('id','desc');//DB::select('select * from colleges');



		if($added_by != "0"){
			$visas=$visas->where('user_id','=',$added_by);
		}

		if($subclass!=null){
			
			$visas=$visas->where('subclass', '=', $subclass);
		}

		if($visa_type_id!="0"){

			$visas=$visas->where('visa_type_id','=',$visa_type_id);
		}

		if($visa_status_id!="0"){

			$visas=$visas->where('visa_status_id','=',$visa_status_id);
		}

		

		$visas=$visas->paginate(20);
		
		$view=View::make('visas/applications')->with('applications',$visas);
		$this->layout->content=$view;
	}

	public function add($id=null){
		$view=View::make('visas/add')->with('client_id',$id);
		$this->layout->content=$view;
	}

	public function save(){
		
		$client_id=Input::get('client_id');

		$validator=Visa::validate(Input::all());

		if ($validator->fails()){
			return Redirect::to("visas/add/$client_id")->withErrors($validator->messages())->withInput();
			
		}
		
		else{
			$array_var=$_POST;
			
			array_shift($array_var);
			$results=Visa::add($array_var);
			Session::flash('message', "You have successfully added new Visa");
			return Redirect::to("clients/view/$client_id");
		}
		
	}

	public function view($id=null){
		
		$visas=Visa::view($id);
		$payment_invoices = DB::select("select * from payment_invoices where relation_with='visas' and relation_id = $id");
		$visa_invoices = DB::select("select * from visa_invoices where visa_id = $id");
		$view=View::make('visas/view')->with(array('visas_details'=> $visas,'payment_invoices'=>$payment_invoices,'visa_invoices'=>$visa_invoices));

		$this->layout->content=$view;

	}

	public function edit_form($id=null){
		$view=View::make('visas/edit')->with('visas', Visa::find($id));
		$this->layout->content=$view;
	}

	public function edit()
	{
		
		$array_var=$_POST;
		$id=$array_var['id'];
		array_shift($array_var);
		/*
		$id=Input::get('id');
		$visas=Visa::edit($array_var,$id);
		*/

		DB::table('visas')
            ->where('id', $id)
            ->update($array_var);
		return Redirect::to("visas/view/$id");
		

	}

	public function delete($id=null){
		DB::table('visas')->where('id', '=', $id)->delete();
		$this->layout->content="Record successfully deleted";

	}

	public function applications($id=null){
		$applications=	DB::select('select * from visas where visa_status_id = ?', array($id));
		$view=View::make('visas/applications')->with('applications',$applications);
		$this->layout->content=$view;
	}

	public function status_update($id=null,$status_id=null){
		$new_status_id=$status_id+1;
		DB::table('visas')
            ->where('id', $id)
            ->update(array('visa_status_id' =>$new_status_id ));
         return $this->applications($status_id);
	}

	

	

	

	
}
?>