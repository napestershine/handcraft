<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Order
 *
 * @SWG\Definition(type="object", @SWG\Xml(name="Order"), required={"user_id","status","source", "destination"})
 *
 * @SWG\Property(type="integer", property="user_id", description="The user identifier for the order.")
 * @SWG\Property(type="string", property="status", description="The status identifier for the order.")
 * @SWG\Property(type="string", property="source", description="The source identifier for the order.")
 * @SWG\Property(type="string", property="destination", description="The destination on the order.")
 * @SWG\Property(type="string", property="pick_time", description="The pick time on the order.")
 * @SWG\Property(type="string", property="discount", description="The discount on the order.")
 * @SWG\Property(type="string", property="total", description="The total amount of the order.")
 *
 * @mixin \Eloquent
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereUpdatedAt($value)
 * @property \Carbon\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order withoutTrashed()
 */
class Order extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'status', 'source', 'destination', 'total', 'discount', 'pick_time'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * Get the user that owns this order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo(User::class);
    }
}
