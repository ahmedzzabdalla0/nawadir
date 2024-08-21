<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;



/**
 * App\Models\WorkEvent
 *
 * @property int $id
 * @property string $title
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $color
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WorkEvent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WorkEvent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WorkEvent query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WorkEvent whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WorkEvent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WorkEvent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WorkEvent whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WorkEvent whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class WorkEvent extends Model
{
    protected $table='workevents';

}
