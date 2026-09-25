<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Display login form
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required'    => 'Email harus diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password harus diisi.',
            'password.min'      => 'Password minimal 6 karakter.',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()
                ->withInput($request->only('email', 'remember_me'))
                ->withErrors(['email' => 'Akun dengan email ini tidak ditemukan.']);
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()
                ->withInput($request->only('email', 'remember_me'))
                ->withErrors(['password' => 'Password yang kamu masukkan salah.']);
        }

        Auth::login($user, $request->remember_me);
        $request->session()->regenerate();

        return $this->redirectByRole($user->role);
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Anda telah logout');
    }

    /**
     * Redirect user by role
     */
    protected function redirectByRole($role)
    {
        if ($role === 'admin') {
            return redirect()->route('dashboard.select');
        } 
        
        $redirects = [
            'gov'         => '/dashboard/gov',
            'soe'         => '/dashboard/soe',
            'sme'         => '/dashboard/sme',
            'private'     => '/dashboard/private',
            'collection'  => '/dashboard',
            'ctc'         => '/dashboard/ctc',
            'risingStar'  => '/dashboard/rising-star',
        ];

        return redirect($redirects[$role] ?? '/');
    }
}
