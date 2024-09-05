<?php

namespace App\Http\Controllers\parents;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\DailyDiaries;
use App\Models\User;
use App\Models\Students;
use Carbon\Carbon;

class ParentsController extends Controller
{
    
    public function dashboard(){
        $title="Parents Dashboard";
        $user = auth()->user(); 
        $parentId=$user->user_id;
        $totalStudents=DB::table('students')->where('parent_id', '=', $parentId)->count();
        $invoices=DB::table('invoices')->select('invoices.*','students.student_name', 'students.admission_no',  'parents.father_name', 'students.id as studentId', 
                    'invoices.roll_no', 'class_setups.class_name', 'class_setups.id as classId', 'section_setups.section_name', 'section_setups.id as SectionId', 'users.name')
                    ->join('students', 'invoices.student_id', '=', 'students.id')
                    ->join('parents', 'students.parent_id', '=', 'parents.id')
                    ->join('section_setups', 'invoices.section_id', '=', 'section_setups.id')
                    ->join('class_setups', 'invoices.class_id', '=', 'class_setups.id')
                    ->join('users', 'invoices.created_by', '=', 'users.id')
                    ->whereIn('student_id', function ($query) use ($parentId) {
                    $query->select('id')
                      ->from('students')
                      ->where('parent_id', $parentId);
                    })
                    ->orderBy('invoices.id', 'desc')
                    ->limit(10)->get();
        $totalInvoice = $invoices->count(); 
        $dailyDiary=DB::table('daily_diaries')->select('daily_diaries.*', 'class_setups.class_name', 'class_setups.id as classId', 'section_setups.section_name', 
                    'section_setups.id as SectionId')
                    ->join('section_setups', 'daily_diaries.section_id', '=', 'section_setups.id')
                    ->join('class_setups', 'daily_diaries.class_id', '=', 'class_setups.id')
                    ->where('daily_diaries.session_id', getSessionDefault())
                    ->whereIn('class_id', function ($query) use ($parentId) {
                    $query->select('classsetup_id')
                      ->from('student_class_allotments')
                      ->join('students', 'student_class_allotments.student_id', '=', 'students.id')
                      ->where('students.parent_id', $parentId)->where('student_class_allotments.session_id', getSessionDefault());
                    })
                    ->orderBy('daily_diaries.id', 'desc')
                    ->limit(10)->get();
        $noticeBoard=DB::table('notices')->where(['session_id'=>getSessionDefault()]) ->orderBy('invoices.id', 'desc')->count();
        
      	return view('parents.dashboard', compact('title', 'totalStudents', 'totalInvoice', 'invoices', 'noticeBoard', 'dailyDiary'));
    }
    
    public function daily_diary_view(Request $request, $id){
        $dailydiaryID=base64_decode($id);
        $dailydiary=DailyDiaries::getDetails($dailydiaryID);
        $title=$dailydiary->title;
      	return view('parents.daily_diary_view', compact('title', 'dailydiary'));
    }
    
    public function daily_diary_list(Request $request){
        $title="Daily Diary List";
        $user = auth()->user(); 
        $parentId=$user->user_id;
        $data = DB::table('daily_diaries')->select('daily_diaries.*', 'session_setups.session_name', 'class_setups.class_name', 
                'class_setups.id as classId', 'section_setups.section_name', 'employees.employee_name',
                    'section_setups.id as SectionId')
                    ->join('session_setups', 'daily_diaries.session_id', '=', 'session_setups.id')
                    ->join('section_setups', 'daily_diaries.section_id', '=', 'section_setups.id')
                    ->join('class_setups', 'daily_diaries.class_id', '=', 'class_setups.id')
                    ->join('employees', 'daily_diaries.teacher_id', '=', 'employees.id')
                    ->where('daily_diaries.session_id', getSessionDefault())
                    ->whereIn('class_id', function ($query) use ($parentId) {
                    $query->select('classsetup_id')
                      ->from('student_class_allotments')
                      ->join('students', 'student_class_allotments.student_id', '=', 'students.id')
                      ->where('students.parent_id', $parentId)->where('student_class_allotments.session_id', getSessionDefault());
                    })
                    ->orderBy('daily_diaries.id', 'desc')->get();
      	return view('parents.daily_diary_list', compact('title', 'data'));
    }
    
