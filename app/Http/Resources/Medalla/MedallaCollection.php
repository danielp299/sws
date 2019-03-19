<?php

namespace App\Http\Resources\Medalla;

use Illuminate\Http\Resources\Json\Resource;

class MedallaCollection extends Resource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            //'user' => $this->uid_user,
            'id_medalla' => $this->uid_gym,
        ];
    }
}
