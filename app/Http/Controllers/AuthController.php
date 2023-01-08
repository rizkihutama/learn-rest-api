<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credential = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        try {
            $user = User::where('email', $request->email)->firstOrFail();

            if (!$user) return throw new Exception('Email or password incorrect', 422);

            $hashCheck = Hash::check($request->password, $user->password);

            if (!Auth::attempt($credential) && !$hashCheck) {
                return throw new Exception('Email or password incorrect', 422);
            }

            $token = $user->createToken('auth_token')->plainTextToken;
            $data = [
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user,
            ];

            return $this->sendResponse($data, 'Authenticated');
        } catch (Exception $e) {
            return $this->sendError($e->getMessage(), $e, $e->getCode());
        }
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:50', 'unique:users'],
            'password' => ['required', 'min:6']
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $user = User::where('email', $request->email)->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        $data = [
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ];

        return $this->sendResponse($data, 'success register');
    }

    public function logout()
    {
        $user = User::find(Auth::user()->id);

        $user->tokens()->delete();

        return response()->noContent();
    }
}
