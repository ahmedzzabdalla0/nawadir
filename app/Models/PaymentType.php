<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\PaymentType
 *
 * @property int $id
 * @property string $name
 * @property string $name_en
 * @property string $icon
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentType whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentType whereNameEn($value)
 * @mixin \Eloquent
 */
class PaymentType extends Model
{
    protected $table='payment_types';
    protected $appends=['image'];
    public function getImageAttribute()
    {
        $logo=isset($this->attributes['icon'])?$this->attributes['icon']:'';

        return $logo?url('uploads/payments/'.$logo):url('uploads/avatar.png');
    }



}
