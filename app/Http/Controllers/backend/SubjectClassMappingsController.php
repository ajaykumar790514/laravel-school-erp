<?php

namespace App\Http\Controllers\backend;

use App\Models\SubjectClassMappings;
use App\Models\SubjectSetups;
use App\Models\ClassSetups;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SubjectClassMappingsController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:subject-class-maping-list');
         $this->middleware('permission:subject-class-maping-list', ['only' => ['create','store']]);
         $this->middleware('permission:subject-class-maping-list', ['only' => ['edit','update']]);
         $this->middleware('permission:subject-class-maping-list', ['only' => ['destroy']]);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $title="Subject Maping in Class";
        return view('backend.subjectclass.index', compact('title'));
     }

    public function subjectclassmappingdata()
    {
        $data = DB::table('subject_class_mappings')
             ->join('class_setups', 'subject_class_mappings.class_setups_id', '=', 'class_setups.id')
             ->join('subject_setups', 'subject_class_mappings.subject_setups_id', '=', 'subject_setups.id')
             ->select('subject_class_mappings.*', 'class_setups.class_name', 'subject_setups.subject_name')
             ->get();
        return datatables()->of($data)
        ->addColumn('action', function ($data) {
                return view('backend.subjectclass.action', ['id' => base64_encode($data->id)]);
            })
        ->editColumn('created_at', function ($data) {
                return Carbon::parse($data->created_at)->diffForHumans();
            })
        ->make(true);
        //->toJson();
    }
    

    public function create(Request $request){
        $title="Subject Maping in Class";
       if($request->input()){
            $this->validate($request, [
                'class_setups_id'=>'required',
                'subject_setups_id'=>'required',
                'status'=>'required',
                
            ]);
            //$data = new ClassSectionMappings;
            $multipalRecordss = [];
            $class_setups_id=$request->input('class_setups_id');
            $status=$request->input('status');
            foreach($request->input('subject_setups_id') as $sectionKey){
                $checkUniqe= SubjectClassMappings::select('id')->where(
                    [
                        'class_setups_id'=>$class_setups_id, 
                        'subject_setups_id'=>$sectionKey
                    ]
                )->get();
                $checkDuplicateRecord=count($checkUniqe);
               // print_r($checkDuplicateRecord); exit;
               if($checkDuplicateRecord==0){
                    $multipalRecordss[] = [
                        'class_setups_id'           => $class_setups_id,
                        'subject_setups_id'           => $sectionKey,
                        'stataus'          => $status,
                        'created_by'          => Auth::id(),
                 ];
                } else{
                    return redirect('/academics/subject-class-maping-list')->with('error',config('app.duplicateErrMsg')); 
                }

             }
               try {
                    $reply= SubjectClassMappings::insert($multipalRecordss);
                 } catch(\Illuminate\Database\QueryException $e){
                       $errorCode = $e->errorInfo[1];          
                }
             if($reply==1){
                return redirect('/academics/subject-class-maping-list')->with('success',config('app.saveMsg')); 
            } elseif($reply==1062) {
                return redirect()->back()->with('error',config('app.duplicateErrMsg'));;
            } else {
                return redirect('/academics/subject-class-maping-list')->with('error',$e->errorInfo[2]); 
            }
            
        }
        return view('backend.subjectclass.create', compact('title'));
    }

    
    public function edit(Request $request, $id) {
        $title="Subject Maping in Class";
        $classes = ClassSetups::select('id', 'class_name')->where(['status'=>0])->get();
        $subjects= SubjectSetups::select('id', 'subject_name')->where(['status'=>0])->get();
        $id=base64_decode($id);
        $data=SubjectClassMappings::find($id);
        
        if($request->input()){
            $this->validate($request, [
                'class_setups_id'=>'required',
                'subject_setups_id'=>'required',
                'status'=>'required',     
            ]);
            $data=SubjectClassMappings::where('id', '=', $id)->first();
            $checkDuplicate=SubjectClassMappings::where('class_setups_id', '=', $request->input('class_setups_id'))
                            ->where('subject_setups_id', '=', $request->input('subject_setups_id'))
                            ->where('id', '!=', $data->id)
                            ->count();
           
            if($checkDuplicate==0){
                $dataarray = array(
                    'class_setups_id'     => $request->input('class_setups_id'),
                    'subject_setups_id'     => $request->input('subject_setups_id'),
                    'stataus'     => $request->input('status'),
                    'created_by'=>      Auth::id()
                   
                );
                
            } else {
                return redirect()->back()->with('error',config('app.duplicateErrMsg'));;
            }

            try {
                 $reply=SubjectClassMappings::where('id', $id)->update($dataarray);
             } catch(\Illuminate\Database\QueryException $e){
                    $errorCode = $e->errorInfo[1];          
                   if($errorCode == 1062){
                        $reply=$errorCode;
                   }
            }
            if($reply==1){
                return redirect('/academics/subject-class-maping-list')->with('success',config('app.updateMsg'));
            } elseif($reply==1062) {
                return redirect()->back()->with('error',config('app.duplicateErrMsg'));;
            } else {
                return redirect('/academics/subject-class-maping-list')->with('error',config('app.saveError')); 
            }
         }
        
        return view('backend.subjectclass.edit', ['data'=>$data, 'classes'=>$classes, 'subjects'=>$subjects, 'title'=>$title]);
    }



     public function delete($id){
         $id=base64_decode($id);
          try {
                 $reply=SubjectClassMappings::where('id',$id)->delete();
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

    
}
