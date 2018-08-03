<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Docs\OrderController;
use App\Models\Order;
use App\Models\Restaurant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrdersController extends OrderController
{

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): JsonResponse {
        $this->validate($request, [
            'user_id' => 'bail|required',
            'status' => 'bail|required|max:255',
            'source' => 'bail|required|max:255',
            'destination' => 'required|max:255',
        ]);

        $order = Order::create($request->all());
        return response()->json($order, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStatus($id): JsonResponse {
        $order = Order::find($id);
        if (empty($order)) {
            return response()->json('Not found', 404);
        }
        return response()->json($order->status, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id): JsonResponse {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id): JsonResponse {
        //
    }
}
