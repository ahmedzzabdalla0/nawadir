<?php

namespace App\Models;

use App\Traits\DeleteImages;
use App\Traits\MultiLanguage;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $table = 'coupons';
    protected $appends=['used_count','can_del'];

    public function orders(){
        return $this->hasMany(Order::class,'coupon_id');
    }

    public function getCanDelAttribute()
    {
        $d1 =$this->orders()->count();
        return ($d1) == 0 ? true:false;
    }

    public function getUsedCountAttribute(){
        return $this->orders()->count();
    }

}
