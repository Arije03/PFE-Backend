<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;


class RequestException extends Exception
{
    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
        parent::__construct('Validation failed');
    }

    public function render(): JsonResponse
    {
        $errors = (new ValidationException($this->validator))->errors();

        return response()->json(['errors' => $errors], 422);
    }
}
