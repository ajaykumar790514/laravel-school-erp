<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\User;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Support\Facades\DB;

class AuthenticationController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|max:255',
            'password' => 'required'
        ]);
        
         if($validator->fails()){
                return  (new BaseController)->sendError('Validation Error.', $validator->errors());   
        } else {
            $login = $request->only('email', 'password');
            if (!Auth::attempt($login)) {
                return (new BaseController)->sendError('Invalid login credential!!', ""); 
            }
            /**
             * @var User $user
             */
            $user = Auth::user();
            $token = Str::random(32);;
            User::where('id', $user->id)->update(['token'=>$token]);
            $data =[
                'id' => $user->id,
                'roles_id'=>$user->roles_id,
                'user_id'=>$user->user_id,
                'user_type'=>$user->user_type,
                'name' => $user->name,
                'email' => $user->email,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
                'token' => $token,
                //'token_expires_at' => $token->token->expires_at,
            ];
            
            return (new BaseController)->sendResponse($data, 'User login successfully.');
            }

        
    }
    
    public function home(Request $request)
    {
       echo "testing";
    }

    public function logout(Request $request){
        $token = $request->input('token') ;//$request->token;
        // Verify
        if(!$token){
            return (new BaseController)->sendError('Token Not Found.!!'.$token, ""); 
        }
        $checkToken = DB::table('users')->where('token', $token)->first();

        // Verify
        if(!$checkToken){
            return (new BaseController)->sendError('Token Not Valid.!!', ""); 
        }
        
         DB::table('users')->where('token', $token)->update(['token'=>NULL]);
        return (new BaseController)->sendResponse("", 'Logged out from all device');

    }
}
