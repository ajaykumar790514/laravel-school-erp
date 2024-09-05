<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ForgetController extends Controller
{
    public function forgotpassword(Request $request){
         if($request->input()){
             $this->validate($request, [
                'email'=>'required|email',
            ]);
           $user=User::where(['email'=>$request->email])->value('email');
           
           if($user!=''){
               DB::table('password_resets')->insert([
                    'email' => $request->email,
                    'token' => Str::random(60),
                    'created_at' => Carbon::now()
                ]);
                
                $tokenData = DB::table('password_resets')->where('email', $request->email)->first();
                $userdetails = DB::table('users')->where('email', $request->email)->select('email')->first();
                //Generate, the password reset link. The token generated is embedded in the link
                $link = $_SERVER['SERVER_NAME']. '/resetpassword/' . $tokenData->token . '?email=' . urlencode($userdetails->email);
                sendGeneralMail($userdetails->email, "Reset Password Link", $link, 'mail.resetpassword');
                return redirect()->back()->with('success', 'A reset link has been sent to your email address.');
                
                
                /*if ($this->sendResetEmail($request->email, $tokenData->token)) {
                    return redirect()->back()->with('success', 'A reset link has been sent to your email address.');
                } else {
                    return redirect()->back()->withErrors('error', 'A Network Error occurred. Please try again.');
                }*/
                
           } else{
               return redirect()->back()->with('error','Email Id not match in database');;
           }
            
         }
        
        return view('backend.forgetpassword.forgetpassword');
    }
    
    public function passwordreset(Request $request){
        return view('backend.forgetpassword.passwordreset');
    }
    
    public function changepassworddirect(Request $request){
            $this->validate($request, [
                // 'email' => 'required|email|exists:users,email',
                 'password' => 'required',
                'confirmpassword' => 'required_with:password|same:password',
                 //'token' => 'required'
            ]);
              $password = $request->password;
              $tokenData = DB::table('password_resets')->where('token', $request->token)->first();
              // Redirect the user back to the password reset request form if the token is invalid
             if (!$tokenData) return view('backend.forgetpassword.forgetpassword');
             $user = User::where('email', $tokenData->email)->first();
            // Redirect the user back if the email is invalid
            if (!$user) return  redirect()->back()->with('error','Email Id not match in database');
            $data = array('password' => bcrypt($request->input('password')));
            User::where('email', $tokenData->email)->update($data);
            DB::table('password_resets')->where('token', $request->token)->delete(); 
            return redirect('login')->with('success', 'Password change successfully');

        }
    
    private function sendResetEmail($email, $token)
        {
        //Retrieve the user from the database
        $user = DB::table('users')->where('email', $email)->select('email')->first();
        //Generate, the password reset link. The token generated is embedded in the link
        $link = config('base_url') . 'resetpassword/' . $token . '?email=' . urlencode($user->email);
        
            try {
            //Here send the link with CURL with an external email API 
                sendGeneralMail($user->email, "Reset Password Link", $link, 'mail.resetpassword.blade');
                return true;
            } catch (\Exception $e) {
                return false;
            }
        }
    
    
    
}
