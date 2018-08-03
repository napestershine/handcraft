<?php

namespace App\Http\Controllers\Docs;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

abstract class UserController extends Controller
{
    /**
     * @SWG\Get(
     *     path="/user",
     *     summary="Get User Information",
     *     tags={"User"},
     *     description="Get User Information by User ID.",
     *     operationId="id",
     *     produces={"application/json"},
     *
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(
     *             type="file",
     *             @SWG\Schema(ref="#/definitions/User")
     *         ),
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Invalid parameter value",
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="User Not Found",
     *     )
     * )
     */
    abstract public function show() : JsonResponse;

    /**
     * @SWG\Get(
     *     path="/users/{id}/orders",
     *     summary="Get User Orders Information",
     *     tags={"User"},
     *     description="Get User Orders Information by User ID.",
     *     operationId="userOrders",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="User ID",
     *         required=true,
     *         type="integer",
     *         format="int64"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Unauthorized.",
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Invalid parameter value",
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="User Not Found",
     *     )
     * )
     */
    abstract public function getUserOrders($id);

}