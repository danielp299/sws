<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Liga extends Model
{
    public function gym()
    {
    	return $this->belongsTo(Gimnasio::class, 'uid_gym');
    }

    public function user()
    {
    	return $this->belongsTo(User::class,'uid_user');
    }

    public function progreso()
    {
    	return $this->hasOne(ProgresoLiga::class);
    }

}
