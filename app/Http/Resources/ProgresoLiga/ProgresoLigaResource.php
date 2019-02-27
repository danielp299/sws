<?php

namespace App\Http\Resources\ProgresoLiga;

use Illuminate\Http\Resources\Json\JsonResource;

class ProgresoLigaResource extends JsonResource
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
            'ligaOponente' => $this->uid_liga_oponente,
            'liga' => $this->uid_liga == NULL ? 'No pertenece a ninguna liga' : $this->uid_liga,
            'victorias' => $this->victorias,
            'derrotas' => $this->derrotas,
        ];
    }
}
