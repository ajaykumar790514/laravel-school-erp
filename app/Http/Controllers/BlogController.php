<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Url;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as Image;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;


class BlogController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:blog-list', ['only' => ['index']]);
         $this->middleware('permission:blog-create', ['only' => ['create']]);
         $this->middleware('permission:blog-edit', ['only' => ['edit']]);
         $this->middleware('permission:blog-view', ['only' => ['show']]);
         $this->middleware('permission:blog-delete', ['only' => ['destroy']]);
    }
    
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $title='Blog List';
        return view('blog.index', compact('title'));
     }

    public function datatable(){
            $data = DB::table('blogs')->select('blogs.*');
            $result=$data->get();
        return datatables()->of($result)
        ->addColumn('action', function ($result) {
                return view('blog.action', ['id' => base64_encode($result->id), 'slug'=>$result->slug]);
            })
       ->editColumn('created_at', function ($result) {
                return Carbon::parse($result->created_at)->diffForHumans();
            })

        ->make(true);
        //->toJson();
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $title='Blog Create';
        if($request->input()){
            $this->validate($request, [
            'title'=>'required',
            'media_type' => 'required',
            'banner' => 'required_if:media_type,==,0',
            'video_content' => 'required_if:media_type,==,1',
            'description'=>'required',
            'status'=>'required',
            ]);
            
            $slug = Str::replace(' ', '-', $request->input('title'));
            $slug = Str::lower($slug);
            $same_slug_count = Blog::where('slug', 'LIKE', $slug . '%')->count();
            $slug_suffix = $same_slug_count ? '-' . $same_slug_count + 1 : '';
            $slug .= $slug_suffix;

            $newsevents = new Blog;
            $newsevents->title              = $request->input('title');
            $newsevents->slug               = $slug;
            $newsevents->short_description  = $request->input('short_description');
            $newsevents->description        = $request->input('description');
            $newsevents->media_type         = $request->input('media_type');
            $newsevents->status             = $request->input('status');
            if($request->input('media_type')==0){
                    $newsevents->media  =$request->input('banner');
            } else{
                $newsevents->media  =$request->input('video_content');
            }
                try {
                    $reply=$newsevents->save();
                 } catch(\Illuminate\Database\QueryException $e){
                        $errorCode = $e->errorInfo[1];          
                        $reply=$errorCode;
                }
                if($reply==1){
                    return redirect('blog-list')->with('success',config('app.saveMsg')); 
                    //return redirect()->back()->with('success',config('app.saveMsg'));;
                } elseif($reply==1062) {
                    return redirect()->back()->with('error',config('app.duplicateErrMsg'));;
                } else {
                   return redirect()->back()->with('error',$e->errorInfo[2]);;
                }
            
        }
        return view('blog.create', compact('title'));
    }

    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
     public function edit(Request $request, $id){
         $title='Edit Blog';
        $ids=$id;
        $id=base64_decode($id);
         $data=Blog::find($id);
        if($request->input()){
            $this->validate($request, [
                'title'=>'required',
                'media_type' => 'required',
                //'banner' => 'required_if:media_type,==,0',
                'video_content' => 'required_if:media_type,==,1',
                'description'=>'required',
                'status'=>'required',
            ]);
            $data=Blog::where('id', '=', $id)->first();
            if($request->input('media_type')==0){
               if(!empty($request->input('banner'))){
                  $media  =$request->input('banner'); 
               } else {
                   $media  =$data->media;
               }
            } else{
                $media  =$request->input('video_content');
            }
            
            $slug = Str::replace(' ', '-', $request->input('title'));
            $slug = Str::lower($slug);
            $same_slug_count = Blog::where('slug', 'LIKE', $slug . '%')->count();
            $slug_suffix = $same_slug_count ? '-' . $same_slug_count + 1 : '';
            $slug .= $slug_suffix;

            $dataarray = array(
                'description'           => $request->input('description'),
                'title'                 => $request->input('title'),
                'short_description'     => $request->input('short_description'),
                'slug'                  =>$slug,
                'media_type'            => $request->input('media_type'),
                'media'                 =>$media,
                'status'                =>$request->input('status'),
            );
            try {
                 $reply=Blog::where('id', $id)->update($dataarray);
             } catch(\Illuminate\Database\QueryException $e){
                    $errorCode = $e->errorInfo[1];          
                    $reply=$errorCode;
                
            }
           // print_r($e->errorInfo); exit;
           if($reply==1){
            return redirect('/blog-list')->with('success',config('app.updateMsg')); 
             } elseif($reply==1062) {
               return redirect()->back()->with('error',config('app.duplicateErrMsg'));;
            } else {
                return redirect()->back()->with('error',$e->errorInfo[2]); 
            }
        }

        return view('blog.edit', ['data'=>$data, 'id'=>$ids, 'title'=>$title]) ;
    }

    /**
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id=base64_decode($id);
        try {
                $reply=Blog::where('id',$id)->delete();
             } catch(\Illuminate\Database\QueryException $e){
                    $errorCode = $e->errorInfo[1];          
                    $reply=$errorCode;
            }
            // print_r($e->errorInfo); exit;
        if($reply==1){
            return redirect()->back()->with('success',config('app.deleteMsg'));
        } else if($reply==1451) {
            return redirect()->back()->with('error',$e->errorInfo[2]);
        } else {
             return redirect()->back()->with('error',$e->errorInfo[2]);
        }
    }
}
