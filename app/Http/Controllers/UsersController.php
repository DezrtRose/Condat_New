<?php 

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\User as User;

use App\Http\Controllers\validate;
use Session;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use View;



class UsersController extendS Controller{
	public $layout="layout.default";
	protected $rules = [
        'first_name' => 'required| min:5|max:55',
        'middle_name' => 'required|alpha|min:2|max:55',
        'last_name' => 'required|alpha|min:2|max:55',
        'dob' => 'min:2|max:15',
        'sex' => 'min:1|max:15',
        'email' => 'required|email|min:5|max:55',
        'phone_no' => 'min:10|max:15',
        
    ];

	public function index(){
		
		$users = User::index();
		return view("users/index")->with('users', $users);
		//$this->layout->content=$view;
		
	}

	public function search(){
		$searchIn=Input::get('searchIn');
		$searchFor=Input::get('searchFor');
		//$users = User::where($searchIn, '=', $searchFor)->orderBy('id','desc')->paginate(15);
		//$view=View:make('users/index')->with('users', $users);
		$this->layout->content=$view;
	}

	public function add(){
		$view=View::make('users/add');
		return $view;
	}

	public function save(Request $request){
		

		$this->validate($request, $this->rules);

		//if validation successful
			$results=User::add($request->all());
			Session::flash('message', "You have successfully added new User");
			return redirect()->action('UsersController@index');
	}

	public function view($id=null){
		
		$users=User::view($id);
		$view=View::make('users/view')->with('users_details', $users);

		$this->layout->content=$view;

	}

	public function edit_form($id=null){
		$view=View::make('users/edit')->with('users', User::find($id));
		$this->layout->content=$view;
	}

	public function edit()
	{
		
		$array_var=$_POST;
		$id=$array_var['id'];
		array_shift($array_var);
		

		DB::table('users')
            ->where('id', $id)
            ->update($array_var);
		return Redirect::to("users/view/$id");


		$this->layout->content=$view;
		

	}

	public function delete($id=null){
		DB::table('users')->where('id', '=', $id)->delete();
		$this->layout->content="Record successfully deleted";

	}

	public function login_form(){
		$view= View::make('users/login') ;
		$this->layout->content=$view;
	}

	public function login(){
		
		
		$rules = array(
			'username'    => 'required|min:6', // make sure the email is an actual email
			'password' => 'required|alphaNum|min:6' // password can only be alphanumeric and has to be greater than 3 characters
		);
		$validator = Validator::make(Input::all(), $rules);
		//$validation=User::validate(array('username','password'));//Input::all());
		if ($validator->fails()){
			
			return Redirect::to('login')->withErrors($validator->messages());

			
		}
		
		else{
			$username=Input::get('username');
			$password=Input::get('password');


			if(Auth::attempt(array('username'=>$username,'password'=>$password))){
				return Redirect::to('users/home');
				//$view=View::make('home');
				//$this->layout->content=$view;
			}
			else{
				$this->layout->content='unsuccessful';
			}
		}
		

	}

	public function doLogout()
	{
		Auth::logout(); // log the user out of our application
		return Redirect::to('login'); // redirect the user to the login screen
	}

	public function home(){
		$view=View::make('home');
		$this->layout->content=$view;
	}


	
}
?>