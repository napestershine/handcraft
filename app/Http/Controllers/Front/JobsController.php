<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Docs\JobsDocController;
use App\Models\Category;
use App\Models\City;
use App\Models\Job;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class JobsController extends JobsDocController
{
    public function __construct()
    {
        //TODO::AUTH
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $statusCode = 200;

            // get instance of Eloquent
            $builder = Job::query();

            // filter by category
            if ($request->get('category_id')) {
                $builder->where('category_id', 'LIKE', $request->get('category_id'));
            }

            // filter by region/ city
            if ($request->get('city_id')) {
                $builder->where('city_id', 'LIKE', $request->get('city_id'));
            }

            if (!empty(\Auth::guard()->user())) {
                $builder->where('user_id', '!=', $this->getUser()->id);
            }

            $builder->where('created_at', '>=', Carbon::today()->subDays(30));

            $response = $builder->orderBy('created_at', 'desc')->get();
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
            $job = new Job();
            $this->validate($request, Job::getRules(), Job::getMessages());
            $data = $request->all();
            $city = City::findOrFail($data['city_id']);
            $category = Category::findOrFail($data['category_id']);
            $user = User::findOrFail($data['user_id']);
            $data['city_id'] = $city->id;
            $data['category_id'] = $category->id;
            $data['user_id'] = $user->id;
            $job->fill($data);
            $job->save();
            $response = $job;
        } catch (ModelNotFoundException $e) {
            $statusCode = 404;
            $response = ['error' => 'Required field not found'];
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
            $response = Job::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            $statusCode = 404;
            $response = ['error' => 'Job not found'];
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
        try {
            $statusCode = 200;
            $job = Job::findOrFail($id);
            $this->validate($request, Job::getRules(), Job::getMessages());
            $data = $request->all();

            $city = City::findOrFail($data['city_id']);
            $category = Category::findOrFail($data['category_id']);
            $user = User::findOrFail($data['user_id']);
            $data['city_id'] = $city->id;
            $data['category_id'] = $category->id;
            $data['user_id'] = $user->id;
            $job->fill($data);
            $job->save();
            $response = $job;
        } catch (ModelNotFoundException $e) {
            $statusCode = 404;
            $response = ['error' => 'Resource not found'];
        } catch (ValidationException $e) {
            $statusCode = 400;
            $response = ['error' => 'Validation Error', 'message' => $e->getMessage()];
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
            $job = Job::findOrFail($id);
            $job->delete();
        } catch (ModelNotFoundException $e) {
            $statusCode = 404;
            $response = ['error' => 'Job not found'];
        } catch (\Exception $e) {
            $statusCode = 500;
            $response = ['error' => 'Internal error'];
        }
        return response()->json($response, $statusCode);
    }
}
