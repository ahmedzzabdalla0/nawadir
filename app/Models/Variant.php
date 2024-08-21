<?php

namespace App\Models;

use App\Traits\MultiLanguage;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Variant
 *
 * @property int $id
 * @property string|null $name_ar
 * @property string|null $name_en
 * @property int $variant_type_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Variant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Variant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Variant query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Variant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Variant whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Variant whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Variant whereType($value)
 * @mixin \Eloquent
 */
class Variant extends Model
{
    protected $table='variants';
    use MultiLanguage;
    protected $multi_lang = ['name'];
    protected $hidden = ['variant_type_id','created_at','updated_at','rgb_color'];
    protected $appends=['image_url'];

    public function variantType(){
        return $this->belongsTo(VariantType::class,'variant_type_id');
    }
    public function getCanDelAttribute(){
        $sizes = ProductVariant::where('size_id',3)->count();
        $cut_types = OrderProduct::where('cut_type_id',3)->count();
        $cover_types = OrderProduct::where('cover_type_id',3)->count();

        return $cut_types+$sizes+$cover_types > 0?0:1;

    }
    public function getImageThumbnailAttribute()
    {
        $logo=$this->attributes['image'];

        return $logo?asset('uploads/thumbnail/'.$logo):asset('uploads/thumbnail/avatar.png');
    }

    public function getImageUrlAttribute()
    {
        $logo=$this->attributes['image'];

        return $logo?asset('uploads/'.$logo):asset('uploads/avatar.png');
    }
}
