<?php

namespace App\Http\Controllers\backend;
use App\Models\MediaCategories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Url;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as Image;
use Carbon\Carbon;

class MediaCategoriesController extends Controller
{
    function __construct(){
         $this->middleware('permission:media-category-list', ['only' => ['index']]);
         $this->middleware('permission:media-category-create', ['only' => ['create']]);
         $this->middleware('permission:media-category-edit', ['only' => ['edit']]);
         $this->middleware('permission:media-category-delete', ['only' => ['destroy']]);
    }
    

    public function index(Request $request)
    {
      $title='Media Category List';
       return view('backend.mediacategories.index', compact('title'));
    }

    public function datatable()
    {
        $data = DB::table('media_categories')->select('media_categories.*');
        return datatables()->of($data)
            ->addColumn('action', function ($data) {
                return view('backend.mediacategories.action', ['id' => base64_encode($data->id)]);
            })
            ->editColumn('created_at', function ($data) {
                return Carbon::parse($data->created_at)->format('d F Y H:i:A');
            })
            ->editColumn('parent_id', function ($data) {
                return MediaCategories::getParentName($data->parent_id);
                //return $data->id;
            })
            ->make(true);
        //->toJson();
    }


    public function create(Request $request)
    {
        $title="Media Category Create";
        $categories = MediaCategories::where(['parent_id' => 0])
            ->with('children')
            ->get();
        if ($request->input()) {
            $this->validate($request, [
                'title' => 'required|unique:media_categories',
                'status' => 'required',
            ]);

            $data = new MediaCategories;
            $slug =$request->input('title');
            $same_slug_count = MediaCategories::where('slug', 'LIKE', $slug . '%')->count();
            $slug_suffix = $same_slug_count ? '-' . $same_slug_count + 1 : '';
            $slug .= $slug_suffix;
            
            $data->title             = $request->input('title');
            $data->slug             = $slug;
            $data->parent_id        = $request->input('parent_id')==""?"0":$request->input('parent_id');
            $data->short_description     = $request->input('short_description');
            $data->status          = $request->input('status');
            $data->image          = $request->input('image')==""?"":$request->input('image');
            $data->meta_title       = $request->input('meta_title');
            $data->meta_description = $request->input('meta_description');
           
            try {
                $reply = $data->save();
            } catch (\Illuminate\Database\QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $reply = $errorCode;
            }
            if ($reply == 1) {
                return redirect('media-category-list')->with('success', config('app.saveMsg'));
            } elseif ($reply == 1062) {
                return redirect()->back()->with('error', config('app.duplicateErrMsg'));;
            } else {
                return redirect()->back()->with('error', $e->errorInfo[2]);
            }
        }
        return view('backend.mediacategories.create', compact('title', 'categories'));
    }


    public function edit(Request $request, $id)
    {
        $title='Edit Media Category';
        $ids=$id;
        $id = base64_decode($id);
        $data = MediaCategories::find($id);
        $categories = MediaCategories::where(['parent_id' => 0])->where('id', '!=' , $id)
            ->with('children')
            ->get();
        
        if ($request->input()) {
            $this->validate($request, [
                'title' => 'required',
                'status' => 'required',
            ]);
            $data = MediaCategories::where('id', '=', $id)->first();
            $slug =$request->input('title');
            $same_slug_count = MediaCategories::where('slug', 'LIKE', $slug . '%')->where('id', '!=' , $ids)->count();
            $slug_suffix = $same_slug_count ? '-' . $same_slug_count + 1 : '';
            $slug .= $slug_suffix;
            
            if(!empty($request->input('image'))){
                $galeryImg=$request->input('image');
            } else{
                $galeryImg=$data->image;
            }

            $dataarray = array(
                'parent_id'  => $request->input('parent_id')==""?"0":$request->input('parent_id'),
                'title'       => $request->input('title'),
                'slug'       => $slug,
                'short_description'       => $request->input('short_description'),
                'status'            => $request->input('status'),
                'meta_title'    => $request->input('meta_title'),
                'meta_title'    => $request->input('meta_title'),
                'image'     => $galeryImg,
               
            );
            try {
                $reply = MediaCategories::where('id', $id)->update($dataarray);
            } catch (\Illuminate\Database\QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $reply = $errorCode;
            }
            if ($reply == 1) {
                return redirect('media-category-list')->with('success', config('app.updateMsg'));
            } elseif ($reply == 1062) {
                return redirect()->back()->with('error', config('app.duplicateErrMsg'));;
            } else {
                return redirect()->back()->with('error', $e->errorInfo[2]);
            }
        }
        return view('backend.mediacategories.edit', compact('data', 'categories', 'ids', 'title'));
    }

    public function destroy($id)
    {
        $id = base64_decode($id);
        try {
            $reply = MediaCategories::where('id', $id)->delete();
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
