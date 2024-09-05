<?php

namespace App\Http\Controllers\backend;
use App\Models\SessionSetups;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;


class SessionSetupsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:session-list');
         $this->middleware('permission:session-create', ['only' => ['create','store']]);
         $this->middleware('permission:session-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:session-delete', ['only' => ['destroy']]);

    }


    public function index(Request $request) {
        $title="Session List";
        return view('backend.session.index', compact("title"));
     }

    public function sessiondatatable()
    {
        $session = DB::table('session_setups')->select('*');
        return datatables()->of($session)
        ->addColumn('action', function ($session) {
                return view('backend.session.action', ['id' => base64_encode($session->id)]);
            })

        ->editColumn('created_at', function ($roles) {
                return Carbon::parse($roles->created_at)->diffForHumans();
            })
        
        ->make(true);
        //->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function create(Request $request){
        $title="Session Create";         
        if($request->input()){
            $this->validate($request, [
                'session_year'=>'required|unique:session_setups|numeric|digits:4',
                'session_name'=>'required',
                'status'=>'required',
                
            ]);
            $SessionSetups = new SessionSetups;
            $SessionSetups->session_year           = $request->input('session_year');
            $SessionSetups->session_name      = $request->input('session_name');
            $SessionSetups->order_by      = $request->input('order_by');
            $SessionSetups->status          = $request->input('status');
            $SessionSetups->created_by          = Auth::id();;
             try {
                $reply=$SessionSetups->save();
             } catch(\Illuminate\Database\QueryException $e){
                    $errorCode = $e->errorInfo[1];          
                //if($errorCode == 1062){
                    $reply=$errorCode;
                //}
            }
            
            if($reply==1){
                return redirect('session-list')->with('success',config('app.saveMsg')); 
            } elseif($reply==1062) {
                //return redirect('/admission/session-create')->with('error',config('app.duplicateErrMsg')); 
                return redirect()->back()->with('error',config('app.duplicateErrMsg'));;
            } else {
                return redirect('session-list')->with('error',config('app.saveError')); 
            }
            
        }
        return view('backend.session.create', compact('title'));
    }

    
    public function edit(Request $request, $id)
    {
        $title="Session Edit";   
        $id=base64_decode($id);
        $SessionSetups=SessionSetups::find($id);
        if($request->input()){
            $this->validate($request, [
             'session_year'=>'required|numeric|digits:4',
              'session_name'=>'required',
              'status'=>'required',          
            ]);
            $SessionSetups=SessionSetups::where('id', '=', $id)->first();
            $data = array(
                'session_year'     => $request->input('session_year'),
                'session_name'     => $request->input('session_name'),
                'order_by'     => $request->input('order_by'),
                'status'     => $request->input('status'),
               
            );
             try {
                 $reply=SessionSetups::where('id', $id)->update($data);


             } catch(\Illuminate\Database\QueryException $e){
                    $errorCode = $e->errorInfo[1];          
                
            }
           if($reply==1){
             return redirect('session-list')->with('success',config('app.updateMsg'));
            } elseif($reply==1062) {
                return redirect()->back()->with('error',config('app.duplicateErrMsg'));;
            } else {
                return redirect('session-list')->with('error',config('app.saveError')); 
            }

            
        }
        return view('backend.session.edit', ['SessionSetups'=>$SessionSetups, 'title'=>$title]);
    }

     public function sesssiondelete($id){
         $id=base64_decode($id);
        
        try {
                $reply=SessionSetups::where('id',$id)->delete();
             } catch(\Illuminate\Database\QueryException $e){
                    $errorCode = $e->errorInfo[1];          
                //if($errorCode == 1062){
                    $reply=$errorCode;
                //}
            }
        if($reply==1){
            return redirect()->back()->with('success',config('app.deleteMsg'));
        } else if($reply==1451) {
            return redirect()->back()->with('error',config('app.deleteErrMsg1'));
        } else {
             return redirect()->back()->with('error',config('app.deleteErrMsg'));
        }
        
    }

    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SessionSetups  $sessionSetups
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SessionSetups $sessionSetups)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SessionSetups  $sessionSetups
     * @return \Illuminate\Http\Response
     */
    public function destroy(SessionSetups $sessionSetups)
    {
        //
    }
}
