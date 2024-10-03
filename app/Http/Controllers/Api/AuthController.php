<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        try {
            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'message' => 'Invalid login credentials'
                ], 401);
            }

            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'status' => 'success',
                'message' => 'login successfully',
                'data' => [
                    'token' => $token,
                    'user' => $user
                ],
            ]);
        } catch (Exception $e) {
            Log::error('Auth.login', ['error' => $e, 'request' => $request]);

            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred during login',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function logout()
    {
        try {
            /** @var App\Model\User */
            $user = Auth::user();
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'bad request'
                ], 400);
            }
            $user->tokens()->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Logged out'
            ]);
        } catch (Exception $e) {
            Log::error('Auth.logout', ['error' => $e, 'request' => null]);

            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred during login',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
