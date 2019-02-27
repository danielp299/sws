<?php

namespace App\Http\Resources\HistoricoMedalla;

use Illuminate\Http\Resources\Json\ResourceCollection;

class HistoricoMedallaCollection extends ResourceCollection
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
            'user' => $this->uid_user,
            'gym' => $this->uid_gym,
        ];
    }
}
