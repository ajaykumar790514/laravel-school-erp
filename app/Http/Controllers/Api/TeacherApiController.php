<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\User;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Support\Facades\DB;
use App\Models\Students;
use App\Models\Parents;
use App\Models\SessionSetups;
use App\Models\StudentClassAllotments;
use App\Models\Invoices;
use App\Models\FeeCollections;

class TeacherApiController extends Controller
{
     public function teacher_dashboard(Request $request){
        $teacherId = $request->input('teacherId') ;
        if(!empty($teacherId)){
            $daildiaryCount=DB::table('daily_diaries')->select("id");
            $daildiaryCount->whereIn('daily_diaries.session_id', function($query) use ($teacherId)
            {
                $query->select('session_id')->from('class_teacher_setups')
                ->where('teacher_id', '=', $teacherId)
                ->groupBy('session_id');
            });
            $daildiaryCount->whereIn('daily_diaries.class_id', function($query) use ($teacherId)
            {
                $query->select('class_id')->from('class_teacher_setups')
                ->where('teacher_id', '=', $teacherId)
                ->groupBy('class_id');
            });
            $daildiaryCount->orWhereIn('daily_diaries.class_id', function($query) use ($teacherId)
            {
                $query->select('subject_class_mappings.class_setups_id')->from('teacher_subject_mapings')
            ->join('subject_class_mappings', 'teacher_subject_mapings.subject_id', '=', 'subject_class_mappings.subject_setups_id')
          ->where('teacher_subject_mapings.teacher_id', '=', $teacherId)
          ->groupBy('subject_class_mappings.class_setups_id');
            }); 
            $resultDailyDiarry=$daildiaryCount->count();
            
            $assignmentCount=DB::table('assignment_holidays')
            ->where(['assignment_holidays.status'=>0, 'assignment_holidays.teacher_id'=>$teacherId, 'assignment_holidays.session_id'=>getSessionDefault()])
            ->count();
            
            $noticeCount=DB::table('notices')
            ->where(['notices.status'=>0, 'notices.teacher_id'=>$teacherId, 'notices.session_id'=>getSessionDefault()])
            ->count();
            
             $eventsCount=DB::table('events')
            ->where(['events.status'=>0, 'events.session_id'=>getSessionDefault()])
            ->count();
            
            $attendeanceClass = DB::table('class_teacher_setups')
                ->where(['class_teacher_setups.teacher_id'=>$teacherId, 'class_teacher_setups.session_id'=>getSessionDefault()] )
                ->join('session_setups', 'class_teacher_setups.session_id', '=', 'session_setups.id')
                ->join('section_setups', 'class_teacher_setups.section_id', '=', 'section_setups.id')
                ->join('class_setups', 'class_teacher_setups.class_id', '=', 'class_setups.id')
                 ->select('class_teacher_setups.id', 'class_teacher_setups.session_id', 'class_teacher_setups.class_id', 'class_teacher_setups.section_id', 'class_setups.class_name', 'section_setups.section_name',  'session_setups.session_name')
                  ->orderBy('class_setups.class_name', 'asc')->get();
            
            
            
            $data['dailyDiaryCount'] =$resultDailyDiarry; 
            $data['assignmentCount'] =$assignmentCount; 
            $data['noticeCount'] =$noticeCount; 
            $data['eventsCount'] =$eventsCount; 
            $data['invoiceCount'] =0;
            $data['subjectsCount'] =0;
            $data['classesForAttendeance'] =$attendeanceClass; 
             return (new BaseController)->sendResponse($data, 'Dashboard Details');  
            exit;
        } else{
            return (new BaseController)->sendError('Please login again', "");
        }
        
    }
    
