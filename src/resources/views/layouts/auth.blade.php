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
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <small class="footer__small">Atte,inc.</small>
    </footer>
</body>
</html>