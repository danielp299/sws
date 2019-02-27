<?php

namespace App\Http\Resources\InscritoTorneo;

use Illuminate\Http\Resources\Json\JsonResource;

class InscritoTorneoResource extends JsonResource
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
            'avatar' => $this->uid_avatar,
            'experencia' => $this->exp,
        ];
    }
}
