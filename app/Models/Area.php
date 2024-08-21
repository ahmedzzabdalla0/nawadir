<?php

namespace App\Models;

use App\Traits\MultiLanguage;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Area
 *
 * @property int $id
 * @property string $name_ar
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $name_en
 * @property int $gov_id
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UserAddress[] $addressies
 * @property-read int|null $addressies_count
 * @property-read mixed $can_del
 * @property-read \App\Models\Gov $gov
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Area newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Area newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Area query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Area whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Area whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Area whereGovId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Area whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Area whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Area whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Area whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Area extends Model
{
    protected $table='areas';
    protected $hidden=['created_at','updated_at','deleted_at'];
    use MultiLanguage;
    protected $multi_lang = ['name'];
    public function gov()
    {
        return $this->belongsTo(Gov::class,'gov_id');
    }
    public function gov_division()
    {
        return $this->belongsTo(GovDivision::class,'gov_division_id');
    }

    public function addressies()
    {
        return $this->hasMany(UserAddress::class,'area_id');
    }
    public function getCanDelAttribute()
    {
        $b1=$this->addressies()->count();
        return $b1 == 0 ? true:false;
    }



}
