<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Models\StudentClassAllotments;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Url;
use Carbon\Carbon;
use App\Exports\DateWiseCollectionExport;
use App\Exports\HeadWiseReportExport;
use App\Exports\ClassWiseFeeCollectionExport;
use App\Exports\MonthWisePendingFeeExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\ClassSetups;
use App\Models\SessionSetups;
use App\Models\SectionSetups;
use App\Models\ClassTeacherSetups;
use App\Models\Employees;

class InvoicesController extends Controller
{
    function __construct(){
        $this->middleware('permission:day-wise-invoice', ['only' => ['day_wise_invoice']]);
        $this->middleware('permission:month-wise-pending-fee', ['only' => ['month_wise_pending_fee']]);
        $this->middleware('permission:export-head-wise-collection', ['only' => ['export_head_wise_collection']]); 
        $this->middleware('permission:class-wise-collection', ['only' => ['class_wise_collection']]);
    }
    
    public function day_wise_invoice(Request $request) {
        $title="Day Wise Invoice ";
        if($request->input()){
            $fromDate   = date('Y-m-d', strtotime($request->input('from_date')));
            $toDate   = date('Y-m-d', strtotime($request->input('to_date')));
            $class_id    = $request->input('class_id');
            
            $data=DB::table('invoices')->select('invoices.*','students.student_name', 'students.admission_no',  'parents.father_name', 'students.id as studentId', 
                    'invoices.roll_no', 'class_setups.class_name', 'class_setups.id as classId', 'section_setups.section_name', 'section_setups.id as SectionId', 'users.name')
                     ->whereBetween('invoices.receipt_date', [$fromDate, $toDate])
                    //->orWhere('invoices.class_id', '=', $class_id)
                    ->join('students', 'invoices.student_id', '=', 'students.id')
                    ->join('parents', 'students.parent_id', '=', 'parents.id')
                    ->join('section_setups', 'invoices.section_id', '=', 'section_setups.id')
                    ->join('class_setups', 'invoices.class_id', '=', 'class_setups.id')
                    ->join('users', 'invoices.created_by', '=', 'users.id')->orderBy('invoices.id', 'desc')
                    ->when($class_id, function ($query, $class_id) {
                        return $query->where('invoices.class_id', '=', $class_id);
                    })->get();
                    $sum_payed_amt = $data->sum('payed_amt');
        } else {
            $data = array();
            $fromDate = "";
            $toDate = "";
            $class_id ="";
            $sum_payed_amt='0';
            
        } 
        
        return view('backend.invoice.day_wise_invoice', compact('data', 'title', 'fromDate', 'toDate', 'class_id', 'sum_payed_amt'));
     }
     
      public function month_wise_pending_fee(Request $request) {
        $title="Day Wise Invoice ";
        $month=DB::table('month_names')->select('month_names.*')->orderBy('order_by', 'asc')->get();
        if($request->input()){
            $this->validate($request, [
                'curent_month'=>'required',
                'sessionId'=>'required',
                'class_id'=>'required',
            ]);
            
            $sessionId    = $request->input('sessionId');
            $class_id    = $request->input('class_id');
            $curent_month   = $request->input('curent_month');
            $data=DB::table('student_class_allotments')
                    //->where('student_class_allotments.session_id', $sessionId)
                    ->where('student_class_allotments.session_id', $sessionId)
                    ->where('student_class_allotments.classsetup_id', $class_id)
                    ->whereNotIn('student_class_allotments.student_id', function ($query) use ($curent_month, $sessionId, $class_id) {
                        $query->select('student_id')
                            ->from('fee_collections')
                            ->where('payment_status', 1)
                            ->where('month_id', $curent_month)
                            ->where('session_setup_id', $sessionId)
                            ->where('class_setup_id', $class_id);;
                    })
                     ->join('students', 'student_class_allotments.student_id', '=', 'students.id')
             ->join('parents', 'students.parent_id', '=', 'parents.id')
             ->join('session_setups', 'student_class_allotments.session_id', '=', 'session_setups.id')
             ->join('class_setups', 'student_class_allotments.classsetup_id', '=', 'class_setups.id')
             ->join('section_setups', 'student_class_allotments.sectionsetup_id', '=', 'section_setups.id')
             ->select('students.*','parents.father_name', 'parents.mothers_name', 'parents.father_mobile_no', 'section_setups.section_name',
             'session_setups.session_name', 'class_setups.class_name', 'student_class_allotments.created_at', 
             'student_class_allotments.roll_no', 'student_class_allotments.id as studentAllmentId',  
             'student_class_allotments.action_type' ,  'student_class_allotments.performeance_status')
             ->orderBy('students.student_name', 'asc')->get();
        } else {
            $data = array();
            $curent_month = "";
            $sessionId ="";
            $class_id ="";
            
        } 
        return view('backend.invoice.month_wise_pending_fee', compact('data', 'title', 'curent_month', 'sessionId', 'class_id', 'month'));
     }
     
