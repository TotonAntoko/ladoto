<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'surname',  'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        // 'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles()
    {
        return $this->belongsToMany("App\Role","roles_user", 'user_id', 'role_id')->withTimeStamps();
    }

    public function isItAuthorized($authorization)
    {
        foreach ($this->roles()->get() as $role) {
                if ($role->name == $authorization)
            {
                return true;
                break;
            }
        }
        return false;
    }

    public function detail()
    {
        return $this->hasOne('App\UserDetail')->withDefault();
    }
}
