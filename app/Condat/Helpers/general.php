<?php

if (! function_exists('asset')) {
    /**
     * Generate an asset path for the application.
     *
     * @param  string  $path
     * @param  bool    $secure
     * @return string
     */
    function asset($path, $secure = null)
    {
        return app('url')->asset('local/resources/'.$path, $secure);
    }
}
/**
 * Show 404 page
 */
function show_404()
{
    App()->abort('404');
}

function tenant($domain = null)
{
    $tenant = app('App\Condat\Libraries\Tenant');

    if (!is_null($domain)) {
        $tenant->setDomain($domain);
    }

    return $tenant;
}

function tenant_route($route, $param = array())
{
    if (env('APP_ENV') == 'local') {
        return route($route, $param);
    }

    return tenant()->route($route, $param, true);
}

function current_user()
{
    $user = \Auth::user();
    $user->isSuperAdmin = ($user->role == 1);
    $user->isAdmin = ($user->role == 2);
    $user->isSales = ($user->role == 3);
    $user->isMarketer = ($user->role == 4);

    return $user;
}

function current_user_id()
{
    return \Auth::user()->id;
}

function current_tenant_id()
{
    return auth()->guard('tenants')->user()->user_id;
}

function get_user_role($role = 3)
{
    switch ($role) {
        case 1:
            $user_role = 'Super Admin';
            break;
        case 2:
            $user_role = 'Admin';
            break;
        case 3:
            $user_role = 'Normal User';
            break;
        default:
            $user_role = 'Unknown';
    }
    return $user_role;

}

function page_title()
{
    $path = Request::path();
    $title = explode('/', $path);
    $title = array_reverse($title);
    $title = array_filter($title);
    if (count($title) > 0)
        return ucwords(join(' / ', $title)) . ' - ' . env('APP_TITLE');
    else
        return env('APP_TITLE');

}

function site_url()
{
    return 'http://' . env('APP_DOMAIN');
}

/*
 * Get total records saved in database
 * */
function get_total_count($entity = 'U')
{
    switch ($entity) {
        case 'U':
            $total = \App\Modules\User\Models\User::count();
            break;
        case 'TU':
            $total = \App\Modules\Tenant\Models\User::count();
            break;
        case 'A':
            $total = \App\Modules\Agency\Models\Agency::count();
            break;
        case 'C':
            $total = \App\Modules\Tenant\Models\Client\Client::count();
            break;
        case 'I':
            $total = \App\Modules\Tenant\Models\Institute\Institute::count();
            break;
        case 'Ag':
            $total = \App\Modules\Tenant\Models\Agent::count();
            break;
        default:
            return 0;
    }
    return $total;
}

function email_date($dateTime)
{
    $date = \Carbon\Carbon::createFromTimeStamp(strtotime($dateTime));

    if ($date->isToday()) {
        return $date->format('h:i a');
    } elseif ($date->year == date('Y')) {
        return $date->format('M d');
    } else {
        return $date->format('M d, Y');
    }
}

function format_telephone($phone_number = null)
{
    if ($phone_number == null || strlen($phone_number))
        return $phone_number;
    $cleaned = preg_replace('/[^[:digit:]]/', '', $phone_number);
    preg_match('/(\d{3})(\d{3})(\d{4})/', $cleaned, $matches);

    return "({$matches[1]}) {$matches[2]}-{$matches[3]}";
}

/*function format_date($date)
{
    $formatted_date = date('d-m-y', strtotime($date));
    return $formatted_date;
}*/

function shorten_date($date)
{
    $formatted_date = date('M. Y', strtotime($date));
    return $formatted_date;
}

function validateDate($date)
{
    $d = DateTime::createFromFormat('d/m/Y', $date);
    return $d && $d->format('d/m/Y') == $date;
}

function insert_dateformat($date)
{
    if($date == '' || $date == null)
        return null;
    $olddate = \Carbon\Carbon::createFromFormat('d/m/Y', $date)->toDateTimeString();
    $formatted_date = date('Y-m-d', strtotime($olddate));
    return $formatted_date;
}

