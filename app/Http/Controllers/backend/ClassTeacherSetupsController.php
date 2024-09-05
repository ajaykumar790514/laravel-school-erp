<?php

namespace App\Http\Controllers\backend;

use App\Models\ClassTeacherSetups;
use App\Models\SectionSetups;
use App\Models\ClassSetups;
use App\Models\SessionSetups;
use App\Models\Employees;
use App\Models\User;
use App\Models\ClassSectionMappings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ClassTeacherSetupsController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:class-teacher-list');
         $this->middleware('permission:class-teacher-create', ['only' => ['create','store']]);
         $this->middleware('permission:class-teacher-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:class-teacher-delete', ['only' => ['destroy']]);
        $this->middleware('permission:classes-for-attendance', ['only' => ['classforattendance']]);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $title="Class Teacher List";
        return view('backend.classteacher.index', compact('title'));
     }

    public function classteacherdata()
    {
        $data = DB::table('class_teacher_setups')
             //->join('class_section_mappings', 'class_teacher_setups.class_id', '=', 'class_section_mappings.id')
            ->join('session_setups', 'class_teacher_setups.session_id', '=', 'session_setups.id')
             ->join('section_setups', 'class_teacher_setups.section_id', '=', 'section_setups.id')
             ->join('class_setups', 'class_teacher_setups.class_id', '=', 'class_setups.id')
             ->join('employees', 'class_teacher_setups.teacher_id', '=', 'employees.id')
             ->select('class_teacher_setups.*', 'class_setups.class_name', 'section_setups.section_name',  'session_setups.session_name', 'employees.employee_name')
              -> get();
        //echo "<pre>"; print_r($data); exit;
        return datatables()->of($data)
        ->addColumn('action', function ($data) {
                return view('backend.classteacher.action', ['id' => base64_encode($data->id)]);
            })
        ->editColumn('created_at', function ($data) {
                return Carbon::parse($data->created_at)->diffForHumans();
            })
        ->make(true);
        //->toJson();
    }

    public function class_for_attendance() {
        $user=User::find(Auth::id());
        $teacherId=$user->user_id;
        $data = DB::table('class_teacher_setups')
                ->where('class_teacher_setups.teacher_id', '=', $teacherId)
             ->join('class_section_mappings', 'class_teacher_setups.class_id', '=', 'class_section_mappings.id')
            ->join('session_setups', 'class_teacher_setups.session_id', '=', 'session_setups.id')
             ->join('section_setups', 'class_section_mappings.section_setup_id', '=', 'section_setups.id')
             ->join('class_setups', 'class_section_mappings.class_setups_id', '=', 'class_setups.id')
             ->join('employees', 'class_teacher_setups.teacher_id', '=', 'employees.id')
             ->select('class_teacher_setups.*', 'class_setups.class_name', 'section_setups.section_name',  'session_setups.session_name', 'employees.employee_name')
              -> get();
            //  echo '<pre>';  print_r($data);
        return view('backend.classteacher.classforattendance', compact('data'));
     }


    public function classforattendance(Request $request) {


        $user=User::find(Auth::id());
        $teacherId=$user->user_id;
        $data = DB::table('class_teacher_setups')
                ->where('class_teacher_setups.teacher_id', '=', $teacherId)
             ->join('class_section_mappings', 'class_teacher_setups.class_id', '=', 'class_section_mappings.id')
            ->join('session_setups', 'class_teacher_setups.session_id', '=', 'session_setups.id')
             ->join('section_setups', 'class_section_mappings.section_setup_id', '=', 'section_setups.id')
             ->join('class_setups', 'class_section_mappings.class_setups_id', '=', 'class_setups.id')
             ->join('employees', 'class_teacher_setups.teacher_id', '=', 'employees.id')
             ->select('class_teacher_setups.*', 'class_setups.class_name', 'section_setups.section_name',  'session_setups.session_name', 'employees.employee_name')
              -> get();
            //  echo '<pre>';  print_r($data);
        return view('backend.classteacher.classforattendance', compact('data'));
     }
    

    public function create(Request $request){
        $title="Create Class Teacher";
        $sessions= SessionSetups::select('id', 'session_name')->where(['status'=>0])->orderBy('order_by', 'desc')->get();
        $teachers= Employees::select('id', 'employee_name')->where(['status'=>0, 'employee_type'=>'0'])->get();
        
        $classesmapings = DB::table('class_section_mappings')
            ->join('class_setups', 'class_section_mappings.class_setups_id', '=', 'class_setups.id')
            ->select('class_section_mappings.class_setups_id', 'class_setups.class_name')
            ->groupBy('class_section_mappings.class_setups_id', 'class_setups.class_name')
            ->orderBy('class_setups.order_by', 'asc')->get();
            
        $sections= [];

        if($request->input()){
            $this->validate($request, [
                'session_id'=>'required',
                'class_id'=>'required',
                'section_id'=>'required',
                'teacher_id'=>'required',
                'status'=>'required',
            ]);
            $data = new ClassTeacherSetups;
            $data->session_id           = $request->input('session_id');
            $data->class_id          = $request->input('class_id');
            $data->section_id          = $request->input('section_id');
            $data->teacher_id          = $request->input('teacher_id');
            $data->status          = $request->input('status');
            $data->created_by          = Auth::id();;
            $checkTeacher=ClassTeacherSetups::checkTeacherExist($request->input('session_id'), $request->input('class_id'), $request->input('section_id'), $request->input('teacher_id'));
            if($checkTeacher>0){
                return redirect()->back()->with('error',config('app.duplicateErrMsg'));;
            }

               try {
                    $reply=$data->save();
                 } catch(\Illuminate\Database\QueryException $e){
                       $errorCode = $e->errorInfo[1]; 
                       $reply=$errorCode;         
                }
            //print_r($e->errorInfo); exit;
             if($reply==1){
                return redirect('/academics/class-teacher-list')->with('success',config('app.saveMsg')); 
            } elseif($reply==1062) {
                return redirect()->back()->with('error',config('app.duplicateErrMsg'));;
            } else {
                return redirect('/academics/class-teacher-list')->with('error',$e->errorInfo[2]); 
            }
            
        }
        return view('backend.classteacher.create', compact('classesmapings', 'sections', 'sessions', 'teachers', 'title'));
    }

    public function get_section(){
      //$ClassSectionMapDetails=ClassSectionMappings::select('class_setups_id')->where(['is'=>$classsectionmapinId])->first();
        $id=$_GET['id'];
      $sections= DB::table('class_section_mappings')
                            ->join('section_setups', 'class_section_mappings.section_setup_id', '=', 'section_setups.id')
                             //->select('class_section_mappings.id', 'section_setups.section_name')
                            ->where('class_section_mappings.class_setups_id', '=', $id)
                            ->orderBy('section_setups.section_name', 'asc')
                            ->pluck('section_setups.section_name', 'class_section_mappings.id');
      return json_encode($sections);
    }

    
    public function edit(Request $request, $id) {
        $title='Edit Class Teacher Details';
        $id=base64_decode($id);
        $sessions= SessionSetups::select('id', 'session_name')->where(['status'=>0])->get();
        $teachers= Employees::select('id', 'employee_name')->where(['status'=>0, 'employee_type'=>'0'])->get();
        $classesmapings = DB::table('class_section_mappings')
            ->join('class_setups', 'class_section_mappings.class_setups_id', '=', 'class_setups.id')
            ->select('class_section_mappings.class_setups_id', 'class_setups.class_name')
            ->groupBy('class_section_mappings.class_setups_id', 'class_setups.class_name')
            ->get();

        $sections= [];
        $data=DB::table('class_teacher_setups')->where(['class_teacher_setups.id'=>$id])
            ->join('session_setups', 'class_teacher_setups.session_id', '=', 'session_setups.id')
             ->join('section_setups', 'class_teacher_setups.section_id', '=', 'section_setups.id')
             ->join('class_setups', 'class_teacher_setups.class_id', '=', 'class_setups.id')
             ->join('employees', 'class_teacher_setups.teacher_id', '=', 'employees.id')
             ->select('class_teacher_setups.*', 'class_setups.class_name', 'section_setups.section_name',  'session_setups.session_name', 'employees.employee_name')
              ->first();
        
        //ClassTeacherSetups::find($id);
        $getClassId=ClassSectionMappings::select('class_setups_id')->where(['id'=>$data->class_id])->first();

        if($request->input()){
            $this->validate($request, [
            'status'=>'required',         
            ]);
            $data=ClassTeacherSetups::where('id', '=', $id)->first();
           $dataarray = array(
                    'status'     => $request->input('status'),
                    'created_by'=>      Auth::id()
                   
                );
                
            try {
                 $reply=ClassTeacherSetups::where('id', $id)->update($dataarray);
             } catch(\Illuminate\Database\QueryException $e){
                    $errorCode = $e->errorInfo[1];          
                //if($errorCode == 1062){
                    $reply=$errorCode;
                //}
            }
            //print_r($e->errorInfo); exit;
           if($reply==1){
             //return redirect('/academics/class-teacher-edit')->with('success',config('app.updateMsg'));
             return redirect()->back()->with('success',config('app.updateMsg'));;
            } elseif($reply==1062) {
                //return redirect('/admission/session-create')->with('error',config('app.duplicateErrMsg')); 
                return redirect()->back()->with('error',config('app.duplicateErrMsg'));;
            } else {
                return redirect()->back()->with('error',config('app.saveError'));;
                //return redirect('/academics/class-teacher-edit')->with('error',config('app.saveError')); 
            }
    }
        return view('backend.classteacher.edit', compact('classesmapings', 'sections', 'sessions', 'teachers','data', 'getClassId', 'title'));
    }



     public function teacherlogindelete($id){
         $id=base64_decode($id);
        $reply=ClassTeacherSetups::where('id',$id)->delete();

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
