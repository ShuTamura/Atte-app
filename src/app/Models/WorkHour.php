<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\carbon;

class WorkHour extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'clock_in', 'clock_out', 'total_break'];

    protected $guarded = ['id'];

    public function justDate($query) {
        $in = new Carbon($query);
        $day = $in->startOfDay();

        return $day;
    }

    public function workingDiff($date1 , $date2 , $total_break) {
        $time1 = new Carbon($date1);
        $time2 = new Carbon($date2);
        $diffInSeconds = $time1->diffInSeconds($time2);
        $diff = new Carbon($diffInSeconds);
        $diffInBreak = $diff->diffInSeconds($total_break);
        $difftime = new Carbon($diffInBreak);

        return $difftime->format('H:i:s');
    }

    public function getDate($datetime) {
        $date = new Carbon($datetime);
        return $date->format('Y/m/d');
    }

    public function getTime($datetime) {
        $time = new Carbon($datetime);
        return $time->format('H:i:s');
    }

    public function User() {
        return $this->belongsTo('App\Models\User');
    }
}
