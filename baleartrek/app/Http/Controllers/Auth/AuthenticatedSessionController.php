<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
{
    $request->validate([
        'email' => 'required|string|email',
        'password' => 'required|string',
    ]);

    if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
        
        // Si viene del frontend React, devolvemos token
        if ($request->expectsJson()) {
            $token = $request->user()->createToken('auth_token')->plainTextToken;
            return response()->json(['token' => $token, 'user' => $request->user()]);
        }

        // Si viene del backoffice, redirigimos al dashboard
        $request->session()->regenerate();
        return redirect()->intended(route('dashboard'));
    }

    // Si falla la autenticación
    if ($request->expectsJson()) {
        return response()->json(['message' => 'Email o contraseña incorrectos.'], 401);
    }

    return back()->withErrors([
        'email' => 'Les credencials no coincideixen amb els nostres registres.',
    ]);
}

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function create()
    {
        return view('auth.login');
    }
}
