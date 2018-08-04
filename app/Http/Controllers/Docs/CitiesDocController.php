<?php

namespace App\Http\Controllers\Docs;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

abstract class CitiesDocController extends BaseController
{
    /**
     * @SWG\Get(
     *     path="/addresses",
     *     summary="List of all the addresses",
     *     tags={"Address"},
     *     description="List of all the addresses in the database.",
     *     produces={"application/json"},
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Unauthorized.",
     *     )
     * )
     */
    abstract public function index();

    /**
     * @SWG\Post(path="/addresses",
     *   tags={"Address"},
     *   summary="Creates a new address with given input array",
     *   description="Store a new address in database.",
     *   operationId="createAddress",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="body",
     *     name="body",
     *     description="Address object",
     *     required=true,
     *     @SWG\Schema(ref="#/definitions/Address")
     *   ),
     *   @SWG\Response(response="200", description="successful operation")
     * )
     */
    abstract public function store(Request $request);

    /**
     * @SWG\Get(
     *     path="/addresses/{id}",
     *     summary="Get Address Information",
     *     tags={"Address"},
     *     description="Get Address Information by Address ID.",
     *     operationId="id",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="Address ID",
     *         required=true,
     *         type="integer",
     *         format="int64"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(ref="#/definitions/Address"),
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Invalid parameter value",
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="Address Not Found",
     *     )
     * )
     */
    abstract public function show($id);

    /**
     * @SWG\Put(path="/addresses/{id}",
     *   tags={"Address"},
     *   summary="Updated address",
     *   description="Update Address. This can only be done by the logged in user.",
     *   operationId="updateAddress",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     description="the Address ID that need to be updated",
     *     required=true,
     *     type="integer",
     *     format="int64"
     *   ),
     *   @SWG\Parameter(
     *     in="body",
     *     name="body",
     *     description="Updated address object",
     *     required=true,
     *     @SWG\Schema(ref="#/definitions/Address")
     *   ),
     *   @SWG\Response(response=400, description="Invalid Address ID supplied"),
     *   @SWG\Response(response=404, description="Address not found")
     * )
     */
    abstract public function update(Request $request, $id);

    /**
     * @SWG\Delete(path="/addresses/{id}",
     *   tags={"Address"},
     *   summary="Delete address",
     *   description="This can only be done by the logged in user.",
     *   operationId="deleteAddress",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     description="The Address ID that needs to be deleted",
     *     required=true,
     *     type="integer",
     *     format="int64"
     *   ),
     *   @SWG\Response(response=400, description="Invalid Address ID supplied"),
     *   @SWG\Response(response=404, description="Address not found")
     * )
     */
    abstract public function destroy($id);
}