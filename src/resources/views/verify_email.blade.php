@extends('layouts.auth')

@section('css')
<link rel="stylesheet" href="{{ asset('css/verify_email.css') }}">
@endsection

@section('content')
    <div class="verify-email">
        <h2 class="verify-email__title"><a href="/">確認メールの送信</a></h2>
        <div class="verify-email__content">
            @if (session('status') === 'verification-link-sent')
                <p class="verify-email__guide">
                    登録したメールアドレスを確認してください！！
                </p>
                <p class="verify-email__link"><a href="/">TOPに戻る</a></p>
            @else
                <p class="verify-email__guide">
                    確認メールを送信してください！！
                </p>
                <form class="verify-email__send-form" method="post" action="{{ route('verification.send') }}">
                    @method('post')
                    @csrf
                    <div>
                        <button class="verify-email__form-btn"type="submit">送信</button>
                    </div>
                </form>
            @endif
        </div>
    </div>
@endsection