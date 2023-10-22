<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthenticatedSessionController extends Controller
{
    public function index() {
        return view('login');
    }

    public function login(Request $request) {
        $user = $request->only(['email' , 'password']);

        if (Auth::attempt($user)) {
            $request->session()->regenerate();
            return redirect('/');
        }

        return redirect('/login')->with('message', 'メールアドレスまたはパスワードが間違っています');
    }
}
