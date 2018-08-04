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
    public function index(): JsonResponse {
        $user = $this->getUser();
        $addresses = $user->addresses()->orderBy('name')->get();
        return response()->json(['status'=>0,'msg'=>'success','data'=>$addresses], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse {

        $user = $this->getUser();

        $data = $this->validate($request, [
            'country_id' => 'required|integer',
            'province_id' => 'required|integer',
            'city_id' => 'required|integer',
            'name' => 'required|max:30',
            'phone' => 'required|max:20',
            'full_address' => 'max:255',
        ]);
        $data['user_id']=$user->id;

        if(Address::create($data)){
            return response()->json(['status'=>0,'msg'=>'success'], 200);
        } else {
            return response()->json(['status'=>__LINE__,'msg'=>'Database create address error'], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  $address_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($address_id): JsonResponse {
        $address = Address::find($address_id);
        if (empty($address->id)) {
            return response()->json(['status'=>__LINE__,'msg'=>'Address not found'], 404);
        }
        return response()->json(['status'=>0,'msg'=>'success','data'=>$address], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $address_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request,$address_id): JsonResponse {

        $user = $this->getUser();
        $data = $this->validate($request,[
            'country_id' => 'integer',
            'province_id' => 'integer',
            'city_id' => 'integer',
            'name' => 'max:30',
            'phone' => 'max:20',
            'full_address' => 'max:255',
        ]);
        $address = Address::where('user_id', $user->id)->where('id',$address_id)->first();
        if (empty($address->id)) {
            return response()->json(['status'=>__LINE__,'msg'=>'Address not found'], 404);
        } else if($address->update($data)){
            return response()->json(['status'=>0,'msg'=>'success'], 200);
        } else {
            return response()->json(['status'=>__LINE__,'msg'=>'Database update address error'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $address_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($address_id): JsonResponse {
        $user = $this->getUser();
        $address = Address::where('user_id', $user->id)->where('id',$address_id)->first();
        if (empty($address->id)) {
            return response()->json(['status'=>__LINE__,'msg'=>'Address not found'], 404);
        }
        $address->delete();
        return response()->json(['status'=>0,'msg'=>'success'], 200);
    }
}
