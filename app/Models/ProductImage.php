<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ProductImage
 *
 * @property int $id
 * @property int $product_id
 * @property string $image
 * @property int $is_main
 * @property-read mixed $image_thumbnail
 * @property-read mixed $image_url
 * @property-read \App\Models\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductImage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductImage query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductImage whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductImage whereIsMain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductImage whereProductId($value)
 * @mixin \Eloquent
 */
class ProductImage extends Model
{
    //
    protected $table = 'product_images';
    public $timestamps=false;
    protected $appends=['image_url','image_thumbnail'];
    protected $hidden = ['product_id','product_variant_id','type','is_main','image_thumbnail'];


    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }
    public function typeOB(){
        return $this->belongsTo(ImageType::class,'type');
    }
    public function productVariant(){
        return $this->belongsTo(ProductVariant::class,'product_variant_id');
    }
    public function getImageUrlAttribute()
    {
        $logo=$this->attributes['image'];

        return $logo?asset('uploads/'.$logo):asset('uploads/avatar.png');
    }
    public function getImageThumbnailAttribute()
    {
        $logo=$this->attributes['image'];

        return $logo?asset('uploads/'.$logo):asset('uploads/thumbnail/avatar.png');
    }
}
