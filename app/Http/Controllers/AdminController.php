<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\ProductCategories;
use App\Models\Product\Products;
use App\Models\Blog;
use App\Models\Testimonals;
use App\Models\Contacts;

class AdminController extends Controller
{
    public function dashboard(){
        
        $dailyDiaryCount =DB::table('daily_diaries')
                        ->where(['session_id'=>getSessionDefault()])
                        ->count();
        
        $dailyDiaryAll =DB::table('daily_diaries')->select('daily_diaries.*', 'session_setups.session_name')
                        ->join('session_setups', 'daily_diaries.session_id', '=', 'session_setups.id')
                        ->where(['daily_diaries.session_id'=>getSessionDefault(), 'daily_diaries.status'=>0])->limit(5)
                        ->orderBy('daily_diaries.id', 'desc')->get();
                        
        $assignmentcount =DB::table('assignment_holidays')
                        ->where(['session_id'=>getSessionDefault()])->limit(12)
                        ->count();
       
       $noticeBoard=DB::table('notices')->where(['session_id'=>getSessionDefault()])->count();
       
           
        $eventsCount =DB::table('events')
                        ->where(['session_id'=>getSessionDefault()])->count();
           
        $testimonals =DB::table('testimonals')->count();
        
        $contacts =DB::table('contacts')->count();
           
        $contactAll=DB::table('contacts')->orderBy('contacts.id', 'desc')->limit(12)->get();
            
        $assignmentAll =DB::table('assignment_holidays')
                        ->select('assignment_holidays.*', 'section_setups.section_name', 'class_setups.class_name')
                        ->join('class_setups', 'assignment_holidays.class_id', '=', 'class_setups.id')
                        ->join('section_setups', 'assignment_holidays.section_id', '=', 'section_setups.id')
                        ->where(['assignment_holidays.session_id'=>getSessionDefault()])->limit(12)
                        ->orderBy('assignment_holidays.id', 'desc')->get();
                    
     
        $title='Dashboard';
         
      	return view('admin/admin-dashboard', compact('title', 'dailyDiaryCount', 'assignmentcount', 'noticeBoard', 'testimonals', 
      	'contacts', 'eventsCount', 'dailyDiaryAll', 'assignmentAll', 'contactAll'));
    }
    
    public function resetpassword(Request $request)
    {
        $user=User::find(Auth::id());
        $ids = $user->id;
        if ($request->input()) {
            $this->validate($request, [
                'password' => 'required',
                'cpassword' => 'required_with:password|same:password'

            ]);
            $User = User::where('id', '=', $ids)->first();
            $data = array('password' => bcrypt($request->input('password')));
            User::where('id', $ids)->update($data);
            return redirect()->back()->with('success', config('app.saveMsg'));
        }
        return view('admin.resetpassword', compact('ids'));
    }
}
