<?php namespace App\Modules\Tenant\Controllers;

use App\Modules\Tenant\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Condat;
use Hash;
use Mail;
use Illuminate\Support\Facades\Redirect;


//use Illuminate\Foundation\Auth\ResetsPasswords;

class PasswordController extends BaseController {

    /*
   |--------------------------------------------------------------------------
   | Password Reset Controller
   |--------------------------------------------------------------------------
   |
   | This controller is responsible for handling password reset requests
   | and uses a simple trait to include this behavior.
   |
   */

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        //$this->middleware('guest');
    }

    /**
     * Display the password reminder view.
     *
     * @return Response
     */
    public function getForgotPassword()
    {
        return view('Auth::password');
    }

    /**
     * Handle a POST request to remind a user of their password.
     *
     * @return Response
     */
    public function postForgotPassword($tenant_id)
    {
        $user = User::where('email', '=', Input::only('email'))->first();
        if (!empty($user)) {
            $this->sendResetEmail($user, $tenant_id);
            return redirect($tenant_id . '/login')->with('message_success', 'Reset Email sent to your email successfully.');
        } else
            return redirect($tenant_id . '/forgot-password')->with('message', 'These credentials do not match our records.');

    }

    function sendResetEmail($user, $tenant_id)
    {
        $confirmation_code = str_random(30);
        DB::table('password_resets')->insert(array('email' => $user->email, 'token' => $confirmation_code, 'created_at' => date('Y-m-d h:i:s')));
        $link = url($tenant_id . '/reset-password/'.$confirmation_code)."  ";

        $message = <<<EOD
<p>You recently requested to reset your account password. Please <a href="{$link}">click here</a> to change your password or follow the link below.</p>
<a href="{$link}">$link</a>
EOD;


        $param = [
            'content'    => $message,
            'subject'    => 'Password Reset',
            'heading'    => 'Condat Solutions',
            'subheading' => 'All your business in one space',
        ];
        $data = [
            // 'to_email'   => 'satshanker.01@gmail.com',
            'to_email'   => $user->email,
            'to_name'    => $user->fullname,
            'subject'    => 'Password Reset',
            'from_email' => env('FROM_EMAIL', 'info@condat.com.au'), //change this later
            'from_name'  => 'Condat Solutions', //change this later
        ];
        Mail::send('template.master', $param, function ($message) use ($data) {
            $message->to($data['to_email'], $data['to_name'])
                ->subject($data['subject'])
                ->from($data['from_email'], $data['from_name']);
        });
        /*$confirmation_code = str_random(30);
        DB::table('password_resets')->insert(array('email' => $user->email, 'token' => $confirmation_code, 'created_at' => date('Y-m-d h:i:s')));

        $link = url('reset-password/'.$confirmation_code)."  ";
        Condat::sendEmail($user->email, $user->fullname, 'forgot_password', ['{{RESET_URL}}' => $link, '{{ USERNAME }}' => $user->fullname, '{{ NAME }}' => $user->fullname]);*/
    }


    /**
     * Display the password reset view for the given token.
     *
     * @param  string $token
     * @return Response
     */
    public function getReset($token = null)
    {
        if (is_null($token)) App::abort(404);
        return view('Auth::passwordReset')->with('token', $token);
    }

    /**
     * Handle a POST request to reset a user's password.
     *
     * @return Response
     */
    public function postReset($tenant_id, $token)
    {
        $rules = array('email' => 'required', 'new_password' => 'required|min:6', 'new_password_confirmation' => 'required|same:new_password|min:6');
        $user_reset = DB::table('password_resets')->where('token', $token)->first();

        if (!empty($user_reset)) {
            $user = DB::table('password_resets')->where('email', Input::only('email'))->first();
            $validator = Validator::make(Input::all(), $rules);

            //Is the input valid? new_password confirmed and meets requirements
            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator);
            } else {
                $newpassword = Hash::make(Input::get('new_password'));
                DB::table('users')->where('email', Input::only('email'))->update(['password' => $newpassword]);
                DB::table('password_resets')->where('email', '=', Input::only('email'))->delete();

                return redirect($tenant_id . '/login')->with('message_success', 'Password Reset successfully.');
            }
        } else
            return redirect($tenant_id . '/login')->with('message', 'Invalid link.');
    }
}
