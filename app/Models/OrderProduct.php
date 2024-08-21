<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\OrderProduct
 *
 * @property int $id
 * @property int $order_id
 * @property int $product_id
 * @property int $product_variant_id
 * @property int $qty
 * @property float $item_price
 * @property float $price
 * @property-read \App\Models\Order $order
 * @property-read \App\Models\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderProduct whereItemPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderProduct whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderProduct wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderProduct whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OrderProduct whereQty($value)
 * @mixin \Eloquent
 */
class OrderProduct extends Model
{
    protected $table='order_products';
    public $timestamps=false;

    public function order()
    {
        return $this->belongsTo(Order::class,'order_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class,'product_variant_id');
    }
    public function cut_type()
    {
        return $this->belongsTo(Variant::class,'cut_type_id');
    }
    public function cover_type()
    {
        return $this->belongsTo(Variant::class,'cover_type_id');
    }



}
