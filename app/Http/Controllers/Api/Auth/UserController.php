<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\User\{RegisterRequest, LoginRequest};
use App\Services\Api\Auth\UserService;
use App\Helpers\ExceptionHandlerHelper;
use App\Traits\ResponseTrait;


class UserController extends Controller
{
    private $userService;
    use ResponseTrait;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(RegisterRequest $request)
    {
        return ExceptionHandlerHelper::tryCatch(function () use ($request) {
            $user = $this->userService->register($request->validated());
            return $this->sendResponse($user, 'User Register Successfully');
        });
    }

    public function login(LoginRequest $request)
    {
        return ExceptionHandlerHelper::tryCatch(function () use ($request) {
            $user = $this->userService->login($request->validated());
            if($user)
            {
                return $this->sendResponse($user, 'User Login Successfully');
            }
            else
            {
                return $this->sendError('Email or Password do not match!');
            }

        });
    }

    public function update_profile(Request $request)
    {
        return ExceptionHandlerHelper::tryCatch(function () use ($request) {
            $user = $this->userService->update_profile($request->all());
            return $this->sendResponse($user, 'User Profile Updated');
        });
    }

    public function update_password(Request $request)
    {
        $request=$request->validate([
        'password' =>'required'
        ]);
        return ExceptionHandlerHelper::tryCatch(function () use ($request) {
            $user = $this->userService->update_password($request);
            return $this->sendResponse($user, 'User Profile Password Updated');
        });
    }

    
}