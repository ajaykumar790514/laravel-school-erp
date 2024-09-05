<?php

namespace App\Http\Controllers\backend;

use App\Models\AssignmentHolidays;
use App\Models\SectionSetups;
use App\Models\ClassSetups;
use App\Models\SessionSetups;
use App\Models\Employees;
use App\Models\User;
use App\Models\ClassSectionMappings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Url;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;


class AssignmentHolidaysController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:assignment-holidays-list');
         $this->middleware('permission:assignment-holidays-view', ['only' => ['view']]);
         $this->middleware('permission:assignment-holidays-create', ['only' => ['create','store']]);
         $this->middleware('permission:assignment-holidays-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:assignment-holidays-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $title="Assignment List";
        return view('backend.assigmentholidays.index', compact('title'));
     }

    public function assignmentholidaysdata()
    {
        $user=User::find(Auth::id());
        $teacherId=$user->user_id;
        $usrType=$user->user_type;

        $data = DB::table('assignment_holidays')
            ->join('class_setups', 'assignment_holidays.class_id', '=', 'class_setups.id')
             ->join('session_setups', 'assignment_holidays.session_id', '=', 'session_setups.id')
             ->join('section_setups', 'assignment_holidays.section_id', '=', 'section_setups.id')
             ->select('assignment_holidays.*','session_setups.session_name', 'section_setups.section_name', 'class_setups.class_name');
             
            $result=$data->get();
        return datatables()->of($result)
        ->addColumn('action', function ($result) {
                return view('backend.assigmentholidays.action', ['id' => base64_encode($result->id)]);
            })
        ->editColumn('created_at', function ($result) {
                return Carbon::parse($result->created_at)->diffForHumans();
            })
        ->make(true);
        //->toJson();
    }
    

    public function create(Request $request){
        $title="Assignment/Holidays Create";
        $user=User::find(Auth::id());
        if($request->input()){
            $this->validate($request, [
                'session_id'=>'required',
                'class_id'=>'required',
                'section_id'=>'required',
                'title'=>'required',
                'upload_content'=>'required',          
                //'attachment'=>'nullable|image|mimes:jpeg,png,jpg,pdf,docx,doc|max:1024',
                //'teacher_id'=>'required', 
                'status'=>'required',
           ]);

            $data = new AssignmentHolidays;
            if($request->input('attachment')){
                $imagepath = $request->input('attachment');
                $extension = pathinfo($imagepath, PATHINFO_EXTENSION);
               
                if($extension){
                    if($extension=="pdf"){
                        $data->doc_type           = 1;  
                    }elseif($extension=="docx"){
                        $data->doc_type           = 2;  
                    }elseif($extension=="doc"){
                        $data->doc_type           = 2;
                    } else{
                        $data->doc_type           = 0;
                    }

                 } else {
                     return redirect('/academics/assignment-holidays-create')->with('error',' Sorry Only Upload png , jpg , doc, docx, pdf');
                 }
            } else{
                $data->doc_type           = 0;
            }
            $slug = Str::replace(' ', '-', $request->input('title'));
            $slug = Str::lower($slug);
            $same_slug_count = AssignmentHolidays::where('slug', 'LIKE', $slug . '%')->count();
            $slug_suffix = $same_slug_count ? '-' . $same_slug_count + 1 : '';
            $slug .= $slug_suffix;
            
            $data->session_id= $request->input('session_id');
            $data->class_id     = $request->input('class_id');
            $data->section_id     = $request->input('section_id');
            $data->upload_content     = $request->input('upload_content');
            $data->title     = $request->input('title');
            $data->slug     = $slug;
             $data->attachment     = $request->input('attachment');
            $data->status          = $request->input('status');
            $data->created_by          = Auth::id();
             

             try {
                $reply=$data->save();
             } catch(\Illuminate\Database\QueryException $e){
                    $errorCode = $e->errorInfo[1];          
                    $reply=$errorCode;
            }
            if($reply==1){
                return redirect('/academics/assignment-holidays-list')->with('success',config('app.saveMsg')); 
            } elseif($reply==1062) {
                return redirect()->back()->with('error',config('app.duplicateErrMsg'));;
            } else {
                return redirect('/academics/assignment-holidays-create')->with('error', $e->errorInfo[2]); 
            }
            
        }
        return view('backend.assigmentholidays.create', compact('title'));
    }

    public function get_section(){
      $id=$_GET['id'];
      $data=ClassSectionMappings::find($id);
      $sections= DB::table('class_section_mappings')
                            ->join('section_setups', 'class_section_mappings.section_setup_id', '=', 'section_setups.id')
                             //->select('class_section_mappings.id', 'section_setups.section_name')
                            ->where('class_section_mappings.class_setups_id', '=', $id)
                            ->orderBy('section_setups.section_name', 'asc')
                            ->pluck('section_setups.section_name', 'class_section_mappings.id');
      return json_encode($sections);
    }

    
    public function edit(Request $request, $id) {
        $title="Assignment/Holidays Edit";
        $user=User::find(Auth::id());
        $teacherId=$user->user_id;
        
        $id=base64_decode($id);
        $data=AssignmentHolidays::find($id);
        
        if($request->input()){
            $this->validate($request, [
                'session_id'=>'required',
                'class_id'=>'required',
                'section_id'=>'required',
                'title'=>'required',
                'upload_content'=>'required',          
                //'attachment'=>'nullable|image|mimes:jpeg,png,jpg,pdf,docx,doc|max:1024',
                //'teacher_id'=>'required', 
                'status'=>'required',
           ]);
            $data=AssignmentHolidays::where('id', '=', $id)->first();
            $slug = Str::replace(' ', '-', $request->input('title'));
            $slug = Str::lower($slug);
            $same_slug_count = AssignmentHolidays::where('slug', 'LIKE', $slug . '%') ->where('id','!=',$id)->count();
            $slug_suffix = $same_slug_count ? '-' . $same_slug_count + 1 : '';
            $slug .= $slug_suffix;
             if($request->input('attachment')){
                    $imagepath = $request->input('attachment');
                    $extension = pathinfo($imagepath, PATHINFO_EXTENSION);
                   
                    if($extension){
                        if($extension=="pdf"){
                            $doc_type           = 1;  
                        }elseif($extension=="docx"){
                            $doc_type          = 2;  
                        }elseif($extension=="doc"){
                            $doc_type          = 2;
                        } else{
                            $doc_type           = 0;
                        }
    
                     } else {
                         return redirect('/academics/assignment-holidays-create')->with('error',' Sorry Only Upload png , jpg , doc, docx, pdf');
                     }
                } else{
                    $doc_type           = 0;
                }
                
                if(!empty($request->input('attachment'))){
                  $media  =$request->input('attachment'); 
               } else {
                   $media  =$data->attachment;
               }
          

            $dataarray = array(
                'session_id'  => $request->input('session_id'),
                'class_id'       => $request->input('class_id'),
                'section_id'       => $request->input('section_id'),
                'upload_content'       => $request->input('upload_content'),
                'slug'       => $slug,
                'title'            => $request->input('title'),
                'doc_type'          => $doc_type,
                'attachment'          => $media,
                'status'            => $request->input('status'),
                'created_by'=>      Auth::id()
             );

             try {
                 $reply=AssignmentHolidays::where('id', $id)->update($dataarray);
             } catch(\Illuminate\Database\QueryException $e){
                    $errorCode = $e->errorInfo[1];          
                    $reply=$errorCode;
                
            }
           if($reply==1){
             return redirect('academics/assignment-holidays-list')->with('success',config('app.updateMsg'));
            } elseif($reply==1062) {
               return redirect()->back()->with('error',config('app.duplicateErrMsg'));;
            } else {
                return redirect()->back()->with('error',$e->errorInfo[2]); 
            }

            
        }
        return view('backend.assigmentholidays.edit', ['data'=>$data, 'title'=>$title]);
    }

     public function view(Request $request, $id){
         $title="Assignment/Holidays View";
        $id=base64_decode($id);
        $data = DB::table('assignment_holidays')
            ->join('session_setups', 'assignment_holidays.session_id', '=', 'session_setups.id')
             ->join('class_setups', 'assignment_holidays.class_id', '=', 'class_setups.id')
             ->join('section_setups', 'assignment_holidays.section_id', '=', 'section_setups.id')
             ->select('assignment_holidays.*','session_setups.session_name', 'section_setups.section_name', 'class_setups.class_name')
             ->where(['assignment_holidays.id'=>$id])
              -> first();
        
        return view('backend.assigmentholidays.view', ['data'=>$data, 'title'=>$title]);
    }

     public function delete($id){
         $id=base64_decode($id);
         try {
                $reply=AssignmentHolidays::where('id',$id)->delete();
             } catch(\Illuminate\Database\QueryException $e){
                    $errorCode = $e->errorInfo[1];          
                    $reply=$errorCode;
            }
        if($reply==1){
            return redirect()->back()->with('success',config('app.deleteMsg'));
        } else if($reply==1451) {
            return redirect()->back()->with('error',$e->errorInfo[2]);
        } else {
             return redirect()->back()->with('error',config('app.deleteErrMsg'));
        }
        
    }
}
