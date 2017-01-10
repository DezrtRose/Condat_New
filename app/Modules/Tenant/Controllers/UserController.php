<?php namespace App\Modules\Tenant\Controllers;

use App\Http\Requests;
use App\Modules\Agency\Models\Agency;
use App\Modules\Agency\Models\AgencySubscription;
use App\Modules\Tenant\Models\Company\Company;
use App\Modules\Agency\Models\Company as MasterCompany;
use App\Modules\Tenant\Models\Invoice\StudentInvoice;
use App\Modules\Tenant\Models\Notes;
use App\Modules\Tenant\Models\Timeline\Timeline;
use App\Modules\Tenant\Models\User;
use App\Modules\Tenant\Models\UserLevel;
use DB;
use Illuminate\Http\Request;
use Flash;
use App\Modules\Tenant\Models\Application\ApplicationStatus;
use Mail;
use Carbon\Carbon;

class UserController extends BaseController
{

    protected $user;
    /* Validation rules for user create and edit */
    protected $rules = [
        'first_name' => 'required|min:2|max:55',
        'last_name' => 'required|min:2|max:55',
        'middle_name' => 'min:2|max:55',
        'dob' => 'required',
        'number' => 'required'
    ];

    function __construct(User $user, ApplicationStatus $applicationStatus, Timeline $timeline, StudentInvoice $invoice, Notes $note, Request $request)
    {
        $this->user = $user;
        $this->applicationStatus = $applicationStatus;
        $this->timeline = $timeline;
        $this->invoice = $invoice;
        $this->note = $note;
        $this->request = $request;
        parent::__construct();
    }

    // user dashboard
    public function dashboard($tenant_id)
    {
        $data['active_clients'] = $this->user->activeClient();
        $data['timelines'] = $this->timeline->getTimeline();
        $data['outstanding_payments'] = $this->invoice->getOutstandingPayments();

        $agency_subscription = AgencySubscription::where('agency_id', '=', $tenant_id)->where('is_current', '=', 1)->first();
        $data['sub_stat'] = $agency_subscription->subscription_status_id;
        $sub_date = Carbon::createFromFormat('Y-m-d', $agency_subscription->end_date);
        $today = Carbon::today();
        $data['sub_diff'] = $today->diffInDays($sub_date, false); //dd($data['sub_diff']);
        //$data['sub_diff'] = Carbon::createFromFormat('Y-m-d', $agency_subscription->end_date)->diffInDays();

        $data['app_stat'] = $this->applicationStatus->getStats();
        for ($record = 1; $record <= 7; $record++) {
            $data['status'][$record] = $this->applicationStatus->statusRecord($record);
        }

        return view("Tenant::User/dashboard", $data);
    }

    public function getMoreTimeline()
    {
        $data = '';
        $page = $this->request['page'];
        $timelines = $this->timeline->getTimelineWithPage($page);
        foreach($timelines as $key => $grouped_timeline) {
            $data .= '<li class="time-label">
            <span class="bg-red">
              '.readable_date($key).'
            </span>
            </li>';
            foreach($grouped_timeline as $timeline) {
                $data .= '<li>
                    <i class="fa '.$timeline->image .'"></i>

                    <div class="timeline-item">
                        <span class="time"><i class="fa fa-clock-o"></i> '.get_datetime_diff($timeline->created_at);
                if(!isset($client)) {
                    $data .= ' | <i class="fa fa-user"></i> '.get_client_name($timeline->client_id);
                }
                $data .= '</span>'.$timeline->message.'</div>
                </li>';
            }
        }
        echo $data;
    }

    /**
     * Display a listing of the users.
     *
     * @return Response
     */
    public function index($tenant_id)
    {
        $data['agency_subscription'] = AgencySubscription::where('agency_id', '=', $tenant_id)->where('is_current', '=', 1)->first()->subscription_id;
        return view("Tenant::User/index", $data);
    }

