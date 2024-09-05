<?php

namespace App\Http\Controllers;

use App\Models\SimpleSliders;
use App\Models\SimpleSliderItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Url;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Validator;

class SimpleSlidersController extends Controller
{
    
    function __construct()
    {
         $this->middleware('permission:simple-sliders', ['only' => ['index']]);
         $this->middleware('permission:simple-sliders-create', ['only' => ['create']]);
         $this->middleware('permission:simple-sliders-edit', ['only' => ['edit']]);
         $this->middleware('permission:simple-sliders-delete', ['only' => ['destroy']]);
         $this->middleware('permission:simple-sliders-item', ['only' => ['sliderItem']]);
         $this->middleware('permission:simple-sliders-item-create', ['only' => ['sliderItemCreate']]);
         $this->middleware('permission:simple-sliders-item-edit', ['only' => ['sliderItemEdit']]);
         $this->middleware('permission:simple-sliders-item-delete', ['only' => ['sliderItemdelete']]);
    }
  
    
    
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(Request $request)
    {
      $title='Simple Slider List';
      return view('simplesliders.index', compact('title'));
    }

    public function datatable()
    {
        $data = DB::table('simple_sliders')->select('simple_sliders.*');
        return datatables()->of($data)
            ->addColumn('action', function ($data) {
                return view('simplesliders.action', ['id' => base64_encode($data->id)]);
            })
            ->editColumn('created_at', function ($data) {
                return Carbon::parse($data->created_at)->format('d F Y H:i:A');
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
        $title='Simple Sliders Create';
        Validator::extend('without_spaces', function($attr, $value){
            return preg_match('/^\S*$/u', $value);
        });
        
        
        if ($request->input()) {
            $this->validate($request, [
                'name' => 'required',
                'key' => 'required|without_spaces',
                'status' => 'required',
            ],[
                'key.without_spaces' => 'Whitespace not allowed.'
            ]);

            $data = new SimpleSliders;
            $data->name             = $request->input('name');
            $data->key              = $request->input('key');
            $data->description     = $request->input('description');
            $data->status          = $request->input('status');
            
            try {
                $reply = $data->save();
            } catch (\Illuminate\Database\QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $reply = $errorCode;
            }
            if ($reply == 1) {
                return redirect('simple-sliders')->with('success', config('app.saveMsg'));
            } elseif ($reply == 1062) {
                return redirect()->back()->with('error', config('app.duplicateErrMsg'));;
            } else {
                return redirect()->back()->with('error', $e->errorInfo[2]);
            }
        }
        return view('simplesliders.create', compact('title'));
    }
    
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SimpleSliders  $simpleSliders
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $ids){
        $title="Edit Sliders Details";
        $id=base64_decode($ids);
        Validator::extend('without_spaces', function($attr, $value){
            return preg_match('/^\S*$/u', $value);
        });
        $data=SimpleSliders::find($id);
        $sliderItemData=SimpleSliderItems::where('simple_slider_id', $id)->get();

        if($request->input()){
            $this->validate($request, [
                'name' => 'required',
                'key' => 'required|without_spaces',
                'status' => 'required',
            ],[
                'key.without_spaces' => 'Whitespace not allowed.'
            ]);
            $contents=SimpleSliders::where('id', '=', $id)->first();
            $data = array(
                'name'          => $request->input('name'),
                'key'           => $request->input('key'),
                'description'   => $request->input('description'),
                'status'     => $request->input('status')
            );
            
             try {
                 $reply=SimpleSliders::where('id', $id)->update($data);
            } catch(\Illuminate\Database\QueryException $e){
                    $errorCode = $e->errorInfo[1];          
                //if($errorCode == 1062){
                    $reply=$errorCode;
                //}
            }
           if($reply==1){
             return redirect()->back()->with('success',config('app.updateMsg'));
            } elseif($reply==1062) {
                return redirect()->back()->with('error',config('app.duplicateErrMsg'));;
            } else {
                return redirect()->back()->with('error', $e->errorInfo[2]);
            }
        }
       return view('simplesliders.edit', ['data'=>$data, 'title'=>$title, 'id'=>$ids, 'sliderItemData'=>$sliderItemData]) ;
    }

     public function sliderItemCreate(Request $request){
        $baseurl= url('/'); 
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'status' => 'required',
        ]);
        
        if($validator->fails()){
                return response()->json([
                    'status'=>400,
                    'errors'=>$validator->messages()
                ]);
        } else {
            $data = new SimpleSliderItems;
            $data->title                = $request->input('title');
            $data->description          = $request->input('description');
            $data->order_by             = $request->input('order_by');
            $data->image                = $request->input('image');
            $data->simple_slider_id     = $request->input('id');
            $data->status               = $request->input('status');
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
    
     public function showdata($id){
        $editId=$id;
    	$data = DB::table("simple_slider_items")->select('simple_slider_items.*')->where(['id'=>$editId])->first();
	    return response()->json([
	      'data' => $data
	    ]);
    }
    
    
    public function sliderItemEdit(Request $request){
        $baseurl= url('/');
        $validator = Validator::make($request->all(), [
            'title'=>'required',
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
            $data = SimpleSliderItems::where('id', '=', $decodeId)->first();
            
            if(!empty($request->input('image'))){
              $media  =$request->input('image'); 
           } else {
               $media  =$data->image;
           }
           
            $dataarray = array(
                'title'      => $request->input('title'),
                'description'   => $request->input('descraption'),
                'image'         =>$media,
                'status'        => $request->input('status'),
                'link'          => $request->input('link'),
                'order_by'      => $request->input('order_by'),
            );
            try {
                $reply = SimpleSliderItems::where('id', $decodeId)->update($dataarray);
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
    
    
    public function sliderItemdelete($id){
        $id = $id; // decode id
        try {
            $reply = SimpleSliderItems::where('id', $id)->delete(); 
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SimpleSliders  $simpleSliders
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $id = base64_decode($id); // decode id
        try {
            $reply = SimpleSliders::where('id', $id)->delete(); 
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
