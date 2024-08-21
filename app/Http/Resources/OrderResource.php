<?php

namespace App\Http\Resources\User;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{ 
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $type= $this->paymentType->name;

        return [
            'id' => $this->id,
            'order_number' => $this->order_number,
            'create_text' => $this->created_text,
            'created_at' => $this->created_at->toDateTimeString(),
            'status'=>$this->status->name,
            'status_id'=>$this->case_id,
            'status_object'=>$this->status,
            'name' => $this->name, 
            'mobile' => $this->mobile,
            // 'user_image' => $this->user->image,
            'tax_price' => $this->tax_price,
            'payment_type' => $this->paymentType,
            'coupon' => $this->coupon,
            'expected_delivery_date' => $this->expected_delivery_time??null,
            'delivery_price' => $this->delivery_price,
            'slaughter_cost' => $this->slaughter_cost??0,
            'total_price' => $this->total_price,
            'products_count' => count($this->products),
            'products' => OrderProductResource::collection($this->products),
            'address' => OrderAddressResource::make($this->address),
            'transaction_url' => $this->transaction && $this->case_id==1?$this->transaction->redirect_url:'',

        ];
    }
}
