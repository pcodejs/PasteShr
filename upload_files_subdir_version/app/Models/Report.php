<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
     /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'reported_pastes';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $guarded = ['id'];
    //protected $fillable = [];

    public function paste()
    {
        return $this->hasOne('App\Models\Paste','id','paste_id');
    }

    public function user()
    {
        return $this->hasOne('App\User','id','user_id');
    }

}
