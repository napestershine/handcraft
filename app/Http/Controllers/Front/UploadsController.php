<?php
/**
 * Created by PhpStorm.
 * Filename: UploadsController.php,
 * Description:
 * User: Manoj Kumar
 * Date: 8/6/2018
 * Time: 1:54 PM
 */

namespace App\Http\Controllers\Front;


use App\helpers\Utility;
use App\Http\Controllers\BaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

/**
 * Class UploadsController
 * @package App\Http\Controllers\Front
 */
class UploadsController extends BaseController
{
    /**
     * Upload an image, create its thumbnails, store it in storage and return its path.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function fileUpload(Request $request): JsonResponse
    {
        try {
            $statusCode = 200;
            $this->validate($request, [
                'file' => 'required'
            ]);

            $dir = 'upload/' . date('Y-m', time()) . '/';
            $imageName = Utility::uploadImage($request->file, $dir);
            $response = [
                'data' => url($dir . Utility::uploadImage($request->file, $dir, 80, 80, $imageName))
                ];

        } catch (ValidationException $e) {
            $statusCode = 400;
            $response = ['error' => 'Validation Error', 'message' => $e->errors()];
        } catch (\Exception $e) {
            $statusCode = 500;
            $response = ['error' => 'Internal error', 'message' => $e->getMessage()];
        }

        return response()->json($response, $statusCode);
    }
}