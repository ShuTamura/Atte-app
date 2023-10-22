@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
@endsection

@section('content')
    <div class="attendance">
        <div class="attendance__search-by-name">
            <form action="/attendance/search" class="name-form" method="GET">
                @csrf
                <div>
                    <input type="text" class="name-form__item" name="name_word" value="{{ old('name_word') }}" placeholder="名前で検索">
                    <input type="hidden" name="target_day" value="{{ $target_day }}">
                </div>
                <div>
                    <button type="submit" class="name-form__search-btn">検索</button>
                </div>
            </form>
        </div>
        <div class="attendance__search-by-date">
            <div class="date-selection">
                <form action="/attendance/before" class="date-selection__form--ago" method="GET">
                    @csrf
                    <input type="hidden" name="target_day" value="{{ $target_day }}">
                    <button type="submit" class="date-selection__btn--ago">&lt</button>
                </form>
            </div>
            <div class="target-day">{{ $target_day }}</div>
            <div class="date-selection">
                <form action="/attendance/after" class="date-selection__form--later" method="GET">
                    @csrf
                    <input type="hidden" name="target_day" value="{{ $target_day }}">
                    <button type="submit" class="date-selection__btn--later">&gt</button>
                </form>
            </div>
        </div>
        <div class="attendance__list">
            <table class="attendance__table">
                <tr>
                    <th>名前</th>
                    <th>勤務開始</th>
                    <th>勤務終了</th>
                    <th>休憩時間</th>
                    <th>勤務時間</th>
                </tr>
                @foreach($work_hours as $work_hour)
                <tr>
                    <td>{{ $work_hour->user->name }}</td>
                    <td>{{ $work_hour->getTime($work_hour->clock_in) }}</td>
                    <td>{{ $work_hour->getTime($work_hour->clock_out) }}</td>
                    <td>{{ $work_hour->getTime($work_hour->total_break) }}</td>
                    <td>{{ $work_hour->workingDiff(
                        $work_hour->clock_in ,
                        $work_hour->clock_out ,
                        $work_hour->total_break)
                    }}</td>
                </tr>
                @endforeach
            </table>
            {{ $work_hours->appends(request()->query())->links() }}
        </div>
    </div>
@endsection