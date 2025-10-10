<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Merchant;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class MerchantAuthController extends Controller
{
    /**
     * Show merchant login form.
     */
    public function showLoginForm()
    {
        return view('auth.merchant-login'); // create this Blade file later
    }

    /**
     * Handle merchant login.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::guard('merchant')->attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
        ], $request->filled('remember'))) {

            $request->session()->regenerate();

            return redirect()->intended(route('merchant.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Invalid credentials provided.',
        ])->onlyInput('email');
    }

    /**
     * Merchant logout.
     */
    public function logout(Request $request)
    {
        Auth::guard('merchant')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('merchant.login');
    }

    /**
     * Merchant dashboard.
     */
    public function dashboard()
{
    if (Auth::guard('merchant')->check()) {
        // Ambil data merchant yang sedang login
        $merchant = Auth::guard('merchant')->user();

        // Ambil semua produk milik merchant tersebut
        $products = Product::where('merchant_id', $merchant->id)->get();

        // Kirim data ke view
        return view('merchant.dashboard', compact('merchant', 'products'));
    }

    // Jika tidak login, redirect ke halaman login merchant
    return redirect()->route('merchant.login');
}

    public function showRegisterForm()
    {
        return view('auth.merchant-register');
    }

    /**
     * Handle merchant registration.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:merchants,name',
            'email' => 'required|email|unique:merchants,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $merchant = Merchant::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::guard('merchant')->login($merchant);

        return redirect()->route('merchant.dashboard');
    }

    /**
     * Show forgot password form.
     */
    public function showForgotPasswordForm()
    {
        return view('auth.merchant-forgot-password');
    }

    /**
     * Send reset link.
     */
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::broker('merchants')->sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
    }

    /**
     * Show reset form.
     */
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.merchant-reset-password', [
            'token' => $token,
            'email' => $request->email
        ]);
    }

    /**
     * Handle reset password.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $status = Password::broker('merchants')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($merchant, $password) {
                $merchant->password = Hash::make($password);
                $merchant->save();
            }
        );

        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('merchant.login')->with('status', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    }

}
