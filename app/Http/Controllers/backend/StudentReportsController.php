<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Models\SessionSetups;
use App\Models\Students;
use App\Models\ClassSetups;
use App\Models\StudentClassAllotments;
use App\Models\ClassSectionMappings;
use App\Models\Settings;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Exports\StudentsExport;
use App\Exports\StudentsAllExport;
use Maatwebsite\Excel\Facades\Excel;



class StudentReportsController extends Controller
{
    function __construct(){
         $this->middleware('permission:classes-register', ['only' => ['classes_register']]);
         $this->middleware('permission:student-search', ['only' => ['student_search']]);
         
    }

    public function classes_register(Request $request) {
        $title="Session Wise Class Register";
        $sessions= DB::table('student_class_allotments')
            ->join('session_setups', 'student_class_allotments.session_id', '=', 'session_setups.id')
            ->select('student_class_allotments.session_id', 'session_setups.session_name')
            ->groupBy('student_class_allotments.session_id', 'session_setups.session_name')
            ->orderBy('session_setups.order_by', 'desc')
            ->get();
        return view('backend.studentreports.classes_register', compact('sessions', 'title'));
     }

     public function student_register(Request $request, $sessionId, $classMapingId, $sectionId) {
         $title="Student List";
        return view('backend.studentreports.student_register', compact('sessionId', 'classMapingId', 'sectionId', 'title'));
     }
     
     public function export_student_class_wise(Request $request, $sessionId, $classId, $sectionId) {
        return Excel::download(new StudentsExport(base64_decode($sessionId), base64_decode($classId), base64_decode($sectionId)), 'student-list.xlsx');
        
     }
     
     public function export_student_all_data(Request $request) {
        return Excel::download(new StudentsAllExport(), 'student-list.xlsx');
        
     }

     public function studentregisterdata($sessionId,$classSettupId, $sectionID){
        $sessionIds=base64_decode($sessionId);
        $classmapingIds=base64_decode($classSettupId);
        $section=base64_decode($sectionID);
        $data = DB::table('student_class_allotments')
            ->where('student_class_allotments.session_id', '=', $sessionIds)
            ->where('student_class_allotments.classsetup_id', '=', $classmapingIds)
            ->where('student_class_allotments.sectionsetup_id', '=', $section)
            ->join('students', 'student_class_allotments.student_id', '=', 'students.id')
             ->join('parents', 'students.parent_id', '=', 'parents.id')
             ->join('session_setups', 'student_class_allotments.session_id', '=', 'session_setups.id')
             ->join('class_setups', 'student_class_allotments.classsetup_id', '=', 'class_setups.id')
             ->join('section_setups', 'student_class_allotments.sectionsetup_id', '=', 'section_setups.id')
             ->select('students.*','parents.father_name', 'parents.mothers_name', 'section_setups.section_name',
             'session_setups.session_name', 'class_setups.class_name', 'student_class_allotments.created_at', 
             'student_class_allotments.roll_no', 'student_class_allotments.id as studentAllmentId',  
             'student_class_allotments.action_type' ,  'student_class_allotments.performeance_status')
             ->orderBy('students.student_name', 'asc')
              -> get();
        //echo "<pre>"; print_r($data); exit;
        return datatables()->of($data)
        ->addColumn('action', function ($data) {
                /*return view('studentreports.action', ['id' => base64_encode($data->studentAllmentId), 'rollnumber'=>$data->roll_no]);*/
                return '';
            })
       
        ->make(true);
        //->toJson();
    }

    public function student_search(Request $request) {
        $title="Student Search Register";
        if($request->input()){
                $student_name   = $request->input('student_name');
                $father_name    = $request->input('father_name');
                $data = DB::table('students')
                        ->where('students.student_name', 'like', '%'. $student_name . '%')
                        ->where('parents.father_name', 'like', '%'. $father_name . '%')
                        ->join('parents', 'students.parent_id', '=', 'parents.id')
                         ->select('students.*','parents.father_name', 'parents.address')
                         ->orderBy('students.student_name', 'asc')
                          -> get();
        } else {
            $data = array();
            $student_name = "";
            $father_name ="";
            
        } 
        
        return view('backend.studentreports.student_search', compact('data', 'title'));
     }

     public function student_records(Request $request, $id) {
        $title="Student Details";
        $studentId=base64_decode($id);
        if($id!=''){
                $data = DB::table('student_class_allotments')
            ->where('student_class_allotments.student_id', '=', $studentId)
            ->join('class_section_mappings', 'student_class_allotments.class_maping_id', '=', 'class_section_mappings.id')
            ->join('students', 'student_class_allotments.student_id', '=', 'students.id')
             ->join('parents', 'students.parent_id', '=', 'parents.id')
             ->join('session_setups', 'student_class_allotments.session_id', '=', 'session_setups.id')
             ->join('class_setups', 'class_section_mappings.class_setups_id', '=', 'class_setups.id')
             ->join('section_setups', 'class_section_mappings.section_setup_id', '=', 'section_setups.id')
             ->select('students.*','parents.father_name', 'section_setups.section_name', 'session_setups.session_name', 'class_setups.class_name', 'student_class_allotments.created_at', 'student_class_allotments.roll_no', 'student_class_allotments.id as studentAllmentId',  'student_class_allotments.action_type' ,  'student_class_allotments.performeance_status')
             ->orderBy('student_class_allotments.id', 'desc')
              -> get();
        } else {
            $data = array();
        } 
        
        return view('backend.studentreports.student_records', compact('data', 'title'));
     }


    

     public function not_enrolled_students(Request $request) {
        $title="Not Enrolled Students";
        return view('backend.studentreports.not_enrolled_students', compact('title'));
     }


}
