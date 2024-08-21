<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\PasswordReset
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PasswordReset newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PasswordReset newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PasswordReset query()
 * @mixin \Eloquent
 */
class PasswordReset extends Model{
    public $timestamps=false;
    protected $table = 'password_reset';

}
