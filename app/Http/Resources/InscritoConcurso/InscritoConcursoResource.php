<?php

namespace App\Http\Resources\InscritoConcurso;

use Illuminate\Http\Resources\Json\JsonResource;

class InscritoConcursoResource extends JsonResource
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
            'concurso' => $this->uid_concurso,
            'experiencia' => $this->exp,
        ];
    }
}
