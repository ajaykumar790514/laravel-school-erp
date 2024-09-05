<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EmployeeAttendances extends Model
{
	static function checkAttendance($attendanceDate,$session){
        $data= EmployeeAttendances::where(['session_id'=>$session,'attendance_dt'=>$attendanceDate ])
            ->count();
            return $data;
    }


    static function getEmployeeAttendanceByMonth($month, $employeeID){
    	$monthDetail=date('m', strtotime($month));
    	$yearDetail=date('Y', strtotime($month));

		$data= DB::table('employee_attendances')->whereYear('employee_attendances.attendance_dt', '=', $yearDetail)
              ->whereMonth('employee_attendances.attendance_dt', '=', $monthDetail)
              ->where(['employee_attendance_transactions.employee_id'=>$employeeID])
        		
				->join('employee_attendance_transactions', 'employee_attendances.id', '=', 'employee_attendance_transactions.employee_attendance_id')
        		->join('employees', 'employee_attendance_transactions.employee_id', '=', 'employees.id')

        		->select('employee_attendance_transactions.employee_id','employee_attendances.id', 'employee_attendance_transactions.id as empdAttTransactionsId', 'employees.employee_name',
        		DB::raw('DATE_FORMAT(employee_attendances.attendance_dt, "%d %b %Y") as attendance_dt'),
        		 'employee_attendance_transactions.status as attStatus')
        		->orderBy('employee_attendances.attendance_dt', 'desc')
            ->get();
            return $data;
    }


    static function getTeacherDetailsById($userID){
    	
		$data= DB::table('users')->where(['users.user_id'=>$userID])
        		->join('employees', 'users.user_id', '=', 'employees.id')
        		->select('users.id','users.email', 'employees.employee_name', 
        			'employees.mobile_whatsapp', 'employees.city' , 'employees.address' , 
        			 'employees.joining_dt', 'employees.qalification' , 'employees.employee_type')
        		->get();
            return $data;
    }

}
