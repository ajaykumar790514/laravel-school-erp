<?php

namespace App\Repositories;

use App\Interfaces\ProductAttributesInterface;
use App\Models\Product\ProductAttributes;
use App\Models\Product\ProductAttributesValues;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProductAttributesRepository implements ProductAttributesInterface 
{
   public function getDataTable(){
       
        $data = ProductAttributes::select('product_attributes.*');
        return datatables()->of($data)
            ->addColumn('action', function ($data) {
                return view('backend.productattributes.action', ['id' => base64_encode($data->id)]);
            })
            ->editColumn('created_at', function ($data) {
                return Carbon::parse($data->created_at)->format('d F Y H:i:A');
            })
            ->editColumn('action1', function ($data) {
                $attributesVal=ProductAttributesValues::where(['product_attributes_id'=>$data->id])->get();
                $terms='';
                foreach($attributesVal as $term){
                     $terms.=$term->terms.", ";
                }
                return $terms;
                
            })
            ->make(true);
    }

    public function getAll() 
    {
         
    }
    
    public function getById($id) 
    {
         return ProductAttributes::where('id', $id)->with('multipalTerms')->first();
    }

    public function deleteById($id) 
    {
        try {
             $reply = ProductAttributesValues::where('product_attributes_id', $id)->delete();
            $reply = ProductAttributes::where('id', $id)->delete();
           
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

    public function create(array $data) {
            $datasave = new ProductAttributes;
            $datasave->title                = $data['title'];
            $datasave->show_on_filter       = $data['show_on_filter'];
            $datasave->status               = $data['status'];
            $datasave->created_by           = Auth::id();
            try {
                $reply = $datasave->save();
                $insertID=$datasave->id;
                foreach($data['terms'] as $terms){
                    $datasave1 = new ProductAttributesValues;
                    $datasave1->product_attributes_id   = $insertID;
                    $datasave1->terms                   = $terms;
                    $reply = $datasave1->save();
                }
                
                
            } catch (\Illuminate\Database\QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $reply = $errorCode;
            }
            if ($reply == 1) {
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

    public function update($id, array $request) 
    {
        $dataarray = array(
            'title'       => $request['title'],
            'show_on_filter'       => $request['show_on_filter'],
            'status'            => $request['status'],
            'created_by'=>Auth::id()
            );
            
            try {
                $reply = ProductAttributes::where('id', $id)->update($dataarray);
                 foreach($request['terms'] as $terms){
                     $checkAlreadyExist=ProductAttributesValues::where(['product_attributes_id'=>$id, 'terms'=>$terms])->first();
                    if(empty($checkAlreadyExist)){ 
                        if(!empty($terms)){
                            $datasave1 = new ProductAttributesValues;
                            $datasave1->product_attributes_id   = $id;
                            $datasave1->terms                   = $terms;
                            $reply = $datasave1->save();
                        }
                    }
                }
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