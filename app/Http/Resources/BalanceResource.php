<?php

namespace App\Http\Resources\User;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class BalanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */



    public function toArray($request)
    {
        $order_id=$this->order_id;

        return [
            'amount' => $this->amount,
            'type' => $this->Btype->name,
            'order_id'=> $order_id,
            'created_at'=> $this->created_at->toDateString(),
            'order'=>OrderResource::make($this->order)

        ];
    }
}
