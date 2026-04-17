<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'El correo es obligatorio.',
            'email.email' => 'El correo no tiene un formato válido.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        if (!$token = Auth::guard('admin_api')->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Credenciales inválidas.',
            ], 401);
        }

        $admin = Auth::guard('admin_api')->user();

        if (!$admin->is_active) {
            Auth::guard('admin_api')->logout();

            return response()->json([
                'success' => false,
                'message' => 'El usuario administrador está inactivo.',
            ], 403);
        }

        return response()->json([
            'success' => true,
            'message' => 'Inicio de sesión correcto.',
            'data' => [
                'token' => $token,
                'token_type' => 'bearer',
                'admin' => $admin,
            ],
        ]);
    }

    public function me(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => Auth::guard('admin_api')->user(),
        ]);
    }

    public function logout(): JsonResponse
    {
        Auth::guard('admin_api')->logout();

        return response()->json([
            'success' => true,
            'message' => 'Sesión cerrada correctamente.',
        ]);
    }
}