function insert_datetimeformat($date)
{

    if($date == '' || $date == null)
        return null;
    $olddate = \Carbon\Carbon::createFromFormat('d/m/Y H:i:s', $date)->toDateTimeString();
    $formatted_date = date('Y-m-d H:i:s', strtotime($olddate));
    return $formatted_date;

}

function format_date($date)
{
    if($date == '' || $date == null)
        return '';
    $formatted_date = date('d/m/Y', strtotime($date));
    return $formatted_date;
}

function readable_date($date)
{
    $formatted_date = date('M d, Y', strtotime($date));
    return ($formatted_date == 'Jan 01, 1970')? '' : $formatted_date;
}

function format_datetime($date)
{
    //$formatted_date = date('M d, Y h:i a', strtotime($date));
    $formatted_date = date('d/m/Y h:i a', strtotime($date));
    return $formatted_date;
}

function format_phone($phone)
{
    return substr($phone, 0, 4)." ".substr($phone, 3, 3)." ".substr($phone,6);
}

function format_only_date($date)
{
    //$formatted_date = date('M d, Y', strtotime($date));
    $formatted_date = date('d/m/Y', strtotime($date));
    return $formatted_date;
}

function short_date($date)
{
    $formatted_date = date('jS M', strtotime($date));
    return $formatted_date;
}

function format_id($id = 0, $text = 'A', $zeros = 5)
{
    $id = sprintf("%0" . $zeros . "d", $id);
    return $text.$id;
}

function data_decode($data)
{
    return @unserialize($data);
}

function data_encode($data)
{
    return @serialize($data);
}

function get_today_date()
{
    $today = Carbon\Carbon::today();
    return $today->format('Y-m-d');
}

function get_expiry_date($date = null, $years = null)
{
    if($date == null)
        $date = Carbon\Carbon::today();
    if($years == null)
        $expiry_date = $date->addDays(30);
    else
        $expiry_date = $date->addYear($years);
    return $expiry_date;
}

function get_today_datetime()
{
    $today = Carbon\Carbon::now();
    return $today;
}

function get_datetime_diff($datetime)
{
    $difference = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $datetime)->diffForHumans();
    return $difference;
}

function float_format($number = 0, $digits = 2)
{
    return number_format($number, $digits);
}

function format_price($number = 0, $digits = 2)
{
    return '$'.number_format($number, $digits);
}

/*
 * For tenant database
 */
function get_tenant_name($user_id = null)
{
    if($user_id == null)
        $user_id = current_tenant_id();
    $user = \App\Modules\Tenant\Models\User::find($user_id)->profile;
        if (!empty($user))
            return $user->first_name . ' ' . $user->last_name;
        else
            return 'Undefined';
}

function get_agent_name($agent_id = null)
{
    if($agent_id != null) {
        $agent = new \App\Modules\Tenant\Models\Agent;
        $name = $agent->getName($agent_id);
            return $name;
    } else {
        return '';
    }
}

function get_country($country_id)
{
    $applicant = \App\Modules\Tenant\Models\Country::find($country_id);
    $name = (!empty($applicant)) ? $applicant->name : 'Undefined';
    return $name;
}

function get_user_name($user_id)
{
    $user = \App\Modules\Tenant\Models\User::select('given_name', 'surname')->find($user_id);
    $name = (!empty($user)) ? $user->given_name.' '.$user->surname : 'Undefined';
    return $name;
}

function get_applicant_name($applicant_id)
{
    if(is_array($applicant_id)) {
        $names = '';
        foreach($applicant_id as $key => $app_id) {
            $names = $names. '<li>'.get_single_applicant_name($app_id).'</li>';
        }
        $name = '<ul class="list-unstyled">'.$names.'</ul>';
    } else {
        $name = get_single_applicant_name($applicant_id);
    }
    return $name;
}

function get_phone_icon($type)
{
    switch ($type) {
        case 'home':
            return 'fa-home';
            break;
        case 'work':
            return 'fa-suitcase';
            break;
        case 'mobile':
            return 'fa-mobile';
            break;
        default:
            return 'fa-phone';
    }
}

function limit_char($x, $length = 200)
{
    if(strlen($x)<=$length)
    {
        return $x;
    }
    else
    {
        $y=substr($x,0,$length) . '...';
        return $y;
    }
}
