<?php

namespace App\Http\Controllers\backend;

use App\Models\DailyDiaries;
use App\Models\SectionSetups;
use App\Models\ClassSetups;
use App\Models\SessionSetups;
use App\Models\Employees;
use App\Models\User;
use App\Models\ClassSectionMappings;
use App\Models\ClassTeacherSetups;
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

class DailyDiariesController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:dailydiaries-list');
         $this->middleware('permission:dailydiaries-view', ['only' => ['view']]);
         $this->middleware('permission:dailydiaries-create', ['only' => ['create','store']]);
         $this->middleware('permission:dailydiaries-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:dailydiaries-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $title="Daily Diaries List";
        return view('backend.dailydiaries.index', compact('title'));
     }

    public function dailydiariesdata()
    {
        $user=User::find(Auth::id());
        $teacherId=$user->user_id;
        $data = DB::table('daily_diaries')
             ->join('session_setups', 'daily_diaries.session_id', '=', 'session_setups.id')
             ->join('class_setups', 'daily_diaries.class_id', '=', 'class_setups.id')
             ->join('section_setups', 'daily_diaries.section_id', '=', 'section_setups.id')
             ->select('daily_diaries.*','session_setups.session_name', 'section_setups.section_name', 'class_setups.class_name');
             $result=$data->get();
            return datatables()->of($result)
            ->addColumn('action', function ($result) {
                return view('backend.dailydiaries.action', ['id' => base64_encode($result->id)]);
            })
            ->editColumn('created_at', function ($result) {
                    return Carbon::parse($result->created_at)->diffForHumans();
                })
            ->make(true);
        //->toJson();
    }
    

    public function create(Request $request){
        $title="Daily Diaries Create";
        $user=User::find(Auth::id());
       
                 
        if($request->input()){
            $this->validate($request, [
                'session_id'=>'required',
                'class_id'=>'required',
                'section_id'=>'required',
                'title'=>'required',
                'upload_content'=>'required',          
               // 'attachment'=>'nullable|image|mimes:jpeg,png,jpg|max:1024',
                //'teacher_id'=>'required', 
                'status'=>'required',
           ]);
           
           $slug = Str::replace(' ', '-', $request->input('title'));
            $slug = Str::lower($slug);
            $same_slug_count = DailyDiaries::where('slug', 'LIKE', $slug . '%')->count();
            $slug_suffix = $same_slug_count ? '-' . $same_slug_count + 1 : '';
            $slug .= $slug_suffix;
            
            $data = new DailyDiaries;
            $data->session_id= $request->input('session_id');
            $data->class_id     = $request->input('class_id');
            $data->section_id     = $request->input('section_id');
            $data->title     = $request->input('title');
            $data->slug     = $slug;
            $data->upload_content     = $request->input('upload_content');
            //$data->teacher_id     = $request->input('teacher_id');
            $data->status          = $request->input('status');
            $data->created_by          = Auth::id();
            $data->attachment          = $request->input('attachment');
            

             try {
                $reply=$data->save();
             } catch(\Illuminate\Database\QueryException $e){
                    $errorCode = $e->errorInfo[1];          
                    $reply=$errorCode;
            }
            //print_r($e->errorInfo); exit;
            if($reply==1){
                return redirect('/academics/dailydiaries-list')->with('success',config('app.saveMsg')); 
                //return redirect()->back()->with('success',config('app.saveMsg'));;
            } elseif($reply==1062) {
                return redirect()->back()->with('error',config('app.duplicateErrMsg'));;
            } else {
                return redirect()->back()->with('error',$e->errorInfo[2]);;
                //return redirect('/employee/designation-list')->with('error',config('app.saveError')); 
            }
            
        }
        return view('backend.dailydiaries.create', compact('title'));
    }

    public function get_section(){
      $id=$_GET['id'];
      $sections= DB::table('class_section_mappings')
                            ->join('section_setups', 'class_section_mappings.section_setup_id', '=', 'section_setups.id')
                            ->where('class_section_mappings.class_setups_id', '=', $id)
                            ->orderBy('section_setups.section_name', 'asc')
                            ->pluck('section_setups.section_name', 'class_section_mappings.id');
      return json_encode($sections);
    }

    
    public function edit(Request $request, $id)
    {
        $title="Daily Diaries Edit";
        $user=User::find(Auth::id());
        
           
        $id=base64_decode($id);
        $data=DailyDiaries::find($id);
         if($request->input()){
            $this->validate($request, [
                'session_id'=>'required',
                'class_id'=>'required',
                'section_id'=>'required', 
                'title'=>'required',
                'upload_content'=>'required',          
                //'attachment'=>'nullable|image|mimes:jpeg,png,jpg|max:1024',
                //'teacher_id'=>'required', 
                'status'=>'required',
           ]);
            $data=DailyDiaries::where('id', '=', $id)->first();
             $slug = Str::replace(' ', '-', $request->input('title'));
            $slug = Str::lower($slug);
            $same_slug_count = DailyDiaries::where('slug', 'LIKE', $slug . '%') ->where('id','!=',$id)->count();
            $slug_suffix = $same_slug_count ? '-' . $same_slug_count + 1 : '';
            $slug .= $slug_suffix;
            
            if(!empty($request->input('attachment'))){
                  $media  =$request->input('attachment'); 
               } else {
                   $media  =$data->attachment;
               }
          
            $dataarray = array(
                'session_id'  => $request->input('session_id'),
                'class_id'       => $request->input('class_id'),
                'section_id'       => $request->input('section_id'),
                'title'       => $request->input('title'),
                'upload_content'       => $request->input('upload_content'),
               'attachment'          =>$media,
                'status'            => $request->input('status'),
                'created_by'=>      Auth::id()
             );

             try {
                 $reply=DailyDiaries::where('id', $id)->update($dataarray);
             } catch(\Illuminate\Database\QueryException $e){
                    $errorCode = $e->errorInfo[1];          
                    $reply=$errorCode;
                
            }
           if($reply==1){
            return redirect('/academics/dailydiaries-list')->with('success',config('app.updateMsg'));
            } elseif($reply==1062) {
               return redirect()->back()->with('error',$e->errorInfo[2]);;
            } else {
                return redirect()->back()->with('error',$e->errorInfo[2]); 
            }

        }
        return view('backend.dailydiaries.edit', ['data'=>$data, 'title'=>$title]);
    }

     public function view(Request $request, $id)
    {
        $title="Daily Diaries View";
        $id=base64_decode($id);
        $data = DB::table('daily_diaries')
            ->join('session_setups', 'daily_diaries.session_id', '=', 'session_setups.id')
             ->join('class_setups', 'daily_diaries.class_id', '=', 'class_setups.id')
             ->join('section_setups', 'daily_diaries.section_id', '=', 'section_setups.id')
             ->select('daily_diaries.*','session_setups.session_name', 'section_setups.section_name', 'class_setups.class_name')
             ->where(['daily_diaries.id'=>$id])
              -> first();
        
        return view('backend.dailydiaries.view', ['data'=>$data, 'title'=>$title]);
    }

     public function delete($id){
         $id=base64_decode($id);
         try {
                $reply=DailyDiaries::where('id',$id)->delete();
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
