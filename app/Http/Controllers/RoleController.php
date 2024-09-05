<?php
    
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use DB;
use App\Models\Roles;
use Carbon\Carbon;
    
class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:role-list', ['only' => ['index','store']]);
         $this->middleware('permission:role-create', ['only' => ['create','store']]);
         $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title='Role List';
        $permission = Permission::get();
        $permissionHeading = Permission::distinct()->select('parent_id')->groupBy('parent_id', 'order_by')->get();
        return view('roles.index', compact('permission', 'permissionHeading', 'title'));
    }

    /**
     * Display a json formate for listing data.
     *
     * @return \Illuminate\Http\Response
     */

    public function rolesdatatable() {
        $roles = DB::table('roles')->select('created_at', 'id', 'name');
        return datatables()->of($roles)
        ->addColumn('action', function ($roles) {
                return view('roles.action', ['id' =>base64_encode($roles->id)]);
            })
            ->addColumn('permission', function ($roles) {
                $rolePermissions = DB::table("role_has_permissions")->select('permissions.name')
                ->join('permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                ->where("role_has_permissions.role_id",$roles->id) ->get();
                $permissionArray= '';
                foreach($rolePermissions as $value){
                    $permissionArray.=$value->name . ' , ';
                }


                return $permissionArray;
            })

        ->editColumn('created_at', function ($roles) {
            return Carbon::parse($roles->created_at)->diffForHumans();
            })

        
        ->make(true);
       
}
    
/**
* Store a newly created resource in storage.
*
* @param  \Illuminate\Http\Request  $request
* @return \Illuminate\Http\Response
*/
    public function create(Request $request){
    
        $validator = Validator::make($request->all(), [
            'name'=> 'required|unique:roles,name',
            'permission'=>'required',
        
        ]);
        if($validator->fails()){
                return response()->json([
                    'status'=>400,
                    'errors'=>$validator->messages()
                ]);
        } else {
            $role = Role::create(['name' => $request->input('name')]);
            $role->syncPermissions($request->input('permission'));
            //print_r($request->input('permission')); exit;
            return response()->json([
                'status'=>200,
                'message'=>config('app.saveMsg')
            ]);
        
        }
                    
    }

    public function loadedit($id){
        $editId=\base64_decode($id);
    	$data = Roles::find($editId);
        $rolePermissions = DB::table("role_has_permissions")->select('permissions.id')
                ->join('permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                ->where("role_has_permissions.role_id",$editId) ->get();

	    return response()->json([
	      'data' => $data,
          'permission'=>$rolePermissions
	    ]);
    }

    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request){
        $validator = Validator::make($request->all(), [
            'name'=> 'required|unique:roles,name,'.$request->input('id'),
            'permission'=>'required',
        
        ]);
        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages()
            ]);
        } else {
            $decodeId = $request->input('id'); 
            $role = Role::find($decodeId);
            $role->name = $request->input('name');
            $role->save();
            $role->syncPermissions($request->input('permission'));
            return response()->json([
                'status'=>200,
                'message'=>config('app.updateMsg')
            ]);
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
            $reply = Roles::where('id', $id)->delete(); 
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
                'status'=>400,
                'message'=>$e->errorInfo[1]
            ]);

        }else if ($reply == 0) {
            return response()->json([
                'status'=>400,
                'message'=>"Record not Deleted Please Check query "
            ]);

        } else {
            return response()->json([
                'status'=>400,
                'message'=>$e->errorInfo[2]
            ]);

        }
   
    } 
}