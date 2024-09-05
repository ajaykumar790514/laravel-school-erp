<?php

namespace App\Http\Controllers\backend;

use App\Models\TeacherSubjectMapings;
use App\Models\Employees;
use App\Models\SubjectSetups;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TeacherSubjectMapingsController extends Controller
{
    
    function __construct()
    {
         $this->middleware('permission:teacher-subject-maping-list');
         $this->middleware('permission:teacher-subject-maping-create', ['only' => ['create','store']]);
         $this->middleware('permission:teacher-subject-maping-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:teacher-subject-maping-delete', ['only' => ['destroy']]);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $title="Teacher subject Maping";
        return view('backend.teachersubject.index', compact('title'));
     }

    public function teachersubjectmapingsdata()
    {
        $data = DB::table('teacher_subject_mapings')
             ->join('employees', 'teacher_subject_mapings.teacher_id', '=', 'employees.id')
             ->join('subject_setups', 'teacher_subject_mapings.subject_id', '=', 'subject_setups.id')
             ->select('teacher_subject_mapings.*', 'subject_setups.subject_name', 'employees.employee_name')
             ->where(['employee_type'=>0])
              -> get();
        return datatables()->of($data)
        ->addColumn('action', function ($data) {
                return view('backend.teachersubject.action', ['id' => base64_encode($data->id)]);
            })
        ->editColumn('created_at', function ($data) {
                return Carbon::parse($data->created_at)->diffForHumans();
            })
        ->make(true);
        //->toJson();
    }
    

    public function create(Request $request){
        $title="Teacher subject Maping Create";
        $teachers = Employees::select('id', 'employee_name')->where(['status'=>0, 'employee_type'=>'0'])->get();
        $now = Carbon::now();
         if($request->input()){
            $this->validate($request, [
                'teacher_id'=>'required',
                'subject_id'=>'required',
                'status'=>'required',
                
            ]);
            $multipalRecordss = [];
            $teacher_id=$request->input('teacher_id');
            foreach($request->input('subject_id') as $sectionKey){
                $checkUniqe= TeacherSubjectMapings::select('id')->where(
                    [
                        'teacher_id'=>$teacher_id, 
                        'subject_id'=>$sectionKey
                    ]
                )->get();
                $checkDuplicateRecord=count($checkUniqe);
               if($checkDuplicateRecord==0){
                    $multipalRecordss[] = [
                        'teacher_id'           => $teacher_id,
                        'subject_id'           => $sectionKey,
                        'status'          => $request->input('status'),
                        'created_by'          => Auth::id(),
                        'created_at' => $now   // remove if not using timestamps
              
                 ];
                } else{
                    return redirect('/academics/teacher-subject-maping-list')->with('error',config('app.duplicateErrMsg')); 
                }

             }
               try {
                    $reply= TeacherSubjectMapings::insert($multipalRecordss);
                 } catch(\Illuminate\Database\QueryException $e){
                       $errorCode = $e->errorInfo[1];          
                }
             if($reply==1){
                return redirect('/academics/teacher-subject-maping-list')->with('success',config('app.saveMsg')); 
            } elseif($reply==1062) {
                return redirect()->back()->with('error',config('app.duplicateErrMsg'));;
            } else {
                return redirect('/academics/teacher-subject-maping-list')->with('error', $e->errorInfo[2]); 
            }
            
        }
        return view('backend.teachersubject.create', compact('teachers', 'title'));
    }

    
    public function edit(Request $request, $id) {
        $title="Teacher subject Maping Edit";
        $teachers = Employees::select('id', 'employee_name')->where(['status'=>0, 'employee_type'=>'0'])->get();
        $id=base64_decode($id);
        $data=TeacherSubjectMapings::find($id);
        
        if($request->input()){
            $this->validate($request, [
                'teacher_id'=>'required',
                'subject_id'=>'required',
                'status'=>'required',     
            ]);
            $data=TeacherSubjectMapings::where('id', '=', $id)->first();
            $checkDuplicate=TeacherSubjectMapings::where('teacher_id', '=', $request->input('teacher_id'))
                            ->where('subject_id', '=', $request->input('subject_id'))
                            ->where('id', '!=', $data->id)
                            ->count();
           
            if($checkDuplicate==0){
                $dataarray = array(
                    'teacher_id'     => $request->input('teacher_id'),
                    'subject_id'     => $request->input('subject_id'),
                    'status'     => $request->input('status'),
                    'created_by'=>      Auth::id()
                   
                );
                
            } else {
                return redirect()->back()->with('error',config('app.duplicateErrMsg'));;
            }

            try {
                 $reply=TeacherSubjectMapings::where('id', $id)->update($dataarray);
             } catch(\Illuminate\Database\QueryException $e){
                    $errorCode = $e->errorInfo[1];          
                   if($errorCode == 1062){
                        $reply=$errorCode;
                   }
            }
            if($reply==1){
                return redirect('/academics/teacher-subject-maping-list')->with('success',config('app.updateMsg'));
            } elseif($reply==1062) {
                return redirect()->back()->with('error',config('app.duplicateErrMsg'));;
            } else {
                return redirect('/academics/teacher-subject-maping-list')->with('error',$e->errorInfo[2]); 
            }
         }
        
        return view('backend.teachersubject.edit', ['data'=>$data, 'teachers'=>$teachers,  'title'=>$title]);
    }



     public function teacherlogindelete($id){
         $id=base64_decode($id);
          try {
                 $reply=TeacherSubjectMapings::where('id',$id)->delete();
          } catch(\Illuminate\Database\QueryException $e){
                    $errorCode = $e->errorInfo[1];          
                 $reply=$errorCode;
          }
        
        //print_r($reply); exit;  
        if($reply==1){
            return redirect()->back()->with('success',config('app.deleteMsg'));
        } else {
            return redirect()->back()->with('error',config('app.deleteErrMsg'));
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ClassSetups  $classSetups
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClassSetups $classSetups)
    {
        //
    }
}
