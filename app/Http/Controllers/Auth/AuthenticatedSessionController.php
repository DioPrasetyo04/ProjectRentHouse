<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request, User $user): JsonResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // user autentikasi
        $user = Auth::user();
        // user token
        $user['token'] = $request->user()->createToken("auth")->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login Successfully',
            // get data user
            'data' => $user,
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): JsonResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->json([
            'success' => true,
            'message' => 'Logout Successfully',
        ]);
    }
}
