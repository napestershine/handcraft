<?php

namespace App\Models;


trait Validator
{

    protected $errors;

    protected function validate($data) {

        if (!$this->rules) {
            return false;
        }
        $validation = \Validator::make($data, $this->rules);

        if ($validation->fails()) {
            return $validation->errors();
        }

        return true;
    }

    protected function errors() {
        return $this->errors;
    }
}