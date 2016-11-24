<?php

class CompaniesController extendS BaseController{
	public $layout="layout.default";
	

	public function view($id=null){
		
		$companies=Company::view($id);

		$view=View::make('companies/view')->with(array('companies_details' => $companies));

		$this->layout->content=$view;

	}

	public function edit_form($id=null){
		$view=View::make('companies/edit')->with('companies', Company::find($id));
		$this->layout->content=$view;
	}

	public function edit()
	{
		
		$array_var=$_POST;
		$id=$array_var['id'];
		array_shift($array_var);

		DB::table('companies')
            ->where('id', $id)
            ->update($array_var);
		$companies_details=Company::view($id);

		return Redirect::to("companies/view/$id");
		

	}

}
?>