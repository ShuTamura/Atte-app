<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atte</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
</head>
<body>
    <header class="header">
        <div class="header__inner">
            <h1 class="header__title">
                <a href="/" class="title">Atte</a>
            </h1>
            <nav class="header__nav">
                <ul class="header__nav-list">
                    <li class="header__nav-item"><a href="/">ホーム</a></li>
                    <li class="header__nav-item"><a href="/attendance">日付別</a></li>
                    <li class="header__nav-item"><a href="/attendance/userlist">ユーザー一覧</a></li>
                    <li class="header__nav-item">
                        <form action="/logout" class="logout" method="POST">
                            @csrf
                            <input type="submit" class="logout-btn" value="ログアウト">
                        </form>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <small class="footer__small">Atte,inc.</small>
    </footer>
</body>
</html>