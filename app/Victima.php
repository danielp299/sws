<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Victima extends Model
{
    protected $table = 'victimas';

    public function user()
    {
    	return $this->belongsTo(User::class, 'uid_user');
    }

    public function avatar()
    {
    	return $this->belongsTo(User::class, 'uid_avatar');
    }
}
