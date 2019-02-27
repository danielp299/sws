<?php

namespace App\Http\Resources\Ranking;

use Illuminate\Http\Resources\Json\Resource;

class RankingCollection extends Resource
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
            'uid_user' => $this->uid_user,
            'puntos' => $this->puntos
        ];
    }
}
