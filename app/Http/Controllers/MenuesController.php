<?php

namespace App\Http\Controllers;

use App\Models\Menues;
use App\Models\Pages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use DB;
use App\Models\Roles;
use Carbon\Carbon;
use Hash;
use Illuminate\Support\Arr;


class MenuesController extends Controller
{
    
    function __construct()
    {
         $this->middleware('permission:menu-list', ['only' => ['index']]);
         $this->middleware('permission:menu-create', ['only' => ['create']]);
         $this->middleware('permission:menu-edit', ['only' => ['edit']]);
         $this->middleware('permission:menu-delete', ['only' => ['destroy']]);
    }
    
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(Request $request)
    {
        $title='Menu List';
        $parentMenu = Menues::select('id', 'name')->where(['parent_id' => 0])->get();
        $pages = Pages::where(['status' => 0])->get();
        return view('menu.index',compact('title', 'parentMenu', 'pages'));

    }

    public function userdatatable() {
        $data = DB::table('menues')->select('menues.*');
        return datatables()->of($data)
        ->addColumn('action', function ($data) {
                return view('menu.action', ['id' =>base64_encode($data->id)]);
            })
            ->editColumn('parent_id', function ($data) {
                return $data->parent_id==0?"Root":Menues::getRootName($data->parent_id);
            })
            ->editColumn('created_at', function ($data) {
                return Carbon::parse($data->created_at)->diffForHumans();
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
            'name' => 'required|unique:menues',
            'link_type' => 'required',
            'url_link_external' => 'required_if:link_type,==,1',
            'url_link_internal' => 'required_if:link_type,==,0',
            'status' => 'required',
        ]);
        
        if($validator->fails()){
                return response()->json([
                    'status'=>400,
                    'errors'=>$validator->messages()
                ]);
        } else {
            $data = new Menues;
            $data->name             = $request->input('name');
            $data->link_type        = $request->input('link_type');
            $data->order_by        = $request->input('order_by');
            $data->parent_id        = $request->input('parent_id')==""?"0":$request->input('parent_id');
           if($request->input('link_type')==0){
               $data->url_link     = $baseurl."/page/".$request->input('url_link_internal');
           } else if($request->input('link_type')==1){
               $data->url_link      = $request->input('url_link_external');
           }
            $data->target_window    = $request->input('target_window');
            $data->status           = $request->input('status');
            $data->created_at       = Carbon::now()->timestamp;
           
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
     * @param  \App\Models\Menues  $menues
     * @return \Illuminate\Http\Response
     */
    public function showdata($id){
        $editId=\base64_decode($id);
    	$data = DB::table("menues")->select('menues.*')->where(['id'=>$editId])->first();
	    return response()->json([
	      'data' => $data
	    ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Menues  $menues
     * @return \Illuminate\Http\Response
     */
   public function edit(Request $request){
        $baseurl= url('/');
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'link_type' => 'required',
            'url_link_external' => 'required_if:link_type,==,1',
            'url_link_internal' => 'required_if:link_type,==,0',
            'status' => 'required',
        ]);
    
        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages()
            ]);
        } else {
            $decodeId = $request->input('id'); 
            $data = Menues::where('id', '=', $decodeId)->first();

           if($request->input('link_type')==0){
               $url_link     = $baseurl."/page/".$request->input('url_link_internal');
           } else if($request->input('link_type')==1){
              $url_link      = $request->input('url_link_external');
           }

            $dataarray = array(
                'name'      => $request->input('name'),
                'link_type'          => $request->input('link_type'),
                'order_by'          => $request->input('order_by'),
                'url_link'         => $url_link,
                'parent_id'         => $request->input('parent_id'),
                'target_window'         => $request->input('target_window'),
                'status'         => $request->input('status'),
                'updated_at'    =>      Carbon::now()->toDateTimeString()
            );
            try {
                $reply = Menues::where('id', $decodeId)->update($dataarray);
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
     * @param  \App\Models\Menues  $menues
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $id = base64_decode($id); // decode id
        try {
            $reply = Menues::where('id', $id)->delete(); 
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
