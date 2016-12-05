<?php
/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here is where we register tenant (sub-domain) related routes
|
*/

/*
if (env('APP_ENV') == 'live') {
    $group_guest = ['domain' => '{account}.mashbooks.no', 'namespace' => 'Controllers', 'middleware' => 'guest.tenant'];
    $group_auth = ['domain' => '{account}.mashbooks.no', 'middleware' => 'auth.tenant'];
} elseif (env('APP_ENV') == 'dev') {
    $group_guest = ['domain' => '{account}.mashbooks.app', 'namespace' => 'Controllers', 'middleware' => 'guest.tenant'];
    $group_auth = ['domain' => '{account}.mashbooks.app', 'middleware' => 'auth.tenant'];
}

Route::group($group_guest, function () {
    get('login', ['as' => 'tenant.login', 'uses' => 'Tenant\AuthController@getLogin']);
    post('login', 'Tenant\AuthController@postLogin');
    post('register', ['as' => 'tenant.register', 'uses' => 'Tenant\AuthController@postRegister']);
    get('forgot-password', ['as' => 'tenant.forgetPassword', 'uses' => 'Tenant\RemindersController@forgetPassword']);
    post('forgot-password', ['as' => 'tenant.forgetPassword', 'uses' => 'Tenant\RemindersController@postForgotPassword']);
    get('reset-password/{code}', ['as' => 'tenant.resetPassword', 'uses' => 'Tenant\RemindersController@getReset']);
    post('reset-password/{code}', ['uses' => 'Tenant\RemindersController@postReset']);
    get('verify/{confirmationCode}', ['as' => 'subuser.register.confirm', 'uses' => 'Tenant\AuthController@confirm']);
});


Route::group($group_auth, function () {

    Route::group(['prefix' => 'file', 'namespace' => 'Tenant\File\Controllers'], function () {
        post('upload/data', 'FileController@upload');
        get('delete', 'FileController@delete');
    });
});*/

/* Tenant Routes for pages that don't need login */
Route::group(array('prefix' => '{tenant_id}', 'module' => 'Tenant', 'middleware' => 'guest.tenant', 'namespace' => 'App\Modules\Tenant\Controllers'), function () {
    Route::get('login', ['as' => 'tenant.login', 'uses' => 'AuthController@getLogin']);
    Route::post('login', 'AuthController@postLogin');
    Route::post('complete', 'AuthController@complete');
    Route::get('forgot-password', ['as' => 'tenant.forgetPassword', 'uses' => 'PasswordController@getForgotPassword']);
    Route::post('forgot-password', ['as' => 'tenant.forgetPassword', 'uses' => 'PasswordController@postForgotPassword']);
    Route::get('reset-password/{code}', ['as' => 'system.reminders.getReset', 'uses' => 'PasswordController@getReset']);
    Route::post('reset-password/{code}', ['as' => 'system.reminders.postReset', 'uses' => 'PasswordController@postReset']);
});

