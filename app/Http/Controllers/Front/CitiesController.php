<?php

namespace App\Http\Controllers\Front;


use App\Http\Controllers\Docs\CitiesDocController;
use App\Models\City;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CitiesController extends CitiesDocController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $statusCode = 200;
            if (!empty($request->get('zip'))) {
                $response = City::where('zip', 'like', '%' . $request->get('zip') . '%')->get();
            } else {
                $response = City::all();
            }
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
            $city = new City();
            $this->validate($request, City::getRules(), City::getMessages());
            $data = $request->all();
            $data['slug'] = str_replace(' ', '-', strtolower($data['name']));
            $city->validateZip($data['zip']);
            $city->fill($data);
            $city->save();
            $response = $city;
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
            $response = City::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            $statusCode = 404;
            $response = ['error' => 'City not found'];
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
        $rules = City::getRules();
        $rules['name'] = $rules['name'] . ',id,' . $id;
        $rules['zip'] = $rules['zip'] . ',id,' . $id;

        try {
            $statusCode = 200;
            $city = City::findOrFail($id);
            $this->validate($request, $rules, City::getMessages());
            $data = $request->all();
            $data['slug'] = str_replace(' ', '-', strtolower($data['name']));
            $city->validateZip($data['zip']);
            $city->fill($data);
            $city->save();
            $response = $city;
        } catch (ModelNotFoundException $e) {
            $statusCode = 404;
            $response = ['error' => 'City not found'];
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
            $city = City::findOrFail($id);
            $city->delete();
        } catch (ModelNotFoundException $e) {
            $statusCode = 404;
            $response = ['error' => 'City not found'];
        } catch (\Exception $e) {
            $statusCode = 500;
            $response = ['error' => 'Internal error'];
        }
        return response()->json($response, $statusCode);
    }
}
