<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\Models\SimpleSliders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Url;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use Intervention\Image\ImageManagerStatic as Image;

class SettingController extends Controller
{
    
    function __construct()
    {
         $this->middleware('permission:settings', ['only' => ['settings']]);
    }
    
    public function settings(Request $request)
    {
        $slider=SimpleSliders::where(['status'=>'0'])->get();
        if ($request->input()) {
            $this->validate($request, [
                'oldpassword' => 'required',
                'password' => 'required',
                'cpassword' => 'required_with:password|same:password'

            ]);
            $User = User::where('id', '=', Auth::user()->id)->first();
            $data = array(
                'password'           => bcrypt($request->input('password')),
            );
            User::where('id', Auth::user()->id)->update($data);
            return redirect('/admin/changepassword')->with('responce', 'Password change sucessfully');
        }
        return view('settings.settings', compact('slider'));
    }

    public function updatelogo(Request $request)
    {
        $id = 13;
        $Settings = Settings::where('id', '=', $id)->first();
        $request->validate([
            'logo' => 'required',
        ]);


        if ($request->input()) {
            $Settings = Settings::where('id', '=', $id)->first();
            /*if (!empty($request->logo)) {
                $filename = 'logo_' . date('ymdhs') . '.' . $request->logo->extension();
                //$image_resize->save('uploads/' . $filename);
                $request->logo->move(public_path('uploads'), $filename);
                $url = 'uploads/' . $filename;
            }*/
            $data = array(
                'settingvalue'  => $request->logo


            );
            Settings::where('id', $id)->update($data);

            return redirect('settings')->with('responce', 'Updated sucessfully');
        }
    }


    public function updatefavicon(Request $request)
    {
        $id = 14;
        $Settings = Settings::where('id', '=', $id)->first();
        $request->validate([

            'favicon' => 'required',

        ]);

        if ($request->input()) {
            $Settings = Settings::where('id', '=', $id)->first();
           /* if (!empty($request->favicon)) {
                $filename = 'logo_' . date('ymdHis') . '.' . $request->favicon->extension();
                //$image_resize->save('uploads/' . $filename);
                $request->favicon->move(public_path('uploads'), $filename);
                $url = 'uploads/' . $filename;
            }*/


            $data = array(
                'settingvalue'  =>$request->favicon
            );
            Settings::where('id', $id)->update($data);

            return redirect('/settings')->with('responce', 'Updated sucessfully');
        }
    }



    public function updatesettings()
    {
        $id = $_POST['pk'];
        
        $value = $_POST['value'];
        return Settings::where('id', $id)->update(['settingvalue' => $value]);

        //return Settings::find($id)->update(['settingvalue'=>$value]);

    }
    
    public function update_slider(Request $request){
        $settingname = 'home-page-slider';
        $Settings = Settings::where('settingname', '=', $settingname)->first();
        $request->validate([
            'settingvalue' => 'required',
        ]);
        
        $value = $request->settingvalue;
        Settings::where('settingname', $settingname)->update(['settingvalue' => $value]);
        return redirect('/settings')->with('responce', 'Updated sucessfully');

    }
}
