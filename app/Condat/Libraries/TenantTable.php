<?php

namespace App\Condat\Libraries;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use DB;


class TenantTable {

    /**
     * Constant for table prefix
     */
    protected $tbl_profix = '';

    function __construct()
    {
        $this->tbl_profix = env('ROOT_TABLE_PREFIX', '');
    }

    /**
     * Run all table SQL
     */
    public function run()
    {
        $create_database = file_get_contents(base_path('resources\assets\condat_fresh.sql'));
        DB::unprepared($create_database);
        /*$this->users();
        $this->settings();
        $this->passwordReset();
        $this->profile();
        $this->customers();*/
    }

    /**
     * Users Tables [used for Tenant admin and sub-user ]
     */
    private function users()
    {
        if (!Schema::hasTable($this->tbl_profix . 'users')) {
            Schema::create($this->tbl_profix . 'users', function ($table) {
                $table->increments('user_id'); // autoincrement value of a tenant admin
                $table->string('guid', 45)->unique(); // unique random ID for a user
                $table->string('fullname', 45); // fullname of a user
                $table->string('email', 100)->unique(); // email ID of a user
                $table->string('password', 70); // password of a user
                $table->string('auth_code', 255); // auth code
                $table->tinyInteger('role')->unsigned()->default(0); // role of a user by default invalid
                $table->tinyInteger('status')->unsigned()->default(0); // status of a user by default pending activation
                $table->string('activation_key', 50); //activation key for confirmation
                $table->text('permissions')->nullable(); // serialized data of permissions
                $table->datetime('last_login')->nullable(); // last login Date time
                $table->datetime('last_login_ip', 20)->nullable(); // last login IP
                $table->string('suspended_reason')->nullable(); // suspended reason set by admin
                $table->boolean('first_time')->default(1); // 1 for first time login

                // remembers token column
                $table->rememberToken();

                // created_at, updated_at DATETIME
                $table->timestamps();
            });
        }
    }

    /**
     * Tenant admin settings table
     */
    private function settings()
    {
        if (!Schema::hasTable($this->tbl_profix . 'settings')) {
            Schema::create($this->tbl_profix . 'settings', function ($table) {
                $table->increments('id'); // autoincrement value of a setting
                $table->string('name', 30)->unique(); // unique key for setting
                $table->text('value')->nullable(); // value of a setting

                // created_at, updated_at DATETIME
                $table->timestamps();
            });
        }
    }

    /**
     * Password Reset Table
     */
    private function passwordReset()
    {
        if (!Schema::hasTable($this->tbl_profix . 'password_resets')) {
            Schema::create($this->tbl_profix . 'password_resets', function (Blueprint $table) {
                $table->string('email')->index();  // user's email ID
                $table->string('token')->index(); // token for verification
                // created_at DATETIME
                $table->timestamp('created_at');
            });
        }
    }

    /**
     * User profile table [one to one relation with users table]
     */
    private function profile()
    {
        if (!Schema::hasTable($this->tbl_profix . 'profile')) {
            Schema::create($this->tbl_profix . 'profile', function (Blueprint $table) {
                $table->increments('id'); // autoincrement value of a profile
                $table->integer('user_id')->unsign()->unique(); // user id from user table
                $table->text('smtp')->nullable(); // serialized value of personal email setting
                $table->integer('social_security_number')->nullable(); // social security number of a user
                $table->bigInteger('phone')->nullable(); // phone number of a user
                $table->string('address', 100)->nullable(); // address of a user
                $table->string('photo', 50)->nullable(); // profile image of a user
                $table->string('postcode', 10)->nullable(); // postcode of a user
                $table->string('town', 45)->nullable(); // town of a user
                $table->string('tax_card', 15)->nullable(); // tax card of a user
                $table->float('vacation_fund_percentage')->nullable(); // vacation fund percentage of a user
                $table->text('comment')->nullable(); // comment by admin

                // updated_at DATETIME
                $table->timestamps('updated_at');

            });
        }
    }

    /**
     * Customers tables [Many to one relation with users]
     */
    private function customers()
    {
        if (!Schema::hasTable($this->tbl_profix . 'customers')) {
            Schema::create($this->tbl_profix . 'customers', function ($table) {
                $table->increments('id'); // autoincrement value of a customer
                $table->string('guid', 32); // unique auto generated ID of a customer
                $table->integer('user_id')->unsign()->index(); //user id, who created the customer
                $table->string('email', 100)->unique(); // email ID of a user
                $table->integer('type')->unsign()->index(); //'1 - human - company' ,
                $table->string('name', 45); //'name of a customer (human or company)'
                $table->string('company_number', 30)->nullable(); //'company registration no of a company'
                $table->date('dob')->nullable(); //'dob of human'
                $table->string('street_name', 70); //'street address of a customer'
                $table->string('street_number', 200); //'street number of a customer'
                $table->string('postcode', 10); //'postcode of a customer'
                $table->string('town', 55); //'town of a customer'
                $table->bigInteger('telephone')->nullable();//'telephone number of a customer'
                $table->bigInteger('mobile')->nullable();//'mobile number of a customer'
                $table->string('image', 50)->nullable(); //'image or logo of a customer'
                $table->string('file', 50)->nullable(); //'file of a customer'
                $table->tinyInteger('status'); //'1 - active\n0 - inactive'

                // created_at, updated_at DATETIME
                $table->timestamps();
            });
        }
    }
}