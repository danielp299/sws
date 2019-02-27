<?php

namespace App\Http\Resources\Gimnasio;

use Illuminate\Http\Resources\Json\Resource;

class GimnasioCollection extends Resource
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
                'gimnasio' => $this->uid_gym,
                'descripcion' => $this->description,
                'medalla' => $this->medal
        ];
    }
}
