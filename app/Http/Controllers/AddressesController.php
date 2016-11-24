<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;


use App\Http\Controllers\validate;
use Session;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use View;
use App\Address as Address;

class AddressesController extends Controller{
	public $layout="layout.default";
	
	public function index(){

		$addresses = Address::orderBy('id','desc')->paginate(20);
		$view=View::make('addresses/index')->with('addresses', $addresses);
		$this->layout->content=$view;
	}

	public function search(){
		$searchIn=Input::get('searchIn');
		$searchFor=Input::get('searchFor');
		$addresses = Address::where($searchIn, '=', $searchFor)->orderBy('id','desc')->paginate(20);
		$view=View::make('addresses/index')->with('addresses', $addresses);
		$this->layout->content=$view;
	}

	public function add($id=null){
		$view=View::make('addresses/add')->with('institute_id',$id);
		$this->layout->content=$view;
	}

	public function save(){
		
		//$this->layout->content="";
		$institute_id=Input::get('institute_id');
		$validator=Address::validate(Input::all());

		if ($validator->fails()){
			//return Redirect::to('addresses/add')->with_errors($validator->errors);
			return Redirect::to("addresses/add/$institute_id")->withErrors($validator->messages())->withInput();
				//$this->layout->content=$messages;
			
		}
		
		else{
			$array_var=$_POST;
			
			array_shift($array_var);
			$results=Address::add($array_var);
			Session::flash('message', "You have successfully added new Address");
			return Redirect::to("institutes/view/$institute_id");
		}
		
	}

	public function view($id=null){
		
		$addresses=Address::view($id);
		$view=View::make('addresses/view')->with('addresses_details', $addresses);

		$this->layout->content=$view;

	}

	public function edit_form($id=null){
		return View::make('addresses/edit')->with('addresses', Address::find($id));
		//$this->layout->content=$view;
	}

	public function edit()
	{
		
		$array_var=$_POST;
		$id=$array_var['id'];
		array_shift($array_var);

		DB::table('addresses')
            ->where('id', $id)
            ->update($array_var);
		$addresses_details=Address::view($id);
		$view=View::make('addresses/view')->with('addresses_details', $addresses_details);
		//$view->data=$array_var;
		$this->layout->content=$view;
		

	}

	public function delete($id=null){
		DB::table('addresses')->where('id', '=', $id)->delete();
		$this->layout->content="Record successfully deleted";

	}
}
?>