    public function teacher_dailydiary_all(Request $request){
       $dailydiarylist=array();
         $teacherId = $request->input('teacherId') ;
        if(!empty($teacherId)){
            $data= DB::table('daily_diaries')
            ->join('employees', 'daily_diaries.teacher_id', '=', 'employees.id')
             //->join('class_section_mappings', 'daily_diaries.class_id', '=', 'class_section_mappings.id')
             ->join('session_setups', 'daily_diaries.session_id', '=', 'session_setups.id')
             ->join('class_setups', 'daily_diaries.class_id', '=', 'class_setups.id')
             ->join('section_setups', 'daily_diaries.section_id', '=', 'section_setups.id')
             ->select('daily_diaries.*','session_setups.session_name', 'section_setups.section_name', 'class_setups.class_name', 'employees.employee_name');
             
                   $data->whereIn('daily_diaries.session_id', function($query) use ($teacherId)
                    {
                        $query->select('session_id')->from('class_teacher_setups')
                        ->where('teacher_id', '=', $teacherId)
                        ->groupBy('session_id');
                    });
                    $data->orwhereIn('daily_diaries.class_id', function($query) use ($teacherId)
                    {
                        $query->select('class_id')->from('class_teacher_setups')
                        ->where('teacher_id', '=', $teacherId)
                        ->groupBy('class_id');
                    });
                    $data->orwhereIn('daily_diaries.class_id', function($query) use ($teacherId)
                    {
                        $query->select('subject_class_mappings.class_setups_id')->from('teacher_subject_mapings')
                    ->join('subject_class_mappings', 'teacher_subject_mapings.subject_id', '=', 'subject_class_mappings.subject_setups_id')
                   ->where('teacher_subject_mapings.teacher_id', '=', $teacherId)
                   ->groupBy('subject_class_mappings.class_setups_id');
                    }); 
          

            $result=$data->get();
            if(!empty($result)){
                foreach($result as $dailyDiaryDetails){
                    $dailydiarylists['id']     =$dailyDiaryDetails->id; 
                    $dailydiarylists['className']       =$dailyDiaryDetails->class_name; 
    				$dailydiarylists['sectionName']     =$dailyDiaryDetails->section_name;
    				$dailydiarylists['title']           =$dailyDiaryDetails->title;
    				$dailydiarylists['upload_content']  =$dailyDiaryDetails->upload_content; 
    				$dailydiarylists['attachment']      =$dailyDiaryDetails->attachment==""?"":asset($dailyDiaryDetails->attachment); 
    				$dailydiarylists['teacher']         =$dailyDiaryDetails->employee_name;
    				$dailydiarylists['created_date']       =date('d F Y H:i:s', strtotime($dailyDiaryDetails->created_at));
    				array_push($dailydiarylist,$dailydiarylists);  
                }
                return (new BaseController)->sendResponse($dailydiarylist, 'Daily Diary Lis');
            } else{
                 return (new BaseController)->sendError('You have no any children register in this school', "");
            }
        } else{
            return (new BaseController)->sendError('Token not found please login again', "");
        }
        
    }
    
    public function dashboard_daily_diary(Request $request){
       $dailydiarylist=array();
        $parentId = $request->input('parentId') ;
        if(!empty($parentId)){
            $dailyDiaries=DB::table('daily_diaries')->select('daily_diaries.*', 'class_setups.class_name', 'class_setups.id as classId', 'section_setups.section_name', 
                    'section_setups.id as SectionId', 'employees.employee_name')
                    ->join('section_setups', 'daily_diaries.section_id', '=', 'section_setups.id')
                    ->join('class_setups', 'daily_diaries.class_id', '=', 'class_setups.id')
                    ->join('employees', 'daily_diaries.teacher_id', '=', 'employees.id')
                    ->where('daily_diaries.session_id', getSessionDefault())
                    ->where(['daily_diaries.status'=>0])
                    ->whereIn('class_id', function ($query) use ($parentId) {
                    $query->select('classsetup_id')
                      ->from('student_class_allotments')
                      ->join('students', 'student_class_allotments.student_id', '=', 'students.id')
                      ->where('students.parent_id', $parentId)->where('student_class_allotments.session_id', getSessionDefault());
                    })
                    ->orderBy('daily_diaries.id', 'desc')
                    ->limit(3)->get();

            if(!empty($dailyDiaries)){
                foreach($dailyDiaries as $dailyDiaryDetails){
                    $dailydiarylists['id']     =$dailyDiaryDetails->id; 
                    $dailydiarylists['className']     =$dailyDiaryDetails->class_name; 
    				$dailydiarylists['sectionName']   =$dailyDiaryDetails->section_name;
    				$dailydiarylists['title']   =$dailyDiaryDetails->title;
    				$dailydiarylists['upload_content']         =$dailyDiaryDetails->upload_content; 
    				$dailydiarylists['attachment']       =$dailyDiaryDetails->attachment==""?"":asset($dailyDiaryDetails->attachment); 
    				$dailydiarylists['teacher']       =$dailyDiaryDetails->employee_name;
    				$dailydiarylists['created_date']       =date('d F Y H:i:s', strtotime($dailyDiaryDetails->created_at));
    				
    				array_push($dailydiarylist,$dailydiarylists);  
                }
                return (new BaseController)->sendResponse($dailydiarylist, 'Daily Diary Lis');
            } else{
                 return (new BaseController)->sendError("We haven't found any data", "");
            }
        } else{
            return (new BaseController)->sendError('Please login again', "");
        }
        
    }
    