    /**
     * Get all the users through ajax request.
     *
     * @return JSON response
     */
    function getData($tenant_id, Request $request)
    {
        $users = User::join('persons', 'persons.person_id', '=', 'users.person_id')
            ->leftJoin('person_phones', 'person_phones.person_id', '=', 'persons.person_id')
            ->leftJoin('phones', 'phones.phone_id', '=', 'person_phones.phone_id')
            ->select(['users.user_id', 'persons.first_name', 'persons.last_name', 'users.email', 'phones.number', 'users.role', 'users.status', 'users.created_at', DB::raw('CONCAT(persons.first_name, " ", persons.last_name) AS fullname')]);

        $datatable = \Datatables::of($users)
            ->addColumn('action', function ($data) use ($tenant_id) {
                $icon = $data->status == 1 ? 'fa-minus-circle' : 'fa-check-circle';
                $change_status_btn = "";
                if ($data->role != 3) {
                    $change_status_btn = ' <a data-toggle="tooltip" title="Change Status" class="btn btn-action-box" href="' . route('tenant.user.changeStatus', [$tenant_id, $data->user_id]) . '"><i class="fa ' . $icon . '"></i></a>';
                }
                return '<a data-toggle="tooltip" title="Edit User" class="btn btn-action-box" href ="' . route('tenant.user.edit', [$tenant_id, $data->user_id]) . '"><i class="fa fa-edit"></i></a>' . $change_status_btn;
            })
            ->editColumn('status', '@if($status == 0)
                                <span class="label label-warning">Pending</span>
                            @elseif($status == 1)
                                <span class="label label-success">Activated</span>
                            @elseif($status == 2)
                                <span class="label label-info">Suspended</span>
                            @else
                                <span class="label label-danger">Trashed</span>
                            @endif')
            ->editColumn('user_id', function ($data) {
                return format_id($data->user_id, 'U');
            })
            ->editColumn('created_at', function ($data) {
                return format_datetime($data->created_at);
            })
            ->editColumn('role', function ($data) {
                return ucwords(UserLevel::find($data->role)->name);
            });
        // Global search function
        if ($keyword = $request->get('search')['value']) {
            // override users.id global search - demo for concat
            $datatable->filterColumn('fullname', 'whereRaw', "CONCAT(first_name,' ',last_name) like ?", ["%$keyword%"]);
        }
        return $datatable->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($tenant_id)
    {
        if(!$this->checkAuthority()) {
            abort(403, 'Unauthorized action.');
        }
        $agency_subscription = AgencySubscription::where('agency_id', '=', $tenant_id)->where('is_current', '=', 1)->first()->subscription_id;
        if($agency_subscription == 1 && get_total_count('TU') >= 10) {
            Flash::success('Maximum number of users (10) has been reached. Please upgrade the subscription plan to access unlimited number of users for the system.');
            return redirect()->route('tenant.user.index', $tenant_id);
        }
        $data['user_levels'] = UserLevel::where('name', '!=', 'Admin')->lists('name', 'user_level_id');
        return view('Tenant::User/add', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store($tenant_id, Request $request)
    {
        /* Additional validations for creating user */
        $this->rules['email'] = 'required|email|min:5|max:55|unique:users';

        $this->validate($request, $this->rules);
        // if validates
        $created = $this->user->add($request->all());
        if ($created) {
            Flash::success('User has been created successfully.');
            $company = $this->getCompanyDetails();
            // sending mail to user
            $agency = MasterCompany::where(['agencies_agent_id' => $tenant_id])->first();
            $complete_profile_url = url($tenant_id . '/login?&auth_code=' . md5($created));
            $client_message = <<<EOD
<strong>Dear {$request['first_name']}, </srtong>
<p>Your account has been created for {$company['company_name']} Condat Solutions. Please <a href="$complete_profile_url">click here</a> or follow the link below to complete your account.</p>
<a href="$complete_profile_url">$complete_profile_url</a>
<p>
Regards,<br>
{$company['company_name']}<br>
Condat Solutions
</p>
EOD;

            $param = ['content' => $client_message,
                'subject' => 'Activate Your Account',
                'heading' => $company['company_name'],
                'subheading' => 'All your business in one space',
            ];
            $data = ['to_email' => $request['email'],
                'to_name' => $request['first_name'],
                'subject' => 'Activate Your Account',
                'from_email' => 'noreply@condat.com.au', //change this later
                'from_name' => $company['company_name'], //change this later
            ];

            Mail::send('template.master', $param, function ($message) use ($data) {
                $message->to($data['to_email'], $data['to_name'])
                    ->subject($data['subject'])
                    ->from($data['from_email'], $data['from_name']);
            });
        }
        return redirect()->route('tenant.user.index', $tenant_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $user_id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($tenant_id, $user_id = null)
    {
        // View Own Profile
        if ($user_id == null)
            $user_id = current_user_id();

        if(!$this->checkAuthority() && $user_id != $this->request->segment(3)) {
            abort(403, 'Unauthorized action.');
        }

        /* Getting the user details*/
        //$data['user'] = User::join('persons', 'persons.person_id', '=', 'users.person_id')->where('users.user_id', $user_id)->first();
        $data['user'] = $this->user->getDetails($user_id);
        $data['user_levels'] = UserLevel::where('name', '!=', 'Admin')->lists('name', 'user_level_id');

        if ($data['user'] != null)
            return view('Tenant::User/edit', $data);
        else
            return show_404();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($tenant_id, $user_id = null)
    {
        // Update Own Profile
        if ($user_id == null)
            $user_id = current_tenant_id();

        /* Additional validation rules checking for uniqueness */
        $this->rules['email'] = 'required|email|min:5|max:55|unique:users,email,' . $user_id . ',user_id';

        $this->validate($this->request, $this->rules);
        // if validates
        $updated = $this->user->edit($this->request->all(), $user_id);
        if ($updated)
            Flash::success('User has been updated successfully.');
        return redirect()->route('tenant.user.index', $tenant_id);
    }

    public function resetPassword()
    {
        return view('Tenant::User/password');
    }

    public function postResetPassword($tenant_id, $user_id)
    {
        $rules = array('password' => 'required|min:6', 'password_confirmation' => 'required|same:password|min:6');

        $this->validate($this->request, $rules);
        $newpassword = \Hash::make(\Input::get('password'));
        User::find($user_id)->update(['password' => $newpassword]);
        Flash::success('Password has been updated successfully.');
        return redirect()->route('tenant.user.index', $tenant_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function profile()
    {
        $user_id = current_user_id();
        $data['user'] = $this->user->getDetails($user_id);
        $data['user_levels'] = UserLevel::where('name', '!=', 'Admin')->lists('name', 'user_level_id');

        if ($data['user'] != null)
            return view('Tenant::User/edit', $data);
        else
            return show_404();
    }

    public function completeReminder($tenant_id, $note_id)
    {
        $this->note->markComplete($note_id);
        return $this->success();
    }

    public function change_status($tenant_id, $user_id)
    {
        $user = new User();
        $data = $user->find($user_id);
        if ($data->status == 1)
            $data->status = 2;
        else
            $data->status = 1;
        $data->save();
        Flash::success('User status has been updated successfully.');

        return redirect()->route('tenant.user.index', $tenant_id);
    }

}
