<?php namespace App\Modules\System\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model {

    protected $table = "settings";

    protected $fillable = ['name', 'value'];

    protected $primaryKey = "name";

    function get($name)
    {
        return $this->where('name', $name)->first();
    }

    function scopeEmail($query)
    {
        return $query->where('name', 'email');
    }

    function scopeTemplate($query)
    {
        return $query->where('name', 'template');
    }

    function get_template(){
        $setting = $this->template()->first();
        if(!empty($setting))
            return (object)$setting->value;
        else
            return false;

    }

    function getEmail()
    {
        $email = $this->email()->first(['value']);
        return isset($email->value) ? $email->value : null;
    }

    function saveSetup($name = '', $value = '')
    {
        $setup = Setting::firstOrNew(['name' => $name]);
        $setup->value = $value;
        $setup->save();
    }

    function addOrUpdate(array $data = array(),$group = NULL)
    {
        if (!empty($data)):
            if(is_null($group)){
                foreach ($data as $key => $value) {

                    $setting = Setting::firstOrNew(['name' => $key]);

                    $setting->value = $value;

                    $setting->save();
                }

            }else{
                foreach ($data as $key => $value) {

                    $setting = Setting::firstOrNew(['name' => $group]);
                    if (is_array($value) || is_object($value)) {
                        $setting->value = serialize($value);
                    } else {
                        $setting->value = $value;
                    }
                    $setting->save();
                }

            }
        endif;
    }

    function getValueAttribute($value)
    {
        $data = @unserialize($value);
        if ($data !== false) {
            return $data;
        } else {
            return $value;
        }
    }

    public function getSupportSetting() {
        $support_smtp = Setting::where('name', 'support_smtp')->first();
        return ($support_smtp) ? ($support_smtp->value) : null;
    }

}
