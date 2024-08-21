<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderProductResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->productVariant->product->name_ar,
                        'weight' => $this->productVariant->name,

            'image' => $this->productVariant->image,
            'cut_type' => $this->cut_type?$this->cut_type->name:null,
            'is_covered' => $this->is_covered,
            'cover_type' => $this->cover_type?$this->cover_type->name:null,
            'real_price' => $this->productVariant->end_price,
            'quantity'=>$this->qty,
            'order_price'=>$this->item_price,
            'total_order_price'=>$this->price,
            'total_slaughter_cost'=>$this->slaughter_cost??0,
        ];
    }
}
