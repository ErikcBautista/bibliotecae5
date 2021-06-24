<?php

namespace App\Http\Resources\Manage;

use Illuminate\Http\Resources\Json\JsonResource;

class LibrosResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            'id'=>$this->id,
            'title'=>$this->title,
            'idioma'=> $this->idioma,
            'archivo'=>url($this->archivo),
            'description'=> $this->description,
            'genero'=> $this->genero,
            'propietario'=>[
                'name'=>$this->user->name,
                'email'=>$this->user->email,
            ],
            'created_at'=>$this->created_at
        ];
    }
}
