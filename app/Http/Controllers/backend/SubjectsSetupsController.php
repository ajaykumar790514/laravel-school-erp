<?php

namespace App\Http\Controllers\backend;

use App\Models\SubjectSetups;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;



class SubjectsSetupsController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:subjectssetup-list');
         $this->middleware('permission:subjectssetup-create', ['only' => ['create','store']]);
         $this->middleware('permission:subjectssetup-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:subjectssetup-delete', ['only' => ['destroy']]);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $title="Subject Setup List";
        return view('backend.subjects.index', compact('title'));
     }

     private function getCategories($parentId = 0){
        $categories = [];
        foreach(SubjectSetups::where('parent_id', 0)->get() as $category)
        {
            $categories = [
                'item' => $category,
                'children' => $this->getCategories($category->id)
            ];
        }
        return $categories;
    }



    public function subjectsetupdatatable()
    {
        $data = DB::table('subject_setups')->select('*')->orderBy('order_by', 'asc');
        return datatables()->of($data)
        ->addColumn('action', function ($data) {
                return view('backend.subjects.action', ['id' => base64_encode($data->id)]);
            })

        ->editColumn('created_at', function ($data) {
                return Carbon::parse($data->created_at)->diffForHumans();
            })
        ->editColumn('parent_id', function ($data) {
                return SubjectSetups::getParent($data->parent_id);
            })
        
        ->make(true);
        //->toJson();
    }
    

    public function create(Request $request){
        $title="Subject Setup Create";
        $parents= SubjectSetups::select('id', 'subject_initial', 'parent_id')->where(['status'=>0, 'parent_id'=>0])->orderBy('subject_initial', 'asc')->get();
                 
        if($request->input()){
            $this->validate($request, [
                'subject_initial'=>'required|unique:subject_setups',
                'subject_name'=>'required',
                'subject_type'=>'required',
                'subject_mode'=>'required',
                'status'=>'required',
            ]);
            $data = new SubjectSetups;
            //echo $request->input('parent_id'); exit;
            $data->subject_initial           = $request->input('subject_initial');
            if($request->input('parent_id')!=""){
                $data->parent_id           = $request->input('parent_id');
            }
            
            $data->subject_name           = $request->input('subject_name');
            $data->subject_type           = $request->input('subject_type');
            $data->subject_mode           = $request->input('subject_mode');
             $data->order_by           = $request->input('order_by');
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
                return redirect('/subjectssetup-list')->with('success',config('app.saveMsg')); 
            } elseif($reply==1062) {
                //return redirect('/admission/session-create')->with('error',config('app.duplicateErrMsg')); 
                return redirect()->back()->with('error',config('app.duplicateErrMsg'));;
            } else {
                return redirect('subjectssetup-list')->with('error',config('app.saveError')); 
            }
            
        }
        return view('backend.subjects.create', compact('parents', 'title'));
    }

    
    public function edit(Request $request, $id)
    {
         $title="Subject Setup Edit";
        $id=base64_decode($id);
        $data=SubjectSetups::find($id);
        if($request->input()){
            $this->validate($request, [
            'subject_initial'=>'required',
                'subject_name'=>'required',
                'subject_type'=>'required',
                'subject_mode'=>'required',
                'status'=>'required',     
            ]);
            $data=SubjectSetups::where('id', '=', $id)->first();
            if($request->input('parent_id')!=""){
                $parent_id           = $request->input('parent_id');
            } else {
                $parent_id=0;
            }
            $dataarray = array(
                'parent_id'     => $parent_id,
                'subject_initial'     => $request->input('subject_initial'),
                'subject_name'     => $request->input('subject_name'),
                'subject_type'     => $request->input('subject_type'),
                'subject_mode'     => $request->input('subject_mode'),
                'order_by'     => $request->input('order_by'),
                'status'     => $request->input('status'),
                'users_id'=>      Auth::id()
               
            );
            try {
                 $reply=SubjectSetups::where('id', $id)->update($dataarray);
             } catch(\Illuminate\Database\QueryException $e){
                    $errorCode = $e->errorInfo[1];          
                //if($errorCode == 1062){
                    $reply=$errorCode;
                //}
            }
           if($reply==1){
             return redirect('/subjectssetup-list')->with('success',config('app.updateMsg'));
            } elseif($reply==1062) {
                //return redirect('/admission/session-create')->with('error',config('app.duplicateErrMsg')); 
                return redirect()->back()->with('error',config('app.duplicateErrMsg'));;
            } else {
                return redirect('/subjectssetup-list')->with('error',config('app.saveError')); 
            }

            
        }
        //print_r($SessionSetups); exit;
        return view('backend.subjects.edit', ['data'=>$data, 'title'=>$title]);
    }

     public function delete($id){
         $id=base64_decode($id);
        $reply=SubjectSetups::where('id',$id)->delete();

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
