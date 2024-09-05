<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blocks;
use App\Models\Settings;
use App\Models\Pages;
use App\Models\Product\Products;
use App\Models\ProductCategories;
use App\Models\Blog;
use App\Models\Contacts;
use App\Models\Testimonals;
use App\Models\SimpleSliders;
use App\Models\MediaGalleries;
use App\Models\Slider;
use Illuminate\Support\Facades\DB;
use App\Exports\PlayersExport;
use Maatwebsite\Excel\Facades\Excel;

class HomeController extends Controller
{
    

  /*  public function index()
    {
        $title="Home";
        return view('frontend.index', compact('title'));
    }*/
    
     public function index(){
         $title="Home";
        $events=DB::table('events')
             ->join('users', 'events.created_by', '=', 'users.id')
             ->join('session_setups', 'events.session_id', '=', 'session_setups.id')
             ->join('events_categories', 'events.events_category_id', '=', 'events_categories.id')
             ->select('events.*','session_setups.session_name', 'events_categories.name as catName', 
                'users.name')
             ->where('events.status', '=', 0)
             ->orderBy('events.id', 'desc')
              -> paginate(4);

        return view('frontend.index', ['events'=>$events, 'title'=>$title]);
    }
    
     public function getCity(Request $request){
        if(!empty($request->stateID)){
             $cityDetails = DB::table('cities')
                    ->select('id', 'name')
                    ->where(['status'=>0, 'state_id'=>$request->stateID])->orderBy('name', 'asc')->get();
            return json_encode($cityDetails);
        }
       
    }
    
    public function about_us(){
         $title="About Us";
        $content=Pages::where(['slug'=>'about-us'])->first();
        return view('frontend.pages', compact('content', 'title'));
    }
    public function admission(){
        $content=Page::where(['id'=>2])->first();
        return view('admission', ['content'=>$content]);
    }
    public function fee_structure(){
        $content=Page::where(['id'=>3])->first();
        return view('fee_structure', ['content'=>$content]);
    }
    public function facilities(){
        $content=Page::where(['id'=>4])->first();
        return view('facilities', ['content'=>$content]);
    }

    public function dailydiares(){
        $title="Daily Diares";
        $DailyDiaryList=DB::table('daily_diaries')
             ->join('class_setups', 'daily_diaries.class_id', '=', 'class_setups.id')
             ->join('section_setups', 'daily_diaries.section_id', '=', 'section_setups.id')
             ->select('daily_diaries.*', 'section_setups.section_name', 'class_setups.class_name')->orderBy('daily_diaries.id', 'desc')->simplePaginate(12);
        return view('frontend.dailydiares', ['title'=>$title, 'DailyDiaryList'=>$DailyDiaryList]);
    }

    public function assignments(){
        $title="Assignment/Home Works";
        $assignmentList=DB::table('assignment_holidays')
             ->join('class_setups', 'assignment_holidays.class_id', '=', 'class_setups.id')
             ->join('section_setups', 'assignment_holidays.section_id', '=', 'section_setups.id')
             ->select('assignment_holidays.*', 'section_setups.section_name', 'class_setups.class_name')->orderBy('assignment_holidays.id', 'desc')->simplePaginate(12);
        return view('frontend.assignments', ['title'=>$title, 'assignmentList'=>$assignmentList]);
    }
    
   
    public function pages(Request $request, $slug){
        $pageContent=Pages::where(['slug'=>$slug])->first();
        $title=$pageContent->page_title;
        $slider=SimpleSliders::where(['id'=>$pageContent->slider_id])->value('key');
        return view('frontend.pages', compact('title', 'pageContent', 'slider'));
    }
    
   
    
     public function blog(){
        $blogAll=Blog::where(['status'=>0])->orderBy('id', 'desc')->take(10)->get();
        $blogs=Blog::where(['status'=>0])->paginate(5);
        $title="Blog";
        $doctortiming=Blocks::where('name', '=', 'doctors-timetable')->value('content');
        return view('frontend.blog', compact('title', 'blogs', 'doctortiming', 'blogAll'));
    }
    