    public function daily_diary_all(Request $request){
        $dailydiarylist=array();
        $parentId = $request->input('parentId') ;
        if(!empty($parentId)){
            $dailyDiaries=DB::table('daily_diaries')->select('daily_diaries.*', 'class_setups.class_name', 'class_setups.id as classId', 'section_setups.section_name', 
                    'section_setups.id as SectionId', 'employees.employee_name')
                    ->join('section_setups', 'daily_diaries.section_id', '=', 'section_setups.id')
                    ->join('class_setups', 'daily_diaries.class_id', '=', 'class_setups.id')
                    ->join('employees', 'daily_diaries.teacher_id', '=', 'employees.id')
                    ->where('daily_diaries.session_id', getSessionDefault())
                    ->where(['daily_diaries.status'=>0])
                    ->whereIn('class_id', function ($query) use ($parentId) {
                    $query->select('classsetup_id')
                      ->from('student_class_allotments')
                      ->join('students', 'student_class_allotments.student_id', '=', 'students.id')
                      ->where('students.parent_id', $parentId)->where('student_class_allotments.session_id', getSessionDefault());
                    })
                    ->orderBy('daily_diaries.id', 'desc')->get();

            if(!empty($dailyDiaries)){
                foreach($dailyDiaries as $dailyDiaryDetails){
                    $dailydiarylists['id']     =$dailyDiaryDetails->id; 
                    $dailydiarylists['className']     =$dailyDiaryDetails->class_name; 
    				$dailydiarylists['sectionName']   =$dailyDiaryDetails->section_name;
    				$dailydiarylists['title']   =$dailyDiaryDetails->title;
    				$dailydiarylists['upload_content']         =$dailyDiaryDetails->upload_content; 
    				$dailydiarylists['attachment']       =$dailyDiaryDetails->attachment==""?"":asset($dailyDiaryDetails->attachment); 
    				$dailydiarylists['teacher']       =$dailyDiaryDetails->employee_name;
    				$dailydiarylists['created_date']       =date('d F Y H:i:s', strtotime($dailyDiaryDetails->created_at));
    				
    				array_push($dailydiarylist,$dailydiarylists);  
                }
                return (new BaseController)->sendResponse($dailydiarylist, 'Daily Diary Lis');
            } else{
                 return (new BaseController)->sendError("We haven't found any data", "");
            }
        } else{
            return (new BaseController)->sendError('Please login again', "");
        }
        
    }
    
    public function assignment_all(Request $request){
        $assignmentList=array();
        $parentId = $request->input('parentId') ;
        if(!empty($parentId)){
            $assignmentAll=DB::table('assignment_holidays')->select('assignment_holidays.*', 'class_setups.class_name', 'section_setups.section_name', 
                     'employees.employee_name')
                    ->join('section_setups', 'assignment_holidays.section_id', '=', 'section_setups.id')
                    ->join('class_setups', 'assignment_holidays.class_id', '=', 'class_setups.id')
                    ->join('employees', 'assignment_holidays.teacher_id', '=', 'employees.id')
                    ->where('assignment_holidays.session_id', getSessionDefault())
                    ->where(['assignment_holidays.status'=>0])
                    ->whereIn('class_id', function ($query) use ($parentId) {
                    $query->select('classsetup_id')
                      ->from('student_class_allotments')
                      ->join('students', 'student_class_allotments.student_id', '=', 'students.id')
                      ->where('students.parent_id', $parentId)->where('student_class_allotments.session_id', getSessionDefault());
                    })
                    ->orderBy('assignment_holidays.id', 'desc')->get();
               

            if(!empty($assignmentAll)){
                foreach($assignmentAll as $assignmentDetails){
                    $assignmentlists['id']              =$assignmentDetails->id; 
                    $assignmentlists['className']       =$assignmentDetails->class_name; 
    				$assignmentlists['sectionName']     =$assignmentDetails->section_name;
    				$assignmentlists['title']           =$assignmentDetails->title;
    				$assignmentlists['upload_content']  =$assignmentDetails->upload_content; 
    				$assignmentlists['attachment']      =$assignmentDetails->attachment==""?"":asset($assignmentDetails->attachment); 
    				$assignmentlists['teacher']         =$assignmentDetails->employee_name;
    				$assignmentlists['created_date']    =date('d F Y H:i:s', strtotime($assignmentDetails->created_at));
    				
    				array_push($assignmentList,$assignmentlists);  
                }
                return (new BaseController)->sendResponse($assignmentList, 'Assignment List');
            } else{
                 return (new BaseController)->sendError("We haven't found any data", "");
            }
        } else{
            return (new BaseController)->sendError('Please login again', "");
        }
        
    }
    
