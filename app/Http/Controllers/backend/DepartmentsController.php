<?php

namespace App\Http\Controllers\backend;

use App\Models\Departments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DepartmentsController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:department-list');
         $this->middleware('permission:department-create', ['only' => ['create','store']]);
         $this->middleware('permission:department-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:department-delete', ['only' => ['destroy']]);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $title='Department List';
        return view('backend.department.index', compact('title'));
     }

    public function departmentdatatable()
    {
        $data = DB::table('departments')->select('*');
        return datatables()->of($data)
        ->addColumn('action', function ($data) {
                return view('backend.department.action', ['id' => base64_encode($data->id)]);
            })
        ->editColumn('created_at', function ($data) {
                return Carbon::parse($data->created_at)->diffForHumans();
            })
        ->make(true);
        //->toJson();
    }
    

    public function create(Request $request){
        $title='Department Create';         
        if($request->input()){
            $this->validate($request, [
                'department_name'=>'required|unique:departments',
                'status'=>'required',
           ]);
            $data = new Departments;
            $data->department_name= $request->input('department_name');
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
                return redirect('department-list')->with('success',config('app.saveMsg'));;
            } elseif($reply==1062) {
                return redirect()->back()->with('error',config('app.duplicateErrMsg'));;
            } else {
                return redirect()->back()->with('error',config('app.saveError'));;
            }
            
        }
        return view('backend.department.create', compact('title'));
    }

    
    public function edit(Request $request, $id)
    {
        $title='Department Edit';
        $id=base64_decode($id);
        $data=Departments::find($id);
        if($request->input()){
            $this->validate($request, [
            'department_name'=>'required',
            'status'=>'required',       
            ]);
            $data=Departments::where('id', '=', $id)->first();
            $dataarray = array(
                'department_name'  => $request->input('department_name'),
                'description'       => $request->input('description'),
                'status'            => $request->input('status'),
                'created_by'=>      Auth::id()
             );
             try {
                 $reply=Departments::where('id', $id)->update($dataarray);
             } catch(\Illuminate\Database\QueryException $e){
                    $errorCode = $e->errorInfo[1];          
                    $reply=$errorCode;
                
            }
           if($reply==1){
             return redirect('department-list')->with('success',config('app.updateMsg'));
            } elseif($reply==1062) {
               return redirect()->back()->with('error',config('app.duplicateErrMsg'));;
            } else {
                return redirect()->back()->with('error',config('app.saveError')); 
            }

            
        }
        return view('backend.department.edit', ['data'=>$data, 'title'=>$title]);
    }

     public function delete($id){
         $id=base64_decode($id);
         try {
                $reply=Departments::where('id',$id)->delete();
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
