<?php

namespace App\Models;

use App\Models\Category;
use App\Traits\MultiLanguage;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    //
    use SoftDeletes;
    use MultiLanguage;
    protected $multi_lang = ['name', 'details'];

    protected $table = 'products';
    protected $hidden=['created_at','updated_at','deleted_at','is_offer','is_slider','in_recent','delivery_price'];
    protected $appends = ['has_variants','is_rated','def_images',
        'image','image_url','has_discount', 'in_favorite', 'real_price','available_weights'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }


    public function getPriceAttribute()
    {

        if ($this->attributes['discount_ratio'] > 0) {
            $price = $this->attributes['price'] - (($this->attributes['price'] * ($this->attributes['discount_ratio'] / 100)));
        } else {
            $price = $this->attributes['price'];
        }

//        if (session('country_id')) {
//            if ($cc = Country::find(session('country_id'))) {
//                $price = $price * $cc->conversion_factor;
//            }
//        }

        return round($price, 3);


    }



    public function getRealPriceAttribute()
    {
        $price = $this->attributes['price'];
        return $price;
    }


    public function getHasDiscountAttribute()
    {
        $h = 0;

        if ($this->attributes['discount_ratio'] > 0) {
            $h = 1;
        }

        return $h;
    }

    public function getDiscountRatioAttribute()
    {
        $h = 0;

        if ($this->attributes['discount_ratio'] > 0) {
            $h = $this->attributes['discount_ratio'];
        }

        return $h;
    }




    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id')->whereNull('product_variant_id')->whereNull('type');
    }
    public function all_images()
    {
        return $this->hasMany(ProductImage::class, 'product_id')->whereNull('product_variant_id');
    }
    public function getDefImagesAttribute()
    {
        $im = ProductImage::query()->where('product_id',$this->attributes['id'])->whereNotNull('type')->get();
        $o=[];
        foreach ($im as $i){
            $oob=$i->typeOB()->first();
            $to=$i;
            $to->type_name=$oob?$oob->name:'';
            $o[]=$to;
        }
        return $im ? $im : null;
    }

    public function variants()
    {
            return $this->hasMany(ProductVariant::class, 'product_id')->where('is_deleted',0);
    }

    public function getHasVariantsAttribute(){
$variants = $this->variants()->where('is_deleted',0)->count();
if($variants>0){
    return 1;
}
    return 0;

    }
    public function getAvailableWeightsAttribute(){
        $category_id = $this->attributes['category_id'];
        $weights = null;
        if($category_id != 1) {
            $min_var  = ProductVariant::where('product_id',$this->attributes['id'])->where('is_deleted',0)->orderBy('weight','asc')->first();
            $max_var  = ProductVariant::whereNotNull('weight_to')->where('is_deleted',0)->where('product_id',$this->attributes['id'])->orderBy('weight_to','desc')->first();
            if($min_var){
                $weights=''.$min_var->weight;
            }
            if($max_var){
                $weights.=' - '.$max_var->weight_to;
            }
        }
        return $weights;
    }


    public function getImageAttribute()
    {
        $im = $this->images()->where('type', 1)->first();
        return $im ? $im->image : 'logo.png';
    }
    public function getNotificationImageAttribute()
    {
        $im = $this->images()->where('type', 3)->first();
        return $im ? $im->image : null;
    }

    public function getImageUrlAttribute()
    {
        $im = $this->all_images()->where('type', 1)->first();
        return $im ? $im->image_url : asset('admin/imgs/logo_w.png');
    }

    public function favorite()
    {
        return $this->hasMany(UserFavorite::class,'product_id');
    }

    public function getInFavoriteAttribute()
    {

        if (isset($_REQUEST['user_id'])) {
            $user_id = $_REQUEST['user_id'];
            if ($this->favorite()->where('user_id', $user_id)->first()) {
                return 1;
            }
        }

        return 0;

    }
    public function getIsRatedAttribute()
    {

        if (isset($_REQUEST['user_id'])) {
            $user_id = $_REQUEST['user_id'];
            $user = User::find($user_id);
            if ($user) {
                $rated_orders = Order::query()->where('user_id',$user_id)->where('is_rated',1)->pluck('id')->toArray();
                $order_products = OrderProduct::whereIn('order_id',$rated_orders)->where('product_id',$this->attributes['id'])->count();
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
    public function orders()
    {
        return $this->hasMany(OrderProduct::class,'product_id');
    }

    public function getCanDelAttribute()
    {
        $r1=$this->orders()->count();
        $r2=0;
        return $r1+$r2 ==0;

    }

    public function getMinPriceAttribute()
    {
        $min_variant = $this->variants()->orderBy('price','asc')->first();
        return $min_variant->price??0;
    }
    public function getMaxPriceAttribute()
    {
        $max_variant = $this->variants()->orderBy('price','desc')->first();
        return $max_variant->price??0;
    }
    public function productLogs(){
        return $this->hasMany(ProductAmountLog::class,'product_id')->orderBy('id','desc');
    }
    public function getAvailableQuantityAttribute(){
        $amount = $this->productLogs()->where('is_approved',1)->sum('amount');
        return $amount*1;
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
