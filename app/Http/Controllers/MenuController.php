<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Menuitems;
use App\Models\Pages;
use App\Models\Events;
use App\Models\Notice;
use Session;

class MenuController extends Controller
{
    public function index(){
        $title='Menu Managment';
        $pages = Pages::getAllPages(0);
        $events = Events::where('status',0)->get();  
        $notices = Notice::where('status',0)->get();  
        $menuitems = '';
        $desiredMenu = '';  
        if(isset($_GET['id']) && $_GET['id'] != 'new'){
          $id = $_GET['id'];
          $desiredMenu = Menu::where('id',$id)->first();
          if($desiredMenu->content != ''){
            $menuitems = json_decode($desiredMenu->content);

          }else{
            $menuitems = Menuitems::where('menu_id',$desiredMenu->id)->get();                    
          }
         
        }else{
            $desiredMenu = '';
        }
        return view ('menumanagge.menu',['title'=>$title, 'pages'=>$pages, 'events'=>$events,
        'notices'=>$notices ,'menus'=>Menu::all(),'desiredMenu'=>$desiredMenu,'menuitems'=>$menuitems]);
      }	



    public function store(Request $request)
    {
        $data = $request->all(); 
        if(Menu::create($data)){ 
            $newdata = Menu::orderby('id','DESC')->first();          
            session::flash('success','Menu saved successfully !');             
            return redirect("manage-menus?id=$newdata->id");
        }else{
            return redirect()->back()->with('error','Failed to save menu !');
        }
    }	

    public function addPageToMenu(Request $request){
        $data = $request->all();
        $menuid = $request->menuid;
        $ids = $request->ids;
        $menu = Menu::findOrFail($menuid);
        if($menu->content == ''){
          foreach($ids as $id){
            $data['title'] =Pages::where('id',$id)->value('page_title');
            $data['slug'] = Pages::where('id',$id)->value('slug');
            $data['type'] = 'pages';
            $data['menu_id'] = $menuid;
            $data['updated_at'] = NULL;
            Menuitems::create($data);
          }
        }else{
          $olddata = json_decode($menu->content,true); 
          foreach($ids as $id){
            $data['title'] = Pages::where('id',$id)->value('page_title');
            $data['slug'] = Pages::where('id',$id)->value('slug');
            $data['type'] = 'pages';
            $data['menu_id'] = $menuid;
            $data['updated_at'] = NULL;
            Menuitems::create($data);
          }
          foreach($ids as $id){
            // $array['title'] = Pages::where('id',$id)->value('page_title');
            // $array['slug'] = Pages::where('id',$id)->value('slug');
            // $array['name'] = NULL;
            // $array['type'] = 'pages';
            // $array['target'] = NULL;
            $array['id'] = Menuitems::where('slug',Pages::where('id',$id)->value('slug'))->where('name',NULL)->where('type','pages')->value('id');
            //$array['children'] = [[]];
            array_push($olddata,$array);
            $oldata = json_encode($olddata);
            $menu->update(['content'=>$olddata]);
          }
        }
      }
      
