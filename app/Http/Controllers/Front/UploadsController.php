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

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;
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
     *
     * @SWG\Post(path="/upload",
     *   tags={"Image Upload"},
     *   summary="Uploads a new image in server date wise",
     *   description="Store a new image in public directory.",
     *   operationId="uploadImage",
     *   consumes={"multipart/form-data"},
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     description="image file to upload",
     *     in="formData",
     *     name="file",
     *     required=true,
     *     type="file"
     *   ),
     *   @SWG\Response(response="200", description="successful operation")
     * )
     */
    public function fileUpload(Request $request): JsonResponse
    {
        try {
            $statusCode = 200;
            $this->validate($request, [
                'file' => 'required'
            ]);
            $dir = 'upload/' . date('Y-m', time()) . '/';
            $path = static::uploadImage($request->file, $dir);
            $response = compact('path');

        } catch (ValidationException $e) {
            $statusCode = 400;
            $response = ['error' => 'Validation Error', 'message' => $e->errors()];
        } catch (\Exception $e) {
            $statusCode = 500;
            $response = ['error' => 'Internal error', 'message' => $e->getMessage()];
        }

        return response()->json($response, $statusCode);
    }

    /**
     * Upload an image
     *
     * @param UploadedFile $image
     * @param $dir
     * @param int $width
     * @param int $height
     * @param null $imgName
     * @return string $path
     */
    public static function uploadImage(UploadedFile $image, $dir, $width = 0, $height = 0, $imgName = null)
    {
        // if directory doesn't exist then create it
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
        if ($dir[strlen($dir) - 1] !== '/') {
            $dir .= '/';
        }

        $img = Image::make($image);
        if ($width > 0 && $height > 0) {
            $img->resize($width, $height);
        }
        $ext = pathinfo($image->getClientOriginalName(), PATHINFO_EXTENSION);
        $imgName = ($imgName === null) ? Str::slug(Str::random(32)) . '.' . $ext : $imgName;
        $path = $dir . $imgName;
        $img->save($path);
        return  url('/'.$path);
    }

}