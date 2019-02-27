<?php

namespace App\Http\Resources\Avatar;

use Illuminate\Http\Resources\Json\JsonResource;

class AvatarResource extends JsonResource
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
            'uid_avatar' => $this->uid_avatar,
            'experiencia' => $this->exp
        ];
    }
}
