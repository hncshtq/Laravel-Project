<?php

namespace App;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class User extends Model implements Authenticatable
{ 
    use \Illuminate\Auth\Authenticatable;
    public function posts()
    {
        return $this->hasMany('App\Post'); //set user relation, it is mean user can has multiple post
    }
    
    public function likes()
    {
        return $this->hasMany('App\Like');
    }
}