     public function export_month_wise_pending_fee(Request $request, $month, $sessionID, $classID) {
        return Excel::download(new MonthWisePendingFeeExport($month, $sessionID, $classID),  'pending-month-wise-fee.xlsx');
         /*$data = DB::table('student_class_allotments')
                    //->where('student_class_allotments.session_id', $sessionId)
                    ->where('student_class_allotments.session_id', $sessionID)
                    ->where('student_class_allotments.classsetup_id', $classID)
                    ->whereNotIn('student_class_allotments.student_id', function ($query) use ($month, $sessionID, $classID) {
                        $query->select('student_id')
                            ->from('fee_collections')
                            ->where('month_id', $month)
                            ->where('payment_status', 1)
                            ->where('session_setup_id', $sessionID)
                            ->where('class_setup_id', $classID);;
                    })
                     ->join('students', 'student_class_allotments.student_id', '=', 'students.id')
             ->join('parents', 'students.parent_id', '=', 'parents.id')
             ->join('session_setups', 'student_class_allotments.session_id', '=', 'session_setups.id')
             ->join('class_setups', 'student_class_allotments.classsetup_id', '=', 'class_setups.id')
             ->join('section_setups', 'student_class_allotments.sectionsetup_id', '=', 'section_setups.id')
             ->select('students.*','parents.father_name', 'parents.mothers_name', 'parents.father_mobile_no', 'section_setups.section_name',
             'session_setups.session_name', 'class_setups.class_name', 'student_class_allotments.created_at', 
             'student_class_allotments.roll_no', 'student_class_allotments.id as studentAllmentId',  
             'student_class_allotments.action_type' ,  'student_class_allotments.performeance_status')
             ->orderBy('students.student_name', 'asc')->get();*/
        return view('backend.exports.export_month_wise_pending_fee', compact('month', 'sessionID', 'classID', 'data'));
     }
     
      public function fee_register(Request $request, $studentID) {
        $title='Fee Collection Invoice ';
        $id=base64_decode($studentID);
       $data=DB::table('invoices')->select('invoices.*','students.student_name', 'students.admission_no',  'parents.father_name', 'students.id as studentId', 
                    'invoices.roll_no', 'class_setups.class_name', 'class_setups.id as classId', 'section_setups.section_name', 'section_setups.id as SectionId', 'users.name')
                    ->where('invoices.student_id', '=', $id)
                    ->join('students', 'invoices.student_id', '=', 'students.id')
                    ->join('parents', 'students.parent_id', '=', 'parents.id')
                    ->join('section_setups', 'invoices.section_id', '=', 'section_setups.id')
                    ->join('class_setups', 'invoices.class_id', '=', 'class_setups.id')
                    ->join('users', 'invoices.created_by', '=', 'users.id')->orderBy('invoices.id', 'desc')->get();
        return view('backend.invoice.fee_register', compact('title', 'data'));
     }
     
     public function export_day_wise_collection(Request $request, $fromDate, $toDate, $classID=null) {
        return Excel::download(new DateWiseCollectionExport($fromDate, $toDate, $classID),  'day-wise-invoice-list.xlsx');
     }
     
