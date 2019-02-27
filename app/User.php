<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    public function victima()
    {
    	return $this->hasOne(Victima::class);
    }

    public function avatar()
    {
    	return $this->belongsTo(Avatar::class,'uid_avatar');
    }

    public function liga()
    {
        return $this->hasOne(Liga::class);
    }

    public function ranking()
    {
        return $this->hasOne(Ranking::class);
    }

}

