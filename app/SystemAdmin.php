<?php
namespace App;
use App\Models\AdminRule;
use function foo\func;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
/**
 * App\SystemAdmin
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $mobile
 * @property string $password
 * @property int $status
 * @property string|null $avatar
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AdminRule[] $Rules
 * @property-read int|null $rules_count
 * @property-read mixed $image_url
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SystemAdmin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SystemAdmin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SystemAdmin query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SystemAdmin whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SystemAdmin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SystemAdmin whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SystemAdmin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SystemAdmin whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SystemAdmin whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SystemAdmin wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SystemAdmin whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SystemAdmin whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SystemAdmin whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SystemAdmin extends Authenticatable
{
    //
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'sms_activation_code', 'password_reset_code', 'key', 'remember_token',
    ];

    protected $guard = "system_admin";

    public function Rules(){
        return $this->hasMany(AdminRule::class,'admin_id');
    }

    public function getImageUrlAttribute()
    {
        return $this->avatar?asset('uploads/'.$this->avatar):asset('admin/imgs/logo.png');
    }

    public function hasRole($role,$where){
        if($this->id != 1){
            $role=strtolower(trim($role));
            $where=strtolower(trim($where));
            if($this->Rules()->whereHas('Rule',function ($qq) use ($role){
              $qq->where('name',$role);
            })->whereHas('Module',function ($qq) use ($where){
              $qq->where('name',$where);
            })->first()){
                return true;
            }
        }else{
            return true;
        }
        return false;
    }

}
