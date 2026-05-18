<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login' => 'required|string',
            'password' => 'required',
        ]);

        $login = strtolower(trim($credentials['login']));

        $user = User::whereRaw('LOWER(email) = ?', [$login])
            ->orWhereRaw('LOWER(nis) = ?', [$login])
            ->orWhereRaw('LOWER(SUBSTRING_INDEX(email, "@", 1)) = ?', [$login])
            ->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::login($user, $request->boolean('remember'));
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'login' => 'Email/username atau password salah.',
        ])->withInput($request->only('login'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    public function dashboard()
    {
        $user = Auth::user();
        if ($user->isAdmin()) return redirect()->route('admin.dashboard');
        if ($user->isGuru())  return redirect()->route('guru.dashboard');
        return redirect()->route('siswa.dashboard');
    }
}
