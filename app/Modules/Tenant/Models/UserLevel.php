<?php namespace App\Modules\Tenant\Models;

use Illuminate\Database\Eloquent\Model;

class UserLevel extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_levels';


    protected $primaryKey = 'user_level_id';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description', 'value'];

    public $timestamps = false;
}