/* Tenant Routes for pages that need authentication */
Route::group(array('prefix' => '{tenant_id}', 'module' => 'Tenant', 'middleware' => 'auth.tenant', 'namespace' => 'App\Modules\Tenant\Controllers'), function () {

    /* Routes for File upload */
    Route::post('file/upload', 'FileController@upload');
    Route::get('file/delete', 'FileController@delete');

    /* Routes for Client module */
    Route::get('clients', ['as' => 'tenant.client.index', 'uses' => 'ClientController@index']);
    Route::get('clients/create', ['as' => 'tenant.client.create', 'uses' => 'ClientController@create']);
    Route::post('clients', ['as' => 'tenant.client.store', 'uses' => 'ClientController@store']);
    Route::get('clients/{id}', ['as' => 'tenant.client.show', 'uses' => 'ClientController@show']);
    Route::get('clients/{id}/edit', ['as' => 'tenant.client.edit', 'uses' => 'ClientController@edit']);
    Route::put('clients/{id}', ['as' => 'tenant.client.update', 'uses' => 'ClientController@update']);
    Route::delete('clients/{id}', ['as' => 'tenant.client.destroy', 'uses' => 'ClientController@destroy']);
    Route::get('client/due', ['as' => 'tenant.client.due', 'uses' => 'ClientController@duePayments']);

    Route::post('clients/{id}/upload', ['as' => 'tenant.client.upload', 'uses' => 'ClientController@upload']);
    Route::post('clients/{id}/urlUpload', ['as' => 'tenant.client.urlUpload', 'uses' => 'ClientController@urlUpload']);

    Route::get('client/data', 'ClientController@getData');
    Route::get('clients/{client_id}/document', ['as' => 'tenant.client.document', 'uses' => 'ClientController@document']);
    Route::post('clients/{client_id}/document', 'ClientController@uploadDocument');
    Route::get('clients/document/{document_id}/download', ['as' => 'tenant.client.document.download', 'uses' => 'ClientController@downloadDocument']);
    Route::get('clients/document/{document_id}/delete', ['as' => 'tenant.client.document.delete', 'uses' => 'ClientController@deleteDocument']);

    Route::get('clients/{client_id}/accounts', ['as' => 'tenant.accounts.index', 'uses' => 'AccountController@index']);
    Route::get('courses/{institute_id}', ['as' => 'tenant.institute.course', 'uses' => 'CourseController@getCourses']);
    Route::get('intakes/{institute_id}', ['as' => 'tenant.institute.intake', 'uses' => 'IntakeController@getIntakes']);

    Route::get('account/payment/{payment_id}/{application_id}/assign', ['as' => 'tenant.account.payment.assign', 'uses' => 'AccountController@assignInvoice']);

    /* Create payments for a client */
    Route::get('payment/{client_id}/add', ['as' => 'tenant.payment.create', 'uses' => 'AccountController@createClientPayment']);
    Route::post('payment/{client_id}/store', ['as' => 'tenant.client.payment', 'uses' => 'AccountController@storeClientPayment']);

    /* Edit Payments for client */
    Route::get('payment/{payment_id}/edit', ['as' => 'client.payment.edit', 'uses' => 'AccountController@editClientPayment']);
    Route::post('payment/{payment_id}/edit', ['as' => 'client.payment.update', 'uses' => 'AccountController@updateClientPayment']);

    Route::get('payment/{payment_id}/delete', ['as' => 'client.payment.delete', 'uses' => 'AccountController@deleteClientPayment']);

    Route::get('payments/client/{client_id}/data', 'AccountController@getPaymentsData');

    /* Create invoices for a client */
    Route::get('invoice/{client_id}/add', ['as' => 'tenant.invoice.create', 'uses' => 'AccountController@createClientInvoice']);
    Route::post('invoice/{client_id}/store', ['as' => 'tenant.client.invoice', 'uses' => 'AccountController@storeClientInvoice']);
    Route::get('invoices/client/{client_id}/data', 'AccountController@getInvoicesData');
    Route::get('invoices/future/{client_id}/data', 'AccountController@getFutureData');

    /* Invoice Actions */
    Route::get('invoices/{invoice_id}/edit', ['as' => 'tenant.invoice.edit', 'uses' => 'AccountController@editInvoice']);
    Route::put('invoices/{invoice_id}/edit', ['as' => 'tenant.invoice.update', 'uses' => 'AccountController@updateInvoice']);

    Route::get('invoices/{invoice_id}/payments/{type}', ['as' => 'tenant.invoice.payments', 'uses' => 'InvoiceController@payments']);
    Route::get('invoices/payments/{invoice_id}/{type}/data', 'InvoiceController@getPaymentsData');


    /* Add Payment to invoices directly */
    Route::get('invoices/{invoice_id}/payment/add/{type}', ['as' => 'invoice.payment.add', 'uses' => 'InvoiceController@createPayment']);
    Route::post('invoices/{invoice_id}/payment/add/{type}', ['as' => 'invoice.payment.create', 'uses' => 'InvoiceController@postPayment']);

    /* Create applications for a client */
    Route::get('clients/{client_id}/applications', ['as' => 'tenant.client.application', 'uses' => 'ApplicationController@index']);

    /* Routes for Client Application module */
    Route::get('applications/{client_id}/data', 'ApplicationController@getApplicationsData');
    Route::get('applications', ['as' => 'tenant.application.index', 'uses' => 'ApplicationController@index']);
    Route::get('applications/{client_id}/create', ['as' => 'tenant.application.create', 'uses' => 'ApplicationController@create']);
    Route::post('applications/{client_id}', ['as' => 'tenant.application.store', 'uses' => 'ApplicationController@store']);
    Route::get('applications/{id}/show', ['as' => 'tenant.application.show', 'uses' => 'ApplicationController@show']);
    Route::get('applications/{id}/edit', ['as' => 'tenant.application.edit', 'uses' => 'ApplicationController@edit']);
    Route::put('applications/{id}', ['as' => 'tenant.application.update', 'uses' => 'ApplicationController@update']);
    Route::delete('applications/{id}', ['as' => 'tenant.application.destroy', 'uses' => 'ApplicationController@destroy']);

    /* Routes for Application document */
    Route::get('applications/{id}/document', ['as' => 'tenant.application.document', 'uses' => 'ApplicationController@document']);
    Route::post('applications/{client_id}/document', 'ApplicationController@uploadDocument');
    Route::get('applications/document/{document_id}/download', ['as' => 'tenant.application.document.download', 'uses' => 'ApplicationController@downloadDocument']);
    Route::get('applications/document/{document_id}/delete', ['as' => 'tenant.application.document.delete', 'uses' => 'ApplicationController@deleteDocument']);

    /* Routes for Application Notes */
    Route::get('applications/{id}/notes', ['as' => 'tenant.application.notes', 'uses' => 'ApplicationController@notes']);
    Route::post('applications/{id}/notes', ['as' => 'tenant.application.notes', 'uses' => 'ApplicationController@saveNote']);

    /* Get application timline */
    Route::get('applications/{id}/details', ['as' => 'tenant.application.details', 'uses' => 'ApplicationController@details']);

    /* Get forms to add through ajax */
    Route::get('application/institute/add', ['as' => 'application.institute.add', 'uses' => 'ApplicationController@createInstitute']);
    Route::get('application/course/add', ['as' => 'application.course.add', 'uses' => 'ApplicationController@createCourse']);
    Route::get('application/intake/add', ['as' => 'application.intake.add', 'uses' => 'ApplicationController@createIntake']);
    Route::get('application/subagent/add', ['as' => 'application.subagent.add', 'uses' => 'ApplicationController@createAgent']);
    Route::get('application/superagent/add', ['as' => 'application.superagent.add', 'uses' => 'ApplicationController@createSuperAgent']);

    /* Create super and sub agents for application */
    Route::post('applications/{application_id}/subagent', ['as' => 'tenant.application.subagent', 'uses' => 'ApplicationController@createSubAgent']);
    Route::post('applications/{application_id}/superagent', ['as' => 'tenant.application.superagent', 'uses' => 'ApplicationController@addSuperAgent']);

    /* Routes for college section */
    Route::get('applications/{application_id}/college', ['as' => 'tenant.application.college', 'uses' => 'CollegeController@index']);

    /* Create payments for a application college */
    Route::get('applications/{application_id}/payment', ['as' => 'tenant.application.payment', 'uses' => 'CollegeController@createPayment']);
    Route::get('applications/{application_id}/payment/{type}', ['as' => 'tenant.application.college.payment', 'uses' => 'CollegeController@createPayment']);
    Route::post('applications/{application_id}/storePayment', ['as' => 'tenant.application.storePayment', 'uses' => 'CollegeController@storePayment']);
    Route::get('applications/{payment_id}/editPayment', ['as' => 'tenant.application.editPayment', 'uses' => 'CollegeController@editPayment']);
    Route::put('applications/{payment_id}/editPayment', ['as' => 'tenant.application.updatePayment', 'uses' => 'CollegeController@updatePayment']);
    Route::get('applications/payments/{client_id}/data', 'CollegeController@getPaymentsData');

    /* Create invoices for a application college */
    Route::get('applications/{application_id}/invoice', ['as' => 'tenant.application.invoice', 'uses' => 'CollegeController@createInvoice']);
    Route::post('applications/{application_id}/storeInvoice', ['as' => 'tenant.application.storeInvoice', 'uses' => 'CollegeController@storeInvoice']);
    Route::get('applications/invoices/{client_id}/data', 'CollegeController@getInvoicesData');
    Route::get('applications/recent/{client_id}/data', 'CollegeController@getRecentData');
    Route::get('applications/invoices/receipt/{invoice_id}', 'CollegeController@printInvoice');

    /* College Invoices */
    Route::get('college/{invoice_id}/invoice', ['as' => 'tenant.college.invoice', 'uses' => 'CollegeController@show']);
    Route::get('college/{invoice_id}/editInvoice', ['as' => 'tenant.college.editInvoice', 'uses' => 'CollegeController@editInvoice']);
    Route::put('college/{invoice_id}/editInvoice', ['as' => 'tenant.college.editInvoice', 'uses' => 'CollegeController@updateInvoice']);
    Route::get('college/{invoice_id}/deleteInvoice', ['as' => 'tenant.college.deleteInvoice', 'uses' => 'CollegeController@deleteInvoice']);

    /* Routes for student section */
    Route::get('applications/{application_id}/students', ['as' => 'tenant.application.students', 'uses' => 'StudentController@index']);

    /* Create payments for a application college */
    Route::get('students/{application_id}/payment', ['as' => 'application.students.payment', 'uses' => 'StudentController@createPayment']);
    Route::post('students/{application_id}/storePayment', ['as' => 'application.students.storePayment', 'uses' => 'StudentController@storePayment']);
    Route::get('students/{payment_id}/editPayment', ['as' => 'application.students.editPayment', 'uses' => 'StudentController@editPayment']);
    Route::put('students/{payment_id}/editPayment', ['as' => 'application.students.updatePayment', 'uses' => 'StudentController@updatePayment']);
    Route::get('students/{payment_id}/deletePayment', ['as' => 'application.students.deletePayment', 'uses' => 'StudentController@deletePayment']);
    Route::get('students/payments/{client_id}/data', 'StudentController@getPaymentsData');

    /* Create invoices for a application college */
    Route::get('students/{application_id}/invoice', ['as' => 'application.students.invoice', 'uses' => 'StudentController@createInvoice']);
    Route::post('students/{application_id}/storeInvoice', ['as' => 'application.students.storeInvoice', 'uses' => 'StudentController@storeInvoice']);
    Route::get('students/invoices/{client_id}/data', 'StudentController@getInvoicesData');
    Route::get('students/recent/{client_id}/data', 'StudentController@getRecentData');
    Route::get('students/payment/receipt/{payment_id}', 'StudentController@printReceipt');

    /* Student Invoices */
    Route::get('student/{invoice_id}/invoice', ['as' => 'tenant.student.invoice', 'uses' => 'StudentController@show']);
    Route::get('student/{invoice_id}/editInvoice', ['as' => 'tenant.student.editInvoice', 'uses' => 'StudentController@editInvoice']);
    Route::put('student/{invoice_id}/editInvoice', ['as' => 'tenant.student.updateInvoice', 'uses' => 'StudentController@updateInvoice']);
    Route::get('student/{invoice_id}/deleteInvoice', ['as' => 'tenant.student.deleteInvoice', 'uses' => 'StudentController@deleteInvoice']);
    Route::get('student/{invoice_id}/deleteInvoiceOnly', ['as' => 'tenant.student.deleteInvoiceOnly', 'uses' => 'StudentController@deleteInvoiceOnly']);

    /* Routes for subagent section */
    Route::get('applications/{application_id}/subagents', ['as' => 'tenant.application.subagents', 'uses' => 'SubAgentController@index']);

    /* Create payments for a application sub agents */
    Route::get('subagents/{application_id}/payment', ['as' => 'application.subagents.payment', 'uses' => 'SubAgentController@createPayment']);
    Route::post('subagents/{application_id}/storePayment', ['as' => 'application.subagents.storePayment', 'uses' => 'SubAgentController@storePayment']);
    Route::get('subagents/{payment_id}/editPayment', ['as' => 'application.subagents.editPayment', 'uses' => 'SubAgentController@editPayment']);
    Route::put('subagents/{payment_id}/editPayment', ['as' => 'application.subagents.updatePayment', 'uses' => 'SubAgentController@updatePayment']);
    Route::get('subagents/payments/{client_id}/data', 'SubAgentController@getPaymentsData');
    Route::get('subagents/{payment_id}/payment/view', ['as' => 'subagents.payment.view', 'uses' => 'SubAgentController@viewPayment']);

    /* Create invoices for a application sub agents */
    Route::get('subagents/{application_id}/invoice', ['as' => 'application.subagents.invoice', 'uses' => 'SubAgentController@createInvoice']);
    Route::post('subagents/{application_id}/storeInvoice', ['as' => 'application.subagents.storeInvoice', 'uses' => 'SubAgentController@storeInvoice']);
    Route::get('subagents/invoices/{client_id}/data', 'SubAgentController@getInvoicesData');
    Route::get('subagents/future/{client_id}/data', 'SubAgentController@getFutureData');

    /* Assign payments to invoices */
    Route::get('payment/{payment_id}/{application_id}/assign', ['as' => 'tenant.subagent.payment.assign', 'uses' => 'SubAgentController@assignInvoice']);
    Route::post('payment/{payment_id}/assign', ['as' => 'tenant.payment.postAssign', 'uses' => 'InvoiceController@postAssign']);

    /* SubAgent Invoices */
    Route::get('subagents/{invoice_id}/invoice', ['as' => 'tenant.subagents.invoice', 'uses' => 'SubAgentController@show']);
    Route::get('subagents/{invoice_id}/editInvoice', ['as' => 'tenant.subagents.editInvoice', 'uses' => 'SubAgentController@editInvoice']);
    Route::put('subagents/{invoice_id}/editInvoice', ['as' => 'tenant.subagents.editInvoice', 'uses' => 'SubAgentController@updateInvoice']);

    /* Assign student payments to invoices */
    Route::get('student/payment/{payment_id}/{application_id}/assign', ['as' => 'tenant.student.payment.assign', 'uses' => 'StudentController@assignInvoice']);

    /* Assign student payments to invoices */
    Route::get('college/payment/{payment_id}/{application_id}/assign', ['as' => 'tenant.college.payment.assign', 'uses' => 'CollegeController@assignInvoice']);
    Route::post('college/payment/{payment_id}/assign', ['as' => 'tenant.college.payment.postAssign', 'uses' => 'InvoiceController@postCollegeAssign']);

    Route::get('clients/{client_id}/personal_details', 'ClientController@personal_details');
    Route::get('clients/{client_id}/notes', 'ClientController@notes');
    Route::get('clients/{client_id}/active', 'ClientController@setActive');
    Route::get('clients/{client_id}/inactive', 'ClientController@removeActive');

    /* Routes for Institute module */
    //Route::resource('institute', 'InstituteController');
    Route::get('institute', ['as' => 'tenant.institute.index', 'uses' => 'InstituteController@index']);
    Route::get('institute/create', ['as' => 'tenant.institute.create', 'uses' => 'InstituteController@create']);
    Route::post('institute', ['as' => 'tenant.institute.store', 'uses' => 'InstituteController@store']);
    Route::get('institute/{institute_id}', ['as' => 'tenant.institute.show', 'uses' => 'InstituteController@show']);
    Route::get('institute/{institute_id}/edit', ['as' => 'tenant.institute.edit', 'uses' => 'InstituteController@edit']);
    Route::put('institute/{institute_id}', ['as' => 'tenant.institute.update', 'uses' => 'InstituteController@update']);
    Route::delete('institute/{institute_id}', ['as' => 'tenant.institute.destroy', 'uses' => 'InstituteController@destroy']);
    
    Route::get('course/search', ['as' => 'tenant.course.search', 'uses' => 'CourseController@search']);
    Route::post('course/search', ['as' => 'tenant.course.search', 'uses' => 'CourseController@search']);

    Route::get('institutes/data', 'InstituteController@getData');
    Route::get('institutes/{institute_id}/document', ['as' => 'tenant.institute.document', 'uses' => 'InstituteController@document']);
    Route::post('institutes/{institute_id}/document', 'InstituteController@uploadDocument');
    Route::get('institutes/document/{document_id}/download', ['as' => 'tenant.institute.document.download', 'uses' => 'InstituteController@downloadDocument']);
    Route::post('institutes/{institute_id}/contact/store', 'InstituteController@storeContact');
    Route::post('institutes/{institute_id}/address/store', 'InstituteController@storeAddress');

    /* Routes for Company Contacts */
    Route::get('institutes/{institute_id}/contacts', 'ContactController@getData');
    Route::get('contact/{id}', ['as' => 'tenant.contact.edit', 'uses' => 'ContactController@edit']);
    Route::post('contact/{id}', ['as' => 'tenant.contact.update', 'uses' => 'ContactController@update']);
    Route::get('contact/{id}/delete', ['as' => 'tenant.contact.destroy', 'uses' => 'ContactController@destroy']);

    /* Routes for Institute Address */
    Route::get('institutes/{institute_id}/addresses', 'AddressController@getData');
    Route::get('address/{id}', ['as' => 'tenant.address.edit', 'uses' => 'AddressController@edit']);
    Route::post('address/{id}', ['as' => 'tenant.address.update', 'uses' => 'AddressController@update']);
    Route::get('address/{id}/delete', ['as' => 'tenant.address.destroy', 'uses' => 'AddressController@destroy']);

    /* Routes for Super Agents */
    Route::post('superagents/{institute_id}/store', 'AgentController@storeSuperAgent');
    Route::get('superagents/{institute_id}/remove/{agent_id}', ['as' => 'tenant.superagent.remove', 'uses' => 'AgentController@removeSuperAgent']);

    Route::get('agents', ['as' => 'tenant.agents.index', 'uses' => 'AgentController@index']);
    Route::get('agents/create', ['as' => 'tenant.agents.create', 'uses' => 'AgentController@create']);
    Route::post('agents', ['as' => 'tenant.agents.store', 'uses' => 'AgentController@store']);
    Route::get('agents/{agent_id}', ['as' => 'tenant.agents.show', 'uses' => 'AgentController@show']);
    Route::get('agents/{agent_id}/edit', ['as' => 'tenant.agents.edit', 'uses' => 'AgentController@edit']);
    Route::put('agents/{agent_id}', ['as' => 'tenant.agents.update', 'uses' => 'AgentController@update']);
    Route::delete('agents/{agent_id}', ['as' => 'tenant.agents.destroy', 'uses' => 'AgentController@destroy']);

    Route::get('agent/data', 'AgentController@getData');

    /* Routes for Course module */
    Route::get('institutes/{institute_id}/courses', ['as' => 'tenant.course.index', 'uses' => 'CourseController@index']);
    Route::get('courses/{institute_id}/data', 'InstituteController@getCoursesData');
    Route::get('course/{id}', ['as' => 'tenant.course.show', 'uses' => 'CourseController@show']);
    Route::get('course/create/{id}', ['as' => 'tenant.course.create', 'uses' => 'CourseController@create']);
    Route::post('course/{id}/store', ['as' => 'tenant.course.store', 'uses' => 'CourseController@store']);
    Route::get('course/{id}/edit', ['as' => 'tenant.course.edit', 'uses' => 'CourseController@edit']);
    Route::put('course/{id}/update', ['as' => 'tenant.course.update', 'uses' => 'CourseController@update']);
    Route::delete('course', ['as' => 'tenant.course.destroy', 'uses' => 'CourseController@destroy']);
    Route::get('narrowfield/{broad_id}', ['as' => 'tenant.course.narrow', 'uses' => 'CourseController@getNarrowField']);
    Route::get('course/fee/{course_id}', ['as' => 'tenant.course.fee', 'uses' => 'CourseController@getCourseFee']);

    /* Routes for Intake module */
    Route::get('institutes/{institute_id}/intakes', ['as' => 'tenant.intake.index', 'uses' => 'IntakeController@index']);
    Route::get('intakes/{institute_id}/data', 'InstituteController@getIntakesData');
    Route::get('intakes/{id}show', ['as' => 'tenant.intake.show', 'uses' => 'IntakeController@show']);
    Route::get('intakes/create/{id}', ['as' => 'tenant.intake.create', 'uses' => 'IntakeController@create']);
    Route::post('intakes/{id}/store', ['as' => 'tenant.intake.store', 'uses' => 'IntakeController@store']);
    Route::get('intakes/{id}/edit', ['as' => 'tenant.intake.edit', 'uses' => 'IntakeController@edit']);
    Route::put('intakes/{id}/update', ['as' => 'tenant.intake.update', 'uses' => 'IntakeController@update']);
    Route::get('intakes/{institute_id}/{intake_id}', ['as' => 'tenant.intake.destroy', 'uses' => 'IntakeController@destroy']);

    /* Routes for User Module */

    Route::get('user', ['as' => 'tenant.user.index', 'uses' => 'UserController@index']);
    Route::get('user/create', ['as' => 'tenant.user.create', 'uses' => 'UserController@create']);
    Route::post('user', ['as' => 'tenant.user.store', 'uses' => 'UserController@store']);
    Route::get('user/{user_id}', ['as' => 'tenant.user.show', 'uses' => 'UserController@show']);
    Route::get('user/{user_id}/edit', ['as' => 'tenant.user.edit', 'uses' => 'UserController@edit']);
    Route::get('user/{user_id}/status', ['as' => 'tenant.user.changeStatus', 'uses' => 'UserController@change_status']);
    Route::put('user/{user_id}', ['as' => 'tenant.user.update', 'uses' => 'UserController@update']);
    Route::delete('user/{user_id}', ['as' => 'tenant.user.destroy', 'uses' => 'UserController@destroy']);

    Route::get('users/data', 'UserController@getData');
    Route::get('profile', 'UserController@edit');
    //Route::post('profile', 'UserController@update');
    Route::post('users/{user_id}/update', ['as' => 'tenant.users.update', 'uses' => 'UserController@update']);
    Route::get('profile/password/{user_id}', ['as' => 'tenant.users.password', 'uses' => 'UserController@resetPassword']);
    Route::post('profile/password/{user_id}', ['as' => 'tenant.users.password', 'uses' => 'UserController@postResetPassword']);
    Route::get('users/dashboard', ['as' => 'users.dashboard', 'uses' => 'UserController@dashboard']);

    /* Set reminder as completed */
    Route::get('reminder/{id}', ['as' => 'tenant.reminder.complete', 'uses' => 'UserController@completeReminder']);

    /*routes for innerdocument*/
    Route::get('client/data', 'ClientController@getData');
    Route::get('clients/{client_id}/innerdocument', ['as' => 'tenant.client.innerdocument', 'uses' => 'ClientController@innerdocument']);
    Route::post('clients/{client_id}/innerdocument', 'ClientController@uploadInnerDocument');
    Route::get('clients/innerdocument/{document_id}/download', ['as' => 'tenant.client.innerdocument.download', 'uses' => 'ClientController@downloadDocument']);


    /*routes for notes*/
    Route::get('clients/{client_id}/notes', 'ClientController@notes');
    Route::get('client/data', 'ClientController@getData');
    Route::get('clients/{client_id}/notes', ['as' => 'tenant.client.notes', 'uses' => 'ClientController@notes']);
    Route::post('clients/{client_id}/notes', 'ClientController@uploadClientNotes');
    Route::get('note/{notes_id}/delete', ['as' => 'tenant.client.notes.delete', 'uses' => 'ClientController@deleteNote']);

    /* Routes for Client Email */
    Route::get('clients/{client_id}/compose', ['as' => 'tenant.client.compose', 'uses' => 'ClientController@compose']);
    Route::post('clients/{client_id}/compose', 'ClientController@sendMail');
    Route::get('clients/{client_id}/sent', ['as' => 'tenant.client.sent', 'uses' => 'ClientController@sent']);
    Route::get('clients/{client_id}/read/{mail_id}', ['as' => 'tenant.client.readMail', 'uses' => 'ClientController@readMail']);

    /* Routes for Settings Module */
    Route::get('settings/company', ['as' => 'tenant.company.edit', 'uses' => 'SettingController@company']);
//    Route::post('settings/company/{agent_id}/store', ['as' => 'tenant.company.store', 'uses' => 'SettingController@updateCompany']);
    Route::post('settings/company/store', ['as' => 'tenant.company.store', 'uses' => 'SettingController@updateCompany']);
    Route::get('settings/send_email', ['as' => 'tenant.bulkemail.view', 'uses' => 'SettingController@send_email']);
    Route::post('settings/send_email', ['as' => 'tenant.bulkemail.send', 'uses' => 'SettingController@send_email_post']);

    /* Routes for Bank Module */
    Route::get('settings/bank', ['as' => 'tenant.bank.edit', 'uses' => 'SettingController@bank']);
    Route::post('settings/bank/store', ['as' => 'tenant.bank.store', 'uses' => 'SettingController@updateBank']);

    /* Routes for Reports Module */
    Route::get('reports/collegeInvoice', 'ReportController@CollegeInvoiceReport');

    Route::get('applications/enquiry', ['as' => 'applications.enquiry.index', 'uses' => 'ApplicationStatusController@index']);
    Route::get('applications/offer_letter_processing', ['as' => 'applications.offer_letter_processing.index', 'uses' => 'ApplicationStatusController@offerLetterProcessing']);
    Route::get('applications/offer_letter_issued', ['as' => 'applications.offer_letter_issued.index', 'uses' => 'ApplicationStatusController@offerLetterIssued']);
    Route::get('applications/coe_processing', ['as' => 'applications.coe_processing.index', 'uses' => 'ApplicationStatusController@coeProcessing']);
    Route::get('applications/coe_issued', ['as' => 'applications.coe_issued.index', 'uses' => 'ApplicationStatusController@coeIssued']);
    Route::get('applications/enrolled', ['as' => 'applications.enrolled.index', 'uses' => 'ApplicationStatusController@enrolled']);
    Route::get('applications/completed', ['as' => 'applications.completed.index', 'uses' => 'ApplicationStatusController@completed']);
    Route::get('applications/cancelled', ['as' => 'applications.cancelled.index', 'uses' => 'ApplicationStatusController@cancelled']);
    Route::get('applications/search', ['as' => 'applications.search.index', 'uses' => 'ApplicationStatusController@advancedSearch']);
    Route::post('application/search', ['as' => 'application.search', 'uses' => 'ApplicationStatusController@advancedSearch']);

    /* Routes for actions in applications module */
    Route::get('applications/{course_application_id}/apply_offer', ['as' => 'applications.apply.offer', 'uses' => 'ApplicationStatusController@apply_offer']);
    Route::post('applications/{course_application_id}/update', ['as' => 'applications.apply.update', 'uses' => 'ApplicationStatusController@update']);
    Route::get('applications/{course_application_id}/cancel_application', ['as' => 'applications.cancel.application', 'uses' => 'ApplicationStatusController@cancel_application']);
    Route::post('applications/{course_application_id}/cancel', ['as' => 'application.cancel', 'uses' => 'ApplicationStatusController@cancel']);
    Route::get('applications/{course_application_id}/offer_letter_received', ['as' => 'applications.offer.received', 'uses' => 'ApplicationStatusController@offer_letter_received']);
    Route::post('applications/{course_application_id}/update_offer_update', ['as' => 'applications.offer_letter.update', 'uses' => 'ApplicationStatusController@offer_received_update']);
    Route::get('applications/{course_application_id}/apply_coe', ['as' => 'applications.apply.coe', 'uses' => 'ApplicationStatusController@apply_coe']);
    Route::post('applications/{course_application_id}/update_applied_coe', ['as' => 'applications.update.applied.coe', 'uses' => 'ApplicationStatusController@update_applied_coe']);
    //Route::get('application/enquiry/data', 'ApplicationStatusController@getData');
    //Route::post('applications/{course_application_id}/status',['as' => 'applications.status', 'uses' => 'ApplicationsStatusController@status']);


    Route::get('applications/{course_application_id}/COE_issued', ['as' => 'applications.action.coe.issued', 'uses' => 'ApplicationStatusController@action_coe_issued']);
    Route::post('applications/{course_application_id}/update_COE_issued', ['as' => 'applications.action.update.coe.issued', 'uses' => 'ApplicationStatusController@update_coe_issued']);
    //Route::get('applications/{course_application_id}/coe_processing',['as' => 'applications.coe.processing', 'uses' => 'ApplicationsStatusController@coe_processing']);
    //Route::put('applications/{course_application_id}', ['as' => 'applications.update', 'uses' => 'ApplicationsStatusController@update']);
    //Route::put('applications/{course_application_id}/update', ['as'=>'apply_offer.update', 'uses'=>'ApplicationsStatusController@update']);
    // Route::resource('apply_offer', 'ApplyOfferController',['only'=>['edit','update']]);

    /*Routes for Invoice Reports All goes to InvoiceReportController*/
    Route::get('client_invoice_report/invoice_pending', ['as' => 'client.invoice.pending', 'uses' => 'InvoiceReportController@clientInvoicePending']);
    Route::get('client_invoice_report/invoice_paid', ['as' => 'client.invoice.paid', 'uses' => 'InvoiceReportController@clientInvoicePaid']);
    Route::get('client_invoice_report/invoice_future', ['as' => 'client.invoice.future', 'uses' => 'InvoiceReportController@clientInvoicefuture']);
    Route::get('client_invoice_report/search', ['as' => 'client.invoice.search', 'uses' => 'InvoiceReportController@clientInvoiceSearch']);
    Route::post('client_invoice_report/search', ['as' => 'client.invoice', 'uses' => 'InvoiceReportController@clientInvoiceSearch']);

    Route::get('college_invoice_report/invoice_pending', ['as' => 'college.invoice.pending', 'uses' => 'InvoiceReportController@collegeInvoicePending']);
    Route::get('college_invoice_report/invoice_paid', ['as' => 'college.invoice.paid', 'uses' => 'InvoiceReportController@collegeInvoicePaid']);
    Route::get('college_invoice_report/invoice_future', ['as' => 'college.invoice.future', 'uses' => 'InvoiceReportController@collegeInvoicefuture']);
    Route::get('college_invoice_report/search', ['as' => 'college.invoice.search', 'uses' => 'InvoiceReportController@collegeInvoiceSearch']);
    Route::post('college_invoice_report/search', ['as' => 'college.invoice', 'uses' => 'InvoiceReportController@collegeInvoiceSearch']);

    /* Routes for Group Invoice */
    Route::get('college_invoice_report/invoice_grouped', ['as' => 'college.invoice.grouped', 'uses' => 'InvoiceReportController@collegeInvoiceGrouped']);
    Route::get('college_invoice_report/show_grouped_invoices/{grouped_invoice_id}', ['as' => 'invoice.grouped.show', 'uses' => 'InvoiceReportController@showGroupedInvoices']);
    Route::get('college_invoice_report/print_grouped_invoices/{grouped_invoice_id}', ['as' => 'invoice.grouped.print', 'uses' => 'InvoiceReportController@showGroupedInvoices']);
    Route::get('group/{grouped_invoice_id}/invoice/{invoice_id}', ['as' => 'invoice.group.remove', 'uses' => 'InvoiceReportController@deleteGroupInvoices']);

    Route::get('client/payments', ['as' => 'accounts.client.payments', 'uses' => 'InvoiceReportController@clientPayments']);
    Route::get('institutes/payments', ['as' => 'accounts.institutes.payments', 'uses' => 'InvoiceReportController@collegePayments']);
    Route::get('subagent/payments', ['as' => 'accounts.subagent.payments', 'uses' => 'InvoiceReportController@subagentsPayments']);
    Route::get('search/payments', ['as' => 'accounts.search.payments', 'uses' => 'InvoiceReportController@searchPayments']);
    Route::post('search/payments', ['as' => 'payments.search', 'uses' => 'InvoiceReportController@searchPayments']);

    Route::get('college_invoice_report/group_invoice', ['as' => 'college.invoice.groupInvoice', 'uses' => 'InvoiceReportController@groupInvoice']);
    Route::post('college_invoice_report/group_invoice', ['as' => 'college.invoice.groupInvoice', 'uses' => 'InvoiceReportController@groupInvoice']);
    Route::get('invoice/group', ['as' => 'college.groupInvoice.create', 'uses' => 'InvoiceReportController@createGroupInvoice']);
    Route::post('invoice/group/{group_invoice_id}/addmore', ['as' => 'group.invoice.addmore', 'uses' => 'InvoiceReportController@addMoreGroupInvoice']);

    /* Print Client Invoices */
    Route::get('client/invoice/print/pending', ['as' => 'client.invoice.print.pending', 'uses' => 'InvoiceReportController@printclientInvoicePending']);
    Route::get('client/invoice/export/pending', ['as' => 'client.invoice.export.pending', 'uses' => 'InvoiceReportController@exportclientInvoicePending']);
    Route::get('client/invoice/pdf/pending', ['as' => 'client.invoice.pdf.pending', 'uses' => 'InvoiceReportController@pdfclientInvoicePending']);

    /* Print Client Invoices */
    Route::get('client/invoice/print/paid', ['as' => 'client.invoice.print.paid', 'uses' => 'InvoiceReportController@printclientInvoicePaid']);
    Route::get('client/invoice/export/paid', ['as' => 'client.invoice.export.paid', 'uses' => 'InvoiceReportController@exportclientInvoicePaid']);
    Route::get('client/invoice/pdf/paid', ['as' => 'client.invoice.pdf.paid', 'uses' => 'InvoiceReportController@pdfclientInvoicePaid']);

    // checking subscription expiry
    Route::get('subscription/check', 'SubscriptionController@checkSubscription');
    Route::get('subscription/renew', 'SubscriptionController@renew');
    Route::post('subscription/renew', 'SubscriptionController@submitRenew');
    Route::post('subscription/get_subscription_amount', 'SubscriptionController@get_subscription_amount');
    Route::get('subscription/complete_subscription_paypal', 'SubscriptionController@complete_subscription_paypal');

});