<?php

namespace App\Http\Controllers\Auth;

use App\helpers\ErrorResponse;
use App\Http\Controllers\Docs\AuthController as Auth;
use App\Models\User;
use App\Notifications\UserHasRegistered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

/**
 * Class RegisterController
 * @package App\Http\Controllers\Auth\User
 */
class AuthController extends Auth
{
    use ErrorResponse;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $apiConfig;

    public function __construct() {
        $this->apiConfig = config('api');
    }

    /**
     * @param Request $request
     * @return array|\Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function login(Request $request) {
        $data = $request->all();

        if (isset($data['email'], $data['password'])) {
            if (!User::emailExists($data['email'])) {
                return $this->generateErrorResponse('EMAIL_NOT_FOUND', 'Email is not registered with us!');
            }

            return $this->getTokens($data['email'], $data['password']);
        }
        if (!isset($data['email'])) {
            $message = 'Email is required!';
        }
        if (!isset($data['password'])) {
            $message = 'Password is required!';
        }

        return $this->generateErrorResponse('DATA_SEMANTIC_ERROR', $message);
    }

    public function register(Request $request) {

        $user = new User();
        $result = $user->saveUser($request->all());
        if ($result['status']) {

            return $this->getTokens($result['data']['email'], $request->all()['password']);

        }
        return $this->generateErrorResponse($result['error_type'], $result['error_message']);
    }

    /**
     * @param $email
     * @param $password
     * @return mixed
     */
    public function getTokens($email, $password) {
        $proxy = Request::create(
            '/oauth/token',
            'post',
            [
                'username' => $email,
                'client_id' => $this->apiConfig['client_id'],
                'client_secret' => $this->apiConfig['client_secret'],
                'grant_type' => 'password',
                'password' => $password,
                'scope' => 'user'
            ]
        );

        return App::dispatch($proxy);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function refreshToken(Request $request) {

        $proxy = Request::create(
            '/oauth/token/refresh',
            'post',
            [
                'refresh_token' => $request->refresh_token,
                'client_id' => $this->apiConfig['client_id'],
                'client_secret' => $this->apiConfig['client_secret'],
                'grant_type' => 'refresh_token',
                'scope' => 'user'
            ]
        );
        return App::dispatch($proxy);
    }

}