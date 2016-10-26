<?php
namespace App\Condat\Libraries;

use App;
use DB;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use App\Modules\Agency\Models\Agency as Agency;
use App\Models\Tenant\Setting as TenantSettings;
use App\Modules\Tenant\Models\User as User;
use Illuminate\Support\Facades\Auth;
use App\Models\Tenant\Profile;
use App\Modules\Tenant\Models\Person\Person;

/**
 * Class Tenant
 * @package App\Condat\Libraries
 */
class Tenant {

    // prefix for database
    /**
     *
     */
    /**
     * Database settings
     */
    protected $DB_username;
    protected $DB_password;
    protected $DB_prefix;

    /**
     * @var string
     */
    protected $connection = 'tenant';
    protected $tenant_db;
    protected $request;
    protected $tenantUser;
    protected $createTable;
    protected $auth;
    protected $domain;


    /**
     * @param Request $request
     * @param User $user
     * @param TenantTable $TenantTable
     * @param Guard $auth
     */
    function __construct(Request $request, User $user, TenantTable $TenantTable, TenantSettings $TenantSettings, Guard $auth)
    {
        $this->init();
        $this->tenatUser = $user;
        $this->tenantSettings = $TenantSettings;
        $this->createTable = $TenantTable;
        $this->auth = $auth;
        $this->request = $request;
        // remove this later $this->setDomain($this->getSubdomain());
        $this->setDomain($this->tenantDb());
        $this->tenant_db = $this->DB_prefix . $this->domain;

    }

    /**
     * initialized Tenant Database
     */
    function init()
    {
        $config = App::make('config');
        $setting = $config->get('constants.database');
        $this->DB_username = $setting['username'];
        $this->DB_password = $setting['password'];
        $this->DB_prefix = $setting['db_prefix'];

    }


    /**
     * Connect to Tenant database
     * @param string $username
     * @param string $password
     */
    function connectTenantDB($username = '', $password = '')
    {
        // Just get access to the config.
        $config = App::make('config');

        // Now we simply copy the Tenant connection information to our new connection.
        $newConnection = $config->get('database.connections.' . $this->connection);

        // Override the database name.
        $newConnection['database'] = $this->tenant_db;
        $newConnection['username'] = ($username == '') ? $this->DB_username : $username;
        $newConnection['password'] = ($password == '') ? $this->DB_password : $password;

        // This will add our new connection to the run-time configuration for the duration of the request.
        App::make('config')->set('database.connections.' . $this->connection, $newConnection);

        // make tenant as default connection
        App::make('config')->set('database.default', $this->connection);
        //  Config::set('session.domain', $this->domain.'.'.Config::get('session.domain'));

    }


    /**
     * Validate Subdomain and authenticate tenant if first time then auto login
     */
    function authenticateTenant()
    {
        $this->connectTenantDB();
        try {
            DB::getDatabaseName();
        } catch (Exception $e) {
            die('Could not connect to database');
        }
        /* remove these later if ($this->isValidSubDomain()):

            //remove this later if ($this->isFirstTime()) {
                // register tenant database
                //$this->setupTenantDatabase();

                //$this->doAutologin();

                //$this->resetSetup();

            /*} else {
                $this->connectTenantDB();
                try {
                    DB::getDatabaseName();
                } catch (Exception $e) {
                    die('Could not connect to database');
                }
            }
        endif; */
    }


    /**
     * Create new tenant database and  insert data
     * @param  Response
     * @return boolean
     */
    function newTenant(array $request)
    {
        //if ($this->isValidSubDomain()):
            // register tenant database
            $this->setupTenantDatabase($request);
        //endif;
    }

    /**
     * Create database and tables for a tenant when first time landed on APP
     */
    function setupTenantDatabase(array $request)
    {
        $this->setDomain($request['company_database_name']);
        $this->tenant_db = $this->DB_prefix . $request['company_database_name'];

        // create tenant DB
        // $this->createNewTenantDB();

        //Connect to Tenant DB
        $this->connectTenantDB();

        //create Tenant Tables
        $this->createTenantTables();

        //insert tenant admin data
        $this->dataInsert($request);

        //create folders
        $this->createFolders();

    }

    /**
     * Create Database for tenant
     */
    public function createNewTenantDB()
    {
        DB::statement('CREATE DATABASE IF NOT EXISTS ' . $this->tenant_db);
    }

