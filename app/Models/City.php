<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class City
 * @package App\Models
 *
 * @SWG\Definition(type="object", @SWG\Xml(name="City"), required={"name","zip"})
 *
 * @SWG\Property(type="string", property="name", description="The name of the City.")
 * @SWG\Property(type="integer", property="zip", description="The zip code of the City.")
 * @SWG\Property(type="string", property="slug", description="The slug to show in urls for SEO purpose.")
 *
 */
class City extends Model
{
    use SoftDeletes;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'zip', 'slug'
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
        'name' => 'required|max:100|string|unique:cities',
        'zip' => 'required|integer|unique:cities',
        'slug' => 'nullable|string|max:255',
    ];

    /**
     * @var array
     */
    protected static $messages = [
        'name.required' => 'Name is required',
        'name.string' => 'Name must be string',
        'name.unique' => 'Name already exists',
        'zip.required' => 'Zip Code is required',
        'zip.integer' => 'Zip Code must be string',
        'zip.unique' => 'Zip Code already exists',
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
     * @param $zip
     * @return bool
     * @throws \Exception
     */
    public function validateZip($zip)
    {
        $ZIPREG = "\b((?:0[1-46-9]\d{3})|(?:[1-357-9]\d{4})|(?:[4][0-24-9]\d{3})|(?:[6][013-9]\d{3}))\b";

        if (!preg_match("/" . $ZIPREG . "/i", $zip)) {
            throw new \Exception('Zip code is invalid!');
        }
        return true;
    }
}
