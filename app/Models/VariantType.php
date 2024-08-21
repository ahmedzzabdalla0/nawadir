<?php

namespace App\Models;

use App\Traits\MultiLanguage;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\VariantType
 *
 * @property int $id
 * @property string|null $name_ar
 * @property string|null $name_en
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VariantType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VariantType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VariantType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VariantType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VariantType whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VariantType whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\VariantType whereType($value)
 * @mixin \Eloquent
 */
class VariantType extends Model
{
    protected $table='variant_types';
    use MultiLanguage;
    protected $multi_lang = ['name'];

    public function variants(){
        return $this->hasMany(Variant::class,'variant_type_id');
    }
}