    /**
     * Create tables for tenant
     */
    function createTenantTables()
    {
        $this->createTable->run($this->tenant_db);
    }


    /**
     * Add Data to tables
     */
    function dataInsert($request)
    {
        // add profile
        $profile = ['first_name' => 'Tenant'];
        $new_person = Person::create($profile);

        //add Admin user
        $tenantInfoInSystem = $this->getTenantinfo();
        $user = $this->tenatUser->findOrNew(1);
        $user->email = $tenantInfoInSystem->email_id;
        $user->role = 1; // Admin Role
        //$user->guid = $tenantInfoInSystem->guid;
        $user->status = 1; // Activated
        //$user->first_time = 1; // yes first time
        $user->auth_code = $request['unique_auth_code']; // yes first time
        $user->person_id = $new_person->person_id;
        $user->save();

        // update company name in setting table
        $setting = $this->tenantSettings->firstOrNew(['name' => 'company']);
        $setting->value = serialize(array(
            'company_name' => $tenantInfoInSystem->name,
            'phone_number' => $tenantInfoInSystem->phone_id,
            'abn' => $tenantInfoInSystem->abn,
            'email' => $tenantInfoInSystem->email_id,
            'website' => $tenantInfoInSystem->website,
            'invoice_to_name' => $tenantInfoInSystem->invoice_to_name,
            'street' => '',
            'suburb' => '',
            'state' => '',
            'postcode' => '',
            'country_id' => '',
            'description' => '',
        ));
        $setting->save();

        // update domain in setting table
        $setting = $this->tenantSettings->firstOrNew(array('name' => 'domain'));
        $setting->value = $tenantInfoInSystem->company_database_name;
        $setting->save();

        $setting = $this->tenantSettings->firstOrNew(array('name' => 'folder'));
        $setting->value = $tenantInfoInSystem->guid;
        $setting->save();

    }


    function createFolders()
    {
        $this->folder('customer', true);
        $this->folder('attachment', true);
        $this->folder('invoice', true);
        $this->folder('user', true);
        $this->folder('temp', true);
    }

    /**
     * Get name of a tenant
     * @return string
     */
    function getName()
    {
        return $this->domain;
    }


    function setDomain($domain = '')
    {
        $this->domain = $domain;
        session()->put('domain', $this->domain);
    }

    /**
     * check for valid subdomain
     * @return bool
     */
    function isValidSubDomain()
    {
        // check for register tenant
        $tenant = $this->getTenantinfo();
        if (empty($tenant)) {
            die('Not Valid');
            //show_404();
        }
        //check tenant is allow to access app
        //$tenant->actionWithStatus();

        return true;
    }

    /**
     * Get detail of admin of tenant app
     * @return mixed
     */
    function getTenantinfo()
    {
        // remove this later $user = Agency::where('domain', $this->domain)->first();
        $user = Agency::select('*')
            ->join('companies', 'companies.agencies_agent_id', '=', 'agencies.agency_id')
            ->where('company_database_name', $this->domain)
            ->first();
        //$user = Agency::where('company_database_name', $this->domain)->first();
        return $user;
    }

    /**
     * Extract sub-domain from site url
     * @return string
     */
    function getSubdomain()
    {

        if (env('APP_ENV') == 'local') {
            // It will work for local environment for live need to change code
            $path = explode('/', $this->request->path());
            $domain = trim($path[0]);

            if ($domain) {
                return $domain;
            }
            show_404();
        }

        $current_params = \Route::current()->parameters();
        if (isset($current_params['account']) AND $current_params['account'] != '') {
            return $current_params['account'];
        }

        return null;
    }

    function tenantDb()
    {
        return 'tenant';
        $query_string = $this->request->all();
        $database_name = 'tenant';
        if(isset($_COOKIE['database_name'])) {
            $database_name = $_COOKIE['database_name'];
            return $database_name;
        } elseif(isset($query_string['tenant'])) {
            $agency = new Agency();
            $database_name = $agency->where('agency_id', $query_string['tenant'])->first()->company_database_name;
            setcookie('database_name', $database_name, time() + 86400, '/');
            return $database_name;
        }
        header('location: ' . url('/'));die;
    }

