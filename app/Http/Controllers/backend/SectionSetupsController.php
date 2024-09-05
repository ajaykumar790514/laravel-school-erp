<?php

namespace App\Http\Controllers\backend;

use App\Models\SectionSetups;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SectionSetupsController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:sectionsetup-list');
         $this->middleware('permission:sectionsetup-create', ['only' => ['create','store']]);
         $this->middleware('permission:sectionsetup-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:sectionsetup-delete', ['only' => ['destroy']]);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $title="Section Setup";
        return view('backend.section.index', compact('title'));
     }

    public function sectionsetupdatatable()
    {
        $data = DB::table('section_setups')->select('*')->orderBy('section_name', 'asc');
        return datatables()->of($data)
        ->addColumn('action', function ($data) {
                return view('backend.section.action', ['id' => base64_encode($data->id)]);
            })

        ->editColumn('created_at', function ($data) {
                return Carbon::parse($data->created_at)->diffForHumans();
            })
        
        ->make(true);
        //->toJson();
    }
    

    public function create(Request $request){
        $title="Section Setup";        
        if($request->input()){
            $this->validate($request, [
                'section_name'=>'required|unique:section_setups',
                'status'=>'required',
            ]);
            $data = new SectionSetups;
            $data->section_name           = $request->input('section_name');
            $data->status          = $request->input('status');
            $data->users_id          = Auth::id();;
             try {
                $reply=$data->save();
             } catch(\Illuminate\Database\QueryException $e){
                    $errorCode = $e->errorInfo[1];          
                //if($errorCode == 1062){
                    $reply=$errorCode;
                //}
            }
           // print_r($e->errorInfo); exit;
            if($reply==1){
                return redirect('sectionsetup-list')->with('success',config('app.saveMsg')); 
            } elseif($reply==1062) {
                //return redirect('/admission/session-create')->with('error',config('app.duplicateErrMsg')); 
                return redirect()->back()->with('error',config('app.duplicateErrMsg'));;
            } else {
                return redirect('sectionsetup-list')->with('error',config('app.saveError')); 
            }
            
        }
        return view('backend.section.create', compact('title'));
    }

    
    public function edit(Request $request, $id)
    {
        $title="Section Setup Edit"; 
        $id=base64_decode($id);
        $data=SectionSetups::find($id);
        if($request->input()){
            $this->validate($request, [
            'section_name'=>'required',
            'status'=>'required',         
            ]);
            $data=SectionSetups::where('id', '=', $id)->first();
            $dataarray = array(
                'section_name'     => $request->input('section_name'),
                'status'     => $request->input('status'),
                'users_id'=>      Auth::id()
               
            );
             try {
                 $reply=SectionSetups::where('id', $id)->update($dataarray);
             } catch(\Illuminate\Database\QueryException $e){
                    $errorCode = $e->errorInfo[1];          
                //if($errorCode == 1062){
                    $reply=$errorCode;
                //}
            }
           if($reply==1){
             return redirect('sectionsetup-list')->with('success',config('app.updateMsg'));
            } elseif($reply==1062) {
                //return redirect('/admission/session-create')->with('error',config('app.duplicateErrMsg')); 
                return redirect()->back()->with('error',config('app.duplicateErrMsg'));;
            } else {
                return redirect('sectionsetup-list')->with('error',config('app.saveError')); 
            }

            
        }
        //print_r($SessionSetups); exit;
        return view('backend.section.edit', ['data'=>$data, 'title'=>$title]);
    }

     public function delete($id){
         $id=base64_decode($id);
         try {
                 $reply=SectionSetups::where('id',$id)->delete();
             } catch(\Illuminate\Database\QueryException $e){
                    $errorCode = $e->errorInfo[1];          
                //if($errorCode == 1062){
                    $reply=$errorCode;
                //}
            }

        //print_r($e->errorInfo[1]); exit;

        if($reply==1){
            return redirect()->back()->with('success',config('app.deleteMsg'));
        } else if($reply==1451) {
            return redirect()->back()->with('error',config('app.deleteErrMsg1'));
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
