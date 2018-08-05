<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Docs\JobsDocController;
use App\Models\Job;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
    public function index(): JsonResponse
    {
        try {
            $statusCode = 200;
            //  $response = Job::paginate(20);
            $response = Job::all();
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
            $city = new Job();
            $this->validate($request, Job::getRules(), Job::getMessages());
            $data = $request->all();
            $data['slug'] = str_replace(' ', '-', strtolower($data['name']));
            $city->fill($data);
            $city->save();
            $response = $city;
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
        $rules = Job::getRules();
        $rules['name'] = $rules['name'] . ',id,' . $id;
        $rules['zip'] = $rules['zip'] . ',id,' . $id;
        dd($this->validate($request, $rules, Job::getMessages()));
        try {
            $statusCode = 200;
            $city = Job::findOrFail($id);
            $this->validate($request, $rules, Job::getMessages());
            $data = $request->all();
            $data['slug'] = str_replace(' ', '-', strtolower($data['name']));
            $city->fill($data);
            $city->save();
        } catch (ModelNotFoundException $e) {
            $statusCode = 404;
            $response = ['error' => 'Job not found'];
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
            $city = Job::findOrFail($id);
            $city->delete();
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
