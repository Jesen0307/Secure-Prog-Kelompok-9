<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use App\Models\Product;


class UserController extends Controller
{
    // ================= LOGIN =================
    public function login(Request $request)
    {
        $incomingFields = $request->validate([
            'loginemail' => 'required|email',
            'loginpassword' => 'required|min:6'
        ]);

        if (Auth::attempt([
            'email' => $incomingFields['loginemail'],
            'password' => $incomingFields['loginpassword']
        ])) {
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }

        
        return redirect('/')
            ->withErrors(['loginemail' => 'Invalid credentials provided.'])
            ->with('authMode', 'login')
            ->with('showAuth', true)
            ->withInput();
    }

    // ================= FORGOT PASSWORD =================
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    // ================= RESET PASSWORD =================
    public function showResetForm($token)
    {
        return view('reset-password', ['token' => $token]);
    }


    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('home')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }



    // ================= REGISTER =================
    public function register(Request $request)
    {
        $incomingFields = $request->validate([
            'name' => 'required|min:3|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6'
        ]);

        $user = User::create([
            'name' => $incomingFields['name'],
            'email' => $incomingFields['email'],
            'password' => Hash::make($incomingFields['password'])
        ]);

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    // ================= LOGOUT =================
    public function logout(Request $request)
    {
        Auth::logout(); // log out user
        $request->session()->invalidate(); // invalidate session
        $request->session()->regenerateToken(); // regenerate CSRF token

        return redirect()->route('home'); // back to homepage
    }
    public function dashboard()
    {
        if (Auth::check()) {
            // Ambil data user yang sedang login
            $user = Auth::user();

            // Ambil semua produk yang tersedia
            $products = Product::all();

            // Kirim data ke view
            return view('dashboard', compact('user', 'products'));
        }

        // Kalau belum login, arahkan ke halaman login
        return redirect()->route('login')->with('error', 'Please login first.');
    }
}
