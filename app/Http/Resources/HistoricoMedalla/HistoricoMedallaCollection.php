<?php

namespace App\Http\Resources\HistoricoMedalla;

use Illuminate\Http\Resources\Json\JsonResource;

class HistoricoMedallaCollection extends JsonResource
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
            'id_medalla' => $this->uid_gym
        ];
    }
}
