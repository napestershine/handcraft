<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Docs\CategoriesDocController;
use App\Models\Category;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CategoriesController extends CategoriesDocController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $statusCode = 200;
            //  $response = Category::paginate(20);
            $response = Category::all();
        } catch (\Exception $e) {
            $statusCode = 500;
            $response = ['error' => 'Internal error'];
        }

        return response()->json($response, $statusCode);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $statusCode = 201;
            $category = new Category();
            $this->validate($request, Category::getRules(), Category::getMessages());
            $data = $request->all();
            $data['slug'] = str_replace(' ', '-', strtolower($data['name']));
            $category->fill($data);
            $category->save();
            $response = $category;
        } catch (ValidationException $e) {
            $statusCode = 400;
            $response = ['error' => 'Validation Error', 'message' => $e->errors()];
        } catch (\PDOException $e) {
            $statusCode = 400;
            $response = ['error' => 'Database Error', 'message' => $e->getMessage()];
        } catch (\Exception $e) {
            $statusCode = 500;
            $response = ['error' => 'Internal error'];
        }

        return response()->json($response, $statusCode);
    }

    /**
     * Display the specified resource.
     *
     * @param  $address_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $statusCode = 200;
            $response = Category::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            $statusCode = 404;
            $response = ['error' => 'Category not found'];
        } catch (\Exception $e) {
            $statusCode = 500;
            $response = ['error' => 'Internal error'];
        }
        return response()->json($response, $statusCode);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  $address_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $rules = Category::getRules();
        $rules['name'] = $rules['name'] . ',id,' . $id;
        $rules['uid'] = $rules['uid'] . ',id,' . $id;

        try {
            $statusCode = 200;
            $category = Category::findOrFail($id);

            $this->validate($request, $rules, Category::getMessages());
            $data = $request->all();
            $data['slug'] = str_replace(' ', '-', strtolower($data['name']));
            $category->fill($data);
            $category->save();
            $response = $category;
        } catch (ModelNotFoundException $e) {
            $statusCode = 404;
            $response = ['error' => 'Category not found'];
        } catch (ValidationException $e) {
            $statusCode = 400;
            $response = ['error' => 'Validation Error', 'message' => $e->errors()];
        } catch (\PDOException $e) {
            $statusCode = 400;
            $response = ['error' => 'Database Error', 'message' => $e->getMessage()];
        } catch (\Exception $e) {
            $statusCode = 500;
            $response = ['error' => 'Internal error'];
        }

        return response()->json($response, $statusCode);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $address_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        try {
            $statusCode = 200;
            $response = 'success';
            $category = Category::findOrFail($id);
            $category->delete();
        } catch (ModelNotFoundException $e) {
            $statusCode = 404;
            $response = ['error' => 'Category not found'];
        } catch (\Exception $e) {
            $statusCode = 500;
            $response = ['error' => 'Internal error'];
        }
        return response()->json($response, $statusCode);
    }
}
