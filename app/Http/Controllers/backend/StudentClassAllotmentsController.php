<?php
namespace App\Http\Controllers\backend;

use App\Models\SessionSetups;
use App\Models\ClassSetups;
use App\Models\StudentClassAllotments;
use App\Models\ClassSectionMappings;
use App\Models\Settings;
use App\Models\Students;
use App\Models\Parents;
use App\Models\SectionSetups;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class StudentClassAllotmentsController extends Controller
{
    function __construct(){
         $this->middleware('permission:student-class-allotment', ['only' => ['classallotment']]);
         $this->middleware('permission:allotment-list', ['only' => ['allotment_list']]);
         $this->middleware('permission:students-class-allotment-list', ['only' => ['students_class_allotment_list']]);
         $this->middleware('permission:student-class-promotion', ['only' => ['promotion']]);
         $this->middleware('permission:student-class-allotment', ['only' => ['promotion_list']]);
         $this->middleware('permission:student-promotion-delete', ['only' => ['promotiondelete']]);
         $this->middleware('permission:promoted-students', ['only' => ['promoted_student']]);
         $this->middleware('permission:promoted-studen-delete', ['only' => ['promoted_studen_delete']]);
         $this->middleware('permission:student-roll-number-allotment', ['only' => ['allotment_rollnumber']]);
         $this->middleware('permission:roll-number-allotment-list', ['only' => ['roll_number_allotment_list']]);
         $this->middleware('permission:students-rollnumber-alloted-list', ['only' => ['students_rollnumber_alloted_list']]);
         $this->middleware('permission:student-list-for-attendance', ['only' => ['student_list_for_attendance']]);
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function classallotment(Request $request) {
        $title="Class Allotments";
            if($request->input()){
                $this->validate($request, [
                'class_maping_id'=>'required',
                'session_id'=>'required', 
                ]);
                $class_id       = $request->input('class_maping_id');
                $session_id     = $request->input('session_id');
                //get already allotment student list
                $allotmentStudent = StudentClassAllotments::where(['class_maping_id'=>$class_id, 'session_id'=>$session_id])->select('student_id')->get()->toArray();
                $data =Students::where('students.session_id', '=', $session_id)->where('students.class_id', '=', $class_id)
                        ->with('parents', 'sessionsetup', 'classsetup', 'religions', 'castcategory')->orderBy('students.student_name', 'asc')->get();;

                $sections = DB::table('class_section_mappings')
                            ->join('section_setups', 'class_section_mappings.section_setup_id', '=', 'section_setups.id')
                            ->join('class_setups', 'class_section_mappings.class_setups_id', '=', 'class_setups.id')
                            ->select('class_section_mappings.id', DB::raw('CONCAT(class_setups.class_name, "->", section_setups.section_name) AS section_name'))
                            ->where('class_section_mappings.class_setups_id', '=', $class_id)
                            ->orderBy('section_setups.section_name', 'asc')
                            ->get();


            } else {
                $data = array();
                $class_id = "";
                $session_id ="";
                $sections=array();
        } 
            return view('backend.classallotment.classallotment', compact('data', 'class_id', 'session_id', 'sections', 'title'));
     }

     public function allotment(Request $request, $session_id) {
            $now = Carbon::now();
            $saveData='';
            $validator = Validator::make($request->all(), [
                'studentid'=>'required',
                'section_setup_id'=>'required',
            ],
            [
            'studentid.required' => 'Please select at least one student',
            'section_setup_id.required' => 'Please Select Section ',
            ]);
        
            if($validator->fails()){
                    return response()->json([
                        'status'=>400,
                        'errors'=>$validator->messages()
                    ]);
            }else{
                $multipalRecordss = [];
                foreach($request->input('studentid') as $studentId){
                    $classetupId=ClassSectionMappings::getClassSetupById($request->input('section_setup_id'));
                    $sectionId=ClassSectionMappings::getSectionIdByMapingId($request->input('section_setup_id'));
                   $checkStudent =StudentClassAllotments::where('session_id', '=', $session_id)
                                ->where('student_id', '=', $studentId)
                                 ->where('sectionsetup_id', '=', $sectionId)
                                 ->where('classsetup_id', '=', $classetupId)->count(); 
                    if($checkStudent==0){             
                        $multipalRecordss[] = [
                                'student_id'           => $studentId,
                                'session_id'           => $session_id,
                                'classsetup_id'         => $classetupId,
                                'sectionsetup_id'      =>$sectionId,
                                'class_maping_id'      => $request->input('section_setup_id'),
                                'section_maping_id'    => $request->input('section_setup_id'),
                                'action_type'    => 0,
                                'created_by'           => Auth::id(),
                        ];
                    }
                }
                try {
                   $reply= StudentClassAllotments::insert($multipalRecordss);
                } catch (\Illuminate\Database\QueryException $e) {
                    $errorCode = $e->errorInfo[1];
                }
                
                if ($reply==1) {
                    return response()->json([
                            'status'=>200,
                            'message'=>config('app.saveMsg')
                        ]);
                } else {
                    return response()->json([
                        'status'=>500,
                        'message'=>$e->errorInfo[2]
                    ]);
                }
                
                
               

            }
     }


     public function allotment_rollnumber(Request $request) {
        $title="Roll No. Allotment ";
        $sessions=DB::table('student_class_allotments')
            ->join('session_setups', 'student_class_allotments.session_id', '=', 'session_setups.id')
            ->select('student_class_allotments.session_id', 'session_setups.session_name')
            ->groupBy('student_class_allotments.session_id', 'session_setups.session_name')
            ->orderBy('session_setups.order_by', 'desc')
            ->get();
            
            $classesmaping = DB::table('student_class_allotments')
            ->join('section_setups', 'student_class_allotments.sectionsetup_id', '=', 'section_setups.id')
            ->join('class_setups', 'student_class_allotments.classsetup_id', '=', 'class_setups.id')
            ->select('student_class_allotments.class_maping_id', DB::raw('CONCAT(class_setups.class_name, "->", section_setups.section_name) AS section_name'))
            ->groupBy('student_class_allotments.class_maping_id', 'section_setups.section_name', 'class_setups.class_name')
            ->orderBy('class_setups.order_by', 'asc')
            ->get();
            
            if($request->input()){
                $this->validate($request, [
                'class_maping_id'=>'required',
                'session_id'=>'required', 
                ]);
                $class_id  = $request->input('class_maping_id');
                $session_id= $request->input('session_id');
                //get already allotment student list
                $data = DB::table('student_class_allotments')
                ->where('student_class_allotments.session_id', '=', $session_id)
                ->where('student_class_allotments.section_maping_id', '=', $class_id)
                ->join('class_section_mappings', 'student_class_allotments.class_maping_id', '=', 'class_section_mappings.id')
                ->join('students', 'student_class_allotments.student_id', '=', 'students.id')
                ->join('parents', 'students.parent_id', '=', 'parents.id')
                 ->join('session_setups', 'student_class_allotments.session_id', '=', 'session_setups.id')
                 ->join('section_setups', 'student_class_allotments.sectionsetup_id', '=', 'section_setups.id')
                ->join('class_setups', 'student_class_allotments.classsetup_id', '=', 'class_setups.id')
                 ->select('students.*', 'student_class_allotments.id as studentClassId',
                    'student_class_allotments.roll_no', 'student_class_allotments.session_id', 'student_class_allotments.performeance_status',   
                    'student_class_allotments.student_id', 'student_class_allotments.class_maping_id',  'parents.address', 'parents.father_name','parents.father_mobile_no as parentsmobile', 
                    'session_setups.session_year', 'class_setups.class_name', 'section_setups.section_name')->orderBy('students.student_name', 'asc')
                ->get();
               } else {
                    $data = array();
                    $class_id = "";
                    $session_id ="";
                    $sections=array();
             } 
            return view('backend.classallotment.allotment_rollnumber', compact('sessions', 'classesmaping', 'data', 'class_id', 'session_id', 'title'));
     }

     public function roll_number_allotment_list(){
        $title="Roll number Allotment List";
        $sessions = DB::table('student_class_allotments')
          ->where('student_class_allotments.roll_no', '!=', NULL)
            ->join('session_setups', 'student_class_allotments.session_id', '=', 'session_setups.id')
            ->join('class_section_mappings', 'student_class_allotments.class_maping_id', '=', 'class_section_mappings.id')
            ->join('section_setups', 'class_section_mappings.section_setup_id', '=', 'section_setups.id')
            ->join('class_setups', 'class_section_mappings.class_setups_id', '=', 'class_setups.id')
            ->select('session_setups.session_name', 'session_setups.id', 'student_class_allotments.class_maping_id', 'section_setups.section_name', 'class_setups.class_name', 'class_setups.id as classid')
            ->groupBy('session_setups.session_name', 'session_setups.id', 'student_class_allotments.class_maping_id', 'section_setups.section_name', 'class_setups.class_name', 'class_setups.id')
           ->orderBy('session_setups.order_by', 'desc')
             ->orderBy('class_setups.order_by', 'asc')
            ->paginate(15);
        return view('backend.classallotment.roll_number_allotment_list', ['sessions'=>$sessions, 'title'=>$title]);
    }

      public function rollnumber(Request $request) {
            $saveData='';
            $validator = Validator::make($request->all(), [
                'rollnumbertxt'=>'required',
            ],
            [
            'rollnumbertxt.required' => 'Please Enter Roll Number ',
            ]);
        
            if($validator->fails()){
                    return response()->json([
                        'status'=>400,
                        'errors'=>$validator->messages()
                    ]);
            }else{
                $multipalRecordss = [];
                $i=0;
                foreach($request->input('rollnumbertxt') as $rollnumber){
                    $dataarray1 = array(
                        'roll_no'               => $rollnumber,
                       'roll_assign_by'         => Auth::id()
                    );
                    $checkRoll=StudentClassAllotments::getDuplicateRoll($request->input('id')[$i], $request->input('sessionid')[$i], $request->input('classid')[$i], $rollnumber, $request->input('student_id')[$i]);
                    if($checkRoll>0){
                        /*return response()->json([
                            'status'=>500,
                            'message'=>"Please check roll number because roll number repeated."
                        ]);*/
                        //return redirect('student-roll-number-allotment')->with('error',config('app.duplicateRollNumber'));
                    }else {
                        StudentClassAllotments::where('id', $request->input('id')[$i])->update($dataarray1);
                    }
                    $i++;
                }
                return response()->json([
                        'status'=>200,
                        'message'=>config('app.saveMsg')
                    ]);
                
            }
            
            
            exit;
            if($request->input()){
                $this->validate($request, [
                'rollnumbertxt'=>'required',
                ],
                [
                'roll_number.required' => 'Please fill at least one student roll number',
                ]);

                $multipalRecordss = [];
                $i=0;
                foreach($request->input('rollnumbertxt') as $rollnumber){
                    $dataarray1 = array(
                        'roll_no'               => $rollnumber,
                       'roll_assign_by'         => Auth::id()
                    );
                    $checkRoll=StudentClassAllotments::getDuplicateRoll($request->input('id')[$i], $request->input('sessionid')[$i], $request->input('classid')[$i], $rollnumber, $request->input('student_id')[$i]);
                    if($checkRoll>0){
                        return redirect('student-roll-number-allotment')->with('error',config('app.duplicateRollNumber'));
                    }
                    StudentClassAllotments::where('id', $request->input('id')[$i])->update($dataarray1);

                    $i++;
                }

               return redirect('roll-number-allotment-list')->with('success',config('app.updateMsg'));
                
            }

     }

    public function promotion(Request $request) {
        $title="Student List for Class Promotion";
        $sessions= SessionSetups::select('id', 'session_name')->where(['status'=>0])->orderBy('order_by', 'desc')->get();
        $classesmaping = DB::table('student_class_allotments')
            ->join('class_section_mappings', 'student_class_allotments.class_maping_id', '=', 'class_section_mappings.id')
            ->join('section_setups', 'class_section_mappings.section_setup_id', '=', 'section_setups.id')
            ->join('class_setups', 'class_section_mappings.class_setups_id', '=', 'class_setups.id')
            ->select('student_class_allotments.class_maping_id', DB::raw('CONCAT(class_setups.class_name, "->", section_setups.section_name) AS section_name'))
            ->groupBy('student_class_allotments.class_maping_id', 'section_setups.section_name', 'class_setups.class_name')
            ->orderBy('class_setups.order_by', 'asc')
            ->get();
          
            if($request->input()){
                $this->validate($request, [
                 'class_maping_id'=>'required',
                 'session_id'=>'required',
                ]);
                $class_id               = $request->input('class_maping_id');
                 $session_id             = $request->input('session_id');
                //get already allotment student list
                $getClassSectionMaping = ClassSectionMappings::getClassSetupById($class_id); 
                //print_r($getClassSectionMaping); exit;
                $data = DB::table('student_class_allotments')
                //->whereNotIn('students.id',  $allotmentStudent)
                ->where('student_class_allotments.session_id', '=', $session_id)
                ->where('student_class_allotments.class_maping_id', '=', $class_id)
                ->where('student_class_allotments.roll_no', '!=',"" )
                ->join('class_section_mappings', 'student_class_allotments.class_maping_id', '=', 'class_section_mappings.id')
                ->join('students', 'student_class_allotments.student_id', '=', 'students.id')
                ->join('parents', 'students.parent_id', '=', 'parents.id')
                ->select('students.*',  'parents.address', 'parents.father_name','parents.father_mobile_no as parentsmobile', 'student_class_allotments.id as classAllotmentID', 'student_class_allotments.performeance_status')
                ->get();
                //print_r($data); exit;
                $sections = DB::table('class_section_mappings')
                            ->join('section_setups', 'class_section_mappings.section_setup_id', '=', 'section_setups.id')
                            ->join('class_setups', 'class_section_mappings.class_setups_id', '=', 'class_setups.id')
                            ->select('class_section_mappings.id', DB::raw('CONCAT(class_setups.class_name, "->", section_setups.section_name) AS section_name'))
                            //->where('class_section_mappings.class_setups_id', '=', $getClassSectionMaping)
                            ->orderBy('class_setups.order_by', 'asc')
                            ->get();
            } else {
                    $data = array();
                    $class_id = "";
                    $session_id ="";
                    $sections=array();

              } 
            return view('backend.classallotment.promotion', compact('sessions', 'classesmaping', 'data', 'class_id', 'session_id', 'sections', 'title'));
     }

     public function promoted(Request $request) {
            $now = Carbon::now();
            if($request->input()){
                $this->validate($request, [
                'studentid'=>'required',
                'Alloted_session_id'=>'required',
                'section_setup_id'=>'required',
                ],
                [
                'studentid.required' => 'Please select at least one student',
                'section_setup_id.required' => 'Please Select Section ',
                ]);

                $multipalRecordss = [];
                foreach($request->input('studentid') as $studentId){
                  $studentDetails=StudentClassAllotments::select('student_id', 'class_maping_id', 'session_id')->where(['id'=>$studentId])->first();  
                  $checkPromation=StudentClassAllotments::getAllotmentStudent($studentDetails->student_id, $request->input('Alloted_session_id'), $request->input('section_setup_id'));
                  if(empty($checkPromation)){
                    $multipalRecordss[] = [
                            'student_id'           => $studentDetails->student_id,
                            'session_id'           => $request->input('Alloted_session_id'),
                            'class_maping_id'      => $request->input('section_setup_id'),
                            'section_maping_id'    => $request->input('section_setup_id'),
                            'action_type'    => 1,
                            'std_class_allt_id'=>$studentId,
                            'created_by'           => Auth::id(),
                            'updated_at' => $now,  // remove if not using timestamps
                            'created_at' => $now   // remove if not using timestamps
                    ];
                    StudentClassAllotments::where('id', $studentId)->update(['performeance_status' =>0]);
                    $getUrl=Settings::getSettingValue('sms_url');
                    $studentName=Students::getStudentName($studentDetails->student_id);
                     $parentName=Parents::getParentName($studentDetails->student_id);
                     $attendancestatus=$studentId==0?"Present":"Absent";
                     $className=ClassSectionMappings::getClassNameByClassMapingID($request->input('section_setup_id')); 
                     $massage="Dear $studentName, You are promoted in $className successfully. Regards, Team Dr. P S Edu.";
                      $mobile=Parents::getParentWhatsappMobile($studentDetails->student_id);
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
                    $reply= StudentClassAllotments::insert($multipalRecordss);
                    return redirect('/admission/student-promotion-list')->with('success',config('app.allotmentStudent'));
                } catch(\Illuminate\Database\QueryException $e){
                       $errorCode = $e->errorInfo[1]; 
                    return redirect('/admission/student-promotion-list')->with('error',$errorCode);          
                }
               // print_r($e->errorInfo);

            }

     }



     public function getAllotmentSection(){
      $id=$_GET['id'];
      $sections= DB::table('class_section_mappings')
                            ->join('section_setups', 'class_section_mappings.section_setup_id', '=', 'section_setups.id')
                             //->select('class_section_mappings.id', 'section_setups.section_name')
                            ->where('class_section_mappings.class_setups_id', '=', $id)
                            ->orderBy('section_setups.section_name', 'asc')
                            ->pluck('section_setups.section_name', 'class_section_mappings.id');
      return json_encode($sections);
    }

    public function promotion_list(){
       $title="Student List for Class Promotion";
       $sessions = DB::table('student_class_allotments')
          ->where('student_class_allotments.action_type', '=', 1)
            ->join('session_setups', 'student_class_allotments.session_id', '=', 'session_setups.id')
            //->join('class_section_mappings', 'student_class_allotments.class_maping_id', '=', 'class_section_mappings.id')
            ->join('section_setups', 'student_class_allotments.sectionsetup_id', '=', 'section_setups.id')
            ->join('class_setups', 'student_class_allotments.classsetup_id', '=', 'class_setups.id')
            ->select('session_setups.session_name', 'session_setups.id', 'student_class_allotments.classsetup_id',  'student_class_allotments.sectionsetup_id', 'section_setups.section_name', 'class_setups.class_name', 'class_setups.id as classid')
            ->groupBy('session_setups.session_name', 'session_setups.id', 'student_class_allotments.classsetup_id', 'student_class_allotments.sectionsetup_id', 'section_setups.section_name', 'class_setups.class_name', 'class_setups.id')
            ->orderBy('session_setups.session_name', 'desc')
            ->paginate(15);
           
      return view('backend.classallotment.promotion_list', ['sessions'=>$sessions, 'title'=>$title]);
    }
    
    public function promoted_update(Request $request, $sessionId, $classId){
       $title="Student List for Promoted Section";
       $sessionID=base64_decode($sessionId);
       $classID=base64_decode($classId);
       $sections = DB::table('class_section_mappings')
                            ->join('section_setups', 'class_section_mappings.section_setup_id', '=', 'section_setups.id')
                            ->join('class_setups', 'class_section_mappings.class_setups_id', '=', 'class_setups.id')
                            ->select('class_section_mappings.section_setup_id', DB::raw('CONCAT(class_setups.class_name, "->", section_setups.section_name) AS section_name'))
                            ->where('class_section_mappings.class_setups_id', '=', $classID)
                            ->orderBy('class_setups.order_by', 'asc')
                            ->get();
       

       $data = DB::table('student_class_allotments')
                ->where('student_class_allotments.session_id', '=', $sessionID)
                ->where('student_class_allotments.classsetup_id', '=', $classID)
                ->where('student_class_allotments.action_type', '=',1 )
                ->join('class_section_mappings', 'student_class_allotments.class_maping_id', '=', 'class_section_mappings.id')
                ->join('students', 'student_class_allotments.student_id', '=', 'students.id')
                ->join('section_setups', 'student_class_allotments.sectionsetup_id', '=', 'section_setups.id')
                ->join('parents', 'students.parent_id', '=', 'parents.id')
                ->select('students.*',  'parents.address', 'parents.father_name','parents.father_mobile_no as parentsmobile', 
                'student_class_allotments.id as classAllotmentID', 'student_class_allotments.performeance_status', 'section_setups.section_name')
                ->get();
                
         if($request->input()){
                $this->validate($request, [
                'studentid'=>'required',
                'section_setup_id'=>'required',
                ],
                [
                'studentid.required' => 'Please select at least one student',
                'section_setup_id.required' => 'Please Select Section ',
                ]);

                $multipalRecordss = [];
                foreach($request->input('studentid') as $studentId){
                    if(!empty($studentId)){
                        StudentClassAllotments::where(['id'=>$studentId, 'session_id'=>$sessionID, 'classsetup_id'=>$classID])->update(['sectionsetup_id'=>$request->input('section_setup_id')]);
                    }
                   
                }
                try {
                    //$reply= StudentClassAllotments::insert($multipalRecordss);
                    return redirect()->back()->with('success',config('app.allotmentStudent'));
                } catch(\Illuminate\Database\QueryException $e){
                       $errorCode = $e->errorInfo[1]; 
                    return redirect('/admission/student-promotion-list')->with('error',$e->errorInfo[2]);          
                }

            }        
                
                

      return view('backend.classallotment.promoted_update', ['sessionId'=>$sessionId, 'classId'=>$classId, 'sections'=>$sections, 'data'=>$data, 'title'=>$title]);
    }

    public function promotiondelete($sessionId, $classmapingId){
         $sessionId=base64_decode($sessionId);
         $classmapingId=base64_decode($classmapingId);
        // echo '--'.$classmapingId; exit;
        
        
        try {
                 $reply=StudentClassAllotments::where(['session_id'=>$sessionId, 'class_maping_id'=>$classmapingId])->delete();
                 //exit;
             } catch(\Illuminate\Database\QueryException $e){
                    $errorCode = $e->errorInfo[1];          
                //if($errorCode == 1062){
                    $reply=$errorCode;
                //}
            }
         //print_r($reply);   exit;
        if($reply>0){
            return redirect()->back()->with('success',config('app.deleteMsg'));
        } else {
            return redirect()->back()->with('error',print_r($e->errorInfo));
        }
        
    }


    public function promoted_student(Request $request, $sessionId, $classId, $sectionID) {
        $title="Student List";
        return view('backend.classallotment.promoted_student', compact('sessionId', 'classId', 'sectionID', 'title'));
     }

    public function promotedstudentdatatable($sessionId, $classId, $sectionId){
         $sessionIds=base64_decode($sessionId);
         $classmapingIds=base64_decode($classId);
         $sectionId=base64_decode($sectionId);
        $data = DB::table('student_class_allotments')
            ->where('student_class_allotments.session_id', '=', $sessionIds)
            ->where('student_class_allotments.classsetup_id', '=', $classmapingIds)
            ->where('student_class_allotments.sectionsetup_id', '=', $sectionId)
            //->join('class_section_mappings', 'student_class_allotments.class_maping_id', '=', 'class_section_mappings.id')
            ->join('students', 'student_class_allotments.student_id', '=', 'students.id')
             ->join('parents', 'students.parent_id', '=', 'parents.id')
             ->join('session_setups', 'student_class_allotments.session_id', '=', 'session_setups.id')
             ->join('class_setups', 'student_class_allotments.classsetup_id', '=', 'class_setups.id')
             ->join('section_setups', 'student_class_allotments.sectionsetup_id', '=', 'section_setups.id')
             ->select('students.*','parents.father_name', 'section_setups.section_name', 'session_setups.session_name', 'class_setups.class_name', 'student_class_allotments.created_at', 'student_class_allotments.roll_no', 'student_class_allotments.id as studentAllmentId')
             ->orderBy('student_class_allotments.id', 'desc')
              -> get();
        //echo "<pre>"; print_r($data); exit;
        return datatables()->of($data)
        ->addColumn('action', function ($data) {
                return view('backend.classallotment.action', ['id' => base64_encode($data->studentAllmentId), 'rollnumber'=>$data->roll_no]);
            })
        ->editColumn('created_at', function ($data) {
                return date('d F Y', strtotime($data->created_at));
            })
        ->make(true);
        //->toJson();
    }

    public function students_rollnumber_alloted_list(Request $request, $sessionId, $classmapingId) {
        $title="Student Roll Number Alloted List";
        return view('backend.classallotment.students_rollnumber_alloted_list', compact('sessionId', 'classmapingId', 'title'));
     }

    public function student_list_datatable($sessionId, $classmapingId){
        $sessionIds=base64_decode($sessionId);
        $classmapingIds=base64_decode($classmapingId);
        $data = DB::table('student_class_allotments')
            ->where('student_class_allotments.session_id', '=', $sessionIds)
            ->where('student_class_allotments.class_maping_id', '=', $classmapingIds)
            ->where('student_class_allotments.roll_no', '!=', NULL)
            ->join('class_section_mappings', 'student_class_allotments.class_maping_id', '=', 'class_section_mappings.id')
            ->join('students', 'student_class_allotments.student_id', '=', 'students.id')
             ->join('parents', 'students.parent_id', '=', 'parents.id')
             ->join('session_setups', 'student_class_allotments.session_id', '=', 'session_setups.id')
             ->join('class_setups', 'student_class_allotments.classsetup_id', '=', 'class_setups.id')
             ->join('section_setups', 'student_class_allotments.sectionsetup_id', '=', 'section_setups.id')
             ->select('students.*','parents.father_name', 'section_setups.section_name', 'session_setups.session_name', 'class_setups.class_name', 'student_class_allotments.created_at', 'student_class_allotments.id as studentAllmentId', 'student_class_allotments.action_type', 'student_class_allotments.roll_no', 'student_class_allotments.performeance_status')
             ->orderBy('student_class_allotments.id', 'desc')
              -> get();
        return datatables()->of($data)
        ->addColumn('action', function ($data) {
                return view('backend.classallotment.action_student', ['id' => base64_encode($data->studentAllmentId)]);
            })
        ->editColumn('updated_at', function ($data) {
                return date('d F Y', strtotime($data->updated_at));
            })
        ->editColumn('action', function ($data) {
                if($data->performeance_status==2){
                    return 'Released';
                } else {
                   return view('backend.classallotment.action_student', ['id' => base64_encode($data->studentAllmentId)]); 
                }
                
            })
        ->make(true);
        //->toJson();
    }




    public function promoted_studen_delete($id){
         $id=base64_decode($id);
         try {
                 $data=StudentClassAllotments::where('id', '=', $id)->first();
                 $passedClassId=$data->std_class_allt_id;
                  StudentClassAllotments::where('id', $passedClassId)->update(['performeance_status' =>3]);
                 $reply=StudentClassAllotments::where(['id'=>$id])->delete();
                 //exit;
             } catch(\Illuminate\Database\QueryException $e){
                    $errorCode = $e->errorInfo[1];          
                //if($errorCode == 1062){
                    $reply=$errorCode;
                //}
            }
         //print_r($reply);   exit;
        if($reply==1){
            return redirect()->back()->with('success',config('app.deleteMsg'));
        } else {
            return redirect()->back()->with('error',print_r($e->errorInfo));
        }
        
    }


    public function released($id){
         $id=base64_decode($id);
         try {
                 $data = array('performeance_status'     => 2);
                 $reply=StudentClassAllotments::where('id', $id)->update($data);
             } catch(\Illuminate\Database\QueryException $e){
                    $errorCode = $e->errorInfo[1];          
                //if($errorCode == 1062){
                    $reply=$errorCode;
                //}
            }
         //print_r($reply);   exit;
        if($reply==1){
            return redirect()->back()->with('success',config('app.releaseMsg'));
        } else {
            return redirect()->back()->with('error',print_r($e->errorInfo));
        }
        
    }

    public function unalloted($id){
         $id=base64_decode($id);
        try {
                $reply=StudentClassAllotments::where('id',$id)->delete();
             } catch(\Illuminate\Database\QueryException $e){
                    $errorCode = $e->errorInfo[1];          
                //if($errorCode == 1062){
                    $reply=$errorCode;
                //}
            }
        if($reply==1){
            return redirect()->back()->with('success',"Student Un Alloted successfully!");
        } else if($reply==1451) {
            return redirect()->back()->with('error',config('app.deleteErrMsg1'));
        } else {
             return redirect()->back()->with('error',config('app.deleteErrMsg'));
        }
        
        
    }

    public function allotment_list()
    {
        $title="Allotment List";
        $sessions = DB::table('student_class_allotments')
          ->where('student_class_allotments.action_type', '=', 0)
            ->join('session_setups', 'student_class_allotments.session_id', '=', 'session_setups.id')
            ->join('class_section_mappings', 'student_class_allotments.class_maping_id', '=', 'class_section_mappings.id')
            ->join('section_setups', 'class_section_mappings.section_setup_id', '=', 'section_setups.id')
            ->join('class_setups', 'class_section_mappings.class_setups_id', '=', 'class_setups.id')
            ->select('session_setups.session_name', 'session_setups.id', 'student_class_allotments.class_maping_id', 'section_setups.section_name', 'class_setups.class_name', 'class_setups.id as classid')
            ->groupBy('session_setups.session_name', 'session_setups.id', 'student_class_allotments.class_maping_id', 'section_setups.section_name', 'class_setups.class_name', 'class_setups.id')
            ->orderBy('session_setups.session_name', 'desc')
            ->paginate(15);
      return view('backend.classallotment.allotment_list', ['sessions'=>$sessions, 'title'=>$title]);
    }

    public function students_class_allotment_list(Request $request, $sessionId, $classmapingId) {
        $title="Class Alloted Student List";
        return view('backend.classallotment.students_class_allotment_list', compact('sessionId', 'classmapingId', 'title'));
     }

     public function student_class_allotment_datatable($sessionId, $classmapingId){
         $sessionIds=base64_decode($sessionId);
         $classmapingIds=base64_decode($classmapingId);
                   
        $data = DB::table('student_class_allotments')
            ->where('student_class_allotments.session_id', '=', $sessionIds)
            ->where('student_class_allotments.class_maping_id', '=', $classmapingIds)
            ->where('student_class_allotments.action_type', '=', 0)
            ->join('students', 'student_class_allotments.student_id', '=', 'students.id')
             ->join('parents', 'students.parent_id', '=', 'parents.id')
             ->join('session_setups', 'student_class_allotments.session_id', '=', 'session_setups.id')
             ->join('class_setups', 'student_class_allotments.classsetup_id', '=', 'class_setups.id')
             ->join('section_setups', 'student_class_allotments.sectionsetup_id', '=', 'section_setups.id')
             ->select('students.*','parents.father_name', 'section_setups.section_name', 'session_setups.session_name',
             'class_setups.class_name', 'student_class_allotments.created_at', 'student_class_allotments.id as studentAllmentId', 'student_class_allotments.action_type')
             ->orderBy('student_class_allotments.id', 'desc')
              -> get();
        return datatables()->of($data)
        ->addColumn('action', function ($data) {
                return view('backend.classallotment.action_class_student', ['id' => base64_encode($data->studentAllmentId)]);
            })
        ->editColumn('created_at', function ($data) {
                return date('d F Y', strtotime($data->created_at));
            })
        ->make(true);
        //->toJson();
    }



    public function student_list_for_attendance($sessionId, $classmapingId, $section){
        $title="Student List For Attendeance";
         $sessionIds=base64_decode($sessionId);
         $sessionName=SessionSetups::getSessionName($sessionIds);
         $classsetupIds=base64_decode($classmapingId);
         $sectionID=base64_decode($section);
         $className=ClassSetups::getClassName($classsetupIds);
         $sectionName=SectionSetups::getSectionName($sectionID);
         $data = DB::table('student_class_allotments')
            ->where('student_class_allotments.session_id', '=', $sessionIds)
            ->where('student_class_allotments.classsetup_id', '=', $classsetupIds)
            ->where('student_class_allotments.sectionsetup_id', '=', $sectionID)
            ->where('student_class_allotments.action_type', '!=', 2)
            ->where('student_class_allotments.action_type', '!=', 3)
            ->where('student_class_allotments.action_type', '!=', 4)
            ->where('student_class_allotments.performeance_status', '!=', 2)
            ->where('student_class_allotments.roll_no', '!=', NULL)
           ->join('students', 'student_class_allotments.student_id', '=', 'students.id')
             ->join('parents', 'students.parent_id', '=', 'parents.id')
             ->join('session_setups', 'student_class_allotments.session_id', '=', 'session_setups.id')
             ->join('class_setups', 'student_class_allotments.classsetup_id', '=', 'class_setups.id')
             ->join('section_setups', 'student_class_allotments.sectionsetup_id', '=', 'section_setups.id')
             ->select('students.student_name','parents.father_name', 'section_setups.section_name', 'session_setups.session_name', 'class_setups.class_name', 'student_class_allotments.roll_no', 'student_class_allotments.id as studentAllmentId', 'student_class_allotments.student_id')
             ->orderBy('students.student_name', 'asc')
              -> get();
        return view('backend.classallotment.student_list_for_attendance', compact('data', 'sessionName', 'className', 'sessionIds', 'classsetupIds', 'sectionID', 'title', 'sectionName'));
    }





    

}