    public function notice_all(Request $request){
        $noticeList=array();
        $parentId = $request->input('parentId') ;
        if(!empty($parentId)){
            $noticeAll=DB::table('notices')->select('notices.*', 'employees.employee_name')
                    ->join('employees', 'notices.teacher_id', '=', 'employees.id')
                    ->where('notices.session_id', getSessionDefault())
                    ->where(['notices.status'=>0])
                    ->orderBy('notices.id', 'desc')->get();
               

            if(!empty($noticeAll)){
                foreach($noticeAll as $noticeDetails){
                    $noticelists['id']              =$noticeDetails->id; 
    				$noticelists['title']           =$noticeDetails->title;
    				$noticelists['content']         =$noticeDetails->content; 
    				if($noticeDetails->priority==0){
    				    $priority="Normal";
    				} elseif($noticeDetails->priority==1){
    				    $priority="Heigh";
    				} else{
    				    $priority="Low";
    				}
    				$noticelists['priority']         =$priority; 
    				$noticelists['attachments']      =$noticeDetails->attachments==""?"":asset($noticeDetails->attachments); 
    				$noticelists['teacher']         =$noticeDetails->employee_name;
    				$noticelists['created_date']    =date('d F Y H:i:s', strtotime($noticeDetails->created_at));
    				
    				array_push($noticeList,$noticelists);  
                }
                return (new BaseController)->sendResponse($noticeList, 'Notice List');
            } else{
                 return (new BaseController)->sendError("We haven't found any data", "");
            }
        } else{
            return (new BaseController)->sendError('Please login again', "");
        }
        
    }
    
    public function events_all(Request $request){
        $eventList=array();
        $parentId = $request->input('parentId') ;
        $eventAll=DB::table('events')->select('events.*', 'events_categories.name')
                     ->join('events_categories', 'events.events_category_id', '=', 'events_categories.id')
                    ->where('events.session_id', getSessionDefault())
                    ->where(['events.status'=>0])
                    ->orderBy('events.id', 'desc')->get();

            if(!empty($eventAll)){
                foreach($eventAll as $eventsDetails){
                    $eventslists['id']              =$eventsDetails->id;
                    $eventslists['category']       =$eventsDetails->name; 
    				$eventslists['note']           =$eventsDetails->note;
    				$eventslists['descriptions']    =$eventsDetails->descriptions; 
    				$eventslists['attachments']     =$eventsDetails->attachments==""?"":asset($eventsDetails->attachments); 
    				$eventslists['date_from']    =date('d F Y', strtotime($eventsDetails->date_from));
    				$eventslists['date_to']    =date('d F Y', strtotime($eventsDetails->date_to));
    				$eventslists['created_date']    =date('d F Y', strtotime($eventsDetails->created_at));
    				
    				array_push($eventList,$eventslists);  
                }
                return (new BaseController)->sendResponse($eventList, 'Event List');
            } else{
                 return (new BaseController)->sendError("We haven't found any data", "");
            }
        
        
    }
    
