<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Models\FeeCollections;
use App\Models\Invoices;
use App\Models\StudentClassAllotments;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use PDF;

class FeeCollectionsController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:student-list-for-fee-collection', ['only' => ['studentlistforcollection']]);
         $this->middleware('permission:fee-collection', ['only' => ['feecollections']]);
         $this->middleware('permission:fee-invoice', ['only' => ['fee_invoice']]);
         $this->middleware('permission:fee-invoice-list', ['only' => ['fee-invoice-list']]);
    }
    
     public function studentlistforcollection(Request $request) {
        $title="Student List For Fee Collection";
            if($request->input()){
                $this->validate($request, [
                'session_id'=>'required',
                'class_maping_id'=>'required', 
                //'section_id'=>'required', 
                ]);
                $class_id       = $request->input('class_maping_id');
                $session_id     = $request->input('session_id');
                $section_id     = $request->input('section_id');
                //get already allotment student list
                $query  = DB::table('student_class_allotments')
                ->where('student_class_allotments.session_id', '=', $session_id)
                ->where('student_class_allotments.classsetup_id', '=', $class_id)
                //->where('student_class_allotments.sectionsetup_id', '=', $section_id)
                ->join('class_section_mappings', 'student_class_allotments.class_maping_id', '=', 'class_section_mappings.id')
                ->join('students', 'student_class_allotments.student_id', '=', 'students.id')
                ->join('parents', 'students.parent_id', '=', 'parents.id')
                 ->join('session_setups', 'student_class_allotments.session_id', '=', 'session_setups.id')
                 ->join('section_setups', 'student_class_allotments.sectionsetup_id', '=', 'section_setups.id')
                ->join('class_setups', 'student_class_allotments.classsetup_id', '=', 'class_setups.id')
                 ->select('students.*', 'student_class_allotments.id as studentClassId',
                    'student_class_allotments.roll_no', 'student_class_allotments.session_id', 'student_class_allotments.performeance_status',   
                    'student_class_allotments.student_id', 'student_class_allotments.class_maping_id',  'parents.address', 'parents.father_name','parents.father_mobile_no as parentsmobile', 
                    'session_setups.session_year', 'class_setups.class_name', 'section_setups.section_name')->orderBy('students.student_name', 'asc');
                    
                if ($request->input('section_id')) {
                    $query->where('student_class_allotments.sectionsetup_id', $request->input('section_id'));
                }
                
                $data= $query->get();

            } else {
                $data = array();
                $class_id = "";
                $session_id ="";
                $section_id="";
        } 
            return view('backend.feecollection.studentlistforcollection', compact('data', 'class_id', 'session_id', 'section_id', 'title'));
     }
     
    public function feecollections(Request $request, $studentClassAllotment) {
        $title="Student Fee Collection";
        $collection = session()->get('collection'); ;
        if(!empty($collection)){
            if($collection['studentId']!=getStudentIdByClassAllotmentId(base64_decode($studentClassAllotment))){
                session()->forget('collection');
                FeeCollections::where(['payment_status'=>0])->delete();
                
            }
        }
        
       
        $stdClasAltId=base64_decode($studentClassAllotment);
        $data = DB::table('student_class_allotments')
                ->where('student_class_allotments.id', '=', $stdClasAltId)
                ->join('class_section_mappings', 'student_class_allotments.class_maping_id', '=', 'class_section_mappings.id')
                ->join('students', 'student_class_allotments.student_id', '=', 'students.id')
                ->join('parents', 'students.parent_id', '=', 'parents.id')
                 ->join('session_setups', 'student_class_allotments.session_id', '=', 'session_setups.id')
                 ->join('section_setups', 'student_class_allotments.sectionsetup_id', '=', 'section_setups.id')
                ->join('class_setups', 'student_class_allotments.classsetup_id', '=', 'class_setups.id')
                 ->select('students.student_name', 'students.id', 'student_class_allotments.id as studentClassId',
                    'student_class_allotments.roll_no',  'session_setups.session_name', 'session_setups.id as SessionID',  
                    'class_setups.class_name', 'class_setups.id as classId', 'section_setups.section_name', 'section_setups.id as sectionId')
                ->first();
        $feeHead=DB::table('fee_amount_setups')
                ->where(['fee_amount_setups.session_setup_id'=>$data->SessionID, 'fee_amount_setups.class_setup_id'=>$data->classId, 'fee_head_setups.status'=>0])
                ->join('fee_head_setups', 'fee_amount_setups.fee_head_setup_id', '=', 'fee_head_setups.id')
                ->select('fee_amount_setups.*', 'fee_head_setups.fee_head_name', 
                    'fee_head_setups.is_compulsory')->orderBy('fee_head_setups.order_by', 'ASC')
                ->get();
        return view('backend.feecollection.feecollections', compact('data', 'title', 'feeHead', 'studentClassAllotment'));
     }
     
    public function addCollectionInInvoice(Request $request) {
        
        if($request->input()){
            $monthNumber=$request->input('monthName');
            $stdClassAltId=base64_decode($request->input('stdClassAltId'));
            $dataArray=StudentClassAllotments::where('student_class_allotments.id', '=', $stdClassAltId)->select('student_class_allotments.*')->first();
            $collection = session()->get('collection', []); 
            //print_r($collection); exit;
            
            if(!empty($collection)){
                $InvoiceNo =$collection['InvoiceNo'];
            } else{
                $InvoiceNo =date('YmdHis');
                $collection=[
                    "InvoiceNo" =>date('YmdHis'),
                    "studentId" =>$dataArray->student_id,
                ];
            }
            
            foreach($request->input('headId') as $headDetails){
                $data = new FeeCollections;
                $data->unique_invoice_no   = $InvoiceNo;
                $data->student_id   = $dataArray->student_id;
                $data->session_setup_id     = $dataArray->session_id;
                $data->class_setup_id       = $dataArray->classsetup_id;
                $data->section_setup_id     = $dataArray->sectionsetup_id;
                $data->fee_amount_setup_id  = $headDetails;
                $data->amount    = getFeeHeadAmt($headDetails);
                $data->month_id        = $monthNumber;
                $data->created_by           = Auth::id();
                $data->save();
            }
            
            
                    
                   /*$feeAmt=0;
                        foreach($request->input('headId') as $headDetails){
                            $feeAmt=$feeAmt+getFeeHeadAmt($headDetails);
                         }
                       
                           $feecollection[$monthNumber] = [
                            "stutAllotmentClass"=>$request->input('stdClassAltId'),
                            "feeHeadID"=>[$request->input('headId')],
                            "monthlyAmt"=>$feeAmt
                        ];
                
                session()->put('feecollection', $feecollection, 500);*/
                session()->put('collection', $collection, 500);
                toastr()->success('Successfully added in invoice!', 'Congrats', ['positionClass' => "toast-top-full-width"]);
                return redirect()->back(); 
        }
        
    }
    
    public function removeFeeSession(Request $request, $studentId, $monthId, $sessionId)
    {
            FeeCollections::where(['student_id'=>$studentId, 
            'session_setup_id'=>$sessionId, 
            'month_id'=>$monthId,
            ])->delete();
            
            $collection = session()->get('collection'); 
            if(!empty($collection)){
                session()->forget('collection');
            } 
            
            toastr()->success('Removed successfully!', 'Congrats', ['positionClass' => "toast-top-full-width"]);
            return redirect()->back(); 
       
    }
     
    public function fee_invoice(Request $request, $studentClassAllotment) {
        $title="Generate Fee Invoice";
        $stdClasAltId=base64_decode($studentClassAllotment);
        $data = DB::table('student_class_allotments')
                ->where('student_class_allotments.id', '=', $stdClasAltId)
                ->join('class_section_mappings', 'student_class_allotments.class_maping_id', '=', 'class_section_mappings.id')
                ->join('students', 'student_class_allotments.student_id', '=', 'students.id')
                ->join('parents', 'students.parent_id', '=', 'parents.id')
                 ->join('session_setups', 'student_class_allotments.session_id', '=', 'session_setups.id')
                 ->join('section_setups', 'student_class_allotments.sectionsetup_id', '=', 'section_setups.id')
                ->join('class_setups', 'student_class_allotments.classsetup_id', '=', 'class_setups.id')
                 ->select('students.student_name', 'students.id', 'student_class_allotments.id as studentClassId',
                    'student_class_allotments.roll_no',  'session_setups.session_name', 'session_setups.id as SessionID',  
                    'class_setups.class_name', 'class_setups.id as classId', 'section_setups.section_name', 'section_setups.id as sectionId')
                ->first();
        $getOldBalance=getOldBalance($data->id , $data->SessionID, $data->classId, $data->sectionId);
        return view('backend.feecollection.fee_invoice', compact('title', 'studentClassAllotment', 'data', 'getOldBalance'));
     }
     
     public function generateinvoice(Request $request, $studentClassAllotment) {
        $title="Generate Fee Invoice";
        $stdClasAltId=base64_decode($studentClassAllotment);
        $data = DB::table('student_class_allotments')
                ->where('student_class_allotments.id', '=', $stdClasAltId)
                ->join('class_section_mappings', 'student_class_allotments.class_maping_id', '=', 'class_section_mappings.id')
                ->join('students', 'student_class_allotments.student_id', '=', 'students.id')
                ->join('parents', 'students.parent_id', '=', 'parents.id')
                 ->join('session_setups', 'student_class_allotments.session_id', '=', 'session_setups.id')
                 ->join('section_setups', 'student_class_allotments.sectionsetup_id', '=', 'section_setups.id')
                ->join('class_setups', 'student_class_allotments.classsetup_id', '=', 'class_setups.id')
                 ->select('students.student_name', 'students.id as studentId', 'student_class_allotments.id as studentClassId',
                    'student_class_allotments.roll_no',  'session_setups.session_name', 'session_setups.id as SessionID',  
                    'class_setups.class_name', 'class_setups.id as classId', 'section_setups.section_name', 'section_setups.id as SectionId')
                ->first();
            if($request->input()){
                $totalAmt=base64_decode($request->input('totalAmt'));
                $this->validate($request, [
                'receipt_no'=>'required|unique:invoices',
                'receipt_date'=>'required|before:tomorrow',
                'discount'=>'nullable|integer|lt:'.$totalAmt,
                //'totalAmt'=>'lt:200',
                ]);
                $collection = session()->get('collection');
                if(!empty($collection)){
                        $InvoiceNo =$collection['InvoiceNo'];
                } else{
                       FeeCollections::where(['student_id'=>$data->studentId, 'session_setup_id'=>$data->SessionID, 'class_setup_id'=>$data->classId, 'payment_status'=>0])->delete();
                       return redirect('student-list-for-fee-collection')->with('error',"Invoice number not generated, Please remove added month for fees and try again.");    
                }
              

                //$lateFee=$request->input('lateFees');
                $discount=$request->input('discount');
                $oldBalance=$request->input('oldBalance');

                $checkInvoice = DB::table('invoices')
                ->where(['invoice_no'=>$InvoiceNo, 
                'student_id'=>$data->studentId, 
                'session_id'=>$data->SessionID, 
                'class_id'=>$data->classId, 
                'section_id'=>$data->SectionId, 'total_amt'=>$totalAmt])
                ->where('invoices.status', '<>', '1')
                ->select('invoices.id')
                ->first();
                
                if(empty($checkInvoice)){
                    $data1 = new Invoices;
                    $data1->invoice_no   = $InvoiceNo;
                    $data1->receipt_no   = $request->input('receipt_no');
                    $data1->receipt_date   = date('Y-m-d H:i:s', strtotime($request->input('receipt_date')));
                    $data1->roll_no   = $data->roll_no;
                    $data1->student_id   = $data->studentId;
                    $data1->session_id     = $data->SessionID;
                    $data1->class_id       = $data->classId;
                    $data1->section_id     = $data->SectionId;
                    $data1->total_amt  = $totalAmt;
                    $data1->month_id  = $request->input('minthId');
                    //$data1->late_fee    = $lateFee;
                    $data1->discount        = $discount;
                    $data1->old_balance        = $oldBalance;
                    $data1->grand_total        = ($totalAmt+$oldBalance)-$discount;
                    $data1->payed_amt        = 0;
                    $data1->curent_balance        = 0;
                    $data1->remarks        = $request->input('remarks');
                    $data1->status         = 0;
                    $data1->created_by           = Auth::id();
                    $data1->save();
                }else{
                    $invID=$checkInvoice->id; 
                    $dataarray = array(
                            'late_fee'      => $request->input('lateFees'),
                            'discount'       => $request->input('discount'),
                            'remarks'            => $request->input('remarks'),
                        );
                    $saveData = Invoices::where('id', $invID)->update($dataarray);
                }
                
                $collection = session()->get('collection');
                if(!empty($collection)){
                    session()->forget('collection');
                }
                return redirect('recived-invoice/'.$InvoiceNo)->with('success',"You have successfully generated invoice");
            }
        
        
     }
     
     public function recived_invoice(Request $request, $invoiceNo) {
        $title="Recived Invoice Amount";
        if(!empty($collection)){
            session()->forget('collection');
        }
       $data = DB::table('invoices')
                ->where('invoices.invoice_no', '=', $invoiceNo)
                ->where('invoices.status', '<>', '1')
                ->join('students', 'invoices.student_id', '=', 'students.id')
                ->join('parents', 'students.parent_id', '=', 'parents.id')
                 ->join('session_setups', 'invoices.session_id', '=', 'session_setups.id')
                 ->join('section_setups', 'invoices.section_id', '=', 'section_setups.id')
                ->join('class_setups', 'invoices.class_id', '=', 'class_setups.id')
                 ->select('invoices.*','students.student_name', 'students.id as studentId', 
                    'invoices.roll_no',  'session_setups.session_name', 'session_setups.id as SessionID',  
                    'class_setups.class_name', 'class_setups.id as classId', 'section_setups.section_name', 'section_setups.id as SectionId')
                ->first();

         if(empty($data)){
            return redirect('student-list-for-fee-collection')->with('error',"Something Wrong");  
        }    

        if($request->input()){
            $grandTotal=$data->grand_total;
                $this->validate($request, [
                  'received_amount'=>'required|integer|lte:'.$grandTotal,
                  'receipt_no'=>'required|unique:invoices,receipt_no,'.$data->id,
                  'receipt_date'=>'required|before:tomorrow',
                ]);
               
                $recivedAmt=$request->input('received_amount');
                $dataarray = array(
                    'receipt_date'  =>date('Y-m-d H:i:s', strtotime($request->input('receipt_date'))),
                    'receipt_no'    =>$request->input('receipt_no'),
                    'payed_amt'     =>$recivedAmt,
                    'curent_balance'       => $grandTotal-$recivedAmt,
                    'status'       =>1,
                    'created_by'            =>Auth::id(),
                );
                
                if(!empty($collection)){
                    if($collection['studentId']!=getStudentIdByClassAllotmentId(base64_decode($studentClassAllotment))){
                        session()->forget('collection');
                    }
                }
                Invoices::where('invoice_no', $invoiceNo)->update($dataarray);
                FeeCollections::where('unique_invoice_no', $invoiceNo)->update(['payment_status'=>1]);
                //return redirect('fee-invoice-pdf/'.$invoiceNo)->with('error',"You have successfully generated invoice");
                return redirect('fee-invoice-download/'.$invoiceNo)->with('success',"You have successfully generated invoice");
            }
        
        return view('backend.feecollection.recived_invoice', compact('title', 'data', 'invoiceNo'));
     }
     
    public function fee_invoice_pdf(Request $request, $invoiceNo) {
        $title="Print Fee Invoice";
       $data = DB::table('invoices')
                ->where('invoices.invoice_no', '=', $invoiceNo)
                ->join('students', 'invoices.student_id', '=', 'students.id')
                ->join('parents', 'students.parent_id', '=', 'parents.id')
                 ->join('session_setups', 'invoices.session_id', '=', 'session_setups.id')
                 ->join('section_setups', 'invoices.section_id', '=', 'section_setups.id')
                ->join('class_setups', 'invoices.class_id', '=', 'class_setups.id')
                ->join('users', 'invoices.created_by', '=', 'users.id')
                 ->select('invoices.*','students.student_name', 'students.admission_no',  'parents.father_name', 'students.id as studentId', 
                    'invoices.roll_no',  'session_setups.session_name', 'session_setups.id as SessionID',  
                    'class_setups.class_name', 'class_setups.id as classId', 'section_setups.section_name', 'section_setups.id as SectionId', 'users.name')
                ->first();
         $pdf = PDF::loadView('backend.pdf.fee_invoice_pdf', ['data'=>$data, 'invoiceNo'=>$invoiceNo])->setPaper('a4', 'landscape');; 
         return $pdf->download($data->student_name.'-invoice.pdf');
         if(empty($data)){
            return redirect('student-list-for-fee-collection')->with('error',"Something Wrong");  
        }    

        //return view('backend.pdf.fee_invoice_pdf', compact('title', 'data', 'invoiceNo'));
     }
     
     public function fee_invoice_download(Request $request, $invoiceNo) {
        $title="Download Fee Invoice";
       $data = DB::table('invoices')
                ->where('invoices.invoice_no', '=', $invoiceNo)
                ->join('students', 'invoices.student_id', '=', 'students.id')
                ->join('parents', 'students.parent_id', '=', 'parents.id')
                 ->join('session_setups', 'invoices.session_id', '=', 'session_setups.id')
                 ->join('section_setups', 'invoices.section_id', '=', 'section_setups.id')
                ->join('class_setups', 'invoices.class_id', '=', 'class_setups.id')
                ->join('users', 'invoices.created_by', '=', 'users.id')
                 ->select('invoices.*','students.student_name', 'students.admission_no',  'parents.father_name', 'students.id as studentId', 
                    'invoices.roll_no',  'session_setups.session_name', 'session_setups.id as SessionID',  
                    'class_setups.class_name', 'class_setups.id as classId', 'section_setups.section_name', 'section_setups.id as SectionId', 'users.name')
                ->first();

         if(empty($data)){
            return redirect('student-list-for-fee-collection')->with('error',"Something Wrong");  
        }    
        

        return view('backend.feecollection.fee_invoice_download', compact('title', 'data', 'invoiceNo'));
     }
     
     public function fee_invoice_list(Request $request) {
        $title='Fee Collection Invoice ';
        return view('backend.feecollection.fee_invoice_list', compact('title'));
     }

    public function feeinvoicelistdatatable(){
            $data = DB::table('invoices')->select('invoices.*','students.student_name', 'students.admission_no',  'parents.father_name', 'students.id as studentId', 
                    'invoices.roll_no',  'session_setups.session_name', 'session_setups.id as SessionID',  
                    'class_setups.class_name', 'class_setups.id as classId', 'section_setups.section_name', 'section_setups.id as SectionId', 'users.name')
                    ->join('students', 'invoices.student_id', '=', 'students.id')
                    ->join('parents', 'students.parent_id', '=', 'parents.id')
                    ->join('session_setups', 'invoices.session_id', '=', 'session_setups.id')
                    ->join('section_setups', 'invoices.section_id', '=', 'section_setups.id')
                    ->join('class_setups', 'invoices.class_id', '=', 'class_setups.id')
                    ->join('users', 'invoices.created_by', '=', 'users.id')->orderBy('invoices.id', 'desc');
            $result=$data->get();
            return datatables()->of($result)
            ->addColumn('action', function ($result) {
                    return view('backend.feecollection.action_fee_invoice_list', ['id' => base64_encode($result->id),
                    'invoice_no'=>$result->invoice_no, 'status'=>$result->status, 
                    'studentId'=>base64_encode($result->student_id), 'created_date'=>$result->created_at]);
                })
           ->editColumn('created_at', function ($result) {
                    return Carbon::parse($result->created_at)->diffForHumans();
            })
            
            ->make(true);
    }
    
    public function removeInvoice(Request $request, $invoiceNo) {
            FeeCollections::where(['unique_invoice_no'=>$invoiceNo])->delete();
            Invoices::where(['invoice_no'=>$invoiceNo])->delete(); 
            
            toastr()->success('Removed successfully!', 'Congrats', ['positionClass' => "toast-top-full-width"]);
            return redirect()->back(); 
       
    }
    
    public function fee_invoice_for_parents(Request $request, $invoiceNo) {
        $title="Print Fee Invoice";
       $data = DB::table('invoices')
                ->where('invoices.invoice_no', '=', $invoiceNo)
                ->join('students', 'invoices.student_id', '=', 'students.id')
                ->join('parents', 'students.parent_id', '=', 'parents.id')
                 ->join('session_setups', 'invoices.session_id', '=', 'session_setups.id')
                 ->join('section_setups', 'invoices.section_id', '=', 'section_setups.id')
                ->join('class_setups', 'invoices.class_id', '=', 'class_setups.id')
                ->join('users', 'invoices.created_by', '=', 'users.id')
                 ->select('invoices.*','students.student_name', 'students.admission_no',  'parents.father_name', 'students.id as studentId', 
                    'invoices.roll_no',  'session_setups.session_name', 'session_setups.id as SessionID',  
                    'class_setups.class_name', 'class_setups.id as classId', 'section_setups.section_name', 'section_setups.id as SectionId', 'users.name')
                ->first();
         $pdf = PDF::loadView('backend.pdf.fee_invoice_parentd_pdf', ['data'=>$data, 'invoiceNo'=>$invoiceNo])->setPaper('a4', 'portrait');; 
         return $pdf->download($data->student_name.'-invoice.pdf');
         
         //return view('backend.pdf.fee_invoice_parentd_pdf', compact('title', 'data', 'invoiceNo'));
     }
     
     
     
}
