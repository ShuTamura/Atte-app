<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\WorkHour;
use App\Models\BreakTime;
use Illuminate\Support\Facades\Auth;
use DateTime;
use Carbon\Carbon;

class AttendanceListController extends Controller
{
    public function index(Request $request) {
        if(Auth::User()) {
            $work_hours_all = WorkHour::with('user')->get();
            foreach($work_hours_all as $work_hour) {
                $total_break_seconds = (int)0;
                $total_break = new Carbon();
                $break_times = BreakTime::where('user_id', $work_hour->user_id)->get();
                $work_day = WorkHour::justDate($work_hour->clock_in);
                foreach($break_times as $break_time) {
                    $diff = 0;
                    $break_day = BreakTime::justDate($break_time->break_start);
                    if($work_day == $break_day) {
                        $diff = BreakTime::breakingDiff($break_time->break_start, $break_time->break_end);
                        $total_break_seconds += $diff;
                    }
                }
                $total_break = new Carbon($total_break_seconds);
                $work = WorkHour::find($work_hour->id);
                $work->update([
                'total_break' => $total_break
                ]);
                echo "\n";
            }
            $today = Carbon::today();
            $target_day = $today->format('Y-m-d');
            $work_hours = WorkHour::with('user')->whereDate('clock_in', $target_day)->Paginate(5);
            return view('attendance', compact('work_hours', 'target_day'));
        }
        return redirect('/login');
    }

    public function back(Request $request) {
        $to_date = new Carbon($request->target_day);
        $yesterday = $to_date->subDay()->format('Y-m-d');
        $work_hours = WorkHour::with('user')->whereDate('clock_in', $yesterday)->Paginate(5);
        $target_day = $yesterday;
        return view('attendance', compact('work_hours', 'target_day'));
    }

    public function advance(Request $request) {
        $to_date = new Carbon($request->target_day);
        $tomorrow = $to_date->addDay()->format('Y-m-d');
        $work_hours = WorkHour::with('user')->whereDate('clock_in', $tomorrow)->Paginate(5);
        $target_day = $tomorrow;
        return view('attendance', compact('work_hours', 'target_day'));
    }

    public function search(Request $request) {
        $target_day = new Carbon($request->target_day);
        // $work_hours = WorkHour::with('user')->NameSearch($request->name_word)->whereDate('clock_in', $target_day)->Paginate(5);
        $keyword = $request->name_word;
        $work_hours = WorkHour::whereHas('user', function ($q) use ($keyword){
            $q->where('name', 'like', '%' . $keyword . '%');
        })->whereDate('clock_in', $target_day)->Paginate(5);
        return view('attendance', compact('work_hours', 'target_day'));
    }

    public function userList() {
        if(Auth::User()) {
            $users = User::Paginate(10);
            return view('user_list', compact('users'));
        }
        return redirect('/login');
    }

    public function userSearch(Request $request) {
        $keyword = $request->name_word;
        $users = User::nameSearch($keyword)->Paginate(10);
        return view('user_list', compact('users'));
    }

    public function personal(Request $request) {
        if(Auth::User()) {
            $user_id = $request->id;
            $request->session()->put('id', $user_id);
            return redirect('/attendance/personaltable');
        }
        return redirect('/login');
    }

    public function personalTable(Request $request) {
        if(Auth::User()) {
            $user_id = $request->session()->get('id');
            $user = User::find($user_id);
            $work_hours = WorkHour::with('user')->where('user_id', $user_id)->Paginate(5);
            return view('personal', compact('user' , 'work_hours'));
        }
        return redirect('/login');
    }
}