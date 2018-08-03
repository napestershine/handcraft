<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Docs\UserController;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UsersController extends UserController
{


    /**
     * @return JsonResponse
     * @throws \Exception
     */
    public function show(): JsonResponse {
        $user = \Auth::guard()->user();
        if (empty($user)) {
            throw new \Exception('User not found');
        }
        return response()->json($user);
    }

    public function logout() {
        if (\Auth::check()) {
            \Auth::guard()->user()->oauthAcessTokens()->delete();
        }
    }

    /**
     * Get User's recent orders
     *
     * @param $id
     * @return JsonResponse
     */
    public function getUserOrders($id): JsonResponse {
        $user = User::find($id);
        if (empty($user)) {
            return response()->json('User not found', 404);
        }
        $orders = $user->orders()->orderBy('created_at', 'desc')->get();
        return response()->json($orders, 200);
    }
}