    public function assignment_for_parents(Request $request) {
    	$user = auth()->user();
        $user = auth()->user(); 
        $parentsID=$user->user_id;
       $parentsDetails = Parents::select('students_id')->where(['id'=> $parentsID])->first(); 
        $studentId=$parentsDetails->students_id;
        $data = DB::table('assignment_holidays')
            ->join('employees', 'assignment_holidays.teacher_id', '=', 'employees.id')
             ->join('class_section_mappings', 'assignment_holidays.class_id', '=', 'class_section_mappings.id')
             ->join('session_setups', 'assignment_holidays.session_id', '=', 'session_setups.id')
             ->join('class_setups', 'class_section_mappings.class_setups_id', '=', 'class_setups.id')
             ->join('section_setups', 'class_section_mappings.section_setup_id', '=', 'section_setups.id')
             ->select('assignment_holidays.*','session_setups.session_name', 'section_setups.section_name', 'class_setups.class_name', 'employees.employee_name')
             ->orderBy('assignment_holidays.id', 'desc');

             $data->whereIn('assignment_holidays.class_id', function($query) use ($studentId)
                {
                    $query->select('class_maping_id')->from('student_class_allotments')
                    ->where('student_id', '=', $studentId);
                });
                $result=$data->paginate(20);

        return view('parents.assignment_for_parents', compact('result'));
    }
    
    public function studentlist(Request $request){
        $title="Student List";
        $user = auth()->user(); 
        $parentId=$user->user_id;
        $data = DB::table('student_class_allotments')->select('students.dob', 'students.student_name', 'students.id')
                    ->join('students', 'student_class_allotments.student_id', '=', 'students.id')
                    ->whereIn('student_id', function ($query) use ($parentId) {
                    $query->select('id')
                      ->from('students')
                      ->where('students.parent_id', $parentId);
                    })
                    ->orderBy('students.student_name', 'asc')->get();
      	return view('parents.studentlist', compact('title', 'data'));
    }
    
    public function student_view(Request $request, $id) {
         $title='Student Details ';
        $studentId=base64_decode($id);
        $data = Students::where('id', $studentId)->with('parents', 'sessionsetup', 'classsetup', 'religions', 'castcategory')->first();;
        $documentsData = DB::table('student_documents')
                 ->join('documents_setups', 'student_documents.document_type', '=', 'documents_setups.id')
                 ->select('student_documents.*', 'documents_setups.name')
                 ->where(['student_documents.student_id'=>$studentId])
                  ->get();
            return view('parents.student_view', compact('data', 'documentsData', 'title', 'id'));
     }
     
    public function invoicelist(Request $request) {
        $title='Invoice List';
        $user = auth()->user(); 
        $parentId=$user->user_id;
        $invoices=DB::table('invoices')->select('invoices.*','students.student_name', 'students.admission_no',  'parents.father_name', 'students.id as studentId', 
                    'invoices.roll_no', 'class_setups.class_name', 'class_setups.id as classId', 'section_setups.section_name', 'section_setups.id as SectionId', 'users.name')
                    ->join('students', 'invoices.student_id', '=', 'students.id')
                    ->join('parents', 'students.parent_id', '=', 'parents.id')
                    ->join('section_setups', 'invoices.section_id', '=', 'section_setups.id')
                    ->join('class_setups', 'invoices.class_id', '=', 'class_setups.id')
                    ->join('users', 'invoices.created_by', '=', 'users.id')
                    ->whereIn('student_id', function ($query) use ($parentId) {
                    $query->select('id')
                      ->from('students')
                      ->where('parent_id', $parentId);
                    })
                    ->orderBy('invoices.id', 'desc')
                    ->limit(10)->get();
            return view('parents.invoicelist', compact('invoices', 'title'));
     }

}
