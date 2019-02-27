<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'uid_avatar' => $this->uid_avatar,
            'experiencia' => $this->exp,
        ];
    }
}