    public function dashboard_invoice(Request $request){
       $invoicelist=array();
        $parentId = $request->input('parentId') ;
        if(!empty($parentId)){
            $invoices=DB::table('invoices')->select('invoices.*','students.student_name',  
                    'class_setups.class_name', 'section_setups.section_name')
                    ->join('students', 'invoices.student_id', '=', 'students.id')
                    ->join('section_setups', 'invoices.section_id', '=', 'section_setups.id')
                    ->join('class_setups', 'invoices.class_id', '=', 'class_setups.id')
                    ->where(['invoices.status'=>1])
                    ->whereIn('student_id', function ($query) use ($parentId) {
                    $query->select('id')
                      ->from('students')
                      ->where('parent_id', $parentId);
                    })
                    ->orderBy('invoices.id', 'desc')
                    ->limit(5)->get();

            if(!empty($invoices)){
                foreach($invoices as $invoicesDetails){
                    $invoiceslists['id']     =$invoicesDetails->id; 
                    $invoiceslists['className']     =$invoicesDetails->class_name; 
    				$invoiceslists['sectionName']   =$invoicesDetails->section_name;
    				$invoiceslists['student_name']    =$invoicesDetails->student_name;
    				$invoiceslists['paid_amount']   =$invoicesDetails->grand_total;
    				$invoiceslists['receipt_date']    =date('d F Y', strtotime($invoicesDetails->receipt_date)); 
    				$invoiceslists['invoice_no']       =$invoicesDetails->invoice_no; 
    				array_push($invoicelist,$invoiceslists);  
                }
                return (new BaseController)->sendResponse($invoicelist, 'Invoice List ');
            } else{
                 return (new BaseController)->sendError("We haven't found any data", "");
            }
        } else{
            return (new BaseController)->sendError('Please login again', "");
        }
        
    }
    
    public function invoice_all(Request $request){
       $invoicelist=array();
        $parentId = $request->input('parentId') ;
        if(!empty($parentId)){
            $invoices=DB::table('invoices')->select('invoices.*','students.student_name',  
                    'class_setups.class_name', 'section_setups.section_name')
                    ->join('students', 'invoices.student_id', '=', 'students.id')
                    ->join('section_setups', 'invoices.section_id', '=', 'section_setups.id')
                    ->join('class_setups', 'invoices.class_id', '=', 'class_setups.id')
                    ->where(['invoices.status'=>1])
                    ->whereIn('student_id', function ($query) use ($parentId) {
                    $query->select('id')
                      ->from('students')
                      ->where('parent_id', $parentId);
                    })->orderBy('invoices.id', 'desc')->get();

            if(!empty($invoices)){
                foreach($invoices as $invoicesDetails){
                    $invoiceslists['id']     =$invoicesDetails->id; 
                    $invoiceslists['className']     =$invoicesDetails->class_name; 
    				$invoiceslists['sectionName']   =$invoicesDetails->section_name;
    				$invoiceslists['student_name']    =$invoicesDetails->student_name;
    				$invoiceslists['paid_amount']   =$invoicesDetails->grand_total;
    				$invoiceslists['receipt_date']    =date('d F Y', strtotime($invoicesDetails->receipt_date)); 
    				$invoiceslists['invoice_no']       =$invoicesDetails->invoice_no; 
    				array_push($invoicelist,$invoiceslists);  
                }
                return (new BaseController)->sendResponse($invoicelist, 'Invoice List');
            } else{
                 return (new BaseController)->sendError("We haven't found any data", "");
            }
        } else{
            return (new BaseController)->sendError('Please login again', "");
        }
        
    }
    
