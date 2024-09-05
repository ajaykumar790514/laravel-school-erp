<?php

namespace App\Http\Controllers;

use App\Models\Blocks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Url;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BlocksController extends Controller
{
    
   function __construct()
    {
         $this->middleware('permission:blocks', ['only' => ['index']]);
         $this->middleware('permission:blocks-create', ['only' => ['create']]);
         $this->middleware('permission:blocks-edit', ['only' => ['edit']]);
         $this->middleware('permission:blocks-delete', ['only' => ['destroy']]);
    }
   
   
   
   
   public function index(Request $request){
         $title='Blocks List';
        return view('block.index',compact('title'));
    }

    public function userdatatable() {
        $data = DB::table('blocks')->select('blocks.*');
        return datatables()->of($data)
        ->addColumn('action', function ($data) {
                return view('block.action', ['id' =>base64_encode($data->id)]);
            })
        ->editColumn('created_at', function ($roles) {
            return Carbon::parse($roles->created_at)->diffForHumans();
            })
        ->make(true);
       
    }
  
    public function showdata($id){
        $editId=\base64_decode($id);
    	$data = DB::table("blocks")->select('blocks.*')->where(['id'=>$editId])->first();
	    return response()->json([
	      'data' => $data
	    ]);
    }
    
    
    
    
    public function edit(Request $request, $ids){
        $title='Edit block';
        $id=base64_decode($ids);
        $data=Blocks::find($id);
        if($request->input()){
            $this->validate($request, [
            'content' => 'required',
            'status'=>'required',

            ]);
            $data=Blocks::where('id', '=', $id)->first();
            $content = trim($request->input('content'));
            $content = stripslashes($content);
            $content = htmlspecialchars($content);
            $data = array(
                'content'    => trim($request->input('content')),
                'status'     => $request->input('status')
            );
            
             try {
                 $reply=Blocks::where('id', $id)->update($data);
            } catch(\Illuminate\Database\QueryException $e){
                    $errorCode = $e->errorInfo[1];          
                //if($errorCode == 1062){
                    $reply=$errorCode;
                //}
            }
           if($reply==1){
             return redirect('blocks')->with('success',config('app.updateMsg'));
            } elseif($reply==1062) {
                //return redirect('/admission/session-create')->with('error',config('app.duplicateErrMsg')); 
                return redirect()->back()->with('error',config('app.duplicateErrMsg'));;
            } else {
                return redirect('block')->with('error',config('app.saveError')); 
            }

            
        }
       return view('block.edit', ['data'=>$data, 'title'=>$title, 'ids'=>$ids]) ;
    }
    
    public function delete($id)
    {
        $id = base64_decode($id);
        try {
            $reply = Blocks::where('id', $id)->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $reply = $errorCode;
        }
        if ($reply == 1) {
            return redirect()->back()->with('success', config('app.deleteMsg'));
        } else if ($reply == 1451) {
            return redirect()->back()->with('error', $e->errorInfo[2]);
        } else {
            return redirect()->back()->with('error', $e->errorInfo[2]);
        }
    }

    
}
