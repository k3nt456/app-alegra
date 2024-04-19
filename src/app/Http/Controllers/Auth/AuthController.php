<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\Request\LoginRequest;
use App\Http\Controllers\Auth\Request\RegisterRequest;
use App\Http\Controllers\Controller;
use App\Services\Auth\AuthService;
use App\Traits\HasResponse;

class AuthController extends Controller
{
    use HasResponse;
    /** @var AuthService */
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request)
    {
        return $this->authService->register($request->validated());
    }

    public function login(LoginRequest $request)
    {
        return $this->authService->login($request->validated());
    }

    public function logout()
    {
        return $this->authService->logout();
    }
}
