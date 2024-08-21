<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Contact
 *
 * @property int $id
 * @property string $name
 * @property string $mobile
 * @property string $email
 * @property string $title
 * @property string $details
 * @property int $user_id
 * @property int $is_artist
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereIsArtist($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Contact whereUserId($value)
 * @mixin \Eloquent
 */
class Contact extends Model
{
    protected $table='contact_us';
    protected $hidden=['created_at','updated_at'];

    //
    public static $getRoles=[
        "id"=>"required|exists:countries",
    ];

    public static  $createRoles = [
        "name_en"=>"required|string|min:3",
        "name_ar"=>"required|string|min:3",
    ];
    public static  $updateRoles = [
        "id"=>"required|exists:countries",
        "name_en"=>"required|string|min:3",
        "name_ar"=>"required|string|min:3",
    ];

}
