<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ProductVariant
 *
 * @property int $id
 * @property int $product_id
 * @property int $size_id
 * @property float $price
 * @property-read \App\Models\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductVariant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductVariant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductVariant query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductVariant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductVariant whereProductId($value)
 * @mixin \Eloquent
 */
class ProductVariant extends Model
{
    //
    protected $table = 'product_variants';
    protected $with=['size'];
    public $timestamps=false;
    protected $appends=['web_name','name','end_price','real_price','weight_name','image'];
protected $hidden = ['created_at','updated_at','deleted_at','product','size_id'];

    public function orders(){
        return $this->hasMany(OrderProduct::class,'product_variant_id');
    }
    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }

    public function size(){
        return $this->belongsTo(Variant::class,'size_id');
    }



    public function getImageAttribute()
    {

        $image = $this->product->image_url;
        return $image;


    }
    public function getEndPriceAttribute()
    {

        $product_ratio = $this->product->discount_ratio;
        if ($product_ratio > 0) {
            $price = $this->attributes['price'] - (($this->attributes['price'] * ($product_ratio / 100)));
        } else {
            $price = $this->attributes['price'];
        }

        return round($price, 3);


    }



    public function getRealPriceAttribute()
    {
        $price = $this->attributes['price'];
        return $price;
    }


    public function getHasDiscountAttribute()
    {
        $product_ratio = $this->product->discount_ratio;
        $h = 0;

        if ($product_ratio > 0) {
            $h = 1;
        }

        return $h;
    }
    public function getCanDelAttribute()
    {
        $products = $this->orders()->count();
       return $products >0?0:1;
    }

    public function getDiscountRatioAttribute()
    {
        $h = 0;
        $product_ratio = $this->product->discount_ratio;
        if ($product_ratio > 0) {
            $h = $product_ratio;
        }

        return $h;
    }
    public function productLogs(){
        return $this->hasMany(ProductAmountLog::class,'product_variant_id')->orderBy('id','desc');
    }
    public function getAvailableQuantityAttribute(){
        $amount = $this->productLogs()->where('is_approved',1)->sum('amount');
        return $amount*1;
    }

    public function getNameAttribute(){
        $name = null;
        if($this->size){
            $name .= $this->size->name;
        }else{
            if($this->attributes['weight'] > 0){
                $name .=$this->attributes['weight'];
            }
            if(!is_null($this->attributes['weight_to']) && $this->attributes['weight_to'] > 0){
                $name .='-'.$this->attributes['weight_to'].' '.trans('api_texts.kilo');
            }else{
                $name .=' '.trans('api_texts.kilo');
            }
        }


        return $name;
    }
    public function getWebNameAttribute(){
        $name = $this->product->name;
        if($this->size){
            $name .= '('.$this->size->name.')';
        }else{
            if($this->attributes['weight'] > 0){
                $name .='('.$this->attributes['weight'];
            }
            if(!is_null($this->attributes['weight_to']) && $this->attributes['weight_to'] > 0){
                $name .='-'.$this->attributes['weight_to'].' '.trans('api_texts.kilo').')';
            }else{

                $name .=' '.trans('api_texts.kilo').')';

            }
        }


        return $name;
    }
    public function getWeightNameAttribute(){
        $name = null;
        if($this->size){
            $name .= $this->size->name;
        }else{
            if($this->attributes['weight'] > 0){
                $name = $this->attributes['weight'];
            }
            if(!is_null($this->attributes['weight_to']) && $this->attributes['weight_to'] > 0){
                $name .='-'.$this->attributes['weight_to'].' '.trans('api_texts.kilo');
            }else{
                if(!$this->size){
                $name .=' '.trans('api_texts.kilo');
                }
            }
        }

        return $name;
    }
    public function getIsRatedAttribute()
    {

        if (isset($_REQUEST['user_id'])) {
            $user_id = $_REQUEST['user_id'];
            $user = User::find($user_id);
            if ($user) {
                $rated_orders = Order::query()->where('user_id',$user_id)->where('is_rated',1)->pluck('id')->toArray();
                $order_products = OrderProduct::whereIn('order_id',$rated_orders)->where('product_variant_id',$this->attributes['id'])->count();
                if($order_products>0){
                    return 1;
                }else{
                    return 0;
                }

            }else{
                return 0;
            }
        }

        return 0;

    }
    public function getRateAttribute(){
        $rated_orders = Order::query()->where('is_rate_approved',1)->where('is_rated',1)->pluck('id')->toArray();
        $rateCount = $this->orders()->whereIn('order_id',$rated_orders)->count();
        $rateSum = $this->orders()->whereIn('order_id',$rated_orders)->sum('rate');
        $rate = $rateCount>0? round($rateSum/$rateCount,2):0;
        return $rate;
    }
    public function getRateCountAttribute(){
        $rated_orders = Order::query()->where('is_rate_approved',1)->where('is_rated',1)->pluck('id')->toArray();
        $rateCount = $this->orders()->whereIn('order_id',$rated_orders)->count();
        return $rateCount;
    }

}
