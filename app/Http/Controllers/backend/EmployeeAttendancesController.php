<?php

namespace App\Http\Controllers\backend;

use App\Models\EmployeeAttendances;
USE App\Models\EmployeeAttendanceTransactions;
use App\Models\SessionSetups;
use App\Models\Employees;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EmployeeAttendancesController extends Controller
{
    function __construct(){
         $this->middleware('permission:employee-attendance', ['only' => ['employee_attendance']]);
         $this->middleware('permission:employee-attendance-register', ['only' => ['employee_attendance_register']]);
         $this->middleware('permission:employee-attendance-list', ['only' => ['employee_attendance_list']]);
    }

    public function employee_attendance(){
        $title="Attendeance";
        $sessions= SessionSetups::select('id', 'session_name')->where(['status'=>0])
                    ->orderBy('order_by', 'desc')->get();
        $data = DB::table('employees')
            ->where('employees.status', '=', 0)
            ->join('designations', 'employees.designation_id', '=', 'designations.id')
            ->join('departments', 'employees.department_id', '=', 'departments.id')
            ->select('employees.*','designations.designation_name', 'departments.department_name')
            ->orderBy('employees.employee_type', 'desc')
            -> get();
              //echo '<pre>'; print_r($data); exit;
        return view('backend.employeeattendances.employee_attendance', compact('data', 'sessions', 'title'));
    }

    public function employee_take_attendance(Request $request) {
            $now = Carbon::now();
            if($request->input()){
                $this->validate($request, [
                'attendance_dt'=>'required|date_format:d-m-Y',
                'attendance_dt' => 'before:tomorrow',
                'session_id' => 'required'
                ],
                [
                'attendance_dt.before' => 'Attendance date not greater then today date',
                ]


            );
                $multipalRecordss = [];
                //echo '<pre>'; print_r($request->input('attendanceReport')); exit;
                $checkAttendance=EmployeeAttendances::checkAttendance(date('Y-m-d', strtotime($request->input('attendance_dt'))), $request->input('session_id'));
                //echo $checkAttendance; exit;
                if($checkAttendance==0){  //check attendance already taken
                    $data = new EmployeeAttendances;
                    $data->session_id             = $request->input('session_id');
                    $data->attendance_dt          = date('Y-m-d', strtotime($request->input('attendance_dt')));
                    $data->created_by              = Auth::id();
                    
                    try {
                        $reply1=$data->save();
                        $AttendanceId=$data->id;
                    } catch(\Illuminate\Database\QueryException $e){
                           $errorCode = $e->errorInfo[1]; 
                            return redirect()->back()->with('error',config('app.saveError'));;        
                    }
                    //print_r($e->errorInfo); exit;

                } else {
                    return redirect()->back()->with('error',config('app.AttendanceAlreadyTakenErrMsg'));; 

                }

                foreach($request->input('attendanceReport') as $key =>$studentId){
                  
                    $multipalRecordss[] = [
                            'employee_attendance_id'  => $AttendanceId,
                            'employee_id'            => $key,
                            'status'                => $studentId,
                            'created_by'           => Auth::id(),
                            'updated_at' => $now,  // remove if not using timestamps
                            'created_at' => $now   // remove if not using timestamps
                    ];
                 

                }
                
                try {
                    $reply= EmployeeAttendanceTransactions::insert($multipalRecordss);
                    return redirect('/attendance/employee-attendance-register')->with('success',config('app.AttendanceMsg'));
                    //return redirect()->back()->with('success',config('app.AttendanceMsg'));;
                } catch(\Illuminate\Database\QueryException $e){
                       $errorCode = $e->errorInfo[1]; 
                    //return redirect('/admission/student-promotion-list')->with('error',$errorCode);  
                    return redirect()->back()->with('error',$errorCode);;        
                }
               // print_r($e->errorInfo);

            }

     }


     public function employee_attendance_register(Request $request) {
        $title="Attendeance Register";
        return view('backend.employeeattendances.employee_attendance_register', compact('title'));
    }

    public function employeeattendanceregisterdata()
    {
         $data = DB::table('employee_attendances')
         ->join('session_setups', 'employee_attendances.session_id', '=', 'session_setups.id')
         ->join('users', 'employee_attendances.created_by', '=', 'users.id')
           ->select('employee_attendances.*', 'session_setups.session_name', 'users.email')
             ->orderBy('employee_attendances.attendance_dt', 'desc')
              -> get();
            return datatables()->of($data)
            ->addColumn('action', function ($data) {
                return view('backend.employeeattendances.action', ['id' => base64_encode($data->id)]);
            })
            ->editColumn('attendance_dt', function ($data) {
                return date('d F Y', strtotime($data->attendance_dt));
            }) 
            ->editColumn('created_at', function ($data) {
                return 'Present : '.EmployeeAttendanceTransactions::getPresent($data->id).'/Absent :'.EmployeeAttendanceTransactions::getAbsent($data->id).'/Half Time :' .EmployeeAttendanceTransactions::getHalfTime($data->id).'/Late :'.EmployeeAttendanceTransactions::getLate($data->id);
            })
            
        ->make(true);
     
    }
    public function employee_attendance_list(Request $request, $id) {
        $title="Employee Attendeance List";
        return view('backend.employeeattendances.employee_attendance_list', compact('id', "title"));
    }

    public function employeeattendancelistdata($attendanceId)
    {
         $id=base64_decode($attendanceId);
         $data = DB::table('employee_attendance_transactions')
            ->where('employee_attendance_transactions.employee_attendance_id', '=', $id)
            ->join('employee_attendances', 'employee_attendance_transactions.employee_attendance_id', '=', 'employee_attendances.id')
             ->join('employees', 'employee_attendance_transactions.employee_id', '=', 'employees.id')
             ->join('designations', 'employees.designation_id', '=', 'designations.id')
            ->join('departments', 'employees.department_id', '=', 'departments.id')
             ->select('employees.employee_name','employees.father_husband_name', 'employees.mobile_whatsapp', 'designations.designation_name', 'departments.department_name', 'employee_attendances.attendance_dt', 'employee_attendance_transactions.status', 'employee_attendance_transactions.id')
             ->orderBy('employees.employee_name', 'desc')
              -> get();
            return datatables()->of($data)
            ->addColumn('action', function ($data) {
                return view('backend.employeeattendances.action1', ['id' => base64_encode($data->id), 'status' =>$data->status]);
            })
            ->editColumn('attendance_dt', function ($data) {
                return date('d F Y', strtotime($data->attendance_dt));
            }) 
            
            
        ->make(true);
     
    }

    public function update_employee_attendance($id, $status){
         $id=base64_decode($id);
         $attendanceDetails=EmployeeAttendanceTransactions::find($id);
         $attendanceId=$attendanceDetails->employee_attendance_id; 
         $attDetail=EmployeeAttendances::find($attendanceId);
         $curentDt = date('Y-m-d');
         if($curentDt!=$attDetail->attendance_dt){
                return redirect()->back()->with('error','Only current date attendance you change');
         }

         $dataarray = array(
                    'status'     => $status,
                );
          try {
                 $reply=EmployeeAttendanceTransactions::where('id', $id)->update($dataarray);
          } catch(\Illuminate\Database\QueryException $e){
                    $errorCode = $e->errorInfo[1];          
                 $reply=$errorCode;
          }
        
        //print_r($e->errorInfo); exit;  
        if($reply==1){
            return redirect()->back()->with('success',config('app.updateMsg'));
        } else {
            return redirect()->back()->with('error',config('app.updateErrMsg'));
        }
        
    }
}
