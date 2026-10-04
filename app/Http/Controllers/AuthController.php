<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LogAuditoria;

class AuthController extends Controller
{
    //Mostrar pantalla de login
    public function showLogin() {
        return view('auth.login');
    }

    //Procesar el login
    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            LogAuditoria::create([
        'user_id' => Auth::id(),
        'accion' => "Inicio de sesión en el sistema",
        'ip_address' => $request->ip()
        ]);

        return redirect()->route('dashboard');
        }

        return back()->withErrors(['email' => 'Las credenciales no coinciden con nuestros registros.']);
    }

    //Cerrar sesión
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}