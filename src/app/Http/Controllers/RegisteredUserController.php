<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
// use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Auth\Events\Verified;

class RegisteredUserController extends Controller
{
    public function index() {
        return view('register');
    }

    public function register(UserRequest $request) {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect('/');
    }

    public function notice(Request $request) {
        return $request->user()->hasVerifiedEmail()
            ? redirect()->intended(RouteServiceProvider::HOME)
            : view('verify_email');
    }

    public function send(Request $request) {
        /** @var User $user */
        $user = $request->user();

        // メール確認済みの場合はトップへ
        if ($user->hasVerifiedEmail()) {
            return redirect()->intended(RouteServiceProvider::HOME);
        }

        // メール送信
        $user->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }

    public function verification(Request $request) {
        /** @var User $user */
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
        }

        // email_verified_atカラムの更新
        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
    }
}
