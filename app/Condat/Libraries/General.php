<?php
namespace App\Condat\Libraries;

use Illuminate\Support\Facades\DB;
use Mail;
use App\Modules\System\Models\Setting as SystemSetting;
use Auth;

/**
 * Class General
 * @package App\Condat\Libraries
 */
class General {


    /**
     * @var array
     */
    protected $js = [];


    /**
     * @var string
     */
    private $templatURl = 'template.master';


    private $modals =[];

    /**
     * Get Template setting from database
     * @param $templateKey
     * @param $param
     * @return \stdClass
     */
    function getEmailTemplate($templateKey, $param)
    {
        $data = new \stdClass();
        $email = SystemSetting::email()->first();
        $emailSet = $email->value;
        $data->from_name = $emailSet['name'];
        $data->from_email = $emailSet['email'];

        $subjectKey = $templateKey . '_subject';

        $templateSet = SystemSetting::template()->first();
        $emailTemplate = $templateSet->value;

        if (isset($emailTemplate[$subjectKey]) AND isset($emailTemplate[$templateKey])) {
            $data->subject = $emailTemplate[$subjectKey];
            $data->body = str_replace(array_keys($param), array_values($param), $emailTemplate[$templateKey]);
        }

        return $data;
    }


    /**
     * Send an email
     * @param $to
     * @param string $to_name
     * @param string $template
     * @param array $attachment
     * @param array $param
     * @return mixed
     */
    public function sendEmail($to, $to_name = '', $template = '', $param = array(),$attachment = array())
    { 
        $template = $this->getEmailTemplate($template, $param);

        if(isset($attachment) && !is_null($attachment) && !empty($attachment)){ 
                $data = ['to_email'   => $to,
                         'to_name'    => ($to_name == '') ? $to : $to_name,
                         'subject'    => (isset($template->subject))?$template->subject:'Condat Solutions Email',
                         'from_email' => $template->from_email,
                         'from_name'  => $template->from_name,
                         'attachment' => $attachment];

                $param = ['content'    => (isset($template->body))?$template->body:'Condat Solutions Body',
                          'subject'    => (isset($template->subject))?$template->subject:'Condat Solutions Email',
                          'heading'    => 'Condat Solutions',
                          'subheading' => 'All your business in one space',
                ];

                $mail_result = Mail::send($this->templatURl, $param, function ($message) use ($data) {
                    $message->to($data['to_email'], $data['to_name'])
                        ->subject($data['subject'])
                        ->from($data['from_email'], $data['from_name']);
                         $size = sizeOf($data['attachment']);
                        for($i=0; $i<$size; $i++)
                        {
                            $message->attach($data['attachment'][$i]);
                        }

                } , true);
        } else {
            $data = ['to_email'   => $to,
                         'to_name'    => ($to_name == '') ? $to : $to_name,
                         'subject'    => (isset($template->subject))?$template->subject:'Condat Email',
                         'from_email' => $template->from_email,
                         'from_name'  => $template->from_name
                    ];

                $param = ['content'    => (isset($template->body))?$template->body:'Condat Body',
                          'subject'    => (isset($template->subject))?$template->subject:'Condat Email',
                          'heading'    => 'Condat Solutions',
                          'subheading' => 'All your business in one space',
                         ];

                $mail_result = Mail::send($this->templatURl, $param, function ($message) use ($data) {
                    $message->to($data['to_email'], $data['to_name'])
                        ->subject($data['subject'])
                        ->from($data['from_email'], $data['from_name']);
                } , true);
        }

        return $mail_result;
    }


    /**
     * Create a randomly generated activation key.
     * @return String
     */
    function uniqueKey($len = 10, $table = '', $column = '')
    {
        $key = str_random($len);
        if ($table != '' AND $column != ''):
            $count = DB::table($table)->where($column, $key)->count();
            if ($count > 0) {
                $this->uniqueKey($len, $table, $column);
            }
        endif;

        return $key;
    }


