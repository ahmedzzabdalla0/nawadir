<?php

namespace App\Models;

use App\Traits\MultiLanguage;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CaseGeneral
 *
 * @property int $id
 * @property string $name_ar
 * @property string $name_en
 * @property string $color_hex
 * @property int $color_r
 * @property int $color_g
 * @property int $color_b
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CaseGeneral newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CaseGeneral newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CaseGeneral query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CaseGeneral whereColorB($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CaseGeneral whereColorG($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CaseGeneral whereColorHex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CaseGeneral whereColorR($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CaseGeneral whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CaseGeneral whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CaseGeneral whereNameEn($value)
 * @mixin \Eloquent
 */
class CaseGeneral extends Model
{
    protected $table='cases';
    use MultiLanguage;
    protected $multi_lang = ['name'];

}
