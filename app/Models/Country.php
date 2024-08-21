<?php
namespace App\Models;
use App\Traits\MultiLanguage;
use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Category
 *
 * @property int $id
 * @property string $name_ar
 * @property string $name_en
 * @property string $image
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read mixed $can_del
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Country extends Model{
    protected $table = 'countries';
    protected $hidden=['created_at','updated_at','prefix','mobile_digits','check_start_digit','start_digit','accept_prefix','status','tax','deleted_at','currency_ar','currency_en'];
    use MultiLanguage;
    protected $multi_lang = ['name'];
    protected $appends=['flag_url'];


    public function users()
    {
        return $this->hasMany(UserAddress::class,'country_id');
    }



    public function getCanDelAttribute()
    {
        $b1=$this->users()->count();
        return $b1 == 0 ? true:false;
    }
    public function getFlagUrlAttribute()
    {

        return url('uploads/'.$this->flag);
    }


}
