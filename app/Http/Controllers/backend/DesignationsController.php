<?php

namespace App\Http\Controllers\backend;

use App\Models\Designations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DesignationsController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:designation-list');
         $this->middleware('permission:designation-create', ['only' => ['create','store']]);
         $this->middleware('permission:designation-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:designation-delete', ['only' => ['destroy']]);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $title="Designation List";
        return view('backend.designation.index', compact('title'));
     }

    public function designationdatatable()
    {
        $data = DB::table('designations')->select('*');
        return datatables()->of($data)
        ->addColumn('action', function ($data) {
                return view('backend.designation.action', ['id' => base64_encode($data->id)]);
            })
        ->editColumn('created_at', function ($data) {
                return Carbon::parse($data->created_at)->diffForHumans();
            })
        ->make(true);
        //->toJson();
    }
    

    public function create(Request $request){
         $title="Designation Create";  
        if($request->input()){
            $this->validate($request, [
                'designation_name'=>'required|unique:designations',
                'status'=>'required',
                
            ]);
            $data = new Designations;
            $data->designation_name= $request->input('designation_name');
            $data->description     = $request->input('description');
            $data->status          = $request->input('status');
            $data->created_by          = Auth::id();;
             try {
                $reply=$data->save();
             } catch(\Illuminate\Database\QueryException $e){
                    $errorCode = $e->errorInfo[1];          
                    $reply=$errorCode;
               
            }
            //print_r($e->errorInfo); exit;
            if($reply==1){
                return redirect('designation-list')->with('success',config('app.saveMsg')); 
            } elseif($reply==1062) {
                return redirect()->back()->with('error',config('app.duplicateErrMsg'));;
            } else {
                return redirect('designation-list')->with('error',config('app.saveError')); 
            }
            
        }
        return view('backend.designation.create', compact('title'));
    }

    
    public function edit(Request $request, $id)
    {
         $title="Designation Edit"; 
        $id=base64_decode($id);
        $data=Designations::find($id);
        if($request->input()){
            $this->validate($request, [
            'designation_name'=>'required',
            'status'=>'required',       
            ]);
            $data=Designations::where('id', '=', $id)->first();
            $dataarray = array(
                'designation_name'  => $request->input('designation_name'),
                'description'       => $request->input('description'),
                'status'            => $request->input('status'),
                'created_by'=>      Auth::id()
             );
             try {
                 $reply=Designations::where('id', $id)->update($dataarray);
             } catch(\Illuminate\Database\QueryException $e){
                    $errorCode = $e->errorInfo[1];          
                    $reply=$errorCode;
                
            }
           if($reply==1){
             return redirect('designation-list')->with('success',config('app.updateMsg'));
            } elseif($reply==1062) {
                return redirect()->back()->with('error',config('app.duplicateErrMsg'));;
            } else {
                return redirect('designation-list')->with('error',config('app.saveError')); 
            }

            
        }
        return view('backend.designation.edit', ['data'=>$data, 'title'=>$title]);
    }

     public function designationdelete($id){
         $id=base64_decode($id);
         try {
                $reply=Designations::where('id',$id)->delete();
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
