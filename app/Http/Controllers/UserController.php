<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Parents;
use App\Models\Students;
use App\Models\Employees;
use App\Models\UserDetails;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;
use DB;
use App\Models\Roles;
use Carbon\Carbon;
use Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

    
class UserController extends Controller
{
    
    function __construct()
    {
         $this->middleware('permission:user-list', ['only' => ['index']]);
         $this->middleware('permission:user-create', ['only' => ['create']]);
         $this->middleware('permission:user-edit', ['only' => ['edit']]);
         $this->middleware('permission:user-delete', ['only' => ['destroy']]);
         
         $this->middleware('permission:teacher-login-list', ['only' => ['teacher_login_list']]);
         $this->middleware('permission:teacher-login-create', ['only' => ['teacher_login_create']]);
         $this->middleware('permission:teacher-login-edit', ['only' => ['teacher_login_create']]);
         $this->middleware('permission:parent-login-create', ['only' => ['parent_login_create']]);
         $this->middleware('permission:parents-password-change', ['only' => ['parents_password_change']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title='User List';
        $roles = Role::select('id','name')->get();
        return view('users.index',compact('roles', 'title'));

    }

    public function userdatatable() {
        $data = DB::table('users')->select('users.*', 'roles.name as roleNamew')
                ->join('roles', 'roles.id', '=', 'users.roles_id');
        return datatables()->of($data)
        ->addColumn('action', function ($data) {
                return view('users.action', ['id' =>base64_encode($data->id)]);
            })
            ->addColumn('roles_id', function ($data) {
                return $data->roleNamew;
            })

        ->editColumn('created_at', function ($roles) {
            return Carbon::parse($roles->created_at)->diffForHumans();
            })
        ->make(true);
       
    }
    
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirmpassword',
            'roles_id' => 'required',
            'mobile' => 'required|numeric|min:10',
        ]);
        if($validator->fails()){
                return response()->json([
                    'status'=>400,
                    'errors'=>$validator->messages()
                ]);
        } else {
            $roles = Role::select('id','name')->where(['id'=>$request->input('roles_id')])->first();
            $password = Hash::make($request->input('password'));
            $data = new User;
            $data->name         = $request->input('name');
            $data->email        = $request->input('email');
            $data->roles_id     = $request->input('roles_id');
            $data->password     = $password ;
            try {
                $user = $data->save();
                $data->assignRole($roles->name);
            } catch (\Illuminate\Database\QueryException $e) {
                $errorCode = $e->errorInfo[1];
            }

            if ($user == 1) {
                //User Details save 
                $data1 = new UserDetails;
                $data1->user_id         = $data->id;
                $data1->mobile          = $request->input('mobile');
                $data1->qualification   = $request->input('qualification');
                $data1->address         = $request->input('address');
                try {
                    $userdetails = $data1->save();
                }catch (\Illuminate\Database\QueryException $e) {
                    $errorCode = $e->errorInfo[1];
                    $userdetails = $errorCode;
                    User::find($data->id)->delete();

                }

                if ($userdetails == 1) {
                    return response()->json([
                        'status'=>200,
                        'message'=>config('app.saveMsg')
                    ]);
                } else {
                    return response()->json([
                        'status'=>500,
                        'message'=>$e->errorInfo[2]
                    ]);
                }
                
            } else {
                return response()->json([
                    'status'=>500,
                    'message'=>$e->errorInfo[2]
                ]);
            }
        }
    }
    
       
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showdata($id){
        $editId=\base64_decode($id);
    	$data = DB::table("users")->select('users.*', 'roles.name as rolename')
        ->join('roles', 'roles.id', '=', 'users.roles_id')
        ->where("users.id",$editId) ->first();
        
        $userDetails = DB::table("user_details")->select('user_details.*')
                ->where("user_details.user_id",$data->id) ->first();

	    return response()->json([
	      'data' => $data,
          'userdetails'=>$userDetails
	    ]);
    }

    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$request->input('id'),
            'roles_id' => 'required',
            'mobile' => 'required|numeric|min:10',
        ]);
    
        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages()
            ]);
        } else {
            $decodeId = $request->input('id'); 
            $data = User::where('id', '=', $decodeId)->first();
            $roles = Role::select('id','name')->where(['id'=>$request->input('roles_id')])->first();
            $dataarray = array(
                'roles_id'      => $request->input('roles_id'),
                'name'          => $request->input('name'),
                'email'         => $request->input('email'),
                'updated_at'    =>      Carbon::now()->toDateTimeString()
            );
            try {
                $reply = User::where('id', $decodeId)->update($dataarray);
                DB::table('model_has_roles')->where('model_id',$decodeId)->delete();
                $data->assignRole($roles->name);
            } catch (\Illuminate\Database\QueryException $e) {
                $errorCode = $e->errorInfo[1];
                $reply = $errorCode;
            }
           
            if ($reply == 1) {
                $userDetailsdata = array(
                    'mobile'        => $request->input('mobile'),
                    'qualification' => $request->input('qualification'),
                    'address'       => $request->input('address'),
                    'updated_at'    =>      Carbon::now()->toDateTimeString()
                );
                $reply = UserDetails::where('user_id', $decodeId)->update($userDetailsdata); 
                return response()->json([
                    'status'=>200,
                    'message'=>config('app.updateMsg')
                ]);

            } else {
                 return response()->json([
                    'status'=>500,
                    'message'=>$e->errorInfo[2]
                ]);
            }



            
            
        }
    }
    
        
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $id = base64_decode($id); // decode id
        try {
            $reply = User::where('id', $id)->delete(); 
                UserDetails::where('user_id', $id)->delete(); 

        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1];
            $reply = $errorCode;
        }


        if ($reply == 1) {
            return response()->json([
                'status'=>200,
                'message'=>config('app.deleteMsg')
            ]);
        } else if ($reply == 1451) {
            return response()->json([
                'status'=>500,
                'message'=>$e->errorInfo[1]
            ]);

        }else if ($reply == 0) {
            return response()->json([
                'status'=>500,
                'message'=>"Record not Deleted Please Check query "
            ]);

        } else {
            return response()->json([
                'status'=>400,
                'message'=>$e->errorInfo[2]
            ]);

        }
   
    } 
    
    public function resetpassword(Request $request)
    {
        $title='Change Password';
        $user=User::find(Auth::id());
        $ids = $user->id;
        if ($request->input()) {
            $this->validate($request, [
                'oldpassword' => 'required',
                'password' => 'required',
                'cpassword' => 'required_with:password|same:password'
            ]);
            $checkPassword = User::where('password', '=', bcrypt($request->input('oldpassword')))->first();
            if(empty($checkPassword)){
                return redirect()->back()->with('error', ' Old Password is wrong ');
            }

            exit;
            $User = User::where('id', '=', $ids)->first();
            $data = array('password' => bcrypt($request->input('password')));
            User::where('id', $ids)->update($data);
            return redirect()->back()->with('success', config('app.saveMsg'));
        }
        return view('admin.resetpassword', compact('ids', 'title'));
    }
    
    
    
     public function teacher_login_list(Request $request){
         $title="Employee/Teacher Login";
        return view('users.teacher_login', compact('title'));

    }

    public function teacherlogindata()
    {
        
        $users = DB::table('users')->select('users.*')
        ->where(['user_type'=>1]);

        return datatables()->of($users)
        ->addColumn('roles', function ($users) {
               $tt= User::getRolename($users->id);
               return $tt;
            })
       
        ->addColumn('action', function ($users) {
                return view('users.action_employee', ['id' => base64_encode($users->id)]);
            })

        ->editColumn('created_at', function ($users) {
                return Carbon::parse($users->created_at)->diffForHumans();
            })
        
        //->make(true);
        ->toJson();
    }
    
    public function teacher_login_create(Request $request){
         $title="Employee/Teacher Login Create";
        $roles = Role::select('id', 'name')->where('id', '!=',1)->where('id', '!=',3)->get();  
        $teachers = Employees::select('id', 'employee_name', 'email')->get(); 

        //employee_type=0 mens teacher      
        if($request->input()){
            $this->validate($request, [
                'teacherId' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|same:confirm-password',
                'roles' => 'required'
           ]);
            $data = new User;
            $employee = Employees::find($request->input('teacherId'));

            $data->name=        $employee->employee_name;
            $data->email     = $request->input('email');
            $data->user_type          =  1; 
            $data->user_id          = $request->input('teacherId');
            $data->roles_id          = $request->input('roles');
            $data->password          = Hash::make($request->input('password'));
            $checkUser = User::where(['user_id'=>$request->input('teacherId')])->count();
            
            if($checkUser>0){
                return redirect()->back()->with('error',"Login already Created");;
            }

            
             try {
                $reply=$data->save();
                $user = User::find($data->id);
                $user->assignRole($request->input('roles'));
             } catch(\Illuminate\Database\QueryException $e){
                    $errorCode = $e->errorInfo[1];          
                    $reply=$errorCode;
            }
            //print_r($e->errorInfo); exit;
            if($reply==1){
                return redirect('teacher-login-list')->with('success',config('app.saveMsg'));;
            } elseif($reply==1062) {
                return redirect()->back()->with('error',config('app.duplicateErrMsg'));;
            } else {
                return redirect()->back()->with('error',config('app.saveError'));;
            }
            
        }
        return view('users.teacher_login_create',compact('roles', 'teachers', 'title'));
    }
    
    public function teacher_login_edit(Request $request, $id)
    {
        $title="Employee/Teacher Password Change";
        
        $roles = Role::select('id', 'name')->get();  
        $id=base64_decode($id);
        $data=User::find($id);
        if($request->input()){
            $this->validate($request, [
                //'email' => 'required|email',
                'status' => 'required',
                'password' => 'required|same:confirm-password',
                'confirm-password' => 'required',
                        
            ]);
            $data=User::where('id', '=', $id)->first();
            $dataarray = array(
                'email'     => $request->input('email'),
                 'status'     => $request->input('status'),
                'password'=> $request->input('password')==""?$data->password:Hash::make($request->input('password'))
            );
             try {
                 $reply=User::where('id', $id)->update($dataarray);
             } catch(\Illuminate\Database\QueryException $e){
                    $errorCode = $e->errorInfo[1];          
                    $reply=$errorCode;
            }
           if($reply==1){
             return redirect('teacher-login-list')->with('success',config('app.updateMsg'));
            } elseif($reply==1062) {
                return redirect()->back()->with('error',config('app.duplicateErrMsg'));;
            } else {
                return redirect('teacher-login-list')->with('error',config('app.saveError')); 
            }

            
        }
        //print_r($SessionSetups); exit;
        return view('users.teacher_login_edit', ['data'=>$data, 'title'=>$title]);
    }
    
    
    public function parents_login_list(Request $request){
         $title="Parents Login";
        return view('users.parents_login_list', compact('title'));
    }

    public function parentslogindata()
    {
        
        $users = DB::table('users')->select('users.*')
        ->where(['user_type'=>3]);
        return datatables()->of($users)
        ->addColumn('student', function ($users) {
               $tt= User::getRolename($users->id);
               $studentDetails=Students::select('student_name')->where(['parent_id'=>$users->user_id])->get();
               $studentName='';
               foreach($studentDetails as $student){
                   $studentName.= $student->student_name.',';
               }
               return $studentName;
            })
            
            ->addColumn('action', function ($data) {
                return view('users.parentaction', ['id' => base64_encode($data->id)]);
            })
        ->editColumn('created_at', function ($users) {
                return Carbon::parse($users->created_at)->diffForHumans();
            })
        
        //->make(true);
        ->toJson();
    }
    
    public function parent_login_create(Request $request){
        $title="Parents Login Create";
        $parents = Parents::select('id', 'father_name')->orderBy('father_name', 'asc')->get();
        if($request->input()){
            $this->validate($request, [
                'email' => 'required|email|unique:users,email',
                'password' => 'required|same:confirm-password',
           ]);
           
            $checkUser = User::where(['user_id'=>$request->input('parents_id')])->count();
            $parentsDetails = Parents::where(['id'=>$request->input('parents_id')])->first();
            if($checkUser>0){
                return redirect()->back()->with('error','Parent (' .$parentsDetails->father_name.') Login already created');;
                exit;
            }
            $data = new User;
            $data->roles_id=        3;
            $data->name=        $parentsDetails->father_name;
            $data->email     = $request->input('email');
            $data->user_type          =  3; 
            $data->user_id          = $request->input('parents_id');
            $data->password          = Hash::make($request->input('password'));
            try {
                $reply=$data->save();
                $user = User::find($data->id);
                $user->assignRole('Parents');
             } catch(\Illuminate\Database\QueryException $e){
                    $errorCode = $e->errorInfo[1];          
                    $reply=$errorCode;
            }
            if($reply==1){
                return redirect('/parents/parents-login-list')->with('success',config('app.saveMsg'));
            } elseif($reply==1062) {
                return redirect()->back()->with('error',config('app.duplicateErrMsg'));
            } else {
                return redirect()->back()->with('error',$e->errorInfo[2]);
            }
        }
        return view('users.parent_login_create',compact('title', 'parents'));
    }
    
    public function getParentsDetails(Request $request){
    	$data = DB::table("parents")->select('id', 'father_name', 'father_mobile_no', 'father_email', 'mothers_name', 'mother_mobile_no')
                ->where("id",$request->parentId) ->first();
        
        $studentDetails = DB::table("students")->select('student_name', 'email', 'class_setups.class_name')
                            ->join('class_setups', 'students.class_id', 'class_setups.id')
                            ->where("parent_id",$data->id) ->get();

	    return response()->json([
	      'data' => $data,
          'student'=>$studentDetails
	    ]);
    }
    
    public function parents_password_change(Request $request, $id)
    {
        $ids=base64_decode($id);
        $title='Change Password';
        $user=User::find($ids);
        if ($request->input()) {
            $this->validate($request, [
                'password' => 'required',
                'cpassword' => 'required_with:password|same:password'
            ]);
            
            $User = User::where('id', '=', $ids)->first(); 
            //$data = array('password' => bcrypt($request->input('password')));
            $data = array('password' => Hash::make($request->input('password')));
            User::where('id', $ids)->update($data);
            return redirect('parents/parents-login-list')->with('success', config('app.saveMsg'));
        }
        return view('users.parents_password_change', compact('id', 'title', 'user'));
    }
    
    
    
}