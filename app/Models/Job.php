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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Job whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Job whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Job whereUpdatedAt($value)
 * @property \Carbon\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Job onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Job whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Job withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Job withoutTrashed()
 */
class Job extends Model
{
    use SoftDeletes;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'execution', 'status', 'user_id', 'city_id', 'category_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Validation rules for user
     *
     * @var array
     */
    protected static $rules = [
        'title' => 'required|max:50|min:5|string',
        'description' => 'required|string',
        'execution' => 'required|string',
        'status' => 'required|string|max:25',
        'user_id' => 'required|integer',
        'city_id' => 'required|integer',
        'category_id' => 'required|integer'
    ];

    /**
     * @var array
     */
    protected static $messages = [
        'title.required' => 'Title is required',
        'title.string' => 'Title must be string',
        'title.max' => 'Title must not more than 50 character',
        'title.min' => 'Title must not less than 5 character',
        'description.required' => 'Description is required',
        'description.string' => 'Description must be string',
        'execution.required' => 'Execution is required',
        'execution.string' => 'Execution must be string',
        'user_id.required' => 'Valid user is required',
        'city_id.required' => 'City is required',
        'category_id.required' => 'Category is required'
    ];

    /**
     * @return array
     */
    public static function getRules()
    {
        return static::$rules;
    }

    /**
     * @return array
     */
    public static function getMessages()
    {
        return static::$messages;

    }


    /**
     * Get the User that belongs to this job.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the category that belongs to this job.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the city that belongs to this job.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
