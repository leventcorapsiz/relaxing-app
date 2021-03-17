<?php

namespace App\Http\Controllers;

use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * @var \Illuminate\Auth\AuthManager
     */
    protected $authManager;

    /**
     * LoginController constructor.
     * @param \Illuminate\Auth\AuthManager $authManager
     */
    public function __construct(AuthManager $authManager)
    {
        $this->authManager = $authManager;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request)
    {
        if ($this->authManager->guard()->attempt($request->only('email', 'password'))) {
            $token = $request->user()->createToken('api');

            return response()->json(['token' => $token->plainTextToken]);
        }

        return response()->json(['error' => ['message' => 'Invalid credentials.']], 401);
    }
}