    /**
     * Append js file or script
     * @param string $htmlorJs
     */
    function js($htmlorJs = '')
    {
        $arr = explode('.', $htmlorJs);
        $isJS = null;
        if (count($arr) > 0) {
            $isJS = strtolower(end($arr));
        }
        if ($isJS == 'js') {
            if (strpos($htmlorJs, '/') === false)
                $path = asset('assets/js/' . $htmlorJs);
            else
                $path = asset($htmlorJs);

            $this->js['file'][] = $path;
            if (\Request::ajax()) {
                echo sprintf('<script src="%s"></script>', $path);
            }
        } else {
            $this->js['script'][] = $htmlorJs;
            if (\Request::ajax()) {
                echo ($htmlorJs != '') ? '<script>' . $htmlorJs . '</script>' : '';
            }
        }
    }


    /**
     * Load all scripts
     * This is function at the footer of the page
     */
    function loadJS()
    {
        $file = "";
        $script = "";
        $jsFiles = isset($this->js['file']) ? $this->js['file'] : array();
        if (!empty($jsFiles)) {
            foreach ($jsFiles as $key => $js) {
                $file .= sprintf('<script src="%s"></script>', $js);
            }
        }

        $jsScripts = isset($this->js['script']) ? $this->js['script'] : array();
        if (!empty($jsScripts)) {
            foreach ($jsScripts as $key => $js) {
                $script .= $js;
            }
        }
        echo $file;
        $script = ($script != '') ? '<script>' . $script . '</script>' : '';
        echo $script;
    }



    function registerModal($modclass = '', $type='', $fade=true)
    {
        $data = array();
        $data['id'] = 'condat-modal';
        $fade = ($fade==true)?'fade':'';
        $type = ($type =='right')?'modal-right':'';
        $data['class'] = $type .' '. $fade;
        $data['modclass'] = $modclass;
        $data['options'] = 'data-backdrop="static" data-keyboard="false" tabindex="-1"  role="dialog" aria-hidden="true"';
        $modal  = view('layouts.partials.modal', $data);
        $this->modals[] = $modal;
        if (\Request::ajax()) {
            echo $modal;
        }
    }

    function loadModal()
    {
        $html ='';
        if (!empty($this->modals)) {
            foreach ($this->modals as $code) {
                $html = $code;
            }
        }
        echo $html;
    }


    /**
     * check for user permissions
     * @param string $access
     */
    function can($access = '')
    {
        $user = Auth::user();
        $permissions = @unserialize($user->permissions);
        if ($user->role == 1 || (!empty($permissions) && in_array($access, $permissions))) {
            return true;
        } else {
            App()->abort('404');
        }
    }

    /**
     * check for user permissions
     * @param string $access
     */
    function can_view($access = '')
    {
        $user = Auth::user();
        if($user)
        {
            $permissions = ($user->permissions!='') ? @unserialize($user->permissions) : array();
            if ($user->role == 1 || in_array($access, $permissions)) {
                return true;
            } else {
                return false;
                //App()->abort('404');
            }
        }
    }

    /*
    * Upload file
    */
    public function uploadFile($uploaded_file) 
    {
        // checking file is valid.
        if ($uploaded_file->isValid()) 
        {
            $destinationPath = public_path('assets/uploads'); // upload path
            $extension = $uploaded_file->getClientOriginalExtension(); // getting image extension
            $fileName = rand(11111,99999).'.'.$extension; // renaming image

            try {
                //move_uploaded_file($_FILES['logo']['tmp_name'], $destinationPath.'/temp.jpg');
                $file = $uploaded_file->move($destinationPath, $fileName);

            } catch(Exception $e) {
                // Handle your error here.
                dd($e->getMessage());
            }
            // sending back with message
            return $fileName;
        }
        /*else {
            // sending back with error message.
            \Session::flash('error', 'Uploaded file is not valid.');
            return redirect()->back();
        }*/
        
    }


}

