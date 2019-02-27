<?php

namespace App\Http\Resources\Medalla;

use Illuminate\Http\Resources\Json\JsonResource;

class MedallaResource extends JsonResource
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
            'gym' => $this->uid_gym,
        ];
    }
}
