<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Avatar extends Model
{
    protected $table = 'avatar';

    public function user()
    {
    	return $this->hasOne(User::class);
    }

}
