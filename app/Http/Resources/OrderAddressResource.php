<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderAddressResource extends JsonResource
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
            'gov' => $this->gov->name,
            'area' => $this->area->name,
//            'block' => $this->block,
            'street'=>$this->street,
            'sub_street'=>$this->sub_street,
            'lat'=>$this->lat,
            'lng'=>$this->lng,
            'address_text'=>$this->address_text
        ];
    }
}
