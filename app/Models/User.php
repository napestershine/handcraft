<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Swagger\Annotations as SWG;


/**
 * @SWG\Definition(type="object", @SWG\Xml(name="User"),
 *     required={"name","email","password","phone",})
 *
 * @SWG\Property(type="string", property="name", description="The name of the user.")
 * @SWG\Property(type="string", property="phone", description="The contact phone of the user.")
 * @SWG\Property(type="string", property="email", description="The email address of the user.")
 * @SWG\Property(type="string", property="password", description="The password of the user.")
 *
 */
class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Validator, SoftDeletes, Authenticatable, Authorizable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'phone', 'email', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'created_at', 'updated_at', 'deleted_at'
    ];

    /**
     * Validation rules for user
     *
     * @var array
     */
    protected $rules = [
        'name' => 'bail|required|max:255',
        'email' => 'bail|required|unique:users|max:255',
        'password' => 'bail|required|max:255',
        'phone' => 'required|unique:users|max:255',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Get the orders associated with the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders() {
        return $this->hasMany(Order::class);
    }
    /**
     * Get the tokens associated with the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function oauthAcessTokens(){
        return $this->hasMany(OauthAccessToken::class);
    }

    /**
     * @param $data
     * @return array
     */
    public function saveUser($data) {

        if ($this->validate($data) === true) {
            $data['password'] = app('hash')->make($data['password']);
            $this->fill($data);

            $emailExist = self::where(['email' => $this->email])->first();
            $phoneExist = self::where(['phone' => $this->phone])->first();

            if ($emailExist) {
                return [
                    'status' => 0,
                    'error_type' => 'DUPLICATE_RECORD',
                    'error_message' => 'Email already registered. Please login.'
                ];
            }
            if ($phoneExist) {
                return [
                    'status' => 0,
                    'error_type' => 'DUPLICATE_RECORD',
                    'error_message' => 'Mobile already registered with us.'
                ];
            }

            try {
                $this->save();
            } catch (\PDOException $e) {
                return [
                    'status' => 0,
                    'error_type' => 'PDO_ERROR',
                    'error_message' => 'Not able to save data. ' . $e->getMessage()
                ];
            }
            return [
                'status' => 1,
                'data' => $this
            ];

        }
        return [
            'status' => 0,
            'error_type' => 'DATA_SEMANTIC_ERROR',
            'error_message' => json_encode($this->validate($data))
        ];
    }

    /**
     * @param $email
     * @return bool
     */
    public static function emailExists($email) {

        $user = self::where('email', $email)->first();

        return null !== $user;
    }

    public function findForPassport($identifier) {
        return $this->orWhere('email', $identifier)->orWhere('phone', $identifier)->first();
    }
}
