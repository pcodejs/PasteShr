<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Notifications\ResetPassword as ResetPasswordNotification;
//use App\Notifications\VerifyEmail as RegisterAccountNotification;
use Laravelista\Comments\Commenter;

class User extends Authenticatable
{
    use Notifiable, Commenter;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'email_verified_at', 'password', 'role', 'status', 'avatar', 'about', 'fb', 'tw', 'gp'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'default_paste' => 'object',
    ];

    /**
     * Route notifications for the mail channel.
     *
     * @param \Illuminate\Notifications\Notification $notification
     * @return string
     */
    public function routeNotificationForMail($notification)
    {
        return $this->email;
    }

    public function sendEmailVerificationNotification()
    {
        try {
            $this->notify(new \App\Notifications\VerifyEmail);
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            session()->flash('warning', __('Registration email was not sent due to invalid mail configuration'));
        }
    }

    /**
     * Mark the given user's email as verified.
     *
     * @return bool
     */
    public function markEmailAsVerified()
    {
        return $this->forceFill([
            'email_verified_at' => $this->freshTimestamp(),
            'status' => 1,
        ])->save();
    }


    /**
     * Send the password reset notification.
     *
     * @param string $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        try {
            $this->notify(new ResetPasswordNotification($token));
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            session()->flash('warning', __('Reset password email was not sent due to invalid mail configuration'));
        }
    }

    public function isAdmin()
    {
        if ($this->role == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function getAvatarAttribute()
    {
        return $this->attributes['avatar'] = (!empty($this->attributes['avatar'])) ? url($this->attributes['avatar']) : 'https://placehold.it/80x80/00a65a/ffffff/&text=' . $this->email[0];
    }

    public function getCreatedAgoAttribute()
    {
        return $this->attributes['created_ago'] = (!empty($this->attributes['created_at'])) ? $this->created_at->diffForHumans() : '-';
    }

    public function getURLAttribute()
    {
        return $this->attributes['url'] = route('user.profile', [$this->name]);
    }

    public function getPasteViewsAttribute()
    {
        $n = \App\Models\Paste::where('user_id', $this->id)->sum('views');
        $precision = 1;
        if ($n < 900) {
            // 0 - 900
            $n_format = number_format($n, $precision);
            $suffix = '';
        } else if ($n < 900000) {
            // 0.9k-850k
            $n_format = number_format($n / 1000, $precision);
            $suffix = 'K';
        } else if ($n < 900000000) {
            // 0.9m-850m
            $n_format = number_format($n / 1000000, $precision);
            $suffix = 'M';
        } else if ($n < 900000000000) {
            // 0.9b-850b
            $n_format = number_format($n / 1000000000, $precision);
            $suffix = 'B';
        } else {
            // 0.9t+
            $n_format = number_format($n / 1000000000000, $precision);
            $suffix = 'T';
        }
        // Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
        // Intentionally does not affect partials, eg "1.50" -> "1.50"
        if ($precision > 0) {
            $dotzero = '.' . str_repeat('0', $precision);
            $n_format = str_replace($dotzero, '', $n_format);
        }
        $views = $n_format . $suffix;

        return $this->attributes['paste_views'] = $views;
    }

}
