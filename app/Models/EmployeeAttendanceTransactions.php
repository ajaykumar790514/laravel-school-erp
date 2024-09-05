<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeAttendanceTransactions extends Model
{
    static function getPresent($attendanceId){
        $data= EmployeeAttendanceTransactions::where(['employee_attendance_id'=>$attendanceId, 'status'=>0])
            ->count();
            return $data;
    }

    static function getAbsent($attendanceId){
        $data= EmployeeAttendanceTransactions::where(['employee_attendance_id'=>$attendanceId, 'status'=>1])
            ->count();
            return $data;
    }

    static function getHalfTime($attendanceId){
        $data= EmployeeAttendanceTransactions::where(['employee_attendance_id'=>$attendanceId, 'status'=>2])
            ->count();
            return $data;
    }

    static function getLate($attendanceId){
        $data= EmployeeAttendanceTransactions::where(['employee_attendance_id'=>$attendanceId, 'status'=>3])
            ->count();
            return $data;
    }
}
