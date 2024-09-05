<?php

namespace App\Http\Controllers\backend;

use App\Models\FeeHeadSetups;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;


class FeeHeadSetupsController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:fee-head-setup-list');
         $this->middleware('permission:fee-head-setup-create', ['only' => ['create','store']]);
         $this->middleware('permission:fee-head-setup-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:fee-head-setup-delete', ['only' => ['destroy']]);

    }
    
    public function index(Request $request) {
        $title='Fee Head Setup List';
        return view('backend.feeheadsetup.index', compact('title'));
     }

    public function datatable(){
            $data = DB::table('fee_head_setups')->select('fee_head_setups.*');
            $result=$data->get();
        return datatables()->of($result)
        ->addColumn('action', function ($result) {
                return view('backend.feeheadsetup.action', ['id' => base64_encode($result->id)]);
            })
       ->editColumn('created_at', function ($result) {
                return Carbon::parse($result->created_at)->diffForHumans();
        })
        ->editColumn('is_compulsory', function ($result) {
                if($result->is_compulsory==0){
                    return "Yes";
                } else{
                    return "No";
                }
        })
        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function create(Request $request){
        $saveData='';
        $validator = Validator::make($request->all(), [
            'fee_head_name'     => 'required|unique:fee_head_setups',
            'is_compulsory'     => 'required',
            'status'        => 'required',
        ]);
        
        if($validator->fails()){
                return response()->json([
                    'status'=>400,
                    'errors'=>$validator->messages()
                ]);
        } else {
                $data = new FeeHeadSetups;
                $data->fee_head_name             = $request->input('fee_head_name');
                $data->is_compulsory              = $request->input('is_compulsory');
                $data->order_by                 = $request->input('order_by');
                $data->status               = $request->input('status');
                $data->created_by           = Auth::id();
            try {
                $saveData = $data->save();
            } catch (\Illuminate\Database\QueryException $e) {
                $errorCode = $e->errorInfo[1];
            }
            
            if ($saveData==1) {
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FeeHeadSetups  $feeHeadSetups
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request){
        $saveData='';
        $validator = Validator::make($request->all(), [
           'edit_fee_head_name'     => 'required',
           'edit_is_compulsory'     => 'required',
           'edit_status'        => 'required',
        ]);
    
        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages()
            ]);
        } else {
            $decodeId = $request->input('id'); 
            $data = FeeHeadSetups::where('id', '=', $decodeId)->first();
            $dataarray = array(
                'fee_head_name'              => $request->input('edit_fee_head_name'),
                'is_compulsory'       => $request->input('edit_is_compulsory'),
                'status'            => $request->input('edit_status'),
                'order_by'            => $request->input('edit_order_by'),            
                
            );
            try {
                $saveData = FeeHeadSetups::where('id', $decodeId)->update($dataarray);
            } catch (\Illuminate\Database\QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $saveData = $errorCode;
            }
           
            if ($saveData == 1) {
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
     * Display the specified resource.
     *
     * @param  \App\Models\FeeHeadSetups  $feeHeadSetups
     * @return \Illuminate\Http\Response
     */
     public function showdata($id){
        $editId=\base64_decode($id);
    	$data = DB::table("fee_head_setups")->select('fee_head_setups.*')->where(['id'=>$editId])->first();
	    return response()->json([
	      'data' => $data
	    ]);
    }


    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FeeHeadSetups  $feeHeadSetups
     * @return \Illuminate\Http\Response
     */
    public function delete($id){
        $id = base64_decode($id); // decode id
        try {
            $reply = FeeHeadSetups::where('id', $id)->delete(); 
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
                'message'=>$e->errorInfo[2]
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