    /**
     * Check for first time loginto tenant app
     * @return bool
     * @todo session is not working between subdomain and domain so we are not using this function
     */
    function _isFirstTime()
    {
        $data = session()->get('register_tenant');
        if (!is_null($data)) {
            return $data['first_time'];
        }

        return false;
    }


    /**
     * @return bool
     */
    function isFirstTime()
    {
        $setupKey = $this->request->input('setup');
        // verify key to setup an account
        if (strlen($setupKey) > 10) {
            $tenant = Agency::where('setup_key', $setupKey)->where('domain', $this->domain)->count();
            if ($tenant > 0) {
                return true;
            }
        }

        return false;
    }

    /**
     * Reset Setup
     */
    function resetSetup()
    {
        $tenantInfoInSystem = $this->getTenantinfo();
        $tenantInfoInSystem->setup_key = null;
        $tenantInfoInSystem->save();
        session()->forget('register_tenant');
    }

    /**
     * remember tenant app url
     */
    function rememberAppUrl()
    {
        // i an using php native cookie function to set cookie. i tried laravel functions but not working at this time
        setcookie("APPURL", $this->domain, time() + (86400 * 2.5), '');
    }

    /**
     * Get Remembered tenant app url
     * @return null
     */
    function getRememberedAppUrl()
    {
        return isset($_COOKIE['APPURL']) ? $_COOKIE['APPURL'] : null;
    }

    /**
     * return domain if tenant is loginto app
     * @return bool
     */
    function getCurrentTenantSession()
    {
        $tenantDomain = session('domain');
        if ($tenantDomain != '') {
            $tenant = Agency::where('domain', $tenantDomain)->first();
            if (isset($tenant->domain) AND $tenant->domain != '') {
                return $tenant->domain;
            }
        }

        return false;
    }

    /**
     * Redirect Tenant user to app if we remembered
     * @return bool|null|string
     */
    function redirectIfRemembered()
    {
        $domain = '';
        $tenantDomain = $this->getCurrentTenantSession();


        if ($tenantDomain) {
            $domain = $tenantDomain;
        } else {
            $tenantDomain = $this->getRememberedAppUrl();
            if ($tenantDomain) {
                $domain = $tenantDomain;
            }
        }

        return $domain;

    }

    /**
     * Auto login tenant admin if first time
     */
    function doAutologin()
    {
        $user = User::find(1);

        if (is_null($user))
            die('Admin user not found');
        else
            echo "fine";
            // Remove this later and make changes accordingly Auth::login($user);

        $this->rememberAppUrl();
    }


    /**
     * @param string $route
     * @param array $param
     * @param bool $url
     * @return \Illuminate\Http\RedirectResponse|string
     */
    function route($route = '', $param = array(), $url = false)
    {
        if (!is_array($param)) {
            die('Parameters should be in array');
        }

        $domain = $this->getActualDomain();

        if (env('APP_ENV') == 'local') {
            if ($url) {
                return route($route, $param);
            }

            return redirect()->route($route, $param);
        }

        if ($url) {
            if (!isset($param['account'])) {
                $param['account'] = $domain;
            }

            return route($route, $param);
        }

        return redirect()->route($route, $domain);

    }


    /**
     * @param string $url
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    function redirect($url = '')
    {
        return redirect($this->url($url));
    }


    /**
     * @param string $url
     * @return string
     */
    function url($url = '')
    {
        $subdomain = $this->getActualDomain();
        if (env('APP_ENV') == 'local') {
            return url($subdomain . '/' . trim($url, '/')) . '/';
        }

        $domain = env('APP_DOMAIN');
        $url = trim($url, '/');

        return sprintf('http://%s.%s/%s', $subdomain, $domain, $url);
    }

    /**
     * @return bool|null|string
     */
    function getActualDomain()
    {
        if ($this->domain == 'login')
            $domain = $this->redirectIfRemembered();
        else
            $domain = $this->domain;

        return $domain;
    }


    /**
     * @param null $folder
     * @param bool $create
     * @return App
     */
    function folder($folder = null, $create = false)
    {
        $tenantFile = app('App\Condat\Libraries\TenantFileSystem');

        if (!is_null($folder)) {
            $tenantFile->folder($folder, $create);
        }

        return $tenantFile;
    }

}