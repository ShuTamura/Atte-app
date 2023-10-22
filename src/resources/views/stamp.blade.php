@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/stamp.css') }}">
@endsection

@section('content')
    <div class="stamp">
        <div class="stamp__content">
            <div class="stamp__title">
                <h2 class="stamp__title">{{ Auth::user()->name }}さんお疲れ様です！</h2>
            </div>
            @if (session('message'))
            <div class="message">
                {{session('message')}}
            </div>
            @endif
            @if (session('error'))
            <div class="message">
                {{session('error')}}
            </div>
            @endif
            <div class="stamp__form-outer">
                <table class="stamp__form-table">
                    <tr>
                        @if(!empty($today['in']))
                        <td>
                            <form action="/clockin" class="form" method="POST">
                                @csrf
                                <button class="btn stamp__btn-clock-in--prevention" type="submit">勤務開始</button>
                            </form>
                        </td>
                        @else
                        <td>
                            <form action="/clockin" class="form" method="POST">
                                @csrf
                                <button class="btn stamp__btn-clock-in--active" type="submit">勤務開始</button>
                            </form>
                        </td>
                        @endif
                        @if(!empty($today['out']))
                        <td>
                            <form action="/clockout" class="form" method="POST">
                                @csrf
                                <button class="btn stamp__btn-clock-out--prevention" type="submit">勤務終了
                                </button>
                            </form>
                        </td>
                        @else
                        <td>
                            <form action="/clockout" class="form" method="POST">
                                @csrf
                                <button class="btn stamp__btn-clock-out--active" type="submit">勤務終了
                                </button>
                            </form>
                        </td>
                        @endif
                    </tr>
                    <tr>
                        @if(!empty($today['start']))
                        <td>
                            <form action="/breakstart" class="form" method="POST">
                                @csrf
                                <button class="btn stamp__btn-break-start--prevention" type="submit">休憩開始</button>
                            </form>
                        </td>
                        @else
                        <td>
                            <form action="/breakstart" class="form" method="POST">
                                @csrf
                                <button class="btn stamp__btn-break-start--active" type="submit">休憩開始</button>
                            </form>
                        </td>
                        @endif
                        @if(!empty($today['end']))
                        <td>
                            <form action="/breakend" class="form" method="POST">
                                @csrf
                                <button class="btn stamp__btn-break-end--prevention" type="submit">休憩終了</button>
                            </form>
                        </td>
                        @else
                        <td>
                            <form action="/breakend" class="form" method="POST">
                                @csrf
                                <button class="btn stamp__btn-break-end--active" type="submit">休憩終了</button>
                            </form>
                        </td>
                        @endif
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection