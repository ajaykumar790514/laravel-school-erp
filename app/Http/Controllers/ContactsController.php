<?php

namespace App\Http\Controllers;

use App\Models\Contacts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Carbon\Carbon;

class ContactsController extends Controller
{
      function __construct()
    {
         $this->middleware('permission:contact-list', ['only' => ['index']]);
         $this->middleware('permission:contact-delete', ['only' => ['destroy']]);
    }
    
    
    public function index(Request $request) {
        $title='Contact Us';
        return view('contacts.index', compact('title'));
     }

    public function datatable(){
            $data = DB::table('contacts')->select('contacts.*');
             
            $result=$data->get();
        return datatables()->of($result)
        ->addColumn('action', function ($result) {
                return view('contacts.action', ['id' => base64_encode($result->id)]);
            })
       ->editColumn('created_at', function ($result) {
                return Carbon::parse($result->created_at)->diffForHumans();
            })

        ->make(true);
        //->toJson();
    }


    public function destroy($id){
        $id = base64_decode($id); // decode id
        try {
            $reply = Contacts::where('id', $id)->delete(); 
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
