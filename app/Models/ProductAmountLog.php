<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAmountLog extends Model
{
    protected $table = 'product_amount_logs';
    protected $fillable=['product_id','product_variant_id','amount','price','type','note','is_approved'];

    public function product(){
        return $this->belongsTo(Product::class ,'product_id');
    }
    public function productVariant(){
        return $this->belongsTo(ProductVariant::class ,'product_variant_id');
    }

    public function order(){
        return $this->belongsTo(Order::class ,'order_id');
    }

    public function getTypeArAttribute()
    {
        $out='';
        switch ($this->type){
            case 'AddToStock':$out="اضافة للمخزون";break;
            case 'BuyFromStock':$out="شراء من المتوفر";break;
            case 'WithdrawFromStock':$out="سحب من المخزون";break;
        }
        return $out;
    }


}
