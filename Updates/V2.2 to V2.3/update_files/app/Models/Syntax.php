<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Syntax extends Model
{
     /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'syntax';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $guarded = ['id'];
    //protected $fillable = [];

    public function getExtensionFAttribute()
    {
        return $this->attributes['extension_f'] = (!empty($this->attributes['extension'] ))?$this->attributes['extension']:'txt';
    }  

    public function getURLAttribute()
    {
        return $this->attributes['url'] = route('archive',[$this->slug]);
    }    
}
