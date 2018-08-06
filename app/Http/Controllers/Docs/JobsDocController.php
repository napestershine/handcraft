<?php

namespace App\Http\Controllers\Docs;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

abstract class JobsDocController extends BaseController
{
    /**
     * @SWG\Get(
     *     path="/jobs",
     *     summary="List of all the jobs",
     *     tags={"Jobs"},
     *     description="List of all the jobs in the database.",
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
     * @SWG\Post(path="/jobs",
     *   tags={"Jobs"},
     *   summary="Creates a new job with given input array",
     *   description="Store a new job in database.",
     *   operationId="createJobs",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="body",
     *     name="body",
     *     description="Jobs object",
     *     required=true,
     *     @SWG\Schema(ref="#/definitions/Job")
     *   ),
     *   @SWG\Response(response="200", description="successful operation")
     * )
     */
    abstract public function store(Request $request);

    /**
     * @SWG\Get(
     *     path="/jobs/{id}",
     *     summary="Get Jobs Information",
     *     tags={"Jobs"},
     *     description="Get Jobs Information by Jobs ID.",
     *     operationId="id",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="Jobs ID",
     *         required=true,
     *         type="integer",
     *         format="int64"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(ref="#/definitions/Job"),
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Invalid parameter value",
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="Jobs Not Found",
     *     )
     * )
     */
    abstract public function show($id);

    /**
     * @SWG\Put(path="/jobs/{id}",
     *   tags={"Jobs"},
     *   summary="Updated job",
     *   description="Update Jobs. This can only be done by the logged in user.",
     *   operationId="updateJobs",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     description="the Jobs ID that need to be updated",
     *     required=true,
     *     type="integer",
     *     format="int64"
     *   ),
     *   @SWG\Parameter(
     *     in="body",
     *     name="body",
     *     description="Updated job object",
     *     required=true,
     *     @SWG\Schema(ref="#/definitions/Job")
     *   ),
     *   @SWG\Response(response=400, description="Invalid Jobs ID supplied"),
     *   @SWG\Response(response=404, description="Jobs not found")
     * )
     */
    abstract public function update(Request $request, $id);

    /**
     * @SWG\Delete(path="/jobs/{id}",
     *   tags={"Jobs"},
     *   summary="Delete job",
     *   description="This can only be done by the logged in user.",
     *   operationId="deleteJobs",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     description="The Jobs ID that needs to be deleted",
     *     required=true,
     *     type="integer",
     *     format="int64"
     *   ),
     *   @SWG\Response(response=400, description="Invalid Jobs ID supplied"),
     *   @SWG\Response(response=404, description="Jobs not found")
     * )
     */
    abstract public function destroy($id);
}