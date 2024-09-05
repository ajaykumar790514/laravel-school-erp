<?php

namespace App\Http\Controllers\backend;

use App\Models\ClassSectionMappings;
use App\Models\SectionSetups;
use App\Models\ClassSetups;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ClassSectionMappingsController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:classsectionmaping-list');
         $this->middleware('permission:classsectionmaping-create', ['only' => ['create','store']]);
         $this->middleware('permission:classsectionmaping-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:classsectionmaping-delete', ['only' => ['destroy']]);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $title="Class Section Maping";
        return view('backend.classsectionmaping.index', compact('title'));
     }

    public function classsectionmapingdatatable()
    {
        $data = DB::table('class_section_mappings')
             ->join('class_setups', 'class_section_mappings.class_setups_id', '=', 'class_setups.id')
             ->join('section_setups', 'class_section_mappings.section_setup_id', '=', 'section_setups.id')
             ->select('class_section_mappings.*', 'class_setups.class_name', 'section_setups.section_name')
             ->orderBy('class_setups.order_by', 'asc')
              -> get();
        //echo "<pre>"; print_r($data); exit;
        return datatables()->of($data)
        ->addColumn('action', function ($data) {
                return view('backend.classsectionmaping.action', ['id' => base64_encode($data->id)]);
            })
        ->editColumn('created_at', function ($data) {
                return Carbon::parse($data->created_at)->diffForHumans();
            })
        ->make(true);
        //->toJson();
    }
    

    public function create(Request $request){
        $title="Class Section Create";
        $classmapings = ClassSetups::select('id', 'class_name')->where(['status'=>0])
        ->orderBy('class_name', 'asc')->get();
        $sections= SectionSetups::select('id', 'section_name')->where(['status'=>0])
        ->orderBy('section_name', 'asc')->get();
        $now = Carbon::now();
         if($request->input()){
            $this->validate($request, [
                'class_setups_id'=>'required',
                'section_setup_id'=>'required',
                'status'=>'required',
                
            ]);
            //$data = new ClassSectionMappings;
            $multipalRecordss = [];
            $class_setups_id=$request->input('class_setups_id');
            foreach($request->input('section_setup_id') as $sectionKey){
                $checkUniqe= ClassSectionMappings::select('id')->where(
                    [
                        'class_setups_id'=>$class_setups_id, 
                        'section_setup_id'=>$sectionKey
                    ]
                )->get();
                $checkDuplicateRecord=count($checkUniqe);
               if($checkDuplicateRecord==0){
                    $multipalRecordss[] = [
                        'class_setups_id'           => $class_setups_id,
                        'section_setup_id'           => $sectionKey,
                        'status'          => $request->input('status'),
                        'users_id'          => Auth::id(),
                        'updated_at' => $now,  // remove if not using timestamps
                        'created_at' => $now   // remove if not using timestamps
              
                 ];
                }
             }
               try {
                    $reply= ClassSectionMappings::insert($multipalRecordss);
                 } catch(\Illuminate\Database\QueryException $e){
                       $errorCode = $e->errorInfo[1];          
                }
            //print_r($e->errorInfo); exit;
             if($reply==1){
                return redirect('classsectionmaping-list')->with('success',config('app.saveMsg')); 
            } elseif($reply==1062) {
                //return redirect('/admission/session-create')->with('error',config('app.duplicateErrMsg')); 
                return redirect()->back()->with('error',config('app.duplicateErrMsg'));;
            } else {
                return redirect('classsectionmaping-list')->with('error',config('app.saveError')); 
            }
            
        }
        return view('backend.classsectionmaping.create', compact('classmapings', 'sections', 'title'));
    }

    
    public function edit(Request $request, $id) {
        $title="Class Section Edit";
         $classmapings = ClassSetups::select('id', 'class_name')->where(['status'=>0])
        ->orderBy('class_name', 'asc')->get();
        $sections= SectionSetups::select('id', 'section_name')->where(['status'=>0])
        ->orderBy('section_name', 'asc')->get();
        $id=base64_decode($id);
        $data=ClassSectionMappings::find($id);
        $selectedSection=ClassSectionMappings::select('section_setup_id')
        ->where('class_setups_id', '=', $data->class_setups_id)
        ->where('section_setup_id', '=', $data->section_setup_id)
        ->where('id', '!=', $data->id)->get();

        
        
        if($request->input()){
            $this->validate($request, [
            'class_setups_id'=>'required',
                'section_setup_id'=>'required',
                'status'=>'required',         
            ]);
            $data=ClassSectionMappings::where('id', '=', $id)->first();
            //print_r(count($selectedSection)); exit;
            if(count($selectedSection)==0){
                $dataarray = array(
                    'class_setups_id'     => $request->input('class_setups_id'),
                    'section_setup_id'     => $request->input('section_setup_id'),
                    'status'     => $request->input('status'),
                    'users_id'=>      Auth::id()
                   
                );
                
            } else{
                return redirect('classsectionmaping-list')->with('error',config('app.duplicateErrMsg'));
            }

            try {
                 $reply=ClassSectionMappings::where('id', $id)->update($dataarray);
             } catch(\Illuminate\Database\QueryException $e){
                    //$errorCode = $e->errorInfo[1];          
                if($errorCode == 1062){
                    $reply=$errorCode;
                }
            }
             
           if($reply==1){
             return redirect('/classsectionmaping-list')->with('success',config('app.updateMsg'));
            } elseif($reply==1062) {
                return redirect()->back()->with('error',config('app.duplicateErrMsg'));;
            } else {
                return redirect('/classsectionmaping-list')->with('error',config('app.saveError')); 
            }
         }
        //print_r($SessionSetups); exit;
        return view('backend.classsectionmaping.edit', ['data'=>$data, 'classmapings'=>$classmapings, 'sections'=>$sections, 'selectedSection'=>$selectedSection, 'title'=>$title]);
    }



     public function delete($id){
         $id=base64_decode($id);
        $reply=ClassSectionMappings::where('id',$id)->delete();

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
