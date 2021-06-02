<?php

namespace App\Http\Resources\DetalleConcurso;

use Illuminate\Http\Resources\Json\JsonResource;

class DetalleConcursoCollection extends JsonResource
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
            'concurso' => $this->uid_concurso,
            'user' => $this->uid_user,
            'puntuacion' => $this->puntuacion,
            'posicion' => $this->posicion,
        ];
    }
}
