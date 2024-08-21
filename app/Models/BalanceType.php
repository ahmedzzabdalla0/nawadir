<?php

namespace App\Models;

use App\Traits\MultiLanguage;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\BalanceType
 *
 * @property int $id
 * @property string|null $name_ar
 * @property string|null $name_en
 * @property string $type
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BalanceType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BalanceType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BalanceType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BalanceType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BalanceType whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BalanceType whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BalanceType whereType($value)
 * @mixin \Eloquent
 */
class BalanceType extends Model
{
    protected $table='balance_types';
    use MultiLanguage;
    protected $multi_lang = ['name'];
}
