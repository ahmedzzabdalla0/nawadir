<?php
namespace App\Models;
use App\Traits\MultiLanguage;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Category
 *
 * @property int $id
 * @property string $name_ar
 * @property string $name_en
 * @property int $status
 * @property string $logo
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read mixed $can_del
 * @property-read mixed $image_thumbnail
 * @property-read mixed $image_url
 * @property-read int|null $products_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereNameAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Category extends Model{
    protected $table = 'categories';
    protected $hidden=['created_at','updated_at','deleted_at','status','logo','sorted'];
    protected $appends=['image_url','products_count'];
    use MultiLanguage;
    protected $multi_lang = ['name'];

    public function products()
    {
        return $this->hasMany(Product::class,'category_id');
    }


    public function getProductsCountAttribute()
    {
        return $this->products()->count();
    }

    public function getCanDelAttribute()
    {
        $b1=0;
        $b2=$this->products()->count();
        return $b1+$b2 == 0 ? true:false;
    }
    public function getImageThumbnailAttribute()
    {
        $logo=$this->attributes['logo'];

        return $logo?asset('uploads/thumbnail/'.$logo):asset('uploads/thumbnail/avatar.png');
    }

    public function getImageUrlAttribute()
    {
        $logo=$this->attributes['logo'];

        return $logo?asset('uploads/'.$logo):asset('uploads/avatar.png');
    }

}
