<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Models\Coupons;

class CouponsController extends Controller
{
   
   function __construct(){
         $this->middleware('permission:coupons-list', ['only' => ['index']]);
         $this->middleware('permission:coupons-create', ['only' => ['create']]);
         $this->middleware('permission:coupons-edit', ['only' => ['edit']]);
         $this->middleware('permission:coupons-delete', ['only' => ['destroy']]);
    }
   
   
   public function index(Request $request) {
        $title='Coupons List';
        return view('backend.coupons.index', compact('title'));
     }

    public function datatable(){
            $data = DB::table('coupons')->select('coupons.*');
            $result=$data->get();
        return datatables()->of($result)
        ->addColumn('action', function ($result) {
                return view('backend.coupons.action', ['id' => base64_encode($result->id)]);
            })
        ->editColumn('start_date', function ($result) {
                 return date('d-m-y', strtotime($result->start_date)).' To '.date('d-m-y', strtotime($result->end_date));
                 
        })
        ->editColumn('coupon_type', function ($result) {
                 if($result->coupon_type==0){
                     return "For Product";
                 } else{
                    return "For Category"; 
                 }
                 
        })
        ->editColumn('discount_type', function ($result) {
                 if($result->discount_type==0){
                     return "Fixed";
                 } else{
                     return "Percentage";
                 }
        })
        ->make(true);
        //->toJson();
    }

    public function create(Request $request){
        $title='Create New Coupon';
        $saveData='';
        if ($request->input()) {
            $validator = Validator::make($request->all(), [
                'coupon_type'           => 'required',
                'coupon_code'           => 'required',
                'product_ids'           => 'required_if:coupon_type,0',
                'category_ids'           => 'required_if:coupon_type,1',
                'start_date'            => 'required',
                'discount'              => 'required|integer',
                'discount_type'         => 'required',
            ]);
            
            if($validator->fails()){
                    return response()->json([
                        'status'=>400,
                        'errors'=>$validator->messages()
                    ]);
            } else {
                    $dateRange = explode('-',$request->input('start_date'));
                    $data = new Coupons;
                    $data->coupon_type          = $request->input('coupon_type');
                    $data->coupon_code          = $request->input('coupon_code');
                    $data->product_ids          = json_encode($request->input('product_ids'));
                    $data->category_ids         = json_encode($request->input('category_ids'));
                    $data->start_date           = date('Y-m-d', strtotime($dateRange[0]));
                    $data->end_date             = date('Y-m-d', strtotime($dateRange[1]));
                    $data->discount             = $request->input('discount');
                    $data->discount_type        = $request->input('discount_type');
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
        return view('backend.coupons.create', compact('title'));
    }

    public function destroy($id){
        $id = base64_decode($id); // decode id
        try {
            $reply = Coupons::where('id', $id)->delete(); 
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
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Testimonals  $testimonals
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id){
        $saveData='';
        $title='Edit New Coupon';
        $decodeId = base64_decode($id);
        $data = Coupons::where('id', '=', $decodeId)->first();
        if($request->input()) {
            $validator = Validator::make($request->all(), [
                'coupon_type'           => 'required',
                'coupon_code'           => 'required|unique:coupons,coupon_code,' . $decodeId,
                'product_ids'           => 'required_if:coupon_type,0',
                'category_ids'           => 'required_if:coupon_type,1',
                'start_date'            => 'required',
                'discount'              => 'required|integer',
                'discount_type'         => 'required',
            ]);
            if($validator->fails()){
                return response()->json([
                    'status'=>400,
                    'errors'=>$validator->messages()
                ]);
            } else {
                 
                $data = Coupons::where('id', '=', $decodeId)->first();
                $dateRange = explode('-',$request->input('start_date'));
                if($request->input('coupon_type')==0){
                    $product=json_encode($request->input('product_ids'));
                    $category='null';
                } else{
                    $product='null';
                    $category=json_encode($request->input('category_ids'));
                }
                
                
                $dataarray = array(
                    'coupon_type'       => $request->input('coupon_type'),
                    'coupon_code'       => $request->input('coupon_code'),
                    'product_ids'       => $product,
                    'category_ids'      => $category,            
                    'start_date'        => date('Y-m-d', strtotime($dateRange[0])),
                    'end_date'          => date('Y-m-d', strtotime($dateRange[1])),
                    'discount'          => $request->input('discount'),
                    'discount_type'     =>$request->input('discount_type'),
                );
                try {
                    $saveData = Coupons::where('id', $decodeId)->update($dataarray);
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
        return view('backend.coupons.edit', compact('title', 'id', 'data'));
    }
}
