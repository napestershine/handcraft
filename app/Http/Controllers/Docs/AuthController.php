<?php

namespace App\Http\Controllers\Docs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

abstract class AuthController extends Controller
{
    /**
     * @SWG\Post(path="/auth/login",
     *   tags={"User"},
     *   summary="Login",
     *   description="This can only be done by the registered user.",
     *   operationId="loginUser",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *         name="email",
     *         in="formData",
     *         description="User Email Address",
     *         required=true,
     *         type="string",
     *         format="email"
     *   ),
     *   @SWG\Parameter(
     *         name="password",
     *         in="formData",
     *         description="User Password",
     *         required=true,
     *         type="string",
     *         format="string"
     *   ),
     *   @SWG\Response(response="default", description="successful operation")
     * )
     */
    abstract public function login(Request $request);

    /**
     * @SWG\Post(path="/auth/register",
     *   tags={"User"},
     *   summary="Register user",
     *   description="This can only be done by the guest user.",
     *   operationId="registerUser",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="body",
     *     name="body",
     *     description="Register(Create) new user object",
     *     required=true,
     *     @SWG\Schema(
     *       allOf={
     *         @SWG\Schema(ref="#/definitions/User"),
     *         @SWG\Schema(
     *           @SWG\Property(
     *             property="role",
     *             type="string",
     *             format="string"
     *           )
     *         ),
     *       }
     *     )
     *   ),
     *   @SWG\Response(response="default", description="successful operation")
     * )
     */
    abstract public function register(Request $request);

}