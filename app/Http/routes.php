<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Authentication routes...
/*Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');*/

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@get_Register');
Route::post('auth/register', 'Auth\AuthController@post_Register');

Route::get('agencies/register', 'AgenciesController@get_Register');
Route::post('agencies/register', 'AgenciesController@post_Register');
Route::get('agencies/index', 'AgenciesController@index');
Route::get('agencies/view/{id}', 'AgenciesController@view@id');



/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
// users
	/*Route::get('users','UsersController@index');
	Route::get('users/index','UsersController@index');
	Route::post('users/search', array( 'uses' => 'UsersController@search'));
	Route::get('users/add',array('as' => 'adduser','uses'=>'UsersController@add'));
	Route::post('users/save','UsersController@save');
	Route::post('users/edit','UsersController@edit');
	Route::get('users/edit/{id}', array('as' => 'users.edit', 'uses' => 'UsersController@edit_form'));
	Route::get('users/view/{id}','UsersController@view@id');
	Route::get('users/delete/{id}','UsersController@delete@id');
	Route::get('login','UsersController@login_form');
	Route::post('login','UsersController@login');
	Route::get('logout', array('uses' => 'UsersController@doLogout'));*/
/*
Route::get('/', function()
{
	return "please enter valid link";
});

*/
	//agencies

	Route::get('agencies', array( 'uses' => 'AgenciesController@index'));
	Route::post('agencies/search', array( 'uses' => 'AgenciesController@search'));
	Route::get('agencies/add',array('as' => 'addagency','uses'=>'AgenciesController@add'));
	Route::post('agencies/save','AgenciesController@save');
	Route::get('agencies/edit/{id}', array('as' => 'agencies.edit', 'uses' => 'AgenciesController@edit_form'));
	Route::post('agencies/edit','AgenciesController@edit');
	Route::get('agencies/view/{id}','AgenciesController@view@id');
	Route::get('agencies/delete/{id}','AgenciesController@delete@id');



	//clients
	Route::get('clients', array( 'uses' => 'ClientsController@index'));
	Route::post('clients/search', array( 'uses' => 'ClientsController@search'));
	Route::get('clients/add',array('as' => 'addclient','uses'=>'ClientsController@add'));
	Route::post('clients/save','ClientsController@save');
	Route::get('clients/edit/{id}', array('as' => 'clients.edit', 'uses' => 'ClientsController@edit_form'));
	Route::post('clients/edit','ClientsController@edit');
	Route::get('clients/view/{id}','ClientsController@view@id');
	Route::get('clients/delete/{id}','ClientsController@delete@id');
	

	// users
	Route::get('users','UsersController@index');
	Route::post('users/search', array( 'uses' => 'UsersController@search'));
	Route::get('users/add',array('as' => 'adduser','uses'=>'UsersController@add'));
	Route::post('users/save','UsersController@save');
	Route::get('users/edit/{id}', array('as' => 'users.edit', 'uses' => 'UsersController@edit_form'));
	Route::post('users/edit','UsersController@edit');
	Route::get('users/view/{id}','UsersController@view@id');
	Route::get('users/delete/{id}','UsersController@delete@id');

	// Institues
	Route::get('institutes','InstitutesController@index');
	Route::post('institutes/search', array( 'uses' => 'InstitutesController@search'));
	Route::get('institutes/add',array('as' => 'addinstitute','uses'=>'InstitutesController@add'));
	Route::post('institutes/save','InstitutesController@save');
	Route::get('institutes/edit/{id}', array('as' => 'institutes.edit', 'uses' => 'InstitutesController@edit_form'));
	Route::post('institutes/edit','InstitutesController@edit');
	Route::get('institutes/view/{id}','InstitutesController@view@id');
	Route::get('institutes/delete/{id}','InstitutesController@delete@id');
	Route::get('institutes/getCourses/{id}','InstitutesController@getCourses@id');
	Route::get('institutes/getInvoiceTo/{id}','InstitutesController@getInvoiceTo@id');

	// Courses
	Route::get('courses','CoursesController@index');
	Route::post('courses/search', array( 'uses' => 'CoursesController@search'));
	Route::get('courses/add/{id}',array('as' => 'addcourses','uses'=>'CoursesController@add'));
	Route::post('courses/save','CoursesController@save');
	Route::get('courses/edit/{id}', array('as' => 'courses.edit', 'uses' => 'CoursesController@edit_form'));
	Route::post('courses/edit','CoursesController@edit');
	Route::get('courses/view/{id}','CoursesController@view@id');
	Route::get('courses/delete/{id}','CoursesController@delete@id');
	Route::get('courses/getCourseInfo/{id}','CoursesController@getCourseInfo@id');

	// Contacts
	Route::get('contacts','ContactsController@index');
	Route::post('contacts/search', array( 'uses' => 'ContactsController@search'));
	Route::get('contacts/add/{id}',array('as' => 'addcontacts','uses'=>'ContactsController@add'));
	Route::post('contacts/save','ContactsController@save');
	Route::get('contacts/edit/{id}', array('as' => 'contacts.edit', 'uses' => 'ContactsController@edit_form'));
	Route::post('contacts/edit','ContactsController@edit');
	Route::get('contacts/view/{id}','ContactsController@view@id');
	Route::get('contacts/delete/{id}','ContactsController@delete@id');

	// Addresses
	Route::get('addresses','AddressesController@index');
	Route::post('addresses/search', array( 'uses' => 'AddressesController@search'));
	Route::get('addresses/add/{id}',array('as' => 'addaddresses','uses'=>'AddressesController@add'));
	Route::post('addresses/save','AddressesController@save');
	Route::get('addresses/edit/{id}', array('as' => 'addresses.edit', 'uses' => 'AddressesController@edit_form'));
	Route::post('addresses/edit','AddressesController@edit');
	Route::get('addresses/view/{id}','AddressesController@view@id');
	Route::get('addresses/delete/{id}','AddressesController@delete@id');

	// colleges
	Route::get('colleges','CollegesController@index');
	Route::post('colleges/search', array( 'uses' => 'CollegesController@search'));
	Route::get('colleges/add/{id}',array('as' => 'addcolleges','uses'=>'CollegesController@add'));
	Route::post('colleges/save','CollegesController@save');
	Route::get('colleges/edit/{id}', array('as' => 'colleges.edit', 'uses' => 'CollegesController@edit_form'));
	Route::post('colleges/edit','CollegesController@edit');
	Route::get('colleges/view/{id}','CollegesController@view@id');
	Route::get('colleges/delete/{id}','CollegesController@delete@id');
	Route::get('colleges/applications/{id}','CollegesController@applications@id');
	Route::get('colleges/status_update/{id}/{status_id}','CollegesController@status_update@id@status_id');

	// visas
	Route::get('visas','VisasController@index');
	Route::post('visas/search', array( 'uses' => 'VisasController@search'));
	Route::get('visas/add/{id}',array('as' => 'addvisas','uses'=>'VisasController@add'));
	Route::post('visas/save','VisasController@save');
	Route::get('visas/edit/{id}', array('as' => 'visas.edit', 'uses' => 'VisasController@edit_form'));
	Route::post('visas/edit','VisasController@edit');
	Route::get('visas/view/{id}','VisasController@view@id');
	Route::get('visas/delete/{id}','VisasController@delete@id');
	Route::get('visas/applications/{id}','VisasController@applications@id');
	Route::get('visas/status_update/{id}/{status_id}','VisasController@status_update@id@status_id');

	// healthcovers
	Route::get('healthcovers','HealthcoversController@index');
	Route::post('healthcovers/search', array( 'uses' => 'HealthcoversController@search'));
	Route::get('healthcovers/add/{id}',array('as' => 'addhealthcovers','uses'=>'HealthcoversController@add'));
	Route::post('healthcovers/save','HealthcoversController@save');
	Route::get('healthcovers/edit/{id}', array('as' => 'healthcovers.edit', 'uses' => 'HealthcoversController@edit_form'));
	Route::post('healthcovers/edit','HealthcoversController@edit');
	Route::get('healthcovers/view/{id}','HealthcoversController@view@id');
	Route::get('healthcovers/delete/{id}','HealthcoversController@delete@id');

	// Invoices
	Route::get('invoices/{id}','InvoicesController@index@id');
	Route::post('invoices/search', array( 'uses' => 'InvoicesController@search'));
	Route::get('invoices/add/{id}',array('as' => 'addinvoices','uses'=>'InvoicesController@add'));
	Route::post('invoices/save','InvoicesController@save');
	Route::get('invoices/edit/{id}', array('as' => 'invoices.edit', 'uses' => 'InvoicesController@edit_form'));
	Route::post('invoices/edit','InvoicesController@edit');
	Route::get('invoices/view/{id}','InvoicesController@view@id');
	Route::get('invoices/delete/{id}','InvoicesController@delete@id');
	Route::get('invoices/claimed/{id}','InvoicesController@claimed@id');
	Route::get('invoices/unclaimed/{id}','InvoicesController@unclaimed@id');
	Route::get('invoices/invoice/{id}','InvoicesController@invoice@id');

	//companies
	Route::get('companies/edit/{id}', array('as' => 'companies.edit', 'uses' => 'CompaniesController@edit_form'));
	Route::post('companies/edit','CompaniesController@edit');
	Route::get('companies/view/{id}','CompaniesController@view@id');

	// payments
	Route::get('payments','PaymentsController@index');
	Route::post('payments/search', array( 'uses' => 'PaymentsController@search'));
	Route::get('payments/add/{id}',array('as' => 'addpayment','uses'=>'PaymentsController@add@id'));
	Route::post('payments/save','PaymentsController@save');
	Route::get('payments/edit/{id}', array('as' => 'payments.edit', 'uses' => 'PaymentsController@edit_form'));
	Route::post('payments/edit','PaymentsController@edit');
	Route::get('payments/view/{id}','PaymentsController@view@id');
	Route::get('payments/delete/{id}','PaymentsController@delete@id');
	Route::get('payments/client_payments/{id}','PaymentsController@client_payments@id');


	// payment invoices
	Route::get('payment_invoices','PaymentInvoicesController@index');
	Route::post('payment_invoices/search', array( 'uses' => 'PaymentInvoicesController@search'));
	Route::get('payment_invoices/add/{id}',array('as' => 'addPaymentInvoices','uses'=>'PaymentInvoicesController@add@id'));
	Route::post('payment_invoices/save','PaymentInvoicesController@save');
	Route::get('payment_invoices/edit/{id}', array('as' => 'PaymentInvoices.edit', 'uses' => 'PaymentInvoicesController@edit_form'));
	Route::post('payment_invoices/edit','PaymentInvoicesController@edit');
	Route::get('payment_invoices/view/{id}','PaymentInvoicesController@view@id');
	Route::get('payment_invoices/delete/{id}','PaymentInvoicesController@delete@id');
	Route::any('payment_invoices/getInvoices/{id}','PaymentInvoicesController@getInvoices@id');
	Route::any('payment_invoices/getInvoicesId/{id}','PaymentInvoicesController@getInvoicesId@id');

	// Student invoices
	Route::get('student_invoices','StudentInvoicesController@index');
	Route::post('student_invoices/search', array( 'uses' => 'StudentInvoicesController@search'));
	Route::get('student_invoices/add/{id}',array('as' => 'addStudentInvoices','uses'=>'StudentInvoicesController@add@id'));
	Route::post('student_invoices/save','StudentInvoicesController@save');
	Route::get('student_invoices/edit/{id}', array('as' => 'StudentInvoices.edit', 'uses' => 'StudentInvoicesController@edit_form'));
	Route::post('student_invoices/edit','StudentInvoicesController@edit');
	Route::get('student_invoices/view/{id}','StudentInvoicesController@view@id');
	Route::get('student_invoices/delete/{id}','StudentInvoicesController@delete@id');
	Route::any('student_invoices/getInvoices/{id}','StudentInvoicesController@getInvoices@id');
	Route::any('student_invoices/getInvoicesId/{id}','StudentInvoicesController@getInvoicesId@id');


	// Visa invoices
	Route::get('visa_invoices','VisaInvoicesController@index');
	Route::post('visa_invoices/search', array( 'uses' => 'VisaInvoicesController@search'));
	Route::get('visa_invoices/add/{id}',array('as' => 'addVisaInvoices','uses'=>'VisaInvoicesController@add@id'));
	Route::post('visa_invoices/save','VisaInvoicesController@save');
	Route::get('visa_invoices/edit/{id}', array('as' => 'VisaInvoices.edit', 'uses' => 'VisaInvoicesController@edit_form'));
	Route::post('visa_invoices/edit','VisaInvoicesController@edit');
	Route::get('visa_invoices/view/{id}','VisaInvoicesController@view@id');
	Route::get('visa_invoices/delete/{id}','VisaInvoicesController@delete@id');
	Route::any('visa_invoices/invoices/{id}','VisaInvoicesController@invoices@id');
	Route::any('visa_invoices/getInvoicesId/{id}','VisaInvoicesController@getInvoicesId@id');


	
	


	//general pages
	Route::get('users/home','UsersController@home');

	

Route::group(['middleware' => 'web'], function () {
    Route::auth();

    Route::get('/home', 'HomeController@index');
});


Route::group(['middleware' => 'web'], function () {
    Route::auth();

    Route::get('/home', 'HomeController@index');
});
