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

    public function showLoginForm()
    {
        return view('auth.merchant-login'); 
    }


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


    public function logout(Request $request)
    {
        Auth::guard('merchant')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }


    public function dashboard()
    {
        if (Auth::guard('merchant')->check()) {

            $merchant = Auth::guard('merchant')->user();


            $products = \App\Models\Product::where('merchant_id', $merchant->id)->get();


            $orders = \App\Models\Transaction::with(['buyer', 'items.product'])
                ->where('merchant_id', $merchant->id)
                ->orderBy('created_at', 'asc')
                ->get();


            return view('merchant.dashboard', compact('merchant', 'products', 'orders'));
        }

        return redirect()->route('merchant.login');
    }


    public function showRegisterForm()
    {
        return view('auth.merchant-register');
    }


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


    public function showForgotPasswordForm()
    {
        return view('auth.merchant-forgot-password');
    }


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


    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.merchant-reset-password', [
            'token' => $token,
            'email' => $request->email
        ]);
    }


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
