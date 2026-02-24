<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $request->validate([
                'name'      => 'required|string|max:100',
                'lastname'  => 'required|string|max:100',
                'dni'       => 'required|string|unique:users',
                'email'     => 'required|email|unique:users',
                'phone'     => 'nullable|string|max:20',
                'password'  => 'required|min:8|confirmed',
            ]);

            $user = User::create([
                'name'      => $request->name,
                'lastname'  => $request->lastname,
                'dni'       => $request->dni,
                'email'     => $request->email,
                'phone'     => $request->phone,
                'password'  => bcrypt($request->password),
                'role_id'   => 2, // rol usuario normal
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'token' => $token,
                'user'  => $user
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'msg'   => 'Error al registrar el usuario',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function login(Request $request)
{
    try {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // Añade esto para debugear
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 401);
        }
        if ($user->status === 'n') {
            return response()->json(['message' => 'Usuario desactivado'], 401);
        }

        if (!\Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Email o contraseña incorrectos.'], 401);
        }

        $user  = \Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['token' => $token, 'user' => $user]);

    } catch (Exception $e) {
        return response()->json(['msg' => 'Error', 'error' => $e->getMessage()]);
    }
}
}