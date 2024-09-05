<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\ZipAvailabilites;
use Illuminate\Support\Facades\Validator;

class ZipAvailabilitesController extends Controller
{
    
    function __construct(){
         $this->middleware('permission:zip-availability-list', ['only' => ['index']]);
         $this->middleware('permission:zip-availability-create', ['only' => ['create']]);
         $this->middleware('permission:zip-availability-edit', ['only' => ['edit']]);
         $this->middleware('permission:zip-availability-delete', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $title='Zip Availability List';
        return view('backend.zip_availability.index', compact('title'));
     }

    public function datatable(){
            $data = DB::table('zip_availabilites')->select('zip_availabilites.*', 'states.name as state', 'cities.name as city')
                     ->join('states', 'zip_availabilites.state_id', '=', 'states.id')
                      ->join('cities', 'zip_availabilites.city_id', '=', 'cities.id');
            $result=$data->get();
        return datatables()->of($result)
        ->addColumn('action', function ($result) {
                return view('backend.zip_availability.action', ['id' => base64_encode($result->id)]);
            })
       ->editColumn('created_at', function ($result) {
                return Carbon::parse($result->created_at)->diffForHumans();
        })
        ->editColumn('state_id', function ($result) {
                return $result->state.'/'.$result->city;
        })
        ->make(true);
        //->toJson();
    }
    
    
    public function getCity(Request $request){
        if(!empty($request->stateID)){
             $cityDetails = DB::table('cities')
                    ->select('id', 'name')
                    ->where(['status'=>0, 'state_id'=>$request->stateID])->orderBy('name', 'asc')->get();
            return json_encode($cityDetails);
        }
       
    }
    
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function create(Request $request){
        $saveData='';
        $validator = Validator::make($request->all(), [
            'state_id'          => 'required',
            'city_id'   => 'required',
            'pincode'   => 'required|integer',
            'deliver_with_days'   => 'nullable|integer',
            'extra_charges'   => 'nullable|integer',
            'status'        => 'required',
        ]);
        
        if($validator->fails()){
                return response()->json([
                    'status'=>400,
                    'errors'=>$validator->messages()
                ]);
        } else {
                $data = new ZipAvailabilites;
                $data->state_id             = $request->input('state_id');
                $data->city_id              = $request->input('city_id');
                $data->area                 = $request->input('area');
                $data->pincode              = $request->input('pincode');
                $data->available            = $request->input('available');
                $data->deliver_with_days    = $request->input('deliver_with_days');
                $data->extra_charges        = $request->input('extra_charges');
                $data->status               = $request->input('status');
                $data->created_by           = Auth::id();
            //print_r($data->save()); exit;
            
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
    
    
    
     public function destroy($id){
        $id = base64_decode($id); // decode id
        try {
            $reply = ZipAvailabilites::where('id', $id)->delete(); 
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
     * Display the specified resource.
     *
     * @param  \App\Models\Testimonals  $testimonals
     * @return \Illuminate\Http\Response
     */
    public function showdata($id){
        $editId=\base64_decode($id);
    	$data = DB::table("zip_availabilites")->select('zip_availabilites.*')->where(['id'=>$editId])->first();
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
        $saveData='';
        $validator = Validator::make($request->all(), [
            'edit_state_id'          => 'required',
            'edit_city_id'   => 'required',
            'edit_pincode'   => 'required|integer',
            'edit_deliver_with_days'   => 'nullable|integer',
            'edit_extra_charges'   => 'nullable|integer',
            'edit_status'        => 'required',
        ]);
    
        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages()
            ]);
        } else {
            $decodeId = $request->input('id'); 
            $data = ZipAvailabilites::where('id', '=', $decodeId)->first();
            $dataarray = array(
                'state_id'              => $request->input('edit_state_id'),
                'city_id'       => $request->input('edit_city_id'),
                'area'            => $request->input('edit_area'),
                'pincode'            => $request->input('edit_pincode'),            
                'available'       => $request->input('edit_available'),
                'deliver_with_days'            => $request->input('edit_deliver_with_days'),
                'extra_charges'            => $request->input('edit_extra_charges'),
                'status'              => $request->input('edit_status'),
            );
            try {
                $saveData = ZipAvailabilites::where('id', $decodeId)->update($dataarray);
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
    
    
    
}
