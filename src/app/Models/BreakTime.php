<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\carbon;

class BreakTime extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'break_start', 'break_end'];

    protected $guarded = ['id'];

    public function justDate($query) {
        $in = new Carbon($query);
        $day = $in->startOfDay();

        return $day;
    }

    public function breakingDiff($date1 , $date2) {
        $time1 = new Carbon($date1);
        $time2 = new Carbon($date2);
        $diffInSeconds = $time1->diffInSeconds($time2);

        return $diffInSeconds;
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }
}
