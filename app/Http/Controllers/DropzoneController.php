<?php
   
namespace App\Http\Controllers;
   
use App\Http\Requests;
use Illuminate\Http\Request;
   
class DropzoneController extends Controller
{
   
    public function dropzone()
    {
         echo 'testing'; exit;
    }
    
    
    
    public function uploadDocuments(Request $request){
        $image = $request->file('documents');
        $fileExtension='.'.$image->getClientOriginalExtension();
        $imageName = 'uploads/studentdocuments/'.date('dmYHis').$fileExtension;
        $image->move(public_path('uploads/studentdocuments'),$imageName);
        return $imageName;
    }
    
     public function gallerymultipal(Request $request)
    {
        
        $files = $request->file('media');
        foreach ($files as $file) {
                    $fileExtension='.'.$file->getClientOriginalExtension();
                    $imageName = 'uploads/gallery/'.date('dmYHis').$fileExtension;
                    $file->move(public_path('uploads/gallery'),$imageName);
                    return $imageName;
        }
    }
    
     public function productgallerymultipal(Request $request)
    {
        // $image = $request->file('productmultipal');
        // $fileExtension='.'.$image->getClientOriginalExtension();
        // $imageName = 'uploads/product/'.date('dmYHis').$fileExtension;
        // $image->move(public_path('uploads/product'),$imageName);
        // return $imageName;
        $files = $request->file('productmultipal');
        foreach ($files as $file) {
                    $fileExtension='.'.$file->getClientOriginalExtension();
                    $imageName = 'uploads/product/'.date('dmYHis').$fileExtension;
                    $file->move(public_path('uploads/product'),$imageName);
                    return $imageName;
                    
                    //return $url;
        }
    }
    
    public function productimg(Request $request){
        $image = $request->file('icon_image');
        $fileExtension='.'.$image->getClientOriginalExtension();
        $imageName = 'uploads/healthservices/icon/'.date('dmYHis').$fileExtension;
        $image->move(public_path('uploads/healthservices/icon'),$imageName);
        return $imageName;
    }
    
     public function categoryimg(Request $request){
        $image = $request->file('images');
        $fileExtension='.'.$image->getClientOriginalExtension();
        $imageName = 'uploads/category/'.date('dmYHis').$fileExtension;
        $image->move(public_path('uploads/category'),$imageName);
        return $imageName;
    }
    
     public function mediacategory(Request $request)
    {
        $image = $request->file('image');
        $fileExtension='.'.$image->getClientOriginalExtension();
        $imageName = 'uploads/mediacategory/'.date('dmYHis').$fileExtension;
        $image->move(public_path('uploads/mediacategory'),$imageName);
        // return response()->json(['success'=>$imageName]);
        return $imageName;
    }
    
    
     public function blogBanner(Request $request){
        $image = $request->file('banner');
        $fileExtension='.'.$image->getClientOriginalExtension();
        $imageName = 'uploads/blog/'.date('dmYHis').$fileExtension;
        $image->move(public_path('uploads/blog'),$imageName);
        return $imageName;
    }
    
     public function testimonalAvtar(Request $request){
        $image = $request->file('images');
        $fileExtension='.'.$image->getClientOriginalExtension();
        $imageName = 'uploads/testimonal/'.date('dmYHis').$fileExtension;
        $image->move(public_path('uploads/testimonal'),$imageName);
        return $imageName;
    }
    
     public function cmsBanner(Request $request){
        $image = $request->file('banner');
        $fileExtension='.'.$image->getClientOriginalExtension();
        $imageName = 'uploads/cms/'.date('dmYHis').$fileExtension;
        $image->move(public_path('uploads/cms'),$imageName);
        return $imageName;
    }
    
    public function sliderImage(Request $request){
        $image = $request->file('image');
        $fileExtension='.'.$image->getClientOriginalExtension();
        $imageName = 'uploads/slider/'.date('dmYHis').$fileExtension;
        $image->move(public_path('uploads/slider'),$imageName);
        return $imageName;
    }
    
     public function logo(Request $request){
        $image = $request->file('logo');
        $fileExtension='.'.$image->getClientOriginalExtension();
        $imageName = 'uploads/'.date('dmYHis').$fileExtension;
        $image->move(public_path('uploads'),$imageName);
        return $imageName;
    }
    
    public function feviconImage(Request $request){
        $image = $request->file('favicon');
        $fileExtension='.'.$image->getClientOriginalExtension();
        $imageName = 'uploads/'.date('dmYHis').$fileExtension;
        $image->move(public_path('uploads'),$imageName);
        return $imageName;
    }
    
    public function dailydiary(Request $request){
        $image = $request->file('attachment');
        $fileExtension='.'.$image->getClientOriginalExtension();
        $imageName = 'uploads/dailydiary/'.date('dmYHis').$fileExtension;
        $image->move(public_path('uploads/dailydiary'),$imageName);
        return $imageName;
    }
    
    
     public function homework(Request $request){
        $image = $request->file('attachment');
        $fileExtension='.'.$image->getClientOriginalExtension();
        $imageName = 'uploads/assignments/'.date('dmYHis').$fileExtension;
        $image->move(public_path('uploads/assignments'),$imageName);
        return $imageName;
    }
    
    public function notice(Request $request){
        $image = $request->file('attachment');
        $fileExtension='.'.$image->getClientOriginalExtension();
        $imageName = 'uploads/notice/'.date('dmYHis').$fileExtension;
        $image->move(public_path('uploads/notice'),$imageName);
        return $imageName;
    }
    
    public function events(Request $request){
        $image = $request->file('attachments');
        $fileExtension='.'.$image->getClientOriginalExtension();
        $imageName = 'uploads/events/'.date('dmYHis').$fileExtension;
        $image->move(public_path('uploads/events'),$imageName);
        return $imageName;
    }
    
    public function ckeditor_image(Request $request){
         if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;
    
            $request->file('upload')->move(public_path('media'), $fileName);
    
            $url = asset('media/' . $fileName);
            return response()->json(['fileName' => $fileName, 'uploaded'=> 1, 'url' => $url]);
        }
        
    }
    
    
   
}