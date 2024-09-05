<?php

namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product\Products;
use App\Models\ProductsImages;
use App\Models\ProductTags;
use App\Models\ProductsSeos;
use App\Models\Product\ProductAttributes;
use App\Models\Product\ProductAttributesValues;
use App\Models\Product\ProductVariations;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductRepository implements ProductRepositoryInterface 
{
  

   
    public function create($request) {
            $productGroupID=random_int(100000, 999999);
            $data = new Products;
            $data->product_group                =  $productGroupID;
            $data->product_type                 =  $request['productType'];
            $data->product_categories_id        =  $request['category_ids'];
            $data->title                        = $request['title'];
            $data->short_description            = $request['short_description'];
            $data->long_description             = $request['long_description'];
            $data->newest_product               = isset($request['newest_product']);
            $data->feacture_product             = isset($request['feacture_product']);
            $data->best_seller                  = isset($request['best_seller']);
            $data->lable_hot                    = isset($request['lable_hot']);
            $data->lable_new                    = isset($request['lable_new']);
            $data->lable_sale                   = isset($request['lable_sale']);
            $data->weight                       = $request['weight'];
            $data->length                       = $request['length'];
            $data->breadth                      = $request['breadth'];
            $data->height                       = $request['height'];
            $data->product_video                = $request['video_content'];
            $data->status                       = $request['status'];
            $data->created_at                   = Carbon::now()->timestamp;
            $data->created_by                   = Auth::id();;
            $slug =$request['slug'];
            $same_slug_count = Products::where('slug', 'LIKE', $slug . '%')->count();
            $slug_suffix = $same_slug_count ? '-' . $same_slug_count + 1 : '';
            $slug .= $slug_suffix;
            $data->slug =  $slug;
            
            if(empty($request['sku'])){
                $sku =  "sku-".random_int(1000, 9999);
                $same_sku_count = Products::where('sku', 'LIKE', $sku . '%')->count();
                $sku_suffix = $same_sku_count ? '-' . $same_sku_count + 1 : '';
                $sku .= $sku_suffix;
                $data->sku =  $sku;
            } else{
                $sku =  $request['sku'];
                $same_sku_count = Products::where('sku', 'LIKE', $sku . '%')->count();
                $sku_suffix = $same_sku_count ? '-' . $same_sku_count + 1 : '';
                $sku .= $sku_suffix;
                $data->sku =  $sku;
            }
                if (is_int($request['quantity']) && is_int($request['price'])) {
                    $data->quantity =  $request['quantity'];
                    $data->price =  $request['price'];
                    if(!empty($request['discount'])){
                        if(is_int($request['discount'])){
                            $data->discount     = $request['discount'];
                            if($request['discount_type']==0){
                                $specialPrice=($request['price'])-($request['discount']);
                                $data->discount_type        = $request->input('discount_type');
                            } else{
                                 $specialPrice=$request['price']-(($request['price']*$request['discount'])/100);
                                 $data->discount_type        = $request['discount_type'];
                            }
                            $data->sale_price            = $specialPrice;
                        } else{
                            $data->sale_price   = 0;
                            $data->discount     = 0;
                        }
                        
                    }
                } else{
                    $data->quantity =  0;
                    $data->price =  0;
                }
            try {
                $reply = $data->save();
                $insertID=$data->id;
            } catch (\Illuminate\Database\QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $reply = $errorCode;
            }
            
            if ($reply == 1) {
                return [
                        'status'=>200,
                        'insertId'=>$insertID,
                        'message'=>config('app.saveMsg')
                        ];
                            
            } else {
                return [
                        'status'=>500,
                        'insertId'=>'',
                        'message'=>$e->errorInfo[2]
                        ];
            }
                        
           
            
    }
    
    public function variantProductCreate($request) {
         $productGroupID=random_int(100000, 999900);
         foreach($request['attribute'] as $key=>$attributes){
            $attribute=$attributes;
            $attributeName=ProductAttributes::getAttributeName($attribute);
            $attributeValue=$request['attributeVal'][$key];
            $attributeValueName=ProductAttributesValues::getAttributeName($attributeValue);
                            
            $data2 = new ProductVariations;
            $data2->product_attribute_id=$attribute;
            $data2->product_attribute_value_id=$attributeValue;
            $reply = $data2->save();
            $productVarationID=$data2->id;
            
            $data = new Products;
            $data->product_group                =  $productGroupID;
            $data->product_variation_id         =  $productVarationID;
            $data->product_type                 =  $request['productType'];
            $data->product_categories_id        =  $request['category_ids'];
            $data->title                        = $request['title']." ".$attributeName." ".$attributeValueName;
            $data->short_description            = $request['short_description'];
            $data->long_description             = $request['long_description'];
            $data->newest_product               = isset($request['feacture_product']);
            $data->feacture_product             = isset($request['feacture_product']);
            $data->best_seller                  = isset($request['feacture_product']);
            $data->lable_hot                    = isset($request['feacture_product']);
            $data->lable_new                    = isset($request['feacture_product']);
            $data->lable_sale                   = isset($request['feacture_product']);
            $data->weight                       = $request['weight'];
            $data->length                       = $request['length'];
            $data->breadth                      = $request['breadth'];
            $data->height                       = $request['height'];
            $data->product_video                = $request['video_content'];
            $data->status                       = $request['status'];
            $data->created_at                   = Carbon::now()->timestamp;
            $data->created_by                   = Auth::id();;
                                    
            $slug =$request['slug']."-".$attributeName."-".$attributeValueName; 
            $slugs = Str::of($slug)->slug('-'); 
            $data->slug =  $slugs;
            $variation_sku=$request['variation_sku'][$key];
            if(empty($variation_sku)){
                $sku =  "sku-".random_int(1000, 9999);
                $same_sku_count = Products::where('sku', 'LIKE', $sku . '%')->count();
                $sku_suffix = $same_sku_count ? '-' . $same_sku_count + 1 : '';
                $sku .= $sku_suffix;
                $data->sku =  $sku;
            } else{
                $sku =  $variation_sku;
                $same_sku_count = Products::where('sku', 'LIKE', $sku . '%')->count();
                $sku_suffix = $same_sku_count ? '-' . $same_sku_count + 1 : '';
                $sku .= $sku_suffix;
                $data->sku =  $sku;
            }
            $data->quantity =  $request['variation_quantity'][$key];
            $data->price =  $request['variation_price'][$key];
            if(!empty($request['variation_discount'][$key])){
                $data->discount     = $request['variation_discount'][$key];
                
                if($request['variation_discount_type'][$key]==0){
                    $specialPrice=($request['variation_price'][$key])-($request['variation_discount'][$key]);
                    $data->discount_type        = $request['discount_type'];
                } else{
                     $specialPrice=$request['variation_price'][$key]-(($request['variation_price'][$key]*$request['variation_discount'][$key])/100);
                     $data->discount_type        = $request['discount_type'];
                }
                $data->sale_price            = $specialPrice;
                
            }
            
            try {
                $reply = $data->save();
                $insertID=$data->id;
                $this->uploadThumbnail(['ProductID'=>$insertID, "image"=>$request['productimages']]);
                if(!empty($request['productmultipal'])){
                    $reply=$this->uploadImages(['ProductID'=>$insertID, "image"=>$request['productmultipal']]);
                }
                
                //Tags
                if(!empty($request['tags'])){
                     $tags = $request['tags'] ? explode(',', $request['tags']) : [];
                     if ($tags) {
                         $reply=$this->tags(['ProductID'=>$insertID, "tags"=>$tags]);
                    }
                }
                //Seo Details 
                $reply=$this->productseo(['ProductID'=>$insertID, 
                            "meta_title"=>$request['meta_title'], "meta_description"=>$request['meta_description']]);

            } catch (\Illuminate\Database\QueryException $e) {
                return [
                        'status'=>500,
                        'insertId'=>'',
                        'message'=>$e->errorInfo[2]
                        ];
            }
        }
    }
    
     public function update($ids, array $request) {
        $data = Products::where('id', $ids)->with('tags', 'inventory', 'multipalimages', 'seo')->first();
        $slug =$request['slug'];
        $same_slug_count = Products::where('slug', 'LIKE', $slug . '%')->where('id', '!=' , $ids)->count();
        $slug_suffix = $same_slug_count ? '-' . $same_slug_count + 1 : '';
        $slug .= $slug_suffix;
                
        $sku =$request['sku'];
        $same_sku_count = Products::where('sku', 'LIKE', $sku . '%')->where('id', '!=' , $ids)->count();
        $sku_suffix = $same_sku_count ? '-' . $same_sku_count + 1 : '';
        $sku .= $sku_suffix;

        if(!empty($request['discount'])){
            $discount = $request['discount'];
            if($request['discount_type']==0){
                $specialPrice=($request['price'])-($request['discount']);
            } else{
                 $specialPrice=$request['price']-(($request['price']*$request['discount'])/100);
            }
        } else{
            $specialPrice=0;
            $discount=0;
        }
              
        /*if(!empty($request['start_date'])){
            $startDate=date('Y-m-d', strtotime($request['start_date']));
        } else{
             $startDate='';
        }
                
        if(!empty($request['end_date'])){
            $endDate=date('Y-m-d', strtotime($request['end_date']));
        } else{
             $endDate='';
        }*/
                
        $dataarray = array(
            'product_categories_id' => $request['category_id'],
            'title'                 => $request['title'],
            'short_description' => $request['short_description'],
            'slug'              => $slug,
            'long_description'  => $request['long_description'],
            'best_seller'       => isset($request['best_seller'])?$request['best_seller']:1,
            'feacture_product'  => isset($request['feacture_product'])?$request['feacture_product']:1,
            'newest_product'    => isset($request['newest_product'])?$request['newest_product']:1,
            'product_video'     => $request['video_content'],
            'lable_hot'         => isset($request['lable_hot'])?$request['lable_hot']:1,
            'lable_new'         => isset($request['lable_new'])?$request['lable_new']:1,
            'lable_sale'        => isset($request['lable_sale'])?$request['lable_sale']:1,
            'sku'               => $sku,
            'quantity'          => $request['quantity'],
            'price'             => $request['price'],
            'sale_price'        => $specialPrice,
            'discount'          => $discount,
            'discount_type'     => $request['discount_type'],
            'status'            => $request['status'],
            'weight'            => $request['weight'],
            'length'            => $request['length'],
            'breadth'            => $request['breadth'],
            'height'            => $request['height'],
        );
        
        
        try {
            $saveData = Products::where('id', $ids)->update($dataarray);
            return [
                    'status'=>200,
                    'insertId'=>$ids,
                    'message'=>config('app.updateMsg')
                ];
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $saveData = $errorCode;
             return [
                'status'=>500,
                'insertId'=>'',
                'message'=>$e->errorInfo[2]
                ];
        }
        exit;
         
         
         
         
         
         
         
         
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
              $home_page_show= $request['home_page_show']==""?1:$request['home_page_show'];
            } else{
                $home_page_show   = $data->home_page_show;
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
    
    public function uploadThumbnail($request) {
            $data = new ProductsImages;
            $data->image_type       = 0;
            $data->product_id       =  $request['ProductID'];
            $data->images           =  $request['image'];
            try {
                $reply = $data->save();
                $insertID=$data->id;
            } catch (\Illuminate\Database\QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $reply = $errorCode;
            }
            
            if ($reply == 1) {
                return [
                        'status'=>200,
                        'message'=>config('app.saveMsg')
                        ];
                            
            } else {
                return [
                        'status'=>500,
                        'message'=>$e->errorInfo[2]
                        ];
            }
                        
           
            
    }
    
    public function uploadImages($request) {
        foreach($request['image'] as $multiImg){
            $multipalImg = new ProductsImages;
            $multipalImg->image_type    =  1;
            $multipalImg->product_id    = $request['ProductID'];
            $multipalImg->images       = $multiImg;
            $reply = $multipalImg->save();
        }
    }
    
    public function tags($request) {
        foreach ($request['tags'] as $tag) {
                $product_tag = ProductTags::create([
                    'product_id' =>$request['ProductID'],
                    'tags' =>$tag
                ]);
        }
    }
    
    public function productseo($request) {
            ProductsSeos::create([
                                'product_id' =>$request['ProductID'],
                                'meta_title' =>$request['meta_title'],
                                'meta_description' =>$request['meta_description']
                            ]);
    }
   
   
}