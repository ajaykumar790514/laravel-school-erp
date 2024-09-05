<?php

namespace App\Http\Controllers\backend;

use App\Models\Employees;
use App\Models\Designations;
use App\Models\Departments;
use App\Models\Religions;
use App\Models\DocumentsSetups;
use App\Models\Documents;
use App\Models\EmployeeDocuments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Url;
use Intervention\Image\ImageManagerStatic as Image;
use Carbon\Carbon;

class EmployeesController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:employees-list');
         $this->middleware('permission:employees-upload-documents', ['only' => ['upload_documents']]);
         $this->middleware('permission:employees-delete-documents', ['only' => ['documentsdelete']]);
         $this->middleware('permission:employees-view', ['only' => ['view']]);
         $this->middleware('permission:employees-create', ['only' => ['create','store']]);
         $this->middleware('permission:employees-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:employees-delete', ['only' => ['destroy']]);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $title="Employee/Teacher List";
        return view('backend.employees.index', compact('title'));
     }

    public function employeesdatatable()
    {
        $data = DB::table('employees')->select('*');
        return datatables()->of($data)
        ->addColumn('action', function ($data) {
                return view('backend.employees.action', ['id' => base64_encode($data->id)]);
            })
        ->editColumn('created_at', function ($data) {
                return Carbon::parse($data->created_at)->diffForHumans();
            })
        ->make(true);
        //->toJson();
    }
    

    public function create(Request $request){
        $title="Employee/Teacher Registration";
        if($request->input()){
            $this->validate($request, [
                'employee_type'=>'required',
                'employee_category'=>'required',
                'designation_id'=>'required',
                'department_id'=>'required',
                'employee_name'=>'required',
                'dob'=>'required',
                'joining_dt'=>'required',
                'father_husband_name'=>'required',
                'gendre'=>'required',
                'marital_status'=>'required',
                'religions_id'=>'required',
                'qalification'=>'required',
                'address'=>'required',
                'city'=>'required',
                'mobile_whatsapp'=>'required|numeric|digits:10',
                'email'=>'nullable|email',
                'status'=>'required',
           ]);
            $data = new Employees;
            $data->employee_type = $request->input('employee_type');
             $data->joining_dt          = date('Y-m-d', strtotime($request->input('joining_dt')));
            $data->employee_category     = $request->input('employee_category');
            $data->designation_id          = $request->input('designation_id');
            $data->department_id          = $request->input('department_id');
            $data->employee_name          = $request->input('employee_name');
            $data->father_husband_name          = $request->input('father_husband_name');
            $data->mother_wife_name          = $request->input('mother_wife_name');
            $data->dob          = date('Y-m-d', strtotime($request->input('dob')));
            $data->gendre          = $request->input('gendre');
            $data->aadhar_no          = $request->input('aadhar_no');
            $data->pan_no          = $request->input('pan_no');
            $data->marital_status          = $request->input('marital_status');
            $data->religions_id          = $request->input('religions_id');
            $data->qalification          = $request->input('qalification');
            $data->specialization          = $request->input('specialization');
            $data->bloud_group          = $request->input('bloud_group');
            $data->mark_aditification          = $request->input('mark_aditification');
            $data->address          = $request->input('address');
            $data->city          = $request->input('city');
            $data->pincode          = $request->input('pincode');
            $data->mobile_whatsapp          = $request->input('mobile_whatsapp');
            $data->mobile_secondary          = $request->input('mobile_secondary');
            $data->email          = $request->input('email');
            $data->status          = $request->input('status');
            $data->created_by          = Auth::id();;

            try {
                 $reply=$data->save();
             } catch(\Illuminate\Database\QueryException $e){
                    $errorCode = $e->errorInfo[1];          
                    $reply=$errorCode;
            }
            //print_r($e->errorInfo); exit;
            if($reply==1){
                return redirect('employees-list')->with('success',config('app.saveMsg')); 
            } elseif($reply==1062) {
                return redirect()->back()->with('error',config('app.duplicateErrMsg'));;
            } else {
                return redirect()->back()->with('error',config('app.saveError'));;
            }
            
        }
        return view('backend.employees.create',compact('title'));
    }


    public function upload_documents(Request $request, $id){
        $title="Upload documents for Employee";
        $documentsSetups= DocumentsSetups::select('id', 'name')->where(['status'=>0])->orderBy('name', 'asc')->get();
        $employeeId=base64_decode($id);
        if($request->input()){
            $this->validate($request, [
                'document_type'=>'required',
                'status'=>'required',
                'documents'=>'required|image|mimes:jpeg,png,jpg|max:1024',
            ]);
            $data = new EmployeeDocuments;
            $data->document_type           = $request->input('document_type');
            $data->employee_id      = $employeeId;
            $data->status          = $request->input('status');
            $data->users_id                 = Auth::id();
            $image = $request->file('documents');
            $fileExtension='.'.$image->getClientOriginalExtension();
            $imageName = 'uploads/employee/'.date('dmYHis').$fileExtension;
            $image->move(public_path('uploads/employee'),$imageName);
            $data->documents  =$imageName;
            

            try {
                     $reply=$data->save();
            } catch(\Illuminate\Database\QueryException $e){
                       $errorCode = $e->errorInfo[1];  
                       $reply=$errorCode;        
             }
            //print_r($e->errorInfo); exit;
            if($reply==1){
                //return redirect('/admission/student-list')->with('success',config('app.uploadMsg')); 
                 return redirect()->back()->with('success',config('app.uploadMsg'));;
            } elseif($reply==1062) {
                return redirect()->back()->with('error',config('app.duplicateErrMsg'));;
            } else {
                //return redirect('/admission/student-list')->with('error',config('app.saveError')); 
                return redirect()->back()->with('error',config('app.saveError'));;
            }
        }
        return view('backend.employees.uploads_documents', compact('id', 'documentsSetups', 'employeeId', 'title'));
    }

    public function view(Request $request, $id) {
         $title="Employee Details";
        $employeeId=base64_decode($id);
        $data = DB::table('employees')
             ->join('designations', 'employees.designation_id', '=', 'designations.id')
             ->join('departments', 'employees.department_id', '=', 'departments.id')
             ->join('religions', 'employees.religions_id', '=', 'religions.id')
             ->select('employees.*','designations.designation_name', 'departments.department_name', 
                'religions.short_name')
             ->where(['employees.id'=>$employeeId])
              ->first();
          $documentsData = DB::table('employee_documents')
                 ->join('documents_setups', 'employee_documents.document_type', '=', 'documents_setups.id')
                 ->select('employee_documents.*', 'documents_setups.name')
                 ->where(['employee_documents.employee_id'=>$employeeId])
                  ->get();
            return view('backend.employees.view', compact('data', 'documentsData', 'title'));
     }

    
    public function edit(Request $request, $id)
    {
        $title="Employee/Teacher Edit";
        $id=base64_decode($id);
        $data=Employees::find($id);
        if($request->input()){
            $this->validate($request, [
            'employee_type'=>'required',
                'employee_category'=>'required',
                'designation_id'=>'required',
                'department_id'=>'required',
                'employee_name'=>'required',
                'dob'=>'required',
                'father_husband_name'=>'required',
                'gendre'=>'required',
                'marital_status'=>'required',
                'religions_id'=>'required',
                'qalification'=>'required',
                'address'=>'required',
                'city'=>'required',
                'mobile_whatsapp'=>'required|numeric|digits:10',
                'email'=>'nullable|email',
                'status'=>'required',      
            ]);
            $data=Employees::where('id', '=', $id)->first();
            $dataarray = array(
                'employee_type' => $request->input('employee_type'),
                'employee_category'     => $request->input('employee_category'),
                'designation_id'          => $request->input('designation_id'),
                'department_id'          => $request->input('department_id'),
                'employee_name'          => $request->input('employee_name'),
                'father_husband_name'          => $request->input('father_husband_name'),
                'mother_wife_name'          => $request->input('mother_wife_name'),
                'dob'          => date('Y-m-d', strtotime($request->input('dob'))),
                'gendre'          => $request->input('gendre'),
                'aadhar_no'          => $request->input('aadhar_no'),
                'pan_no'          => $request->input('pan_no'),
                'marital_status'          => $request->input('marital_status'),
                'religions_id'          => $request->input('religions_id'),
                'qalification'          => $request->input('qalification'),
                'specialization'          => $request->input('specialization'),
                'bloud_group'          => $request->input('bloud_group'),
                'mark_aditification'          => $request->input('mark_aditification'),
                'address'          => $request->input('address'),
                'city'          => $request->input('city'),
                'pincode'          => $request->input('pincode'),
                'mobile_whatsapp'          => $request->input('mobile_whatsapp'),
                'mobile_secondary'          => $request->input('mobile_secondary'),
                'email'          => $request->input('email'),
                'status'          => $request->input('status'),
                'created_by'          => Auth::id()
             );
             try {
                 $reply=Employees::where('id', $id)->update($dataarray);
             } catch(\Illuminate\Database\QueryException $e){
                    $errorCode = $e->errorInfo[1];          
                    $reply=$errorCode;
                
            }
           if($reply==1){
             return redirect('employees-list')->with('success',config('app.updateMsg'));
            } elseif($reply==1062) {
               return redirect()->back()->with('error',config('app.duplicateErrMsg'));;
            } else {
                return redirect()->back()->with('error',config('app.saveError')); 
            }
        }
        return view('backend.employees.edit', ['data'=>$data, 'title'=>$title]);
    }

    public function documentsdelete($id){
         $id=base64_decode($id);
         $data=EmployeeDocuments::find($id);
        $reply=EmployeeDocuments::where('id',$id)->delete();

        if($reply==1){
            $image_path = $data->documents;  // Value is not URL but directory file path
            if(File::exists($image_path)) {
                File::delete($image_path);
            }
            return redirect()->back()->with('success',config('app.deleteMsg'));
        } else {
            return redirect()->back()->with('error',config('app.deleteErrMsg'));
        }
        
    }

     public function employeedelete($id){
         $id=base64_decode($id);
         try {
                $reply=Employees::where('id',$id)->delete();
             } catch(\Illuminate\Database\QueryException $e){
                    $errorCode = $e->errorInfo[1];          
                    $reply=$errorCode;
            }
        if($reply==1){
            return redirect()->back()->with('success',config('app.deleteMsg'));
        } else if($reply==1451) {
            return redirect()->back()->with('error',$e->errorInfo[2]);
        } else {
             return redirect()->back()->with('error',config('app.deleteErrMsg'));
        }
        
    }
}
