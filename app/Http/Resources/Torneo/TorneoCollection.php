<?php

namespace App\Http\Resources\Torneo;

use Illuminate\Http\Resources\Json\JsonResource;

class TorneoCollection extends JsonResource
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
            'medallas' => $this->medallas,
            'fecha' => $this->fecha,
        ];
    }
}
