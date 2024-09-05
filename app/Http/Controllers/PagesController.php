<?php

namespace App\Http\Controllers;

use App\Models\Pages;
use App\Models\SimpleSliders;
use App\Models\Menuitems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Url;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;


class PagesController extends Controller
{
    
  function __construct()
    {
         $this->middleware('permission:cms-list', ['only' => ['index']]);
         $this->middleware('permission:cms-create', ['only' => ['create']]);
         $this->middleware('permission:cms-edit', ['only' => ['edit']]);
         $this->middleware('permission:cms-delete', ['only' => ['destroy']]);
    }
  
  
  
   public function index(Request $request)
    {
      $title='CMS List';
      return view('page.index', compact('title'));
    }

    public function datatable()
    {
        $data = DB::table('pages')->select('pages.*');
        return datatables()->of($data)
            ->addColumn('action', function ($data) {
                return view('page.action', ['id' => base64_encode($data->id), 'slug' =>$data->slug]);
            })
            ->editColumn('created_at', function ($data) {
                return Carbon::parse($data->created_at)->format('d F Y H:i:A');
            })
            
            ->make(true);
        //->toJson();
    }
    
    
     public function create(Request $request)
    {
       $sliders=SimpleSliders::where(['status'=>0])->get();
        $title='CMS Page Create';
        if ($request->input()) {
            $this->validate($request, [
                'page_title' => 'required',
                'page_content' => 'required',
                'status' => 'required',
            ]);

            $data = new Pages;
            $data->page_title           = $request->input('page_title');
            $slug = Str::replace(' ', '-', $request->input('page_title'));
            $slug = Str::lower($slug);
            $same_slug_count = Pages::where('slug', 'LIKE', $slug . '%')->count();
            $slug_suffix = $same_slug_count ? '-' . $same_slug_count + 1 : '';
            $slug .= $slug_suffix;
            $data->slug                 =  $slug;
            $data->page_content         = $request->input('page_content');
            $data->slider_id         = $request->input('slider_id');
            $data->status               = $request->input('status');
            $data->show_home_page       = $request->input('show_home_page');
            $data->banner               = $request->input('banner');
            
            try {
                $reply = $data->save();
               
            } catch (\Illuminate\Database\QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $reply = $errorCode;
            }
            //  print_r($e->errorInfo);        exit;
            if ($reply == 1) {
                return redirect('cms-list')->with('success', config('app.saveMsg'));
            } else {
                return redirect()->back()->with('error', $e->errorInfo[2]);
            }
        }
        return view('page.create', compact('title', 'sliders'));
    }
    
    public function edit(Request $request, $id){
        $title="CMS Page Edit";
        $id=base64_decode($id);
        $contents=Pages::find($id);
        $sliders=SimpleSliders::where(['status'=>0])->get();
        if($request->input()){
            $this->validate($request, [
            'page_title'=>'required',
            'page_content'=>'required',
            ]);
            $contents=Pages::where('id', '=', $id)->first();
            $slug = Str::replace(' ', '-', $request->input('page_title'));
            $slug = Str::lower($slug);
            $same_slug_count = Pages::where('slug', 'LIKE', $slug . '%')->whereNot('id', $id)->count();
            $slug_suffix = $same_slug_count ? '-' . $same_slug_count + 1 : '';
            $slug .= $slug_suffix;
                if(!empty($request->input('banner'))){
                  $media  =$request->input('banner'); 
               } else {
                   $media  =$contents->banner;
               }
            
            
            $data = array(
                'page_title'        => $request->input('page_title'),
                'slug'              =>$slug,
                'show_home_page'    => $request->input('show_home_page'),
                'slider_id'         => $request->input('slider_id'),
                'banner'            => $media,
                'page_content'     => $request->input('page_content'),
                'status'     => $request->input('status')
            );
            
             try {
                 $reply=Pages::where('id', $id)->update($data);
                 $item = Menuitems::where('slug', $contents->slug);
                $item->update(['slug'=>$slug]);
                 
            } catch(\Illuminate\Database\QueryException $e){
                    $errorCode = $e->errorInfo[1];          
                //if($errorCode == 1062){
                    $reply=$errorCode;
                //}
            }
           if($reply==1){
             return redirect('cms-list')->with('success',config('app.updateMsg'));
            } elseif($reply==1062) {
                return redirect()->back()->with('error',config('app.duplicateErrMsg'));;
            } else {
                return redirect()->back()->with('error', $e->errorInfo[2]);
            }
        } else{
            echo "dsfdsf";
           $request->page_content;
        }
        

       return view('page.edit', ['contents'=>$contents, 'title'=>$title, 'sliders'=>$sliders]) ;
    }
    
    public function destroy($id)
    {
        $id = base64_decode($id);
        $contents=Pages::find($id);
        try {
            $baseurl= url('/');
            $path=$contents->banner;
           // unlink($path);
            $reply = Pages::where('id', $id)->delete();
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
