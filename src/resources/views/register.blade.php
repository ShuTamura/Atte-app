@extends('layouts.auth')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
    <div class="register">
        <div class="register__content">
            <div class="register__header">
                <h2 class="register__title">会員登録</h2>
            </div>
            <div class="register__form-outer">
                <form action="/register" class="register__form" method="POST">
                    @csrf
                    <input type="text" name="name" class="register__item" placeholder="名前" value="{{ old('name') }}">
                    <div class="error-message">
                        @error('name'){{ $message }}@enderror
                    </div>
                    <input type="email" name="email" class="register__item" placeholder="メールアドレス" value="{{ old('email') }}">
                    <div class="error-message">
                        @error('email'){{ $message }}@enderror
                    </div>
                    <input type="password" name="password" class="register__item" placeholder="パスワード" value="{{ old('password') }}">
                    <div class="error-message">
                        @error('password'){{ $message }}@enderror
                    </div>
                    <input type="password" name="password_confirmation" class="register__item" placeholder="確認用パスワード" value="{{ old('password_confirmation') }}">
                    <button type="submit" class="register__button">会員登録</button>
                </form>
            </div>
            <div class="login">
                <p class="login__guide">アカウントをお持ちの方はこちら</p>
                <a href="/login" class="login__link">ログイン</a>
            </div>
        </div>
    </div>
@endsection