<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\LoginHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Catat login history
            LoginHistory::create([
                'user_id' => Auth::id(),
                'login_at' => now(),
                'ip_address' => $request->ip()
            ]);

            // Redirect berdasarkan role
            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.dashboard');
            } elseif (Auth::user()->isPetugas()) {
                return redirect()->route('petugas.dashboard');
            } else {
                return redirect()->route('wilayah.index'); // User biasa diarahkan ke halaman wilayah
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput($request->only('email'));
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'user'  // Set default role sebagai user
        ]);

        return redirect()->route('login')
            ->with('success', 'Registration successful! Please login to continue.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}