    public function addEventToMenu(Request $request){
        $data = $request->all();
        $menuid = $request->menuid;
        $ids = $request->ids;
        $menu = Menu::findOrFail($menuid);
        if($menu->content == ''){
          foreach($ids as $id){
            $data['title'] =Events::where('id',$id)->value('note');
            $data['slug'] = Events::where('id',$id)->value('slug');
            $data['type'] = 'events';
            $data['menu_id'] = $menuid;
            $data['updated_at'] = NULL;
            Menuitems::create($data);
          }
        }else{
          $olddata = json_decode($menu->content,true); 
          foreach($ids as $id){
            $data['title'] = Events::where('id',$id)->value('note');
            $data['slug'] = Events::where('id',$id)->value('slug');
            $data['type'] = 'events';
            $data['menu_id'] = $menuid;
            $data['updated_at'] = NULL;
            Menuitems::create($data);
          }
          foreach($ids as $id){
            /*$array['title'] = Diseases::where('id',$id)->value('title');
            $array['slug'] = Diseases::where('id',$id)->value('slug');
            $array['name'] = NULL;
            $array['type'] = 'diseases';
            $array['target'] = NULL;*/
            $array['id'] = Menuitems::where('slug',Events::where('id',$id)->value('slug'))->where('name',NULL)->where('type','events')->value('id');
            //$array['children'] = [[]];
            array_push($olddata,$array);
            $oldata = json_encode($olddata);
            $menu->update(['content'=>$olddata]);
          }
        }
      }  
    
      
      public function addNoticeToMenu(Request $request){
        $data = $request->all();
        $menuid = $request->menuid;
        $ids = $request->ids;
        $menu = Menu::findOrFail($menuid);
        if($menu->content == ''){
          foreach($ids as $id){
            $data['title'] = Notice::where('id',$id)->value('title');
            $data['slug'] = Notice::where('id',$id)->value('slug');
            $data['type'] = 'notice';
            $data['menu_id'] = $menuid;
            $data['updated_at'] = NULL;
            Menuitems::create($data);
          }
        }else{
          $olddata = json_decode($menu->content,true); 
          foreach($ids as $id){
            $data['title'] = Notice::where('id',$id)->value('title');
            $data['slug'] = Notice::where('id',$id)->value('slug');
            $data['type'] = 'notice';
            $data['menu_id'] = $menuid;
            $data['updated_at'] = NULL;
            Menuitems::create($data);
          }
          foreach($ids as $id){
            // $array['title'] = HealthServices::where('id',$id)->value('title');
            // $array['slug'] = HealthServices::where('id',$id)->value('slug');
            // $array['name'] = NULL;
            // $array['type'] = 'healthservices';
            // $array['target'] = NULL;
            $array['id'] = Menuitems::where('slug',Notice::where('id',$id)->value('slug'))->where('name',NULL)->where('type','notice')->orderby('id','DESC')->value('id');                
            //$array['children'] = [[]];
            array_push($olddata,$array);
            $oldata = json_encode($olddata);
            $menu->update(['content'=>$olddata]);
          }
        }
      }
      
      public function addCustomLink(Request $request){
        $data = $request->all();
        $menuid = $request->menuid;
        $menu = Menu::findOrFail($menuid);
        if($menu->content == ''){
          $data['title'] = $request->link;
          $data['slug'] = $request->url;
          $data['type'] = 'custom';
          $data['menu_id'] = $menuid;
          $data['updated_at'] = NULL;
          Menuitems::create($data);
        }else{
          $olddata = json_decode($menu->content,true); 
          $data['title'] = $request->link;
          $data['slug'] = $request->url;
          $data['type'] = 'custom';
          $data['menu_id'] = $menuid;
          $data['updated_at'] = NULL;
          Menuitems::create($data);
          $array = [];
          /*$array['title'] = $request->link;
          $array['slug'] = $request->url;
          $array['name'] = NULL;
          $array['type'] = 'custom';
          $array['target'] = NULL;*/
          $array['id'] = Menuitems::where('slug',$request->url)->where('name',NULL)->where('type','custom')->orderby('id','DESC')->value('id');                
          //$array['children'] = [[]];
          array_push($olddata,$array);
          $oldata = json_encode($olddata);
          $menu->update(['content'=>$olddata]);
        }
      }	

      public function updateMenu(Request $request){
        $newdata = $request->all(); 
        $menu=Menu::findOrFail($request->menuid);            
        $content = $request->data; 
        $newdata = [];  
        $newdata['location'] = $request->location;       
        $newdata['content'] = json_encode($content);
        $menu->update($newdata); 
      }	

      public function updateMenuItem(Request $request){
        $data = $request->all();        
        $item = Menuitems::findOrFail($request->id);
        $item->update($data);
        return redirect()->back();
      }
      
      public function deleteMenuItem($id,$key,$in=''){        
        $menuitem = Menuitems::findOrFail($id);
        $menu = Menu::where('id',$menuitem->menu_id)->first();
       
        if($menu->content != ''){
          $data = json_decode($menu->content,true);    
          $maindata = $data; 
          
          if($in == ''){
            unset($data[$key]);
            $newdata = json_encode($data); 
            $menu->update(['content'=>$newdata]);                         
          }else{
              unset($data[$key]['children'][$in]);
              $newdata = json_encode($data);
            $menu->update(['content'=>$newdata]); 
          }
        }
        $menuitem->delete();
        return redirect()->back();
      }	

      public function destroy(Request $request)
        {
        Menuitems::where('menu_id',$request->id)->delete();	
        Menu::findOrFail($request->id)->delete();
        return redirect('manage-menus')->with('success','Menu deleted successfully');
        }	

        












}
