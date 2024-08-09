<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\ResponseTrait;

class LoginRequest extends FormRequest
{
    use ResponseTrait;

    public function rules(): array
    {
        return [
            'email'      => ['required'],
            'password'   => ['required'], 
        ];
    }
}
