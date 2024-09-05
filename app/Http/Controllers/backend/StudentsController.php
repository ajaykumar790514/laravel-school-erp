<?php

namespace App\Http\Controllers\backend;

use App\Models\Students;
use App\Models\Parents;
use App\Models\SessionSetups;
use App\Models\ClassSetups;
use App\Models\Religions;
use App\Models\CastCategorySetups;
use App\Models\Cities;
use App\Models\DocumentsSetups;
use App\Models\StudentDocuments;
use App\Models\User;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Url;
use Intervention\Image\ImageManagerStatic as Image;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ParentsImport;
use Maatwebsite\Excel\HeadingRowImport;

class StudentsController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:student-list');
         $this->middleware('permission:student-upload-documents', ['only' => ['upload_documents']]);
         $this->middleware('permission:student-delete-documents', ['only' => ['documentsdelete']]);
         $this->middleware('permission:student-view', ['only' => ['view']]);
         $this->middleware('permission:student-create', ['only' => ['create','store']]);
         $this->middleware('permission:add-more-student', ['only' => ['add_more_student']]);
         $this->middleware('permission:student-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:parents-edit', ['only' => ['parents_edit']]);
         $this->middleware('permission:student-delete', ['only' => ['destroy']]);
         $this->middleware('permission:parents-list', ['only' => ['parents_list']]);

    }
    
    public function importexcel(Request $request) {
        $filePath = "public/uploads/all.csv";
        
        $file="public/uploads/all.csv";
        $column= (new HeadingRowImport)->toArray($file);
        $excelChecker =Excel::toArray(array(), $file);
        
        $import = new ParentsImport;
        $import->import($file);
        
       echo  " Total records inserted ".$import->getInsertRowCount()." out of ".$import->getRowCount();
     }
    
    
    
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(Request $request) {
        $title='Student List';
        return view('backend.students.index', compact('title'));
     }

    public function datatable(){
            $data = DB::table('students')->select('students.*', 'session_setups.session_name as sessionName', 'class_setups.class_name as className',
            'parents.father_name as fatherNAme', 'parents.father_mobile_no')
             ->join('parents', 'students.parent_id', '=', 'parents.id')
              ->join('session_setups', 'students.session_id', '=', 'session_setups.id')
              ->join('class_setups', 'students.class_id', '=', 'class_setups.id');
            $result=$data->orderBy('students.id', 'DESC')->get();
            return datatables()->of($result)
            ->addColumn('action', function ($result) {
                    return view('backend.students.action', ['id'=>base64_encode($result->id), 'parentID'=>base64_encode($result->parent_id)]);
                })
           ->editColumn('created_at', function ($result) {
                    return Carbon::parse($result->created_at)->diffForHumans();
            })
            ->make(true);
    }
    
    
    public function parents_list(Request $request) {
        $title='Parents List';
        return view('backend.students.parents_list', compact('title'));
     }

    public function parentdatatable(){
            $data = DB::table('parents')->select('parents.*');
            $result=$data->orderBy('parents.father_name', 'asc')->get();
            return datatables()->of($result)
            ->addColumn('action', function ($result) {
                    return view('backend.students.action_parents', ['id'=>base64_encode($result->id)]);
                })
           ->editColumn('created_at', function ($result) {
                    return Carbon::parse($result->created_at)->diffForHumans();
            })
            ->editColumn('student', function ($result) {
                    $students=getStudentsByParentID($result->id);
                    $studentName='';
                    foreach($students as $student){
                        $studentName.=$student->student_name.' , ';
                    }
                    return rtrim($studentName, ", ");
            })
            ->make(true);
    }
    
    public function indexold(Request $request) {
        $title="Student List";
      $sessions= SessionSetups::select('id', 'session_name')->where(['status'=>0])->orderBy('session_name', 'desc')->get();
      $classes= ClassSetups::select('id', 'class_name')->where(['status'=>0])->orderBy('order_by', 'asc')->get();
       if($request->input()){
            $session_id     =$request->input('session_id');
            $class_id       =$request->input('class_id');
            $student_name   =$request->input('student_name');
            $father_name    =$request->input('father_name');
            $reg_date       =$request->input('reg_date');
            $query = DB::table('students')
             ->join('parents', 'students.parent_id', '=', 'parents.id')
              ->join('session_setups', 'students.session_id', '=', 'session_setups.id')
              ->join('class_setups', 'students.class_id', '=', 'class_setups.id')
              ->select('students.*','parents.father_name', 'session_setups.session_name', 'class_setups.class_name')
              ->orderBy('students.id', 'desc');

              $countresults = DB::table('students')
               ->join('parents', 'students.id', '=', 'parents.students_id')
              ->join('session_setups', 'students.session_id', '=', 'session_setups.id')
              ->join('class_setups', 'students.class_id', '=', 'class_setups.id')
              ->select('students.*','parents.father_name', 'session_setups.session_name', 'class_setups.class_name');
              


              if($session_id!="") {
                  $query->where('students.session_id', '=', $session_id);
                  $countresults->where('students.session_id', '=', $session_id);
              }
              if($class_id!="") {
                  $query->where('students.class_id', '=', $class_id);
                  $countresults->where('students.class_id', '=', $class_id);
              }

              if($student_name!="") {
                  $query->where('students.student_name', 'like', "%".$student_name."%");
                  $countresults->where('students.student_name', 'like', "%".$student_name."%");
              }

              if($father_name!="") {
                  $query->where('parents.father_name', 'like', "%".$father_name);
                   $countresults->where('parents.father_name', 'like', "%".$father_name);
              }
              if($reg_date!="") {
                  $query->where('students.reg_date', '=', date('Y-m-d', strtotime($reg_date)));
                  $countresults->where('students.reg_date', '=', date('Y-m-d', strtotime($reg_date)));
              }


               $data=$query->paginate(20);
               $countdata=$countresults->count();

              

       } else {

          $session_id     ="";
          $class_id       ="";
          $student_name   ="";
          $father_name    ="";
          $reg_date       ="";
         $data = DB::table('students')
             ->join('parents', 'students.parent_id', '=', 'parents.id')
             ->join('session_setups', 'students.session_id', '=', 'session_setups.id')
             ->join('class_setups', 'students.class_id', '=', 'class_setups.id')
             ->select('students.*','parents.father_name', 'session_setups.session_name', 'class_setups.class_name')
             ->orderBy('students.id', 'desc')
              ->paginate(20);

              $countdata = DB::table('students')
              ->join('parents', 'students.parent_id', '=', 'parents.id')
              ->join('session_setups', 'students.session_id', '=', 'session_setups.id')
              ->join('class_setups', 'students.class_id', '=', 'class_setups.id')
              ->select('students.*','parents.father_name', 'session_setups.session_name', 'class_setups.class_name')
              ->count();
       }


        return view('backend.students.index', compact('data', 'sessions', 'classes', 'countdata',
          'session_id', 'class_id', 'student_name', 'father_name', 'reg_date', 'title'));
     }

    public function studentsdatatable()
    {
        $data = DB::table('students')
             ->join('parents', 'students.id', '=', 'parents.students_id')
             ->join('session_setups', 'students.session_id', '=', 'session_setups.id')
             ->join('class_setups', 'students.class_id', '=', 'class_setups.id')
             ->select('students.*','parents.father_name', 'session_setups.session_name', 'class_setups.class_name')
             ->orderBy('students.id', 'desc')
              -> get();
        //echo "<pre>"; print_r($data); exit;
        return datatables()->of($data)
        ->addColumn('action', function ($data) {
                return view('students.action', ['id' => base64_encode($data->id)]);
            })
        ->editColumn('reg_date', function ($data) {
                return date('d F Y', strtotime($data->reg_date));
            })
        ->make(true);
        //->toJson();
    }

    public function autocomplete(Request $request){
        $data = Cities::select("name")
                ->where("name","LIKE","{$request->input('city')}%")
                ->get();
            return response()->json($data);

    }
    

    public function create(Request $request){
        $title="Student Registration";
        $now = Carbon::now();
         if($request->input()){
            $this->validate($request, [
                'session_id'=>'required',
                'reg_date'=>'required|date_format:d-m-Y',
                'class_id'=>'required', 
                'student_name'=>'required',
                //'student_email'=>'nullable|email', 
                'father_mobile_no'=>'required|numeric|digits:10|unique:parents',
                //'student_secondary_mobile'=>'nullable|numeric|digits:10',
                //'parents_mobile_whatsapp'=>'required|numeric|digits:10',
                'dob'=>'required|date_format:d-m-Y',
                'gender'=>'required',
                'religions_id'=>'required',
                'cast_category_setups_id'=>'required',
                'father_name'=>'required',
                'mothers_name'=>'required',
                'address'=>'required',
                'city'=>'required',
            ],
            [
                'session_id.required' => 'Select Session',
                'class_id.required' => 'Select Class',
                'cast_category_setups_id.required' => 'Select Category ',
            ]

            );
            /*parents details*/
            $data1 = new Parents;
            $data1->father_name               = $request->input('father_name');
            $data1->father_occupation         = $request->input('father_occupation');
            $data1->father_qualification      = $request->input('father_qualification');
            $data1->father_mobile_no          = $request->input('father_mobile_no');
            $data1->father_whatsapp_mobile	  = $request->input('father_whatsapp_mobile');
            $data1->fathere_income            = $request->input('fathere_income');
            $data1->father_email              = $request->input('father_email');
            $data1->mothers_name              = $request->input('mothers_name');
            $data1->mother_occup              = $request->input('mother_occup');
            $data1->mother_qalification       = $request->input('mother_qalification');
            $data1->mother_mobile_no          = $request->input('mother_mobile_no');
            $data1->mother_whatsapp_no       = $request->input('mother_whatsapp_no');
            $data1->guardian_name             = $request->input('guardian_name');
            $data1->guardian_occupation       = $request->input('guardian_occupation');
            $data1->guardian_qualification    = $request->input('guardian_qualification');
            $data1->guardian_mobile           = $request->input('guardian_mobile');
            $data1->address                   = $request->input('address');
            $data1->city                      = $request->input('city');
            $data1->relatives_first_name     = $request->input('relatives_first_name');
            $data1->relative_first_class     = $request->input('relative_first_class');
            $data1->relative_second_name     = $request->input('relative_second_name');
            $data1->relative_second_class    = $request->input('relative_second_class');
            $data1->users_id                 = Auth::id();
               try {
                    $reply=$data1->save();
                    $parentId=$data1->id;
                    $data = new Students;
                     $data->session_id               = $request->input('session_id');
                    $data->session_id               = $request->input('session_id');
                    $data->reg_date                = date('Y-m-d', strtotime($request->input('reg_date')));
                    $data->class_id                 = $request->input('class_id');
                    $data->parent_id                 = $parentId;
                    $data->student_name             = $request->input('student_name');
                    //$data->email                    = $request->input('student_email');
                    //$data->mobile_whatsapp          = $request->input('student_mobile_whatsapp');
                    //$data->secondary_mobile         = $request->input('student_secondary_mobile ');
                    $data->dob                      = date('Y-m-d', strtotime($request->input('dob')));
                    $data->gender                   = $request->input('gender');
                    $data->aadhar_No                = $request->input('aadhar_No');
                    $data->religions_id             = $request->input('religions_id');
                    $data->cast_category_setups_id  = $request->input('cast_category_setups_id');
                    $data->last_attended_class      = $request->input('last_attended_class');
                    $data->last_attended_school     = $request->input('last_attended_school');
                    $data->blood_group              = $request->input('blood_group');
                    $data->mark_identification      = $request->input('mark_identification');
                    $data->users_id                 = Auth::id();
                    
                    try {
                         $reply=$data->save();
                         $studentId=$data->id;
                         Students::where('id', $studentId)->update(['admission_no'=>$studentId]);
                     } catch(\Illuminate\Database\QueryException $e){
                           $errorCode = $e->errorInfo[1];  
                           $reply=$errorCode;        
                    }
                     
                     $replys=$data1->save();
                 } catch(\Illuminate\Database\QueryException $e){
                       $errorCode = $e->errorInfo[1];  
                       $reply=$errorCode;        
                }
             if($reply==1){
                return redirect('student-list')->with('success',config('app.saveMsg')); 
            } elseif($reply==1062) {
                return redirect()->back()->with('error',config('app.duplicateErrMsg'));
            } else {
                return redirect()->back()->with('error',$e->errorInfo[2]); 
            }
            
        }
        return view('backend.students.create', compact('title'));
    }


    public function upload_documents(Request $request, $id){
        $title="Upload documents";
        $studentId=base64_decode($id);
        $documentsData = DB::table('student_documents')
                    ->select('student_documents.*', 'documents_setups.name')
                 ->join('documents_setups', 'student_documents.document_type', '=', 'documents_setups.id')
                 ->where(['student_documents.student_id'=>$studentId])
                  ->get();
        if($request->input()){
            $this->validate($request, [
                'document_type'=>'required',
                'status'=>'required',
                'documents'=>'required',
            ]);
            $data = new StudentDocuments;
            $data->document_type           = $request->input('document_type');
            $data->student_id      = $studentId;
            $data->documents          = $request->input('documents');
            $data->users_id                 = Auth::id();
            try {
                     $reply=$data->save();
            } catch(\Illuminate\Database\QueryException $e){
                       $errorCode = $e->errorInfo[1];  
                       $reply=$errorCode;        
             }
            if($reply==1){
                 return redirect()->back()->with('success',config('app.uploadMsg'));;
            } else {
                return redirect()->back()->with('error',$e->errorInfo[2]);;
            }
        }
        return view('backend.students.uploads_documents', compact('id',  'title', 'documentsData'));
    }



     public function view(Request $request, $id) {
         $title='Student Details ';
        $studentId=base64_decode($id);
        $data = Students::where('id', $studentId)->with('parents', 'sessionsetup', 'classsetup', 'religions', 'castcategory')->first();;
        $documentsData = DB::table('student_documents')
                 ->join('documents_setups', 'student_documents.document_type', '=', 'documents_setups.id')
                 ->select('student_documents.*', 'documents_setups.name')
                 ->where(['student_documents.student_id'=>$studentId])
                  ->get();
            return view('backend.students.view', compact('data', 'documentsData', 'title', 'id'));
     }



    
    public function parents_edit(Request $request, $id, $studentID) {
        $parentsID=base64_decode($id);
        $data1=Parents::where(['id'=>$parentsID])->first();
        $title="Parents Details";
        if($request->input()){
            $this->validate($request, [
                'student_secondary_mobile'=>'nullable|numeric|digits:10',
                'father_mobile_no'=>'required|numeric|digits:10',
                'father_name'=>'required',
                'mothers_name'=>'required',
                'address'=>'required',
                'city'=>'required',
                'parents_email'=>'nullable|email', 
                
            ]
            
            );
            $data1=Parents::where(['id'=>$parentsID])->first();;
           $dataarray1 = array(
                'father_name'               => $request->input('father_name'),
                'father_occupation'         => $request->input('father_occupation'),
                'father_qualification'      => $request->input('father_qualification'),
                'father_dob'      => date('Y-m-d', strtotime($request->input('father_dob'))),
                'father_mobile_no'      => $request->input('father_mobile_no'),
                'father_whatsapp_mobile'      => $request->input('father_whatsapp_mobile'),
                'fathere_income'      => $request->input('fathere_income'),
                'father_email'      => $request->input('father_email'),
                 'mothers_name'              => $request->input('mothers_name'),
                 'mother_dob'              => $request->input('mother_dob'),
                'mother_occup'              => $request->input('mother_occup'),
                'mother_qalification'       => $request->input('mother_qalification'),
                'mother_mobile_no'       => $request->input('mother_mobile_no'),
                'mother_whatsapp_no'       => $request->input('mother_whatsapp_no'),
                'guardian_name'             => $request->input('guardian_name'),
                'guardian_occupation'       => $request->input('guardian_occupation'),
               'guardian_mobile'       => $request->input('guardian_mobile'),
                'address'                   => $request->input('address'),
                'city'                      =>$request->input('city'),
                'state'                      =>$request->input('state'),
               'relatives_first_name'     => $request->input('relatives_first_name'),
                'relative_first_class'     => $request->input('relative_first_class'),
                'relative_second_name'     => $request->input('relative_second_name'),
                'relative_second_class'     => $request->input('relative_second_class'),
               'users_id'                 => Auth::id()
               
            );

            try {
                 $reply=Parents::where('id', $parentsID)->update($dataarray1);
             } catch(\Illuminate\Database\QueryException $e){
                    $errorCode = $e->errorInfo[1];          
                    $reply=$errorCode;
            }
           // print_r($e->errorInfo); exit;
           if($reply==1){
              return redirect("student-view/$studentID")->with('success',config('app.updateMsg'));
            } elseif($reply==1062) {
                 return redirect()->back()->with('error',config('app.duplicateErrMsg'));;
            } else {
                return redirect()->back()->with('error',$e->errorInfo[2]); 
            }
         }
       
        return view('backend.students.parents_edit', ['data'=>$data1, 'title'=>$title, 'id'=>$id, 'studentID'=>$studentID]);
    }
    
     public function edit(Request $request, $ids) {
        $title="Edit Student Details";
        $id=base64_decode($ids);
        $data=Students::find($id);
        if($request->input()){
            $this->validate($request, [
                'student_name'=>'required',
                'email'=>'nullable|email', 
                'mobile_whatsapp'=>'nullable|numeric|digits:10',
                'student_secondary_mobile'=>'nullable|numeric|digits:10',
                'dob'=>'required',
                'gender'=>'required',
                'religions_id'=>'required',
                'cast_category_setups_id'=>'required',
            ],
            [
                'cast_category_setups_id.required' => 'Select Category ',
            ]

            );
            $data=Students::where('id', '=', $id)->first();
            $dataarray = array(
                'student_name'             => $request->input('student_name'),
                'email'                    => $request->input('email'),
                'mobile_whatsapp'          => $request->input('mobile_whatsapp'),
                'secondary_mobile'         => $request->input('student_secondary_mobile '),
                'dob'                      => date('Y-m-d', strtotime($request->input('dob'))),
                'gender'                   => $request->input('gender'),
                'aadhar_No'                => $request->input('aadhar_No'),
                'religions_id'             => $request->input('religions_id'),
                'cast_category_setups_id'  => $request->input('cast_category_setups_id'),
                'last_attended_class'      => $request->input('last_attended_class'),
                'last_attended_school'     => $request->input('last_attended_school'),
                'blood_group'              => $request->input('blood_group'),
                'mark_identification'      => $request->input('mark_identification'),
                'users_id'                 => Auth::id()
            );
           
            try {
                 $reply=Students::where('id', $id)->update($dataarray);
             } catch(\Illuminate\Database\QueryException $e){
                    $errorCode = $e->errorInfo[1];          
                    $reply=$errorCode;
            }
           if($reply==1){
             return redirect("student-view/$ids")->with('success',config('app.updateMsg'));
            } elseif($reply==1062) {
                 return redirect()->back()->with('error',config('app.duplicateErrMsg'));;
            } else {
                return redirect()->back()->with('error',config('app.saveError')); 
            }
         }
       
        return view('backend.students.edit', ['data'=>$data, 'title'=>$title]);
    }

     public function add_more_student(Request $request, $parentId) {
        $title="Add More Student";
        $id=base64_decode($parentId);
        $data=Parents::find($id);
        if($request->input()){
            $this->validate($request, [
                'session_id'=>'required',
                'class_id'=>'required', 
                'student_name'=>'required',
                'email'=>'nullable|email', 
                'mobile_whatsapp'=>'nullable|numeric|digits:10',
                'student_secondary_mobile'=>'nullable|numeric|digits:10',
                'dob'=>'required',
                'gender'=>'required',
                'religions_id'=>'required',
                'cast_category_setups_id'=>'required',
            ],
            [
                'cast_category_setups_id.required' => 'Select Category ',
            ]

            );
                $data = new Students;
                   $data->session_id               = $request->input('session_id');
                    $data->reg_date                = date('Y-m-d');
                    $data->class_id                 = $request->input('class_id');
                    $data->parent_id                 = $id;
                    $data->student_name             = $request->input('student_name');
                    $data->email                    = $request->input('student_email');
                    $data->mobile_whatsapp          = $request->input('student_mobile_whatsapp');
                    $data->secondary_mobile         = $request->input('student_secondary_mobile ');
                    $data->dob                      = date('Y-m-d', strtotime($request->input('dob')));
                    $data->gender                   = $request->input('gender');
                    $data->aadhar_No                = $request->input('aadhar_No');
                    $data->religions_id             = $request->input('religions_id');
                    $data->cast_category_setups_id  = $request->input('cast_category_setups_id');
                    $data->last_attended_class      = $request->input('last_attended_class');
                    $data->last_attended_school     = $request->input('last_attended_school');
                    $data->blood_group              = $request->input('blood_group');
                    $data->mark_identification      = $request->input('mark_identification');
                    $data->users_id                 = Auth::id();
           
            try {
                $reply=$data->save();
                $studentId=$data->id;
                Students::where('id', $studentId)->update(['admission_no'=>$studentId]);
             } catch(\Illuminate\Database\QueryException $e){
                    $errorCode = $e->errorInfo[1];          
                    $reply=$errorCode;
            }
           if($reply==1){
             return redirect("student-list")->with('success',config('app.updateMsg'));
            } elseif($reply==1062) {
                 return redirect()->back()->with('error',config('app.duplicateErrMsg'));;
            } else {
                return redirect()->back()->with('error',$e->errorInfo[2]); 
            }
         }
       
        return view('backend.students.add_more_student', ['data'=>$data, 'title'=>$title, 'parentId'=>$parentId]);
    }

     public function studentsdelete($id){
         $id=base64_decode($id);
         try {
                $reply=Students::where('id',$id)->delete();
             } catch(\Illuminate\Database\QueryException $e){
                    $errorCode = $e->errorInfo[1];          
            }
        if($reply==1){
            //Parents::where('students_id',$id)->delete();
            return redirect()->back()->with('success',config('app.deleteMsg'));
        } else if($reply==1451) {
            return redirect()->back()->with('error', $e->errorInfo[2]);
        } else {
             return redirect()->back()->with('error',config('app.deleteErrMsg'));
        }

        
    }
    
    public function parentdelete($id){
         $id=base64_decode($id);
         try {
                $reply=Parents::where('id',$id)->delete();
             } catch(\Illuminate\Database\QueryException $e){
                    $errorCode = $e->errorInfo[1];          
            }
        if($reply==1){
            return redirect()->back()->with('success',config('app.deleteMsg'));
        } else if($reply==1451) {
            return redirect()->back()->with('error', $e->errorInfo[2]);
        } else {
             return redirect()->back()->with('error',config('app.deleteErrMsg'));
        }

        
    }

    public function documentsdelete($id){
         $id=base64_decode($id);
         $data=StudentDocuments::find($id);
        $reply=StudentDocuments::where('id',$id)->delete();

        if($reply==1){
            $image_path = $data->documents;  // Value is not URL but directory file path
            if(File::exists($image_path)) {
                File::delete($image_path);
            }
            return redirect()->back()->with('success',config('app.deleteMsg'));
        } else {
            return redirect()->back()->with('error',config('app.deleteErrMsg'));
        }
        
    }

}
