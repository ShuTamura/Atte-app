@extends('layouts.app')


@section('content')
<div class="personal-space">
    <div class="stamp__title">
        <h2 class="stamp__title">{{ $user->name }}さんの勤怠表</h2>
    </div>
    <div class="personal__list">
            <table class="personal__table table">
                <tr>
                    <th>日付</th>
                    <th>勤務開始</th>
                    <th>勤務終了</th>
                    <th>休憩時間</th>
                    <th>勤務時間</th>
                </tr>
                @foreach($work_hours as $work_hour)
                <tr>
                    <td>{{ $work_hour->getDate($work_hour->clock_in) }}</td>
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