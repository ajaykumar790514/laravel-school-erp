<?php

namespace App\Http\Controllers\backend;

use App\Models\FeeAmountSetups;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;


class FeeAmountSetupsController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:fee-amount-setup-list');
         $this->middleware('permission:fee-amount-setup-create', ['only' => ['create','store']]);
         $this->middleware('permission:fee-amount-setup-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:fee-amount-setup-delete', ['only' => ['destroy']]);

    }
    
    public function index(Request $request) {
        $title='Fee Head Setup List';
        return view('backend.feeamount.index', compact('title'));
     }

    public function datatable(){
            $data = DB::table('fee_amount_setups')->select('fee_amount_setups.*', 'session_setups.session_name as sessionNAme', 
                    'class_setups.class_name as className', 'fee_head_setups.fee_head_name as feeHead')
                    ->join('session_setups', 'fee_amount_setups.session_setup_id', '=', 'session_setups.id')
                    ->join('class_setups', 'fee_amount_setups.class_setup_id', '=', 'class_setups.id')
                    ->join('fee_head_setups', 'fee_amount_setups.fee_head_setup_id', '=', 'fee_head_setups.id')->orderBy('fee_amount_setups.id', 'desc');;
            $result=$data->get();
        return datatables()->of($result)
        ->addColumn('action', function ($result) {
                return view('backend.feeamount.action', ['id' => base64_encode($result->id)]);
            })
       ->editColumn('created_at', function ($result) {
                return Carbon::parse($result->created_at)->diffForHumans();
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
            'session_setup_id'     => 'required',
            'class_setup_id'     => 'required',
            'fee_head_setup_id'     => 'required',
            'fee_amount'     => 'required|integer',
            'status'        => 'required',
        ]);
        
        if($validator->fails()){
                return response()->json([
                    'status'=>400,
                    'errors'=>$validator->messages()
                ]);
        } else {
                $checkDuplicate=DB::table('fee_amount_setups')->where(['session_setup_id'=>$request->input('session_setup_id'),
                 'class_setup_id'=>$request->input('class_setup_id'), 'fee_head_setup_id'=>$request->input('fee_head_setup_id')])->count() ;;
                 if($checkDuplicate>0){
                    return response()->json([
                    'status'=>500,
                    'message'=>"You have try to enter duplicate records please check."
                    ]); 
                 }

                $data = new FeeAmountSetups;
                $data->session_setup_id             = $request->input('session_setup_id');
                $data->class_setup_id              = $request->input('class_setup_id');
                $data->fee_head_setup_id              = $request->input('fee_head_setup_id');
                $data->fee_amount              = $request->input('fee_amount');
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
     * @param  \App\Models\FeeAmountSetups  $feeHeadSetups
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request){
        $saveData='';
        $validator = Validator::make($request->all(), [
           'edit_session_setup_id'     => 'required',
            'edit_class_setup_id'     => 'required',
            'edit_fee_head_setup_id'     => 'required',
            'edit_fee_amount'     => 'required|integer',
            'edit_status'        => 'required',
        ],[
        'edit_fee_amount.required' => 'The fee amount field is required',
        'edit_fee_amount.integer' => 'The fee amount must be an integer.'
        ]);
    
        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages()
            ]);
        } else {
            $decodeId = $request->input('id'); 
            $data = FeeAmountSetups::where('id', '=', $decodeId)->first();
            $dataarray = array(
                'session_setup_id'              => $request->input('edit_session_setup_id'),
                'class_setup_id'       => $request->input('edit_class_setup_id'),
                'fee_head_setup_id'       => $request->input('edit_fee_head_setup_id'),
                'fee_amount'       => $request->input('edit_fee_amount'),
                'status'            => $request->input('edit_status'),
                'order_by'            => $request->input('edit_order_by'),            
                
            );
            try {
                $saveData = FeeAmountSetups::where('id', $decodeId)->update($dataarray);
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
    	$data = DB::table("fee_amount_setups")->select('fee_amount_setups.*')->where(['id'=>$editId])->first();
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
            $reply = FeeAmountSetups::where('id', $id)->delete(); 
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
