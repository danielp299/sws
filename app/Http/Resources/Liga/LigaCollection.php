<?php

namespace App\Http\Resources\Liga;

use Illuminate\Http\Resources\Json\Resource;

class LigaCollection extends Resource
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
            'user' => $this->uid_user,
            'nombre' => \App\User::where('uid_user', $this->uid_user)->first()->nombre,
            'puntos' => $this->puntos,
        ];
    }
}
