<?php

namespace App\Http\Controllers\backend;

use App\Models\MediaGalleries;
use App\Models\MediaCategories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Url;
use Intervention\Image\ImageManagerStatic as Image;
use Carbon\Carbon;
use Illuminate\Support\Str;

class MediaGalleriesController extends Controller
{
    
    function __construct(){
         $this->middleware('permission:media-gallery-list', ['only' => ['index']]);
         $this->middleware('permission:media-gallery-create', ['only' => ['create']]);
         $this->middleware('permission:media-gallery-delete', ['only' => ['destroy']]);
         
         $this->middleware('permission:video-gallery-list', ['only' => ['videoindex']]);
         $this->middleware('permission:video-gallery-create', ['only' => ['videocreate']]);
         $this->middleware('permission:video-gallery-edit', ['only' => ['videoedit']]);
         $this->middleware('permission:video-gallery-delete', ['only' => ['videodestroy']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(Request $request){
        $title='Media Gallery  List'; 
        return view('backend.mediagallery.index', compact('title'));
    }

    public function datatable()
    {
        $data = DB::table('media_galleries')
        ->join('media_categories', 'media_galleries.media_categories_id', '=', 'media_categories.id')
        ->select('media_galleries.*', 'media_categories.title as catname')->where(['media_type'=>0]);
        return datatables()->of($data)
            ->addColumn('action', function ($data) {
                return view('backend.mediagallery.action', ['id' => base64_encode($data->id)]);
            })
            ->make(true);
     
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function create(Request $request){
        $title='Create Media Gallery'; 
        $categories = MediaCategories::where(['parent_id' => 0])
        ->with('children')
        ->get();
            
        if ($request->input()) {
           $this->validate($request, [
                'media'=>'required|array',
                'status'=>'required',
                'media_categories_id'=>'required',
            ]);
            
        
            $data = new MediaGalleries;
            foreach($request->input('media') as $multiImg){
                $multipalImg = new MediaGalleries;
                $multipalImg->media_type                =  0;
                $multipalImg->media_categories_id       =  $request->input('media_categories_id');
                $multipalImg->title                     =  $request->input('title');
                $multipalImg->media                     = $multiImg;
                $multipalImg->status                    = $request->input('status');
                $reply = $multipalImg->save();
            }
            
            return redirect('media-gallery-list')->with('success', config('app.saveMsg'));
        }
        return view('backend.mediagallery.create', compact('title', 'categories'));
    }
   


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NewsEvents  $newsEvents
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ids = base64_decode($id);
        
        try {
            $reply = MediaGalleries::where('id', $ids)->delete();
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
    
    public function videoindex(Request $request){
        $title='Video Gallery  List'; 
        return view('backend.mediagallery.videoindex', compact('title'));
    }

    public function videodatatable()
    {
        $data = DB::table('media_galleries')
        ->join('media_categories', 'media_galleries.media_categories_id', '=', 'media_categories.id')
        ->select('media_galleries.*', 'media_categories.title as catname')->where(['media_type'=>1]);
        return datatables()->of($data)
            ->addColumn('action', function ($data) {
                return view('backend.mediagallery.videoaction', ['id' => base64_encode($data->id)]);
            })
             ->addColumn('video', function ($data) {
                return view('backend.mediagallery.video_frame', ['video' =>$data->media]);
            })
            ->make(true);
     
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function videocreate(Request $request){
        $title='Video Media Gallery'; 
        $categories = MediaCategories::where(['parent_id' => 0])
        ->with('children')
        ->get();
        if($request->isMethod('post')) {
           $this->validate($request, [
                'media_content'=>'required',
                'status'=>'required', 
                'media_categories_id'=>'required',
                'demo'=>'required',
            ]);

            $data = new MediaGalleries;
            $data->media_type                =  1;
            $data->media_categories_id       =  $request->input('media_categories_id');
            $data->title                     =  $request->input('title');
            $data->media                     = $request->input('media_content');
            $data->status                    = $request->input('status');
            $reply = $data->save();
            
            try {
                $reply = $data->save();
            } catch (\Illuminate\Database\QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $reply = $errorCode;
            }
           // print_r($e->errorInfo[2]); exit;
            
            if ($reply == 1) {
                return redirect('video-gallery-list')->with('success', config('app.saveMsg'));
            } else {
                return redirect()->back()->with('error', $e->errorInfo[2]);;
            }

            
        } 
        return view('backend.mediagallery.videocreate', compact('title', 'categories'));
    }
    
     public function videoedit(Request $request, $id)
    {
        $title='Edit Video Category';
        $ids=$id;
        $id = base64_decode($id);
        $data = MediaGalleries::find($id);
        $categories = MediaCategories::where(['parent_id' => 0])->where('id', '!=' , $id)
            ->with('children')
            ->get();
        
        if ($request->input()) {
            $this->validate($request, [
                'media'=>'required',
                'status'=>'required',
                'media_categories_id'=>'required',
            ]);
            $data = MediaGalleries::where('id', '=', $id)->first();
            $dataarray = array(
                'media_categories_id'  => $request->input('media_categories_id'),
                'title'       => $request->input('title'),
                'status'            => $request->input('status'),
                'media'    => $request->input('media'),
            );
            try {
                $reply = MediaGalleries::where('id', $id)->update($dataarray);
            } catch (\Illuminate\Database\QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $reply = $errorCode;
            }
            if ($reply == 1) {
                return redirect('video-gallery-list')->with('success', config('app.updateMsg'));
            } elseif ($reply == 1062) {
                return redirect()->back()->with('error', config('app.duplicateErrMsg'));;
            } else {
                return redirect()->back()->with('error', $e->errorInfo[2]);
            }
        }
        return view('backend.mediagallery.videoedit', compact('data', 'categories', 'ids', 'title'));
    }
    
     public function videodestroy($id){
        $ids = base64_decode($id);
        
        try {
            $reply = MediaGalleries::where('id', $ids)->delete();
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
