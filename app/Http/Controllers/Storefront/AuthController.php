<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('storefront.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials)) {

            $user = Auth::user();

            if ($user->roles()->where('slug', 'customer')->exists()) {

                $request->session()->regenerate();

                 return redirect()
                    ->intended(route('home'))
                    ->with('success', 'Welcome back!');
            }

            Auth::logout();

            return back()
                ->withErrors([
                    'email' => 'This account is not a customer account.',
                ])
                ->onlyInput('email');
        }

        return back()
            ->withErrors([
                'email' => 'The provided email or password is incorrect.',
            ])
            ->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('home')
            ->with('success', 'You have been logged out successfully.');
    }
}