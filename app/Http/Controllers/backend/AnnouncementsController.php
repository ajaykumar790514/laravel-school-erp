<?php

namespace App\Http\Controllers\backend;

use App\Models\Announcements;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class AnnouncementsController extends Controller
{
   function __construct()
    {
         $this->middleware('permission:announcements', ['only' => ['index']]);
         $this->middleware('permission:announcements-create', ['only' => ['create']]);
         $this->middleware('permission:announcements-edit', ['only' => ['edit']]);
         $this->middleware('permission:announcements-delete', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title='Announcements List';
        return view('backend.announcements.index',compact('title'));

    }

    public function userdatatable() {
        $data = DB::table('announcements')->select('announcements.*');
        return datatables()->of($data)
        ->addColumn('action', function ($data) {
                return view('backend.announcements.action', ['id' =>base64_encode($data->id)]);
            })
        ->editColumn('created_at', function ($roles) {
            return Carbon::parse($roles->created_at)->diffForHumans();
            })
        ->make(true);
       
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function create(Request $request){
        $baseurl= url('/'); 
        $validator = Validator::make($request->all(), [
            'description'   => 'required',
            'status'        => 'required',
        ]);
        
        if($validator->fails()){
                return response()->json([
                    'status'=>400,
                    'errors'=>$validator->messages()
                ]);
        } else {
            $data = new Announcements;
            $data->urls             = $request->input('urls');
            $data->description      = $request->input('description');
            $data->status           = $request->input('status');
            try {
                $saveData = $data->save();
            } catch (\Illuminate\Database\QueryException $e) {
                $errorCode = $e->errorInfo[1];
            }
            if ($saveData == 1) {
                return response()->json([
                        'status'=>200,
                        'message'=>config('app.saveMsg')
                    ]);
            } else {
                return response()->json([
                    'status'=>500,
                    'message'=>$e->errorInfo[2]
                ]);
            }
        }
    }

    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Testimonals  announcements
     * @return \Illuminate\Http\Response
     */
    public function showdata($id){
        $editId=\base64_decode($id);
    	$data = DB::table("announcements")->select('announcements.*')->where(['id'=>$editId])->first();
	    return response()->json([
	      'data' => $data
	    ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Testimonals  $testimonals
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request){
        $baseurl= url('/');
        $validator = Validator::make($request->all(), [
           'descraption' => 'required',
            'status' => 'required',
        ]);
    
        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages()
            ]);
        } else {
            $decodeId = $request->input('id'); 
            $data = Announcements::where('id', '=', $decodeId)->first();
            $dataarray = array(
                'urls'              => $request->input('urls'),
                'description'       => $request->input('descraption'),
                'status'            => $request->input('status'),
            );
            try {
                $reply = Announcements::where('id', $decodeId)->update($dataarray);
            } catch (\Illuminate\Database\QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $reply = $errorCode;
            }
           
            if ($reply == 1) {
                return response()->json([
                    'status'=>200,
                    'message'=>config('app.updateMsg')
                ]);

            } else {
                 return response()->json([
                    'status'=>500,
                    'message'=>$e->errorInfo[2]
                ]);
            }
        }
    }

    
  
    public function destroy($id){
        $id = base64_decode($id); // decode id
        try {
            $reply = Announcements::where('id', $id)->delete(); 
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $reply = $errorCode;
        }

        if ($reply == 1) {
            return response()->json([
                'status'=>200,
                'message'=>config('app.deleteMsg')
            ]);
        } else if ($reply == 1451) {
            return response()->json([
                'status'=>500,
                'message'=>$e->errorInfo[1]
            ]);

        }else if ($reply == 0) {
            return response()->json([
                'status'=>500,
                'message'=>"Record not Deleted Please Check query "
            ]);

        } else {
            return response()->json([
                'status'=>400,
                'message'=>$e->errorInfo[2]
            ]);

        }
   
    } 
}
