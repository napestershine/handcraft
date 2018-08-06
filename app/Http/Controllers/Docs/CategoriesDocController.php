<?php

namespace App\Http\Controllers\Docs;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

abstract class CategoriesDocController extends BaseController
{
    /**
     * @SWG\Get(
     *     path="/categories",
     *     summary="List of all the categories",
     *     tags={"Category"},
     *     description="List of all the categories in the database.",
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
     * @SWG\Post(path="/categories",
     *   tags={"Category"},
     *   summary="Creates a new category with given input array",
     *   description="Store a new category in database.",
     *   operationId="createCategory",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="body",
     *     name="body",
     *     description="Category object",
     *     required=true,
     *     @SWG\Schema(ref="#/definitions/Category")
     *   ),
     *   @SWG\Response(response="200", description="successful operation")
     * )
     */
    abstract public function store(Request $request);

    /**
     * @SWG\Get(
     *     path="/categories/{id}",
     *     summary="Get Category Information",
     *     tags={"Category"},
     *     description="Get Category Information by Category ID.",
     *     operationId="id",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         description="Category ID",
     *         required=true,
     *         type="integer",
     *         format="int64"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="successful operation",
     *         @SWG\Schema(ref="#/definitions/Category"),
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Invalid parameter value",
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="Category Not Found",
     *     )
     * )
     */
    abstract public function show($id);

    /**
     * @SWG\Put(path="/categories/{id}",
     *   tags={"Category"},
     *   summary="Updated category",
     *   description="Update Category. This can only be done by the logged in user.",
     *   operationId="updateCategory",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     description="the Category ID that need to be updated",
     *     required=true,
     *     type="integer",
     *     format="int64"
     *   ),
     *   @SWG\Parameter(
     *     in="body",
     *     name="body",
     *     description="Updated category object",
     *     required=true,
     *     @SWG\Schema(ref="#/definitions/Category")
     *   ),
     *   @SWG\Response(response=400, description="Invalid Category ID supplied"),
     *   @SWG\Response(response=404, description="Category not found")
     * )
     */
    abstract public function update(Request $request, $id);

    /**
     * @SWG\Delete(path="/categories/{id}",
     *   tags={"Category"},
     *   summary="Delete category",
     *   description="This can only be done by the logged in user.",
     *   operationId="deleteCategory",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     description="The Category ID that needs to be deleted",
     *     required=true,
     *     type="integer",
     *     format="int64"
     *   ),
     *   @SWG\Response(response=400, description="Invalid Category ID supplied"),
     *   @SWG\Response(response=404, description="Category not found")
     * )
     */
    abstract public function destroy($id);
}