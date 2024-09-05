<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class StudentAttendances extends Model
{
    static function checkAttendance($attendanceDate, $session, $classstupId, $sectionID){
        $data= StudentAttendances::where(['session_id'=>$session, 'classsetup_id'=>$classstupId, 'sectionsetup_id'=>$sectionID, 'attendeance_date'=>$attendanceDate])
            ->count();
            return $data;
    }
    
     

    static function getStudentListByClassSession($session, $classSessionMaping, $studentId){
		$data= DB::table('student_attendances')->where(['student_attendances.session_id'=>$session, 'student_attendances.class_maping_id'=>$classSessionMaping, 'student_attendance_transactions.student_id'=>$studentId])
        		//->join('student_attendances', 'student_attendance_transactions.student_attedance_id', '=', 'student_attendances.id')
				->join('student_attendance_transactions', 'student_attendances.id', '=', 'student_attendance_transactions.student_attedance_id')
        		->join('students', 'student_attendance_transactions.student_id', '=', 'students.id')

        		->select('students.id as studentid','student_attendances.id as attendanceid', 'student_attendance_transactions.id as stdAttTransactionsId', 'students.student_name',
        		DB::raw('DATE_FORMAT(student_attendances.attendeance_date, "%d %b %Y") as attendeance_date'),
        		 'student_attendance_transactions.status as attStatus')
        		->orderBy('student_attendances.attendeance_date', 'desc')
            ->get();
            return $data;
    }

    
}
