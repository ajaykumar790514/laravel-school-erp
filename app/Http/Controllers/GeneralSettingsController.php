<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Url;
use Intervention\Image\ImageManagerStatic as Image;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\BasicMail;
use App\Models\Settings;

class GeneralSettingsController extends Controller
{
   
   function __construct()
    {
         $this->middleware('permission:smtp-settings', ['only' => ['smtp_settings']]);
        
    }
   
   public function smtp_settings()
    {
        $title='SMTP Settings';
        $host=Settings::where(['settingname'=>'mail_host'])->value('settingvalue');
        $port=Settings::where(['settingname'=>'mail_port'])->value('settingvalue');
        $username=Settings::where(['settingname'=>'mail_user'])->value('settingvalue');
        $password=Settings::where(['settingname'=>'mail_password'])->value('settingvalue');
        return view('settings.smtp-settings', compact('title', 'host', 'port', 'username', 'password'));
    }

    public function update_smtp_settings(Request $request)
    {
        $this->validate($request, [
            'site_smtp_mail_host' => 'required|string',
            'site_smtp_mail_port' => 'required|string',
            'site_smtp_mail_username' => 'required|string',
            'site_smtp_mail_password' => 'required|string',
        ]);
        
        Settings::where('settingname', 'mail_user')->update(['settingvalue'=>$request->input('site_smtp_mail_username')]);
        Settings::where('settingname', 'mail_host')->update(['settingvalue'=>$request->input('site_smtp_mail_host')]);
        Settings::where('settingname', 'mail_password')->update(['settingvalue'=>$request->input('site_smtp_mail_password')]);
        Settings::where('settingname', 'mail_port')->update(['settingvalue'=>$request->input('site_smtp_mail_port')]);
         return redirect()->back()->with('success',config('app.updateMsg'));
    }
    
    public function test_smtp_settings(Request $request)
    {
    

        $this->validate($request, [
            'subject' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'message' => 'required|string',
        ]);
        try {
            $data=[
                'subject' =>$request->subject,
                'form_message' =>$request->message
            ];
             sendGeneralMail($request->email, $request->subject, $data, 'mail.basic-mail-template');
             //exit;
        } catch(\Illuminate\Database\QueryException $e){
             $errorCode = $e->errorInfo[1];  
            return redirect()->back()->with('error',$errorCode);
        }

       
       return redirect()->back()->with('success','Your mail Sent Successfully.');
    }
}
