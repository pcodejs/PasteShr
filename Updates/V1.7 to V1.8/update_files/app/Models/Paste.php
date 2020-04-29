<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravelista\Comments\Commentable;

class Paste extends Model
{
    use Commentable;
     /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'pastes';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $guarded = ['id'];
    //protected $fillable = [];


    public function user()
    {
        return $this->hasOne('App\User','id','user_id');
    }

    public function language()
    {
        return $this->hasOne('App\Models\Syntax','slug','syntax');
    }

    public function getTitleFAttribute()
    {
        return $this->attributes['title_f'] = (!empty($this->title))?$this->title:'Untitled';
    }        
    public function getContentFAttribute()
    {
        return $this->attributes['content_f'] = html_entity_decode($this->content);
    }     
    public function getViewsFAttribute()
    {
        return $this->attributes['views_f'] = number_format($this->views);
    }    
    public function getURLAttribute()
    {
        return $this->attributes['url'] = url($this->slug);
    }

    public function getCreatedAgoAttribute()
    {
        return $this->attributes['created_ago'] = $this->created_at->diffForHumans();
    }

    public function getContentSizeAttribute()
    {
        return $this->attributes['content_size'] = number_format(strlen($this->content)/1000,2);
    }


}


