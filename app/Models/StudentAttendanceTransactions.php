<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentAttendanceTransactions extends Model
{
    static function getPresent($attendanceId){
        $data= StudentAttendanceTransactions::where(['student_attedance_id'=>$attendanceId, 'status'=>0])
            ->count();
            return $data;
    }

    static function getAbsent($attendanceId){
        $data= StudentAttendanceTransactions::where(['student_attedance_id'=>$attendanceId, 'status'=>1])
            ->count();
            return $data;
    }
}