    public function invoice_details(Request $request){
        $invoices=array();
        $parentId = $request->input('parentId') ;
        $invoiceId = $request->input('invoiceId') ;
        if(!empty($parentId)){
            $invoiceDetails= Invoices::select('invoices.invoice_no', 'invoices.receipt_no', 
                        'invoices.receipt_date', 'invoices.total_amt', 'invoices.late_fee',
                        'invoices.discount', 'invoices.old_balance', 'invoices.grand_total', 
                        'invoices.payed_amt', 'invoices.curent_balance', 'students.student_name', 'parents.father_name', 
                        'class_setups.class_name', 'section_setups.section_name', 'session_setups.session_name', 'users.name')
                        ->join('session_setups', 'invoices.session_id', '=', 'session_setups.id')
                        ->join('students', 'invoices.student_id', '=', 'students.id')
                        ->join('parents', 'students.parent_id', '=', 'parents.id')
                        ->join('section_setups', 'invoices.section_id', '=', 'section_setups.id')
                        ->join('class_setups', 'invoices.class_id', '=', 'class_setups.id')
                        ->join('users', 'invoices.created_by', '=', 'users.id')
                        ->where(['invoices.invoice_no'=>$invoiceId])->first();
                        
            if(!empty($invoiceDetails)){
                $amtWorld=amountToWordCopy($invoiceDetails->payed_amt);
                    $invoiceDetail = [
                        'receipt_no' => $invoiceDetails->receipt_no,
                        'receipt_date' => date('d F Y', strtotime($invoiceDetails->receipt_date)),
                        'total_amt' => $invoiceDetails->total_amt,
                        'late_fee' => $invoiceDetails->late_fee,
                        'discount' => $invoiceDetails->discount==null?0:$invoiceDetails->discount,
                        'old_balance' => $invoiceDetails->old_balance,
                        'grand_total' => $invoiceDetails->grand_total,
                        'payed_amt' => $invoiceDetails->payed_amt,
                        'payed_amt_world' =>$amtWorld,
                        'curent_balance' => $invoiceDetails->curent_balance,
                        'student_name' => $invoiceDetails->student_name,
                        'father_name' => $invoiceDetails->father_name,
                        'session_name' => $invoiceDetails->session_name,
                        'class_name' => $invoiceDetails->class_name,
                        'section_name' => $invoiceDetails->section_name,
                        'createdBy' => $invoiceDetails->name,
                    ];
    				
                $collections = FeeCollections::select('fee_collections.month_id', 'month_names.month_name')
                            ->join('month_names', 'fee_collections.month_id', '=', 'month_names.id')
                            ->where(['fee_collections.unique_invoice_no' => $invoiceId, 'fee_collections.payment_status' => 1])
                            ->groupBy('fee_collections.month_id',  'month_names.month_name')
                            ->get();
                 foreach ($collections as $collection) {
                    $month=ltrim(date($collection->month_id), '0');
                    $amount = FeeCollections::where(['month_id'=>$month, 'unique_invoice_no'=>$invoiceId, 'payment_status'=>1])->sum('amount');
                    $collectionDetails = [
                        'month_name' => $collection->month_name,
                        'amount' =>$amount,
                    ];
                    $invoiceDetail['collections'][] = $collectionDetails;
                }
                //array_push($invoices,$invoiceDetail);  
                
               $invoices[] = $invoiceDetail;
                return (new BaseController)->sendResponse($invoices, 'Invoice Details');
            } else{
                 return (new BaseController)->sendError('Something error please try again.', "");
            }
        } else{
            return (new BaseController)->sendError('Token not found please login again', "");
        }
    }
    
    public function student_profile(Request $request){
        $studentDetails=array();
        $studentID = $request->input('studentID') ;
        if(!empty($studentID)){
            $childrens= Students::select('students.*', 'parents.father_name', 'parents.mothers_name')
                        ->join('parents', 'students.parent_id', '=', 'parents.id')
                        ->where(['students.id'=>$studentID])->first();
            if(!empty($childrens)){
                 $studentProfile = ['studentId'=>$childrens->id,
                    				'studentName'=>$childrens->student_name,
                    				'fatherName'=>$childrens->father_name,
                    				'motherName'=>$childrens->mothers_name,
                    				'studentPhoto'=>$childrens->student_photo,
                    				'admission_no'=>$childrens->admission_no,
                    				'reg_date'=>date('d F Y', strtotime($childrens->reg_date)), 
                    				'dob'=>date('d F Y', strtotime($childrens->dob)),  
                    				'gender'=>$childrens->gender==0?"Male":"Female" ];
                
				
				$studentClasses= StudentClassAllotments::select('session_setups.session_name', 
                				'class_setups.class_name',  
                				'section_setups.section_name', 'student_class_allotments.roll_no')
                                ->join('session_setups', 'student_class_allotments.session_id', '=', 'session_setups.id')
                                ->join('class_setups', 'student_class_allotments.classsetup_id', '=', 'class_setups.id')
                                ->join('section_setups', 'student_class_allotments.sectionsetup_id', '=', 'section_setups.id')
                                ->where(['student_id'=>$studentID])->orderBy('student_class_allotments.id', 'desc')
                                ->get();
                
                foreach($studentClasses as $classHistory){
                    $classHistory = [
                            'sessionName'=>$classHistory->session_name, 
            				'ClassName'=>$classHistory->class_name,
            				'SectionName'=>$classHistory->section_name,
            				'RollNumber'=>$classHistory->roll_no
                                        ];
                     
    				$studentProfile['classes'][] = $classHistory; 
                }
                $studentDetails[] = $studentProfile;
                return (new BaseController)->sendResponse($studentDetails, 'Student Profile');
            } else{
                 return (new BaseController)->sendError('Student Id invalid! Please login again', "");
            }
        } else{
            return (new BaseController)->sendError('Student Not Found! Please login again', "");
        }
        
    }
    
    
    
    
}
