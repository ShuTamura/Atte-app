@extends('layouts.auth')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
    <div class="login">
        <div class="login__content">
            <div class="login__header">
                <h2 class="login__title">ログイン</h2>
            </div>
            <div class="login__form-outer">
                <form action="/login" class="login__form" method="POST">
                    @csrf
                    <input type="email" name="email" class="login__item" placeholder="メールアドレス" value="{{ old('email') }}">
                    <input type="password" name="password" class="login__item" placeholder="パスワード" value="{{ old('password') }}">
                    @if (session('message'))
                    <div class="message">
                        <p class="error-message">{{session('message')}}</p>
                    </div>
                    @endif
                    <button class="login__button">ログイン</button>
                </form>
            </div>
            <div class="registration">
                <p class="registration__guide">アカウントをお持ちでない方はこちら</p>
                <a href="/register" class="registration__link">会員登録</a>
            </div>
        </div>
    </div>
@endsection