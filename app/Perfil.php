<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    protected $table = 'perfiles';

    public function user()
    {
    	return $this->belongsTo(User::class, 'uid_user');
    }

    public function avatar()
    {
    	return $this->belongsTo(User::class, 'uid_avatar');
    }
    
}
