<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForgotPasswordMail;
use Illuminate\Support\Facades\URL;
use Illuminate\Auth\Events\Registered;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        // Gửi email kích hoạt
        $token = app('auth.password.broker')->createToken($user);

        Mail::to($user->email)->send(new ForgotPasswordMail($token));

        Auth::login($user);

        return redirect()->route('home');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect()->route('home');
        }

        return redirect()->back()->withErrors([
            'email' => 'Invalid credentials',
        ]);
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        // Gửi email quên mật khẩu
        if ($status == Password::RESET_LINK_SENT) {
            $user = User::where('email', $request->email)->first();
            $token = Password::createToken($user);

            Mail::to($request->email)->send(new ForgotPasswordMail($token));
            return redirect()->back()->with('status', __($status));
        }

        return redirect()->back()->withErrors(['email' => __($status)]);
    }


    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|confirmed|min:8',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->save();
                Auth::login($user);
            }
        );

        return $status == Password::PASSWORD_RESET
            ? redirect()->route('home')->with('status', __($status))
            : redirect()->back()->withErrors(['email' => __($status)]);
    }
}
