<?php

namespace App\Http\Controllers\Docs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

abstract class OrderController extends Controller
{
    /**
     * @SWG\Post(path="/orders",
     *   tags={"Order"},
     *   summary="Creates a new order with given input array",
     *   description="Store a new order in database.",
     *   operationId="createOrder",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="body",
     *     name="body",
     *     description="Order object",
     *     required=true,
     *     @SWG\Schema(ref="#/definitions/Order")
     *   ),
     *   @SWG\Response(response="200", description="successful operation")
     * )
     */
    abstract public function store(Request $request);

    /**
     * @SWG\Get(
     *     path="/orders/{id}",
     *     summary="Get Order Information",
     *     tags={"Order"},
     *     description="Get Order Information by Order ID.",
     *     operationId="id",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="Order ID",
     *         required=true,
     *         type="integer",
     *         format="int64"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(
     *             type="file",
     *             @SWG\Schema(ref="#/definitions/Order")
     *         ),
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Invalid parameter value",
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="Order Not Found",
     *     )
     * )
     */
    abstract public function getStatus($id);
}