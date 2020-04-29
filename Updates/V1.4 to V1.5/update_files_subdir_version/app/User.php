<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Notifications\ResetPassword as ResetPasswordNotification;
//use App\Notifications\VerifyEmail as RegisterAccountNotification;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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
     * Route notifications for the mail channel.
     *
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return string
     */
    public function routeNotificationForMail($notification)
    {
        return $this->email;
    } 

    public function sendEmailVerificationNotification()
    {
        try{
            $this->notify(new \App\Notifications\VerifyEmail);
        }
        catch(\Exception $e){            
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
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        try{
            $this->notify(new ResetPasswordNotification($token));
        }
        catch(\Exception $e){            
            session()->flash('warning', __('Reset password email was not sent due to invalid mail configuration'));
        }
    }   

    public function isAdmin()
    {
        if($this->role == 1){
            return true;
        }
        else{
            return false;
        }
    }

    public function getAvatarAttribute()
    {
        return $this->attributes['avatar'] =  (!empty($this->attributes['avatar']))?$this->attributes['avatar']:'https://placehold.it/80x80/00a65a/ffffff/&text='.$this->name[0];
    }        

    public function getCreatedAgoAttribute()
    {
        return $this->attributes['created_ago'] =  (!empty($this->attributes['created_at']))?$this->created_at->diffForHumans():'-';
    }    


}
