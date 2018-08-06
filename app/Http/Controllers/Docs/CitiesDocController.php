<?php

namespace App\Http\Controllers\Docs;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

abstract class CitiesDocController extends BaseController
{
    /**
     * @SWG\Get(
     *     path="/cities",
     *     summary="List of all the cities",
     *     tags={"City"},
     *     description="List of all the cities in the database.",
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
    abstract public function index(Request $request);

    /**
     * @SWG\Post(path="/cities",
     *   tags={"City"},
     *   summary="Creates a new city with given input array",
     *   description="Store a new city in database.",
     *   operationId="createCity",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="body",
     *     name="body",
     *     description="City object",
     *     required=true,
     *     @SWG\Schema(ref="#/definitions/City")
     *   ),
     *   @SWG\Response(response="200", description="successful operation")
     * )
     */
    abstract public function store(Request $request);

    /**
     * @SWG\Get(
     *     path="/cities/{id}",
     *     summary="Get City Information",
     *     tags={"City"},
     *     description="Get City Information by City ID.",
     *     operationId="id",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="City ID",
     *         required=true,
     *         type="integer",
     *         format="int64"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(ref="#/definitions/City"),
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Invalid parameter value",
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="City Not Found",
     *     )
     * )
     */
    abstract public function show($id);

    /**
     * @SWG\Put(path="/cities/{id}",
     *   tags={"City"},
     *   summary="Updated city",
     *   description="Update City. This can only be done by the logged in user.",
     *   operationId="updateCity",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     description="the City ID that need to be updated",
     *     required=true,
     *     type="integer",
     *     format="int64"
     *   ),
     *   @SWG\Parameter(
     *     in="body",
     *     name="body",
     *     description="Updated city object",
     *     required=true,
     *     @SWG\Schema(ref="#/definitions/City")
     *   ),
     *   @SWG\Response(response=400, description="Invalid City ID supplied"),
     *   @SWG\Response(response=404, description="City not found")
     * )
     */
    abstract public function update(Request $request, $id);

    /**
     * @SWG\Delete(path="/cities/{id}",
     *   tags={"City"},
     *   summary="Delete city",
     *   description="This can only be done by the logged in user.",
     *   operationId="deleteCity",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     description="The City ID that needs to be deleted",
     *     required=true,
     *     type="integer",
     *     format="int64"
     *   ),
     *   @SWG\Response(response=400, description="Invalid City ID supplied"),
     *   @SWG\Response(response=404, description="City not found")
     * )
     */
    abstract public function destroy($id);
}