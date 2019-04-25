<?php

namespace App\Http\Resources\Perfil;

use Illuminate\Http\Resources\Json\JsonResource;

class PerfilResource extends JsonResource
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
            'uid_user' => $this->uid_user,
            'avatar' => $this->uid_avatar,
            'puntos' => $this->puntos,
            'ranking' => $this->ranking,
            'gimnasio' => 'kandelo',
            'nombre' => 'pepe',
            'poder' => '99999',
            'ligas' => 'pronto',
            'medallas' => 'pronto',
            'torneos' => 'pronto',
            'concursos' => 'pronto'
        ];
    }
}
