<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UserRateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $rate = $this->rate;

        return [
            'user_name' => $this->order->user->name,
            'user_image' => $this->order->user->image_thumbnail,
            'rate_notes'=> $this->rate_notes??'',
            'rate_time'=> $this->order->rated_at ? Carbon::parse($this->rated_at)->format('d/m/Y, h:i a') : null,
            'rate'=> $rate,
        ];
    }
}
