<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\WorkHour;
use App\Models\BreakTime;
use Illuminate\Support\Facades\Auth;
use Carbon\carbon;

class StampingController extends Controller
{
    public function index(Request $request) {
        if(Auth::user()) {
            $user = Auth::user();
            $today = null;
            $old_day_in = new Carbon();
            $old_day_out = new Carbon();
            $today_in = 0;
	    $today_out = 0;
	    $start = session()->get('start');
            $end = session()->get('end');
            $request->session()->reflash();

            $old_stamp = WorkHour::where('user_id', $user->id)->latest()->first();   //直前のデータを取得
            if ($old_stamp) {
                $old_clockin = new Carbon($old_stamp->clock_in);  //直前の出勤打刻時間を取得
                $old_clockout = new Carbon($old_stamp->clock_out);

                $old_day_in = $old_clockin->startOfDay();
                if(!empty($old_clockout)) {
                    $old_day_out = $old_clockout->startOfDay();
                }
            }

            $new_day = Carbon::today();      //データ取得日の00:00:00を取得

            if($new_day != $old_day_in) {
                $today_in = 0;
            }
            elseif($new_day == $old_day_in) {
                $today_in = 1;
            }

            if((!empty($old_stamp->clock_out)) && ($new_day == $old_day_out)) {
                $today_out = 1;
            }

            $today = [
                'in' => $today_in,
                'out' => $today_out,
            ];
            return view('stamp', compact('today', 'start', 'end'));
        }
        return redirect('/login');
    }

    public function clockIn() {
        $user = Auth::user();   //ログインしているユーザー

        $stamp = WorkHour::create([
            'user_id' => $user->id,
            'clock_in' => Carbon::now(),
        ]);
        return redirect()->back()->with('message', '出勤打刻が完了しました');
    }

    public function clockOut() {
        $user = Auth::user();

        $stamp = WorkHour::where('user_id', $user->id)->latest()->first();

        if ($stamp) {
        	$old_clockin = new Carbon($stamp->clock_in);
		$old_day = $old_clockin->startOfDay();

		$new_day = Carbon::today();

		if($old_day != $new_day) {
                	return redirect()->back()->with('error', '出勤打刻が完了していません');
            	}else {
                	$stamp->update([
                    		'clock_out' => Carbon::now()
                	]);
                return redirect()->back()->with('message', '退勤打刻が完了しました');
            	}
	}else {
            return redirect()->back()->with('error', '出勤打刻が完了していません');
        }	
    }

    public function breakStart(Request $request) {
	$user = Auth::user();
	$start = $request->start;
        $end = 0;
        $request->session()->put('start', $start);

	$stamp = WorkHour::where('user_id', $user->id)->latest()->first();
	$break_stamp = BreakTime::where('user_id', $user->id)->latest()->first();

        if($stamp) {
            $old_clockin = new Carbon($stamp->clock_in);
            $old_day = $old_clockin->startOfDay();

            $new_day = Carbon::today();

	    if($old_day != $new_day) {
                $start = 0;
                $request->session()->put('start', $start);
                return redirect()->back()->with([
                    'error' => '今日の出勤打刻が完了していません',
                    'start' => $start,
                    'end' => $end,
                ]);
            }elseif(!empty($stamp->clock_out)) {
                $start = 0;
                $request->session()->put('start', $start);
                return redirect()->back()->with([
                    'error' => '今日の退勤打刻が完了しています',
                    'start' => $start,
                    'end' => $end,
                ]);
            }elseif((!empty($break_stamp->break_start)) && empty($break_stamp->break_end)) {
                $start = 0;
                $request->session()->put('start', $start);
                return redirect()->back()->with([
                    'error' => 'すでに休憩中です',
                    'start' => $start,
                    'end' => $end,
                ]);
	    }else {
                $stamp = BreakTime::create([
                    'user_id' => $user->id,
                    'break_start' => Carbon::now(),
                ]);
                return redirect()->back()->with([
                    'message' => '休憩開始',
                    'start' => $start,
                    'end' => $end,
                ]);
            }
        }else {
            return redirect()->back()->with('error', '出勤打刻が完了していません');
        }
    }

    public function breakEnd(Request $request) {
        $user = Auth::user();
        $start = 0;
        $end = $request->end;
        $request->session()->put('end', $end);

        $stamp = BreakTime::where('user_id', $user->id)->latest()->first();

        if ($stamp) {
                $old_break = new Carbon($stamp->break);
                $old_day = $old_break->startOfDay();
            }

        $new_day = Carbon::today();

        if(empty($old_day)) {
            return redirect()->back()->with('error', '休憩を開始していません');
        }elseif(!empty($stamp->break_end)) {
            return redirect()->back()->with('error', 'すでに休憩終了打刻がされています');
        }
        if(($old_day == $new_day) && (!empty($old_day))) {
            $stamp->update([
                'break_end' => Carbon::now()
            ]);
            return redirect()->back()->with([
                'message' => '休憩終了',
                'start' => $start,
                'end' => $end
            ]);
        }
    }
}
