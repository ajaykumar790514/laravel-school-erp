<?php

namespace App\Http\Controllers;

use App\Models\NewsEvents;
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


class NewsEventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(Request $request){
        $title='News Events List'; 
        return view('newsevents.index', compact('title'));
    }

    public function datatable()
    {
        $data = DB::table('news_events')->select('news_events.*');
        return datatables()->of($data)
            ->addColumn('action', function ($data) {
                return view('newsevents.action', ['id' => base64_encode($data->id), 'slug'=>$data->slug]);
            })
            ->editColumn('post_date', function ($data) {
                if($data->post_date!=''){
                    return Carbon::parse($data->post_date)->format('d F Y');
                } else {
                    return '';
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
        $title='Create News Events'; 
        if ($request->input()) {
           $this->validate($request, [
            'title'=>'required',
            'media_type' => 'required',
            'banner' => 'required_if:media_type,==,0|mimes:jpeg,jpg,png, gif',
            'video_content' => 'required_if:media_type,==,1',
            'description'=>'required',
            'status'=>'required',
            //'images' => 'required|mimes:jpeg,jpg,png, gif',
            ]);
            $data = new NewsEvents;
            $data->title =  $request->input('title');
            $data->short_description =  $request->input('short_description');
            $data->media_type =  $request->input('media_type');
            $data->description =  $request->input('description');
            $data->post_date =  date('Y-m-d', strtotime($request->input('post_date')));
            $data->status          =$request->input('status');
            if($request->input('media_type')==0){
                if($request->file('banner')){
                    $file=$request->file('banner');
                    $filename='news_events_'.date('ymdHis').'.'.$file->getClientOriginalExtension();
                    $image_resize = Image::make($request->file('banner')->getRealPath());              
                    //$image_resize->resize(1200, 430);
                     $image_resize->save('public/uploads/' .$filename);
                    $url='uploads/'.$filename;
                    $data->media  =$url;
                }
            } else{
                $data->media  =$request->input('video_content');
            }
            $slug = $slug = Str::slug($request->input('title'), '-');
            $same_slug_count = NewsEvents::where('slug', 'LIKE', $slug . '%')->count();
            $slug_suffix = $same_slug_count ? '-' . $same_slug_count + 1 : '';
            $slug .= $slug_suffix;
            $data->slug =  $slug;
            
            
            
            try {
                $reply = $data->save();
            } catch (\Illuminate\Database\QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $reply = $errorCode;
            }
            if ($reply == 1) {
                return redirect('newsevents-list')->with('success', config('app.saveMsg'));
            } elseif ($reply == 1062) {
                return redirect()->back()->with('error', config('app.duplicateErrMsg'));;
            } else {
                return redirect()->back()->with('error', $e->errorInfo[2]);;
            }
        }
        return view('newsevents.create', compact('title'));
    }
   

    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NewsEvents  $newsEvents
     * @return \Illuminate\Http\Response
     */
    public function show(NewsEvents $newsEvents)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NewsEvents  $newsEvents
     * @return \Illuminate\Http\Response
     */
     public function edit(Request $request, $id)
    {
        $title='Edit News Events';
        $ids=$id;
        $id = base64_decode($id);
        $data = NewsEvents::find($id);
        if ($request->input()) {
            $this->validate($request, [
                'title'=>'required',
                'media_type'=>'required',
                //'banner'=>'required_if:media_type,==,0|mimes:jpeg,jpg,png, gif|nullable',
                //'video_content'=>'required_if:media_type,==,1',
                'description'=>'required',
                'status'=>'required',
            ]);

            $data = NewsEvents::where('id', '=', $id)->first();
           if($request->input('media_type')==0){
                if($request->file('banner')){
                    $file=$request->file('banner');
                    $filename='news_events_'.date('ymdHis').'.'.$file->getClientOriginalExtension();
                    $image_resize = Image::make($request->file('banner')->getRealPath());              
                     $image_resize->save('public/uploads/' .$filename);
                    $url='uploads/'.$filename;
                    $media  =$url;
                } else{
                    $media  =$data->media;
                }
            } else{
                $media  =$request->input('video_content');
            }
            $slug = $slug = Str::slug($request->input('title'), '-');
            $same_slug_count = NewsEvents::where('slug', 'LIKE', $slug . '%')->whereNot('id', $data->id)->count();
            $slug_suffix = $same_slug_count ? '-' . $same_slug_count + 1 : '';
            $slug .= $slug_suffix;

            $dataarray = array(
                'media'                     => $media,
                'title'                     => $request->input('title'),
                'short_description'         => $request->input('short_description'),
                'slug'                      => $slug,
                'post_date'                => $request->input('post_date')!=''?date('Y-m-d', strtotime($request->input('post_date'))):$data->post_date,
                'description'       => $request->input('description'),
                'status'       => $request->input('status'),
            );
            try {
                $reply = NewsEvents::where('id', $id)->update($dataarray);
            } catch (\Illuminate\Database\QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $reply = $errorCode;
            }
            if ($reply == 1) {
                return redirect('newsevents-list')->with('success', config('app.updateMsg'));
            } elseif ($reply == 1062) {
                return redirect()->back()->with('error', config('app.duplicateErrMsg'));;
            } else {
                return redirect()->back()->with('error', $e->errorInfo[2]);
            }
        }
        return view('newsevents.edit', ['data' => $data, 'id'=>$ids, 'title'=>$title]);
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
            $reply = NewsEvents::where('id', $ids)->delete();
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
