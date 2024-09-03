<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Contracts\Validation\Validator;
use App\Http\Responses\ApiResponse;

class FailedValidationException extends Exception {
    protected $validator;

    protected $code = 422;

    public function __construct(Validator $validator) {
        $this->validator = $validator;
    }

    /**
     * Report the exception.
     */
    public function report(): bool
    {
        return true;
    }

    /**
     * Render the exception into an HTTP response.
     */
    public function render() {
        if (request()->is('api/*')) {
            return ApiResponse::error(
                message: __('messages.ERR_422'),
                errors: $this->validator->errors()->toArray(),
                statusCode: $this->code
            );
        }

        return false;
    }
}
