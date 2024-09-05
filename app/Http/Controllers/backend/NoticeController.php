<?php

namespace App\Http\Controllers\backend;

use App\Models\Notice;
use App\Models\SectionSetups;
use App\Models\ClassSetups;
use App\Models\SessionSetups;
use App\Models\Employees;
use App\Models\ClassSectionMappings;
use Illuminate\Http\Request;
use App\Models\User;
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

class NoticeController extends Controller
{
    
     function __construct()
    {
         $this->middleware('permission:notice-list');
         $this->middleware('permission:notice-view', ['only' => ['view']]);
         $this->middleware('permission:notice-create', ['only' => ['create','store']]);
         $this->middleware('permission:notice-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:notice-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(){
        $title="Notice Board";
        return view('backend.notice.index', compact('title'));
       
    }

    public function noticedata()
    {
        $user=User::find(Auth::id());
       $data = DB::table('notices')
            ->join('session_setups', 'notices.session_id', '=', 'session_setups.id')
            ->select('notices.*','session_setups.session_name');
             
        $result=$data->get();      
        return datatables()->of($result)
        ->addColumn('action', function ($result) {
                return view('backend.notice.action', ['id' => base64_encode($result->id)]);
            })
        ->editColumn('created_at', function ($result) {
                return Carbon::parse($result->created_at)->diffForHumans();
            })
        
        ->make(true);
        //->toJson();
    }

    

    public function create(Request $request){
        $title="Notice Board";
        $user=User::find(Auth::id());

        if($request->input()){
            $this->validate($request, [
                'session_id'=>'required',
                'title'=>'required',
                'priority'=>'required',
                'upload_content'=>'required',          
                //'attachment'=>'nullable|image|mimes:jpeg,png,jpg|max:1024',
                
                'status'=>'required',
           ]);
            $data = new Notice;
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
            $same_slug_count = Notice::where('slug', 'LIKE', $slug . '%')->count();
            $slug_suffix = $same_slug_count ? '-' . $same_slug_count + 1 : '';
            $slug .= $slug_suffix;
            
            $data->session_id= $request->input('session_id');
            $data->upload_content     = $request->input('upload_content');
            $data->slug     =$slug;
            $data->title     = $request->input('title');
            $data->attachment     = $request->input('attachment');
            $data->priority     = $request->input('priority');
            $data->status          = $request->input('status');
            $data->created_by          = Auth::id();
             try {
                $reply=$data->save();
             } catch(\Illuminate\Database\QueryException $e){
                    $errorCode = $e->errorInfo[1];          
                    $reply=$errorCode;
            }
            if($reply==1){
                return redirect('/academics/notice-list')->with('success',config('app.saveMsg')); 
            } elseif($reply==1062) {
                return redirect()->back()->with('error',config('app.duplicateErrMsg'));;
            } else {
                return redirect()->back()->with('error',$e->errorInfo[2]);;
            }
            
        }
        return view('backend.notice.create', compact('title'));
    }

    

    public function edit(Request $request, $id)
    {
         $title="Notice Board";
        $user=User::find(Auth::id());
        
        $id=base64_decode($id);
        $data=Notice::find($id);
        


        if($request->input()){
            $this->validate($request, [
                'session_id'=>'required',
                'title'=>'required',
                'priority'=>'required',
                'upload_content'=>'required',          
                //'attachment'=>'nullable|image|mimes:jpeg,png,jpg|max:1024',
                'status'=>'required',
           ]);
            $data=Notice::where('id', '=', $id)->first();
            $slug = Str::replace(' ', '-', $request->input('title'));
            $slug = Str::lower($slug);
            $same_slug_count = Notice::where('slug', 'LIKE', $slug . '%') ->where('id','!=',$id)->count();
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
                'upload_content'       => $request->input('upload_content'),
                'slug'       => $slug,
                'attachment'          =>$media,
                'doc_type'          =>$doc_type,
                'title'       => $request->input('title'),
                'priority'          =>$request->input('priority'),
                'status'            => $request->input('status'),
                'created_by'=>      Auth::id()
             );

             try {
                 $reply=Notice::where('id', $id)->update($dataarray);
             } catch(\Illuminate\Database\QueryException $e){
                    $errorCode = $e->errorInfo[1];          
                    $reply=$errorCode;
                
            }
           if($reply==1){
            return redirect('/academics/notice-list')->with('success',config('app.updateMsg')); 
            } elseif($reply==1062) {
               return redirect()->back()->with('error',$e->errorInfo[2]);;
            } else {
                return redirect()->back()->with('error',$e->errorInfo[2]); 
            }

            
        }
        return view('backend.notice.edit', ['data'=>$data, 'title'=>$title]);
    }


    public function view(Request $request, $id){
        $title="Notice Board";
        $id=base64_decode($id);
        $data = DB::table('notices')
            ->join('session_setups', 'notices.session_id', '=', 'session_setups.id')
            ->select('notices.*','session_setups.session_name')
             ->where(['notices.id'=>$id])
              -> first();
        return view('backend.notice.view', ['data'=>$data, 'title'=>$title]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Notice  $notice
     * @return \Illuminate\Http\Response
     */
     public function delete($id){
         $id=base64_decode($id);
         try {
                $reply=Notice::where('id',$id)->delete();
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
