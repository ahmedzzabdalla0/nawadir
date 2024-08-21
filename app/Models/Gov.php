<?php

namespace App\Models;

use App\Traits\MultiLanguage;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Gov
 *
 * @property int $id
 * @property string $name_ar
 * @property string $name_en
 * @property int $country_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UserAddress[] $addressies
 * @property-read int|null $addressies_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Area[] $areas
 * @property-read int|null $areas_count
 * @property-read mixed $can_del
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Gov newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Gov newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Gov query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Gov whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Gov whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Gov whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Gov whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Gov whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Gov whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Gov whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Gov extends Model
{
    protected $table='govs';
    protected $hidden=['created_at','updated_at','deleted_at'];
    use MultiLanguage;
    protected $multi_lang = ['name'];
    public function areas()
    {
        return $this->hasMany(Area::class,'gov_id');
    }

    public function addressies()
    {
        return $this->hasMany(UserAddress::class,'gov_id');
    }
    public function divisions()
    {
        return $this->hasMany(GovDivision::class,'gov_id');
    }
    public function getCanDelAttribute()
    {
        $b1=$this->addressies()->count();
        $b2=$this->areas()->count();
        return $b1+$b2 == 0 ? true:false;
    }


}