    public function blog_details(Request $request, $slug){
        $blogAll=Blog::where(['status'=>0])->whereNot('slug', $slug)->orderBy('id', 'desc')->take(10)->get();
        $blogs=Blog::where(['slug'=>$slug])->first();
        $title=$blogs->title;
        return view('frontend.blog_details', compact('title', 'blogs', 'blogAll'));
    }
    
     public function testimonal(){
        $testimonalAll=Testimonals::where(['status'=>0])->orderBy('id', 'desc')->take(6)->get();
        $title="Testimonals List";
        return view('frontend.testimonal', compact('title', 'testimonalAll'));
    }
    
    public function contact(Request $request){
        $title="Contact";
        if($request->input()){
            $this->validate($request, [
                'name'=>'required',
                'email'=>'required|email',
                'mobile'=>'required|numeric' ,
                'subject'=>'required' ,
                'massage'=>'required',
            ]);
            $data = new Contacts;
            //print_r($request->input()); exit;
            $data->name       = $request->input('name');
            $data->email      = $request->input('email');
            $data->mobile     = $request->input('mobile');
            $data->subject    = $request->input('subject');
            $data->massage    = $request->input('massage');
            
            try {
                $reply=$data->save();
             } catch(\Illuminate\Database\QueryException $e){
                    $errorCode = $e->errorInfo[1];          
                    $reply=$errorCode;
            }
           // print_r($e->errorInfo); exit;
            if($reply==1){
                return redirect('/contact')->with('success',"Your Inquiry Submitted successfully! Our Team will contact as soon as possible. "); 
                //return redirect()->back()->with('success',config('app.saveMsg'));;
            } elseif($reply==1062) {
                return redirect()->back()->with('error',config('app.duplicateErrMsg'));;
            } else {
               // return redirect()->back()->with('error',config('app.saveError'));;
                return redirect('/contact')->with('error',$e->errorInfo[2]); 
            }

        }
        return view('frontend.contact', compact('title'));
    }
    
    
     public function getSectionByClassId(Request $request){
        if(!empty($request->classId)){
            $details = DB::table('class_section_mappings')
                    ->select('section_setups.id', 'section_setups.section_name')
                    ->join('section_setups', 'class_section_mappings.section_setup_id', '=', 'section_setups.id')
                    ->where([ 'class_setups_id'=>$request->classId])->orderBy('section_setups.section_name', 'asc')->get();
            return json_encode($details);
        }
       
    }
    
    public function get_section(){
      $id=$_GET['id'];
      $sections= DB::table('class_section_mappings')
                            ->join('section_setups', 'class_section_mappings.section_setup_id', '=', 'section_setups.id')
                            ->where('class_section_mappings.class_setups_id', '=', $id)
                            ->orderBy('section_setups.section_name', 'asc')
                            ->pluck('section_setups.section_name', 'section_setups.id');
      return json_encode($sections);
    }
    
    public function news_events(){
        $title="News Events";
       $data = DB::table('events')
            ->join('session_setups', 'events.session_id', '=', 'session_setups.id')
             ->join('events_categories', 'events.events_category_id', '=', 'events_categories.id')
            ->select('events.*','session_setups.session_name', 'events_categories.name as catName')
            ->orderBy('events.date_from', 'desc')
             ->where('events.status', '=', 0)
             ->paginate(9);
        return view('frontend.news_events', compact('data', 'title'));
    }
    
    public function events_details(Request $request, $slug){
       
       $eventsCatAll = DB::table('events_categories')->select('events_categories.*')
            ->orderBy('events_categories.id', 'desc')->limit(5)
             ->where(['events_categories.status'=>0])
             ->get();
       
       $dataAll = DB::table('events')
            ->join('session_setups', 'events.session_id', '=', 'session_setups.id')
             ->join('events_categories', 'events.events_category_id', '=', 'events_categories.id')
            ->select('events.*','session_setups.session_name', 'events_categories.name as catName')
            ->orderBy('events.id', 'desc')
             ->where(['events.status'=>0])
             ->get();
             
       $data = DB::table('events')
            ->join('session_setups', 'events.session_id', '=', 'session_setups.id')
             ->join('events_categories', 'events.events_category_id', '=', 'events_categories.id')
            ->select('events.*','session_setups.session_name', 'events_categories.name as catName')
            ->where(['events.status'=>0, 'events.slug'=>$slug])
             ->first();
         $title=$data->note;
        return view('frontend.news_events_details', compact('data', 'title', 'dataAll', 'eventsCatAll'));
    }
    
