<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gimnasio extends Model
{
   
    public function liga()
    {
    	return $this->hasOne(Liga::class);
    }

}
