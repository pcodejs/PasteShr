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

    protected $table      = 'pastes';
    protected $primaryKey = 'id';
    public $timestamps    = true;
    protected $guarded    = ['id'];
    //protected $fillable = [];
    private $str;

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function language()
    {
        return $this->hasOne('App\Models\Syntax', 'slug', 'syntax');
    }

    public function getTitleFAttribute()
    {
        return $this->attributes['title_f'] = (!empty($this->title)) ? $this->title : __('Untitled');
    }
    public function getContentFAttribute()
    {
        return $this->attributes['content_f'] = html_entity_decode($this->content);
    }
    public function getContentBFAttribute()
    {
        $content = $this->content;
        if ($this->storage == 2) {
            $content = file_get_contents(ltrim($content, '/'));
        }
        if ($this->encrypted == 1) {
            $content = decrypt($content);
        }
        $content = html_entity_decode($content);
        return $this->attributes['content_bf'] = $content;
    }
    public function getViewsFAttribute()
    {
        $n         = $this->views;
        $precision = 1;
        if ($n < 900) {
            // 0 - 900
            $n_format = number_format($n, $precision);
            $suffix   = '';
        } else if ($n < 900000) {
            // 0.9k-850k
            $n_format = number_format($n / 1000, $precision);
            $suffix   = 'K';
        } else if ($n < 900000000) {
            // 0.9m-850m
            $n_format = number_format($n / 1000000, $precision);
            $suffix   = 'M';
        } else if ($n < 900000000000) {
            // 0.9b-850b
            $n_format = number_format($n / 1000000000, $precision);
            $suffix   = 'B';
        } else {
            // 0.9t+
            $n_format = number_format($n / 1000000000000, $precision);
            $suffix   = 'T';
        }
        // Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
        // Intentionally does not affect partials, eg "1.50" -> "1.50"
        if ($precision > 0) {
            $dotzero  = '.' . str_repeat('0', $precision);
            $n_format = str_replace($dotzero, '', $n_format);
        }
        $views = $n_format . $suffix;

        return $this->attributes['views_f'] = $views;
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
        return $this->attributes['content_size'] = number_format(strlen($this->content) / 1000, 2);
    }

}
