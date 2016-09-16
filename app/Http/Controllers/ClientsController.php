<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Client as Client;

use App\Http\Controllers\validate;
use Session;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use View;

class ClientsController extendS Controller{
	//public $layout="layout.default";

	protected $rules = [
        'first_name' => 'required| min:2|max:155',
        'last_name' => 'required|alpha|min:2|max:155',
        'dob' => 'min:2|max:15',
        'sex' => 'min:1|max:15',
        'email' => 'required|email|min:5|max:55',
        'phone_no' => 'min:10|max:15',
        
    ];
	
	public function index(){

		$clients = Client::index();
		

		return view("clients/index")->with('clients', $clients);

	}

	public function search(){
		$searchIn=Input::get('searchIn');
		$searchFor=Input::get('searchFor');
		$clients = Client::where($searchIn, 'like', '%'.$searchFor.'%')->orderBy('id','desc')->paginate(20);
		$view=View::make('clients/index')->with('clients', $clients);
		$this->layout->content=$view;

		
	}

	public function add(){
		return View::make('clients/add');

		//$this->layout->content=$view;
	}

	public function save(Request $request){

			$this->validate($request, $this->rules);
			$results=Client::add($request->all());
			Session::flash('message', "You have successfully added new client");
			return redirect()->action('ClientsController@index');
		
		
	}

	public function view($id=null){
		
		$clients=Client::view($id);

		return view("clients/view")->with('clients', $clients);

		

	}

	public function edit_form($id=null){
		$clients= Client::view($id);

		return view("clients/edit")->with('clients', $clients);
	}

	public function edit(Request $request)
	{
		
		$this->validate($request, $this->rules);

		$results=Client::edit($request->all());
		return redirect()->action('ClientsController@index');
	
	}

	public function delete($client_id=null){
		$clients= Client::deleteClient($client_id);
		print_r($clients);
		//return redirect()->action('ClientsController@index');

	}
}
?>