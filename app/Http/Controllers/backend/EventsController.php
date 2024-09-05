<?php

namespace App\Http\Controllers\backend;

use App\Models\Events;
use App\Models\User;
use App\Models\EventsCategories;
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


class EventsController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:events-list');
         $this->middleware('permission:events-view', ['only' => ['view']]);
         $this->middleware('permission:events-create', ['only' => ['create','store']]);
         $this->middleware('permission:events-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:events-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $title="School Events";
        return view('backend.events.index',compact('title'));
     }

    public function eventdata()
    {
            $data = DB::table('events')
            ->join('users', 'events.created_by', '=', 'users.id')
             ->join('session_setups', 'events.session_id', '=', 'session_setups.id')
             ->join('events_categories', 'events.events_category_id', '=', 'events_categories.id')
             ->select('events.*','session_setups.session_name', 'events_categories.name as catName', 
                'users.name');
             
            $result=$data->get();
        return datatables()->of($result)
        ->addColumn('action', function ($result) {
                return view('backend.events.action', ['id' => base64_encode($result->id)]);
            })
        ->editColumn('date_from', function ($result) {
                return date('d F y', strtotime($result->date_from));
            })
        ->editColumn('date_to', function ($result) {
                return date('d F Y', strtotime($result->date_to));
            })
        ->editColumn('created_at', function ($result) {
                return Carbon::parse($result->created_at)->diffForHumans();
            })
        ->make(true);
        //->toJson();
    }
    

    public function create(Request $request){
        $title="School Events";
        $eventsCategory= EventsCategories::select('id', 'name')->where(['status'=>0])
         ->orderBy('name', 'asc')->get();
              
        if($request->input()){
            $this->validate($request, [
                'session_id'=>'required',
                'events_category_id'=>'required',
                'date_from'=>'required',
                'date_to'=>'required',
                'descriptions'=>'required',          
               // 'attachments'=>'nullable|image|mimes:jpeg,png,jpg|max:1024',
                'status'=>'required',
           ]);

            $data = new Events;
           $slug = Str::replace(' ', '-', $request->input('note'));
            $slug = Str::lower($slug);
            $same_slug_count = Events::where('slug', 'LIKE', $slug . '%')->count();
            $slug_suffix = $same_slug_count ? '-' . $same_slug_count + 1 : '';
            $slug .= $slug_suffix;
            
            $data->session_id= $request->input('session_id');
            $data->events_category_id     = $request->input('events_category_id');
            $data->date_from     = date('Y-m-d', strtotime($request->input('date_from')));
            $data->date_to     = date('Y-m-d', strtotime($request->input('date_to')));
            $data->descriptions     = $request->input('descriptions');
            $data->note     = $request->input('note');
            $data->attachments     = $request->input('attachments');
            $data->slug     = $slug;
            $data->created_by          = Auth::id();
            try {
                $reply=$data->save();
             } catch(\Illuminate\Database\QueryException $e){
                    $errorCode = $e->errorInfo[1];          
                    $reply=$errorCode;
            }
            //print_r($e->errorInfo); exit;
            if($reply==1){
                return redirect('/academics/events-list')->with('success',config('app.saveMsg')); 
            } elseif($reply==1062) {
                return redirect()->back()->with('error',$e->errorInfo[1]);;
            } else {
                return redirect('/academics/events-list')->with('error',$e->errorInfo[2]); 
            }
            
        }
        return view('backend.events.create', compact('eventsCategory', 'title'));
    }

   
    
    public function edit(Request $request, $id)
    {
        $title="School Events";
        $eventsCategory= EventsCategories::select('id', 'name')->where(['status'=>0])
         ->orderBy('name', 'asc')->get();
        $id=base64_decode($id);
        $data=Events::find($id);
        if($request->input()){
            $this->validate($request, [
                'session_id'=>'required',
                'events_category_id'=>'required',
                'date_from'=>'required',
                'date_to'=>'required',
                'descriptions'=>'required',          
                //'attachment'=>'nullable|image|mimes:jpeg,png,jpg|max:1024',
                'status'=>'required',
           ]);
            $data=Events::where('id', '=', $id)->first();
            $slug = Str::replace(' ', '-', $request->input('note'));
            $slug = Str::lower($slug);
            $same_slug_count = Events::where('slug', 'LIKE', $slug . '%') ->where('id','!=',$id)->count();
            $slug_suffix = $same_slug_count ? '-' . $same_slug_count + 1 : '';
            $slug .= $slug_suffix;
            
             if(!empty($request->input('attachments'))){
                  $media  =$request->input('attachments'); 
               } else {
                   $media  =$data->attachments;
               }

             $dataarray = array(
                'session_id'  => $request->input('session_id'),
                'events_category_id'       => $request->input('events_category_id'),
                'date_from'       => date('Y-m-d', strtotime($request->input('date_from'))),
                'date_to'       => date('Y-m-d', strtotime($request->input('date_to'))),
                'descriptions'       => $request->input('descriptions'),
                'note'            => $request->input('note'),
                'slug'            => $slug,
                'attachments'          =>$media,
                'status'            => $request->input('status'),
                'created_by'=>      Auth::id()
             );

             try {
                 $reply=Events::where('id', $id)->update($dataarray);
             } catch(\Illuminate\Database\QueryException $e){
                    $errorCode = $e->errorInfo[1];          
                    $reply=$errorCode;
                
            }
           // print_r($e->errorInfo); exit;
           if($reply==1){
            return redirect('/academics/events-list')->with('success',config('app.updateMsg')); 
             } elseif($reply==1062) {
               return redirect()->back()->with('error',config('app.duplicateErrMsg'));;
            } else {
                return redirect()->back()->with('error',$e->errorInfo[2]); 
            }

            
        }
        return view('backend.events.edit', ['data'=>$data, 'eventsCategory'=>$eventsCategory, 'title'=>$title]);
    }

     public function view(Request $request, $id)
    {
        $title="School Events";
        $id=base64_decode($id);
        $data = DB::table('events')
            ->join('users', 'events.created_by', '=', 'users.id')
             ->join('session_setups', 'events.session_id', '=', 'session_setups.id')
             ->join('events_categories', 'events.events_category_id', '=', 'events_categories.id')
            ->select('events.*','session_setups.session_name', 'events_categories.name as catName', 
                'users.name')
             ->where('events.id', '=', $id)
              -> first();
        
        return view('backend.events.view', ['data'=>$data, 'title'=>$title]);
    }

     public function delete($id){
         $id=base64_decode($id);
         try {
                $reply=Events::where('id',$id)->delete();
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
