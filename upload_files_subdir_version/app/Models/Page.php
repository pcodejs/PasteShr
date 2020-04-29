<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Page extends Model
{
    use HasTranslations;
     /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'pages';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $guarded = ['id'];
    //protected $fillable = [];

    public $translatable = ['title','content'];

    public function getContentFAttribute()
    {
        return $this->attributes['content_f'] = html_entity_decode($this->content);
    }  

    public function getURLAttribute()
    {
        return $this->attributes['url'] = route('page.show',[$this->slug]);
    }
}
