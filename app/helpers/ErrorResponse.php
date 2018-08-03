<?php

namespace App\helpers;

trait ErrorResponse
{
    protected $errorCodes = [
        420 => ['NO_DATA'],
        400 => ['DATA_SEMANTIC_ERROR', 'TOKEN_ERROR', 'EMAIL_NOT_FOUND', 'TYPE_NOT_FOUND', 'NOT_FOUND'],
        422 => ['DUPLICATE_RECORD', 'PDO_ERROR']
    ];

    protected function generateErrorResponse($errorType, $errorMessage) {
        foreach ($this->errorCodes as $key => $value) {

            if (\in_array($errorType, $value, true)) {
                if ($errorType === 'TOKEN_ERROR') {
                    $errorMessage = $this->extractTokenError($errorMessage);
                }

                return response($errorMessage, $key);
            }
        }
    }

    /**
     * @param $message
     * @return string
     */
    protected function extractTokenError($message): string {
        if (preg_match_all('/Client authentication/', $message)) {
            $message = 'Client authentication failed. Contact server administrator';
        }

        if (preg_match_all('/The user credentials/', $message)) {
            $message = 'User credentials are incorrect';
        }

        return $message;
    }
}
