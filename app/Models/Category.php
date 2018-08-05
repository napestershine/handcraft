<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'uid', 'slug', 'image'
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
        'name' => 'required|max:100|string|unique:categories',
        'uid' => 'required|integer|unique:categories',
        'image' => 'nullable|string|max:255',
        'slug' => 'nullable|string|max:255',
    ];

    /**
     * @var array
     */
    protected static $messages = [
        'name.required' => 'Name is required',
        'name.string' => 'Name must be string',
        'name.unique' => 'Name already exists',
        'uid.required' => 'UID is required',
        'uid.integer' => 'UID must be string',
        'uid.unique' => 'UID already exists',
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
}
