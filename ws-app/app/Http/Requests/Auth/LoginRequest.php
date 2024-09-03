<?php

namespace App\Http\Requests\Auth;

use Illuminate\Validation\Rules;
use App\Http\Requests\AbstractRequest;

class LoginRequest extends AbstractRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'password' => ['required', Rules\Password::defaults()],
        ];
    }
}
