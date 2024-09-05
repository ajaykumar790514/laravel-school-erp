<?php
namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Product\Products;
use App\Models\Coupons;
use Illuminate\Support\Facades\Auth;

class CartsController extends Controller{
    
    public function cart(Request $request){
        $title="Cart";
        $newArrivalProducts=Products::where(['status'=>'publish', 'newest_product'=>0])
                    ->whereNotNull('image')->orderBy('id', 'desc')
                    ->with('category')->take(10)->get();
        return view('frontend.cart', compact('title', 'newArrivalProducts'));
    }
    
    public function checkout(Request $request){
        $title="checkout";
        return view('frontend.checkout', compact('title'));
    }
    
     public function order_confirmation(Request $request, $id){
        $title="Order Confirmation";
        return view('frontend.order_confirmation', compact('title', 'id'));
    }
    
    
    public function update_cart(Request $request){
        $title="Update Cart";
        
    }
    
    
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function addToCart($ids) {
        $id=base64_decode($ids);
        $salePrice=0;
        $product = Products::where(['id'=>$id])->with('multipalimages')->first();;
        if(!empty($product)){
           $cart = session()->get('cart', []);
                if(isset($cart[$id])) {
                    $cart[$id]['quantity']++;
                    $cart[$id]['totalItemPrice']=$cart[$id]['quantity']*$cart[$id]['price'];
                    //echo $cart[$id]['quantity']; exit;
                } else {
                    if($product->discount>0){
                        $salePrice=$product->sale_price;
                        $totalPrice=$product->sale_price;
                    } else{
                         $totalPrice=$product->price;
                    }
                    
                    $cart[$id] = [
                        "name" => $product->title,
                        "slug"  =>  $product->slug,
                        "quantity" => 1,
                        "price" =>$product->price,
                        "sale_price" =>$salePrice,
                        "totalItemPrice"=>$totalPrice,
                        "disccount"=>0,
                        "coupon"=>'',
                        "image" => getProductThumImage($product->multipalimages),
                    ];
                     updateProductView($product->id);
                }
                session()->put('cart', $cart, 500);
                toastr()->success('Product added to cart successfully!', 'Congrats', ['positionClass' => "toast-top-full-width"]);
                return redirect()->back(); 
        }
        
    }
    
    
    public function updateToCart(Request $request) {
        $cart = session()->get('cart');
        foreach ($request->quantity as $item_id => $quantity) {
            foreach ($cart as $id => $details) {
                if($id==$item_id) {
                    
                    if($cart[$id]['sale_price']>0){
                            $price=$cart[$id]['sale_price'];
                    } else{
                             $price=$cart[$id]['price'];
                    }
                    $cart[$id]['quantity'] = $quantity;
                    $cart[$id]['totalItemPrice']=$quantity*$price;
                    break;
                }
            }
        }
        session()->put('cart', $cart);
        toastr()->success('Product quantity update successfully!', 'Congrats', ['positionClass' => "toast-top-full-width"]);
        return redirect()->back(); 
    }
    
    public function updateSingleToCart(Request $request) {
        $cart = session()->get('cart');
        foreach ($cart as $id => $details) {
            if ($request->productId==$id) {
                if($cart[$id]['sale_price']>0){
                        $PRICE=$cart[$id]['sale_price'];
                } else{
                         $PRICE=$cart[$id]['price'];
                }
                $cart[$id]['quantity'] = $request->qty;
                $cart[$id]['totalItemPrice']=$request->qty*$PRICE;
                break;
            }
        }
        session()->put('cart', $cart);
        //toastr()->success('Product quantity update successfully!', 'Congrats', ['positionClass' => "toast-top-full-width"]);
        //return redirect()->back(); 
    }
    
    public function apply_coupon(Request $request) {
        $cart = session()->get('cart');
        if(!empty($request->coupon_code)){
            $couponDetails=Coupons::getCouponDetails($request->coupon_code);
            if(!empty($couponDetails)){
                   $productDetails=json_decode($couponDetails->product_ids);
                   foreach($productDetails as $item_id => $productId) {
                       $productAmount=Products::getProductAmount($productId);
                       $discount=Coupons::getDiscountAmt($couponDetails->discount_type, $couponDetails->discount, $productAmount);
                        foreach ($cart as $id => $details) {
                            if($id==$productId) {
                                $cart[$id]['disccount'] = $discount;
                                $cart[$id]['coupon']=$request->coupon_code;
                                break;
                            }
                        }
                    }
                    session()->put('cart', $cart);
                    toastr()->success('Coupon has been applied successfully!', 'Congrats', ['positionClass' => "toast-top-full-width"]);
                     
            }
        }
        return redirect()->back();
    }
    
    
        /**
     * Write code on Method
     *
     * @return response()
     */
    public function remove(Request $request)
    {
        if(!empty($request->id)) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            toastr()->success('Product removed successfully!', 'Congrats', ['positionClass' => "toast-top-full-width"]);
            return redirect()->back(); 
        }
    }
    
    
    public function clearcart(Request $request) {
            session()->forget('cart');
            toastr()->success('Cart clear successfully!', 'Congrats', ['positionClass' => "toast-top-full-width"]);
            return redirect('/index'); 
    }
    
    
}
