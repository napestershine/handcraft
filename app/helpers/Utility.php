<?php
/**
 * Created by PhpStorm.
 * Filename: Utility.php,
 * Description:
 * User: Manoj Kumar
 * Date: 8/6/2018
 * Time: 1:41 PM
 */

namespace App\helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

/**
 * Class Utility
 * @package App\helpers
 */
class Utility
{

    /**
     * Returns the extension of an image by its mime type (if any)
     *
     * @param string $imageType
     *
     * @return bool|string
     */
    public static function get_extension($imageType)
    {
        if (empty($imageType)) return false;
        switch ($imageType) {
            case 'image/jpeg':
                return '.jpg';
            case 'image/svg':
                return '.svg';
            case 'image/x-icon':
                return '.ico';
            case 'image/png':
                return '.png';
            default:
                return false;
        }
    }

    /**
     * Generates a random image name with proper extension by taking its mime type
     *
     * @param string $mimeType
     *
     * @return string
     *
     */
    public static function imageName($mimeType)
    {
        $imgName = Str::slug(Str::random(32));
        $imgName .= self::get_extension($mimeType);
        return $imgName;
    }

    /**
     * Upload an image
     *
     * @param UploadedFile $image
     * @param $dir
     * @param int $width
     * @param int $height
     * @param null $imgName
     * @return null|string
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
        $imgName = ($imgName === null) ? self::imageName($img->mime) : $imgName;
        $img->save($dir . $imgName);

        return $imgName;
    }
}