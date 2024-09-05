<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Product\Products;

class WishlistController extends Controller
{
     public function wishlist(Request $request){
        $title="MY WISHLIST";
        $wishlist = session()->get('wishlist');
        return view('frontend.wishlist', compact('title', 'wishlist'));
    }
    
    public function addToWishlist($id) {
        $product = Products::findOrFail(base64_decode($id));
        $wishlist = session()->get('wishlist', []);
        if(isset($wishlist[$id])) {
            $wishlist[$id]['quantity']++;
        } else {
            $wishlist[$id] = [
                "name" => $product->title,
                "slug"  =>  $product->slug,
                "quantity" => 1,
                "price" => $product->price,
                "image" => getProductThumImage($product->multipalimages),
            ];
            updateProductView($product->id);
        }
        session()->put('wishlist', $wishlist);
        toastr()->success('Product added to wishlist successfully!', 'Congrats', ['positionClass' => "toast-top-full-width"]);
        return redirect()->back();
    }
    
    
        /**
     * Write code on Method
     *
     * @return response()
     */
    public function remove(Request $request) {
        if($request->id) {
            $wishlist = session()->get('wishlist');
            if(isset($wishlist[$request->id])) {
                unset($wishlist[$request->id]);
                session()->put('wishlist', $wishlist);
            }
             toastr()->success('Product removed successfully in WISHLIST!', 'Congrats', ['positionClass' => "toast-top-full-width"]);
            return redirect()->back();
        }
    }
    
    
}
