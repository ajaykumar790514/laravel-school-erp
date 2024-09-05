<?php

namespace App\Http\Controllers;

use App\Models\Testimonals;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class TestimonalsController extends Controller
{
   function __construct()
    {
         $this->middleware('permission:testimonals', ['only' => ['index']]);
         $this->middleware('permission:testimonals-create', ['only' => ['create']]);
         $this->middleware('permission:testimonals-edit', ['only' => ['edit']]);
         $this->middleware('permission:testimonals-delete', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title='Testimonals List';
        return view('testimonals.index',compact('title'));

    }

    public function userdatatable() {
        $data = DB::table('testimonals')->select('testimonals.*');
        return datatables()->of($data)
        ->addColumn('action', function ($data) {
                return view('testimonals.action', ['id' =>base64_encode($data->id)]);
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
            'name'          => 'required',
            'descraption'   => 'required',
            'status'        => 'required',
        ]);
        
        if($validator->fails()){
                return response()->json([
                    'status'=>400,
                    'errors'=>$validator->messages()
                ]);
        } else {
            $data = new Testimonals;
            $data->name             = $request->input('name');
            $data->descraption      = $request->input('descraption');
            $data->images           = $request->input('images');
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Testimonals  $testimonals
     * @return \Illuminate\Http\Response
     */
    public function showdata($id){
        $editId=\base64_decode($id);
    	$data = DB::table("testimonals")->select('testimonals.*')->where(['id'=>$editId])->first();
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
            'name'=>'required',
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
            $data = Testimonals::where('id', '=', $decodeId)->first();
                if(!empty($request->input('images'))){
                  $media  =$request->input('images'); 
               } else {
                   $media  =$data->images;
               }
               

            $dataarray = array(
                'name'              => $request->input('name'),
                'descraption'       => $request->input('descraption'),
                'images'            => $media,
                'status'            => $request->input('status'),
            );
            try {
                $reply = Testimonals::where('id', $decodeId)->update($dataarray);
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

    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Testimonals  $testimonals
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $id = base64_decode($id); // decode id
        try {
            $reply = Testimonals::where('id', $id)->delete(); 
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
