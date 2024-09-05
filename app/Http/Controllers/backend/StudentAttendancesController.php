<?php

namespace App\Http\Controllers\backend;

use App\Models\StudentAttendances;
use App\Models\StudentAttendanceTransactions;
use App\Models\SessionSetups;
use App\Models\User;
use App\Models\StudentClassAllotments;
use App\Models\ClassSectionMappings;
use App\Models\Settings;
use App\Models\ClassSetups;
use App\Models\SectionSetups;
use App\Models\Parents;
use App\Models\Students;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StudentAttendancesController extends Controller
{
   
    function __construct(){
         $this->middleware('permission:student-attendance', ['only' => ['attendance_register']]);
         $this->middleware('permission:student-attendance-list', ['only' => ['student_attendance_list']]);
         $this->middleware('permission:classes-attendance', ['only' => ['class_attendance']]);
    }

     public function class_attendance(){
        $title="Attendeance";
        $user=User::find(Auth::id());
        $teacherId=$user->user_id;
        $data = DB::table('class_teacher_setups')
                ->where('class_teacher_setups.teacher_id', '=', $teacherId)
             //->join('class_section_mappings', 'class_teacher_setups.class_id', '=', 'class_section_mappings.id')
            ->join('session_setups', 'class_teacher_setups.session_id', '=', 'session_setups.id')
             ->join('section_setups', 'class_teacher_setups.section_id', '=', 'section_setups.id')
             ->join('class_setups', 'class_teacher_setups.class_id', '=', 'class_setups.id')
             ->join('employees', 'class_teacher_setups.teacher_id', '=', 'employees.id')
             ->select('class_teacher_setups.*', 'class_setups.class_name', 'section_setups.section_name',  'session_setups.session_name', 'employees.employee_name')
             ->get();
        return view('backend.studentattendance.classforattendance', compact('data', 'title'));
     }

   public function take_attendance(Request $request, $sessionId, $classsetupId, $sectionID) {
            $now = Carbon::now();
            $user=User::find(Auth::id());
            $teacherId=$user->user_id;
            if($request->input()){
                $this->validate($request, [
                    'attendeance_date'=>'required|before:tomorrow',
                    'attendeance_date' => 'before:tomorrow',
                    //'attendeance_date' => 'after:tomorrow'
                    ],
                    [ 'attendeance_date.before' => 'Attendance date not greater then today date',]
                );
                exit;
                $multipalRecordss = [];
                //echo '<pre>'; print_r($request->input('attendanceReport')); exit;
                $checkAttendance=StudentAttendances::checkAttendance(date('Y-m-d', strtotime($request->input('attendeance_date'))), $sessionId, $classsetupId);
                if($checkAttendance==0){  //check attendance already taken
                    $data = new StudentAttendances;
                    $data->session_id               = $sessionId;
                    $data->class_maping_id          = $classsetupId;
                    $data->section_maping_id       = $classsetupId;
                    $data->attendeance_date         = date('Y-m-d', strtotime($request->input('attendeance_date')));
                    $data->teacher_id              = $teacherId;
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
                  if(empty($checkPromation)){
                    $multipalRecordss[] = [
                            'student_attedance_id'  => $AttendanceId,
                            'student_id'            => $key,
                            'status'                => $studentId,
                            'created_by'           => Auth::id(),
                            'updated_at' => $now,  // remove if not using timestamps
                            'created_at' => $now   // remove if not using timestamps
                    ];
                    $getUrl=Settings::getSettingValue('sms_url');
                    $studentName=Students::getStudentName($key);
                     $parentName=Parents::getParentName($key);
                     $attendancestatus=$studentId==0?"Present":"Absent";
                     $className=ClassSectionMappings::getClassNameByClassMapingID($classmapingId); 
                     $massage="Dear $parentName, Today, $studentName of $className is $attendancestatus in school.. Regards, Team Dr. P S Edu.";
                      $mobile=Parents::getParentWhatsappMobile($key);
                      $msg = str_replace(' ', '%20', $massage);
                      $curl = curl_init();
                      $url= $getUrl."message=".$msg."&mobileNos=".$mobile;

                    curl_setopt_array($curl, array(
                     CURLOPT_URL=>"$url",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_HTTPHEADER => array(
                      "Cache-Control: no-cache"
                    ),
                  ));
                  $response = curl_exec($curl);
                  $err = curl_error($curl);
                  curl_close($curl);
                  } 

                }
                
                try {
                    $reply= StudentAttendanceTransactions::insert($multipalRecordss);
                    //return redirect('/admission/student-promotion-list')->with('success',config('app.allotmentStudent'));
                    return redirect()->back()->with('success',config('app.AttendanceMsg'));;
                } catch(\Illuminate\Database\QueryException $e){
                       $errorCode = $e->errorInfo[1]; 
                    //return redirect('/admission/student-promotion-list')->with('error',$errorCode);  
                    return redirect()->back()->with('error',$errorCode);;        
                }
               // print_r($e->errorInfo);

            }

     }


    public function attendance_register(Request $request, $sessionId, $classsetupID, $sectionID) {
        $title="Student Attendeance Register";
        $sessionIds=base64_decode($sessionId);
         $sessionName=SessionSetups::getSessionName($sessionIds);
         $classID=base64_decode($classsetupID);
         $className=ClassSetups::getClassName($classID);
         $sectionID=base64_decode($sectionID);
         $sectionName=SectionSetups::getSectionName($sectionID);
        return view('backend.studentattendance.attendance_register', compact('sessionName', 'className', 'classID', 'sessionIds', 'sectionName', 'sectionID', 'title'));
    }

    public function studentattendanceregisterdata($sessionId, $classsetupID, $sectionID)
    {
         $data = DB::table('student_attendances')
            ->where('student_attendances.session_id', '=', $sessionId)
            ->where('student_attendances.classsetup_id', '=', $classsetupID)
            ->where('student_attendances.sectionsetup_id', '=', $sectionID)
            //->join('class_section_mappings', 'student_attendances.classsetup_id', '=', 'class_section_mappings.id')
             ->join('session_setups', 'student_attendances.session_id', '=', 'session_setups.id')
             ->join('class_setups', 'student_attendances.classsetup_id', '=', 'class_setups.id')
             ->join('section_setups', 'student_attendances.sectionsetup_id', '=', 'section_setups.id')
             ->join('employees', 'student_attendances.teacher_id', '=', 'employees.id')
             ->select('student_attendances.*','session_setups.session_name', 'section_setups.section_name', 'class_setups.class_name', 'employees.employee_name')
             ->orderBy('student_attendances.attendeance_date', 'desc')
              -> get();
            return datatables()->of($data)
            ->addColumn('action', function ($data) {
                return view('backend.studentattendance.action', ['id' => base64_encode($data->id), 'sessionId'=>base64_encode($data->session_id), 'classmapingId'=>base64_encode($data->classsetup_id), 'sectionId'=>base64_encode($data->sectionsetup_id)]);
            })
            ->editColumn('attendeance_date', function ($data) {
                return date('d F Y', strtotime($data->attendeance_date));
            }) 
            ->editColumn('class_sec_id', function ($data) {
                return 'Present : '.StudentAttendanceTransactions::getPresent($data->id).'/Absent :'.StudentAttendanceTransactions::getAbsent($data->id);
            })
        ->make(true);
     
    }



    public function student_attendance_list(Request $request, $id, $sessionId, $classSetupId, $sectionID) {
        $title="Student Attendeance List";
        $sessionIds=base64_decode($sessionId);
         $sessionName=SessionSetups::getSessionName($sessionIds);
         $classmapingIds=base64_decode($classSetupId);
         $className=ClassSetups::getClassName($classmapingIds);
         $sectionId=base64_decode($sectionID);
         $sectionName=SectionSetups::getSectionName($sectionId);
        return view('backend.studentattendance.student_attendance_list', compact('id', 'sessionIds', 'classSetupId', 'sessionName', 'className', 'sectionId', 'title'));
    }

    public function studentattendancelistdata($attendanceId)
    {
         $id=base64_decode($attendanceId);
         $data = DB::table('student_attendance_transactions')
            ->where('student_attendance_transactions.student_attedance_id', '=', $id)
            ->join('student_attendances', 'student_attendance_transactions.student_attedance_id', '=', 'student_attendances.id')
             ->join('students', 'student_attendance_transactions.student_id', '=', 'students.id')
             ->join('parents', 'students.parent_id', '=', 'parents.id')
             ->join('employees', 'student_attendances.teacher_id', '=', 'employees.id')
             ->select('students.student_name','students.id', 'parents.father_name', 'parents.father_mobile_no', 'employees.employee_name', 'student_attendances.attendeance_date', 'student_attendance_transactions.status', 'student_attendance_transactions.id as attendTransID')
             ->orderBy('students.student_name', 'desc')
              -> get();
            return datatables()->of($data)
            ->addColumn('action', function ($data) {
                return view('backend.studentattendance.action1', ['id' => base64_encode($data->attendTransID), 'status' =>$data->status]);
            })
            ->editColumn('attendeance_date', function ($data) {
                return date('d F Y', strtotime($data->attendeance_date));
            }) 
            
        ->make(true);
     
    }

    public function update_attendance($id, $status){
         $id=base64_decode($id);
         $attendanceDetails=StudentAttendanceTransactions::find($id);
         $attendanceId=$attendanceDetails->student_attedance_id; 
         $attDetail=StudentAttendances::find($attendanceId);
         $curentDt = date('Y-m-d');
         if($curentDt!=$attDetail->attendeance_date){
                return redirect()->back()->with('error','Only current date attendance you change');
         }

         $dataarray = array(
                    'status'     => $status,
                );
          try {
                 $reply=StudentAttendanceTransactions::where('id', $id)->update($dataarray);
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
