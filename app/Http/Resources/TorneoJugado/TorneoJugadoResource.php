<?php

namespace App\Http\Resources\TorneoJugado;

use Illuminate\Http\Resources\Json\JsonResource;

class TorneoJugadoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'user' => $this->uid_user,
            'torneo' => $this->uid_torneo,
            'posicion' => $this->posicion,
        ];
    }
}
