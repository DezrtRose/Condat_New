<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Agency as Agency;

use App\Http\Controllers\validate;
use Session;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use View;

class AgenciesController extendS Controller{
	//public $layout="layout.default";

	protected $rules = [
        'name' => 'required| min:2|max:155',
        'abn' => 'min:2|max:55',
        'website' => 'min:2|max:155',
        
    ];
	
	public function index(){

		$agencies = Agency::index();

		return view("agencies/index")->with('agencies', $agencies);

	}

	public function search(){
		$searchIn=Input::get('searchIn');
		$searchFor=Input::get('searchFor');
		$clients = Client::where($searchIn, 'like', '%'.$searchFor.'%')->orderBy('id','desc')->paginate(20);
		$view=View::make('clients/index')->with('clients', $clients);
		$this->layout->content=$view;

		
	}



	public function view($id=null){
		
		$data['agencies']=Agency::view($id);
		$data['agency_super_admins'] = Agency::agency_super_admins($id);
		return view("agencies/view",$data);	

	}

	public function edit_form($id=null){
		$agencies= Agency::view($id);
		return view("agencies/edit")->with('agencies', $agencies);
	}

	public function edit(Request $request)
	{
		
		
		$this->validate($request, $this->rules);
		$results=Agency::edit($request->all());
		return redirect()->action('AgenciesController@index');
		
	
	}

	public function delete($client_id=null){
		$clients= Client::deleteClient($client_id);
		print_r($clients);
		//return redirect()->action('ClientsController@index');

	}


	 public function post_Register(Request $request)
    {
        
        Agency::registration($request->all());
        return redirect()->action('AgenciesController@index');
    
       
    }



    public function get_Register()
    {
        
        return view('agencies/register');
    
       
    }
}
?>