     public function export_head_wise_collection(Request $request, $fromDate, $toDate, $classID=null) {
        return Excel::download(new HeadWiseReportExport($fromDate, $toDate, $classID),  'head-wise-invoice-list.xlsx');
         /*$data = DB::table('invoices')->select('invoices.*','students.student_name', 'students.admission_no',  'parents.father_name', 'students.id as studentId', 
                    'invoices.roll_no', 'class_setups.class_name', 'class_setups.id as classId', 'section_setups.section_name', 'section_setups.id as SectionId', 'users.name')
                    ->whereBetween('invoices.receipt_date', [$fromDate, $toDate])
                    ->join('students', 'invoices.student_id', '=', 'students.id')
                    ->join('parents', 'students.parent_id', '=', 'parents.id')
                    ->join('section_setups', 'invoices.section_id', '=', 'section_setups.id')
                    ->join('class_setups', 'invoices.class_id', '=', 'class_setups.id')
                    ->join('users', 'invoices.created_by', '=', 'users.id')
                    ->when($classID, function ($query, $classID) {
                        return $query->where('invoices.class_id', $classID);
                    })
                    ->orderBy('invoices.id', 'desc')->get();
                    $sum_payed_amt = $data->sum('payed_amt');
        return view('backend.exports.head_wise_collection', compact('fromDate', 'toDate', 'classID', 'data', 'sum_payed_amt'));*/
     }
     
     public function curent_month_balance_fee(Request $request) {
        $title="Curent Month Balance";
            $curentSessionYear    = getSessionDefault();
            $month=ltrim(date('m'), '0'); 
            $data=DB::table('invoices')->select('invoices.*','students.student_name', 'students.admission_no',  'parents.father_name', 'students.id as studentId', 
                    'invoices.roll_no', 'class_setups.class_name', 'class_setups.id as classId', 'section_setups.section_name', 'section_setups.id as SectionId', 'users.name')
                    //->where('invoices.month_id', '=', $month)
                    ->where('invoices.curent_balance', '!=', 0)
                    ->where('invoices.session_id', '=', $curentSessionYear)
                    ->join('students', 'invoices.student_id', '=', 'students.id')
                    ->join('parents', 'students.parent_id', '=', 'parents.id')
                    ->join('section_setups', 'invoices.section_id', '=', 'section_setups.id')
                    ->join('class_setups', 'invoices.class_id', '=', 'class_setups.id')
                    ->join('users', 'invoices.created_by', '=', 'users.id')->orderBy('invoices.id', 'desc')->get();
                     $sum_payed_amt = $data->sum('curent_balance');
        return view('backend.invoice.curent_month_balance_fee', compact('data', 'title', 'sum_payed_amt'));
     }
     
     public function class_wise_collection(Request $request) {
        $title="Class Wise Fee Collection";
        $sessions= DB::table('student_class_allotments')
            ->join('session_setups', 'student_class_allotments.session_id', '=', 'session_setups.id')
            ->select('student_class_allotments.session_id', 'session_setups.session_name')
            ->groupBy('student_class_allotments.session_id', 'session_setups.session_name')
            ->orderBy('session_setups.order_by', 'desc')
            ->get();
        return view('backend.invoice.class_wise_collection', compact('sessions', 'title'));
     }
     
      public function export_class_wise_collection_report(Request $request, $sessionID, $classID, $sectionnID) {
        return Excel::download(new ClassWiseFeeCollectionExport($sessionID, $classID, $sectionnID),  'class-wise-fee-collection.xlsx');
         /*$data = StudentClassAllotments::where(['student_class_allotments.session_id'=>$this->sessionID, 'student_class_allotments.classsetup_id'=>$this->classID,
        'student_class_allotments.sectionsetup_id'=>$this->sectionID])
         ->join('students', 'student_class_allotments.student_id', '=', 'students.id')
            ->join('class_setups', 'student_class_allotments.classsetup_id', '=', 'class_setups.id')
            ->join('section_setups', 'student_class_allotments.sectionsetup_id', '=', 'section_setups.id')
           ->select('students.student_name', 'students.id', 'student_class_allotments.classsetup_id', 'student_class_allotments.sectionsetup_id')
           ->orderBy('students.student_name', 'asc')
           ->get();
           $className=ClassSetups::where(['id'=>$this->classID])->value('class_name');
           $sessionName=SessionSetups::where(['id'=>$this->sessionID])->value('session_name');
           $sectionName=SectionSetups::where(['id'=>$this->sectionID ])->value('section_name');
           $teacherID=ClassTeacherSetups::where(['session_id'=>$this->sessionID, 'class_id'=>$this->classID, 'section_id'=>$this->sectionID ])->value('teacher_id');
           $teacher=Employees::where(['id'=>$teacherID])->value('employee_name');*/
       
        return view('backend.exports.class_wise_collection_report', compact('sessionID', 'classID',  'data', 'className', 'sessionName', 'sessionName', 'teacher'));
     }
     
     
}
