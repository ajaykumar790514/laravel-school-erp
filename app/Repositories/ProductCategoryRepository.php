<?php

namespace App\Repositories;

use App\Interfaces\ProductCategoryRepositoryInterface;
use App\Models\ProductCategories;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProductCategoryRepository implements ProductCategoryRepositoryInterface 
{
   public function getDataTable(){
        $data = DB::table('product_categories')->select('product_categories.*');
        return datatables()->of($data)
            ->addColumn('action', function ($data) {
                return view('backend.productcategories.action', ['id' => base64_encode($data->id)]);
            })
            ->editColumn('created_at', function ($data) {
                return Carbon::parse($data->created_at)->format('d F Y H:i:A');
            })
            ->editColumn('parent_id', function ($data) {
                return ProductCategories::getParentName($data->parent_id);
                //return $data->id;
            })
            ->make(true);
    }

    public function getAll()  {
         $categories = ProductCategories::where(['parent_id' => 0])
            ->with('children')
            ->get();
        return  $categories;
    }
    
    public function getById($id) 
    {
        return ProductCategories::findOrFail($id);
    }

    public function deleteById($id) 
    {
        try {
            $reply = ProductCategories::where('id', $id)->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $reply = $errorCode;
        }
        if ($reply == 1) {
            toastr()->success(config('app.deleteMsg'), 'Congrats');
            return redirect()->back();
        } else if ($reply == 1451) {
            toastr()->error($e->errorInfo[2], 'Oops');
            return redirect()->back();
        } else {
            toastr()->error($e->errorInfo[2], 'Oops');
            return redirect()->back();
        }
    }

    public function create($request) {
            $data = new ProductCategories;
            $slug =$request['slug'];
            $same_slug_count = ProductCategories::where('slug', 'LIKE', $slug . '%')->count();
            $slug_suffix = $same_slug_count ? '-' . $same_slug_count + 1 : '';
            $slug .= $slug_suffix;
            
            $data->title            = $request['title'];
            $data->slug             = $slug;
            $data->parent_id        = $request['parent_id']==""?"0":$request['parent_id'];
            $data->description      = $request['description'];
            $data->status           = $request['status'];
            if(isset($request['images'])){
               $data->images=$request['images']==""?"":$request['images'];
           } else{
               $data->images='';
           }
           if(isset($request['home_page_show'])){
              $data->home_page_show= $request['home_page_show']==""?1:$request['home_page_show'];
           } else{
                $data->home_page_show   = 1;
           }
           
            $data->meta_title       = $request['meta_title'];
            $data->meta_description = $request['meta_description'];
            $data->created_by = Auth::id();
            try {
                $reply = $data->save();
            } catch (\Illuminate\Database\QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $reply = $errorCode;
            }
            if ($reply == 1) {
                toastr()->success(config('app.saveMsg'), 'Congrats');
                return redirect('product-category-list');
            } elseif ($reply == 1062) {
                toastr()->error(config('app.duplicateErrMsg'), 'Oops');
                return redirect()->back();
            } else {
                toastr()->error(config($e->errorInfo[2]), 'Oops');
                return redirect()->back();
            }
    }

    public function update($id, array $request) {
            $data = ProductCategories::where('id', '=', $id)->first();
            $slug =$request['slug'];
            $same_slug_count = ProductCategories::where('slug', 'LIKE', $slug . '%')->where('id', '!=' , $id)->count();
            $slug_suffix = $same_slug_count ? '-' . $same_slug_count + 1 : '';
            $slug .= $slug_suffix;
            if(isset($request['images'])){
                if(!empty($request['images'])){
                    $galeryImg=$request['images'];
                } else{
                    $galeryImg=$data->images;
                }
            } else {
                $galeryImg=$data->images;
            }
            if(isset($request['home_page_show'])){
              $home_page_show= $request['home_page_show'];
            } else{
                $home_page_show   = 1;
            }

            $dataarray = array(
                'parent_id'  =>$request['parent_id']==""?"0":$request['parent_id'],
                'title'       => $request['title'],
                'slug'       => $slug,
                'description'       => $request['description'],
                'status'            => $request['status'],
                'home_page_show'    => $home_page_show,
                'meta_title'    => $request['meta_title'],
                'meta_title'    =>$request['meta_title'],
                'images'     => $galeryImg,
                'created_by'=>Auth::id()
               
            );
            try {
                $reply = ProductCategories::where('id', $id)->update($dataarray);
            } catch (\Illuminate\Database\QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $reply = $errorCode;
            }
            if ($reply == 1) {
                 toastr()->success(config('app.updateMsg'), 'Congrats');
                return redirect('/product-category-list');
            } elseif ($reply == 1062) {
                toastr()->error(config('app.duplicateErrMsg'), 'Oops');
                return redirect()->back();
            } else {
                toastr()->error(config($e->errorInfo[2]), 'Oops');
                return redirect()->back();
            }
    }

   
   
}