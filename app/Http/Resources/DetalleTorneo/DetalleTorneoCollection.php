<?php

namespace App\Http\Resources\DetalleTorneo;

use Illuminate\Http\Resources\Json\JsonResource;

class DetalleTorneoCollection extends JsonResource
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
            'torneo' => $this->uid_torneo,
            'oponente_1' => $this->uid_user,
            'oponente_2' => $this->uid_oponente,
            'ganador' => $this->ganador,

        ];
    }
}
