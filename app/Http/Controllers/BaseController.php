<?php
/**
 * Created by PhpStorm.
 * Filename: BaseController.php,
 * Description:
 * User: Manoj Kumar
 * Date: 8/3/2018
 * Time: 9:42 PM
 */

namespace App\Http\Controllers;


class BaseController extends Controller
{
    protected $user;

    /**
     * @return mixed
     * @throws \Exception
     */
    public function getUser()
    {
        $this->user = \Auth::guard()->user();
        if (empty($this->user)) {
            $this->user = \App\Models\User::first();
        }
        if (empty($this->user)) {
            throw new \Exception('User not found');
        }
        return $this->user;
    }
}