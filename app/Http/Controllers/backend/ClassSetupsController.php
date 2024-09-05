<?php

namespace App\Http\Controllers\backend;

use App\Models\ClassSetups;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ClassSetupsController extends Controller
{
    
    function __construct()
    {
         $this->middleware('permission:classsetup-list');
         $this->middleware('permission:classsetup-create', ['only' => ['create','store']]);
         $this->middleware('permission:classsetup-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:classsetup-delete', ['only' => ['destroy']]);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $title="Class Setup List";
        return view('backend.classsetups.index', compact("title"));
     }

    public function classsetupdatatable()
    {
        $data = DB::table('class_setups')->select('*');
        return datatables()->of($data)
        ->addColumn('action', function ($data) {
                return view('backend.classsetups.action', ['id' => base64_encode($data->id)]);
            })

        ->editColumn('created_at', function ($data) {
                return Carbon::parse($data->created_at)->diffForHumans();
            })
        
        ->make(true);
        //->toJson();
    }
    

    public function create(Request $request){
        $title="Class Setup Create";         
        if($request->input()){
            $this->validate($request, [
                'class_name'=>'required|unique:class_setups',
                'class_strength'=>'required|numeric',
                'status'=>'required',
                
            ]);
            $data = new ClassSetups;
            $data->class_name           = $request->input('class_name');
            $data->class_strength           = $request->input('class_strength');
            $data->order_by          = $request->input('order_by');
            $data->status          = $request->input('status');
            $data->created_by          = Auth::id();;
             try {
                $reply=$data->save();
             } catch(\Illuminate\Database\QueryException $e){
                    $errorCode = $e->errorInfo[1];          
                //if($errorCode == 1062){
                    $reply=$errorCode;
                //}
            }
            //print_r($e->errorInfo); exit;
            if($reply==1){
                return redirect('classsetup-list')->with('success',config('app.saveMsg')); 
            } elseif($reply==1062) {
                //return redirect('/admission/session-create')->with('error',config('app.duplicateErrMsg')); 
                return redirect()->back()->with('error',config('app.duplicateErrMsg'));;
            } else {
                return redirect('classsetup-list')->with('error',config('app.saveError')); 
            }
            
        }
        return view('backend.classsetups.create', compact("title"));
    }

    
    public function edit(Request $request, $id)
    {
        $title="Class Setup Edit"; 
        $id=base64_decode($id);
        $data=ClassSetups::find($id);
        if($request->input()){
            $this->validate($request, [
            'class_name'=>'required',
            'class_strength'=>'required|numeric',
            'status'=>'required',         
            ]);
            $data=ClassSetups::where('id', '=', $id)->first();
            $dataarray = array(
                'class_name'     => $request->input('class_name'),
                'class_strength'     => $request->input('class_strength'),
                'order_by'     => $request->input('order_by'),
                'status'     => $request->input('status'),
                'created_by'=>      Auth::id()
               
            );
             try {
                 $reply=ClassSetups::where('id', $id)->update($dataarray);
             } catch(\Illuminate\Database\QueryException $e){
                    $errorCode = $e->errorInfo[1];          
                //if($errorCode == 1062){
                    $reply=$errorCode;
                //}
            }
           if($reply==1){
             return redirect('classsetup-list')->with('success',config('app.updateMsg'));
            } elseif($reply==1062) {
                //return redirect('/admission/session-create')->with('error',config('app.duplicateErrMsg')); 
                return redirect()->back()->with('error',config('app.duplicateErrMsg'));;
            } else {
                return redirect('classsetup-list')->with('error',config('app.saveError')); 
            }

            
        }
        return view('backend.classsetups.edit', ['data'=>$data, 'title'=>$title]);
    }

     public function classsetupdelete($id){
         $id=base64_decode($id);
         try {
                $reply=ClassSetups::where('id',$id)->delete();
             } catch(\Illuminate\Database\QueryException $e){
                    $errorCode = $e->errorInfo[1];          
                //if($errorCode == 1062){
                    $reply=$errorCode;
                //}
            }
        if($reply==1){
            return redirect()->back()->with('success',config('app.deleteMsg'));
        } else if($reply==1451) {
            return redirect()->back()->with('error',$e->errorInfo[2]);
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
