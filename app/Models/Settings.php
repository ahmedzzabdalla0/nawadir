<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Settings
 *
 * @property int $id
 * @property string $name
 * @property string $value
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Settings whereValue($value)
 * @mixin \Eloquent
 */
class Settings extends Model{
    protected $table = 'settings';
    protected $fillable=['name','value'];
    public $timestamps=false;
}
