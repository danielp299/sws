<?php

namespace App\Http\Resources\Gimnasio;

use Illuminate\Http\Resources\Json\Resource;

class GimnasioCollection extends Resource
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
                'gimnasio' => $this->uid_gym,
                'descripcion' => $this->description,
                'medalla' => $this->medal,
                'lider' => $this->leader ? $this->leader: "lider".rand ( 0 , 100 ),
                'mascota' => $this->mascota ? $this->leader: "lider".rand ( 1 , 25 ),
                'puntos' => $this->points? $this->points: "".rand ( 0 , 99999 ),
                'miembros' => $this->members? $this->leader: "".rand ( 0 , 999 ),
                'ranking' => $this->ranking? $this->leader: "".rand ( 0 , 10 )
        ];

        /**
            $table->string('uid_gym')->unique();
            $table->string('description');
            $table->string('medal');
            $table->string('leader');
            $table->string('points');
            $table->string('members');
            $table->string('ranking'); */
    }
}
