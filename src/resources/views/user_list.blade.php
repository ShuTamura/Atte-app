@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/user_list.css') }}">
@endsection

@section('content')
<div class="user-list">
    <div class="user-list__search-by-name search-by-name">
        <form action="/attendance/usersearch" class="name-form" method="GET">
            @csrf
            <div>
                <input type="text" class="name-form__item" name="name_word" value="{{ old('name_word') }}" placeholder="名前で検索">
            </div>
            <div>
                <button type="submit" class="name-form__search-btn">検索</button>
            </div>
        </form>
    </div>
    <div class="user-list__list">
            <table class="user-list__table table">
                <tr>
                    <th>名前</th>
                    <th>個人ページ</th>
                </tr>
                @foreach($users as $user)
                <form action="/attendance/personal" class="jump-form" method="POST">
                @csrf
                <tr>
                    <td>{{ $user->name }}</td>
                    <td><button class="jump-form__btn" name="id" value="{{ $user->id }}">個別勤怠表</button></td>
                </tr>
                </form>
                @endforeach
            </table>
            {{ $users->appends(request()->query())->links() }}
        </div>
</div>
@endsection