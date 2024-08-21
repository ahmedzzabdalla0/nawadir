<?php
namespace App\Models;

use App\Traits\MultiLanguage;
use \Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * App\Models\Page
 *
 * @property int $id
 * @property string $title_ar
 * @property string $title_en
 * @property string $text_ar
 * @property string $text_en
 * @property string|null $created_at
 * @property string|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page whereTextAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page whereTextEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page whereTitleAr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page whereTitleEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Page extends Eloquent{
    public $timestamps=false;
    protected $table = 'pages';
    protected $hidden=['created_at','updated_at'];
    use MultiLanguage;

    protected $multi_lang = ['title','text'];
}
