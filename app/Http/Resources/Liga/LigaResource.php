<?php

namespace App\Http\Resources\Liga;

use Illuminate\Http\Resources\Json\JsonResource;

class LigaResource extends JsonResource
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
            'gym' => $this->uid_gym,
            'liga' => $this->uid_gym,
            'user' => $this->uid_user
        ];
    }
}
