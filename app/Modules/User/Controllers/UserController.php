<?php namespace App\Modules\User\Controllers;

use App\Http\Requests;
use App\Http\Controllers\BaseController;
use App\Modules\User\Models\User;
use DB;
use Illuminate\Http\Request;
use Flash;

class UserController extends BaseController
{

    protected $user;
    /* Validation rules for user create and edit */
    protected $rules = [
        'given_name' => 'required|min:2|max:55',
        'surname' => 'required|alpha|min:2|max:55',
    ];

    function __construct(User $user)
    {
        $this->user = $user;
        parent::__construct();
    }

    /**
     * Display a listing of the users.
     *
     * @return Response
     */
    public function index()
    {
        return view("User::index");
    }

    /**
     * Get all the users through ajax request.
     *
     * @return JSON response
     */
    function getData(Request $request)
    {
        $users = User::select(['id', 'given_name', 'surname', 'username', 'email', 'status', 'is_active', 'role', 'title', 'created_at', DB::raw('CONCAT(given_name, " ", surname) AS fullname')]);

        $datatable = \Datatables::of($users)
            ->addColumn('action', function ($data) {
                $icon = $data->is_active == 1 ? 'fa-minus-circle' : 'fa-check-circle';
                $change_status_btn = "";
                if ($data->role != 1 && $data->id != $this->current_user()->id) { //not for super admin and current user
                    $change_status_btn = ' <a data-toggle="tooltip" title="Change Status" class="btn btn-action-box" href="' . route('user.changeStatus', $data->id) . '" onclick="return confirm(\'Are you sure?\')"><i class="fa ' . $icon . '"></i></a>';
                }

                $delete = '<form action="{{ route( \'user.destroy\', $data->id) }}" method="POST">
    {{ method_field(\'DELETE\') }}
    {{ csrf_field() }}
    <button data-toggle="tooltip" title="Delete User" type="submit" class="delete-user btn btn-action-box"><i class="fa fa-trash"></i></button>
</form>';

                return '<a data-toggle="tooltip" title="Edit User" class="btn btn-action-box" href ="' . route('user.edit', $data->id) . '"><i class="fa fa-edit"></i></a>' . $change_status_btn;
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
            ->editColumn('role', '@if($role == 1)
                                <span class="label label-info">Super Admin</span>
                            @elseif($role == 2)
                                <span class="label label-info">Admin</span>
                            @elseif($role == 3)
                                <span class="label label-info">Normal User</span>
                            @endif');
        // Global search function
        if ($keyword = $request->get('search')['value']) {
            // override users.id global search - demo for concat
            $datatable->filterColumn('fullname', 'whereRaw', "CONCAT(given_name,' ',surname) like ?", ["%$keyword%"]);
        }
        return $datatable->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('User::add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        /* Additional validations for creating user */
        $this->rules['email'] = 'required|email|min:5|max:55|unique:users';
        $this->rules['username'] = 'required|min:4|max:55|unique:users|alpha_dash';

        $this->validate($request, $this->rules);
        // if validates
        $created = $this->user->add($request->all());
        if ($created)
            Flash::success('User has been created successfully.');
        return redirect()->route('user.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
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
    public function edit($user_id = null)
    {
        // View Own Profile
        if ($user_id == null)
            $user_id = current_user_id();

        /* Getting the user details*/
        $data['user'] = User::where('id', $user_id)->first();

        if ($data['user'] != null)
            return view('User::edit', $data);
        else
            return show_404();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($user_id = null, Request $request)
    {
        // Update Own Profile
        if ($user_id == null)
            $user_id = current_user_id();

        /* Additional validation rules checking for uniqueness */
        $this->rules['username'] = 'required|min:4|max:55|unique:users,username,' . $user_id . '|alpha_dash';
        $this->rules['email'] = 'required|email|min:5|max:55|unique:users,email,' . $user_id;

        $this->validate($request, $this->rules);
        // if validates
        $updated = $this->user->edit($request->all(), $user_id);
        if ($updated)
            Flash::success('User has been updated successfully.');
        return redirect()->route('user.index');
    }

    public function changeStatus($user_id)
    {
        $user = User::find($user_id);
        if ($user->is_active == 1)
            $user->is_active = 0;
        else
            $user->is_active = 1;
        $user->save();
        Flash::success('User status has been updated successfully.');

        return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect('user')->with('message', 'User has been removed.');
    }

    public function profile()
    {

    }

}
