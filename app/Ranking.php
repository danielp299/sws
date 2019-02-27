<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ranking extends Model
{
    protected $table = 'ranking';

    public function user()
    {
    	return $this->belongsTo(User::class, 'uid_user');
    }
}
