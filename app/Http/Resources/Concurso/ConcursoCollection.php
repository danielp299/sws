<?php

namespace App\Http\Resources\Concurso;

use Illuminate\Http\Resources\Json\Resource;

class ConcursoCollection extends Resource
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
            'fecha' => $this->fecha,
        ];
    }
}
