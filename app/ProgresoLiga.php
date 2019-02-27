<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProgresoLiga extends Model
{
    public function liga()
    {
    	return $this->belongsTo(Liga::class, 'uid_liga');
    }

    public function ligaUser()
    {
    	return $this->belongsTo(Liga::class, 'uid_user');
    }
}