    public function notice_board_details(Request $request, $slug){
       $noticeAll=DB::table('notices')
                            ->join('session_setups', 'notices.session_id', '=', 'session_setups.id')
                            ->where('notices.slug', '!=', $slug)->orderBy('notices.id', 'desc')->get();
        $noticeDetails=DB::table('notices')
                            ->join('session_setups', 'notices.session_id', '=', 'session_setups.id')
                            ->where('notices.slug', '=', $slug)->first();
        $title=$noticeDetails->title;
        return view('frontend.notice_board_details', compact('title', 'noticeDetails', 'noticeAll'));
    }
    
    
    public function events_category($eventCat){
        $title="News Events";
        $eventsCategory = DB::table('events_categories')->select('id')->where(['slug'=>$eventCat])->first();
        $data = DB::table('events')
            ->join('users', 'events.created_by', '=', 'users.id')
             ->join('session_setups', 'events.session_id', '=', 'session_setups.id')
             ->join('events_categories', 'events.events_category_id', '=', 'events_categories.id')
            ->select('events.*','session_setups.session_name', 'events_categories.name as catName', 
                'users.name')
            ->orderBy('events.date_from', 'desc')
             ->where('events.status', '=', 0)
             ->where('events.events_category_id', '=',$eventsCategory->id)
              -> paginate(10);
        return view('frontend.news_events', compact('data', 'title'));
    }
    
    public function notice_board(){
        $title="News Events";
       $data =DB::table('notices')
                ->join('session_setups', 'notices.session_id', '=', 'session_setups.id')
                ->where('notices.status', '=', 0)->orderBy('notices.id', 'desc')
              ->paginate(10);
              
        return view('frontend.notice_board', compact('data', 'title'));
    }
    
    
    public function photo_gallery(){
        $title="Photo Gallery";
        $photoGallery=DB::table('media_categories')
                        ->select('media_categories.*')
                        ->where(['media_categories.status'=>0])->orderBy('media_categories.title', 'asc')->take(9)->get();
        return view('frontend.photo_gallery', compact('title', 'photoGallery'));
    }
    
    public function photo_gallery_list($slug){
        $title="Photo Gallery List";
        $photoGallery=DB::table('media_galleries')->join('media_categories', 'media_galleries.media_categories_id', '=', 'media_categories.id')
                        ->select('media_galleries.*', 'media_categories.title as category')
                        ->where(['media_galleries.status'=>0, 'media_categories.slug'=>$slug, 'media_galleries.media_type'=>0])->orderBy('media_galleries.id', 'desc')->get();
        return view('frontend.photo_gallery_list', compact('title', 'photoGallery'));
    }
    
    public function video_gallery(){
        $title="Video Gallery";
        $photoGallery=DB::table('media_categories')
                        ->select('media_categories.*')
                        ->where(['media_categories.status'=>0])->orderBy('media_categories.title', 'asc')->take(9)->get();
        return view('frontend.video_gallery', compact('title', 'photoGallery'));
    }
     
     public function video_gallery_list($slug){
        $title="Video Gallery List";
        $photoGallery=DB::table('media_galleries')->join('media_categories', 'media_galleries.media_categories_id', '=', 'media_categories.id')
                        ->select('media_galleries.*', 'media_categories.title as category')
                        ->where(['media_galleries.status'=>0, 'media_categories.slug'=>$slug, 'media_galleries.media_type'=>1])->orderBy('media_galleries.id', 'desc')->get();
        return view('frontend.video_gallery_list', compact('title', 'photoGallery'));
    }
    
    
    
    
}
