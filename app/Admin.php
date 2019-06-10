<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

// use Illuminate\Database\Eloquent\Model;

class Admin extends Authenticatable
{
    //
    use Notifiable;

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
}
