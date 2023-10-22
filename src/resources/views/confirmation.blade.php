<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atte</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/confirm.css') }}">
</head>
<body>
    <div class="confirm">
        <p class="confirm__guide">Atte：本人確認</p>
        <p class="confirm__guide">リンクをクリックしてください</p>
        <a class="confirm__link" href="{{ $displayableActionUrl }}" target="newtab">click</a>
    </div>
</body>