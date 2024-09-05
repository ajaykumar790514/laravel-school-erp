<?php

namespace App\Exports;
use App\Models\Students;
use App\Models\Parents;
use App\Models\SessionSetups;
use App\Models\ClassSetups;
use App\Models\Religions;
use App\Models\CastCategorySetups;
use App\Models\Cities;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class HeadWiseReportExport implements FromView
{
    use Exportable;

    public function __construct($fromDate, $toDate, $classId=null)
    {
        $this->fromDate = $fromDate;
         $this->toDate = $toDate;
        $this->classId = $classId;
    }
    
    public function view(): View
    {

       if($this->fromDate!="" && $this->toDate!=""){
         $class_id=  $this->classId;
         $data = DB::table('invoices')->select('invoices.*','students.student_name', 'students.admission_no',  'parents.father_name', 'students.id as studentId', 
                    'invoices.roll_no', 'class_setups.class_name', 'class_setups.id as classId', 'section_setups.section_name', 'section_setups.id as SectionId', 'users.name')
                    ->whereBetween('invoices.receipt_date', [$this->fromDate, $this->toDate])
                    ->join('students', 'invoices.student_id', '=', 'students.id')
                    ->join('parents', 'students.parent_id', '=', 'parents.id')
                    ->join('section_setups', 'invoices.section_id', '=', 'section_setups.id')
                    ->join('class_setups', 'invoices.class_id', '=', 'class_setups.id')
                    ->join('users', 'invoices.created_by', '=', 'users.id')
                    ->when($class_id, function ($query, $class_id) {
                        return $query->where('invoices.class_id', $class_id);
                    })
                    ->orderBy('invoices.id', 'desc')->get();
                    $sum_payed_amt = $data->sum('payed_amt');
       } else { //All data 
           $class_id=  $this->classId;
            $data = DB::table('invoices')->select('invoices.*','students.student_name', 'students.admission_no',  'parents.father_name', 'students.id as studentId', 
                    'invoices.roll_no', 'class_setups.class_name', 'class_setups.id as classId', 'section_setups.section_name', 'section_setups.id as SectionId', 'users.name')
                    //->orWhere('invoices.class_id', '=', $class_id)
                    //->whereBetween('invoices.receipt_date', [$this->fromDate, $this->toDate])
                    ->join('students', 'invoices.student_id', '=', 'students.id')
                    ->join('parents', 'students.parent_id', '=', 'parents.id')
                    ->join('section_setups', 'invoices.section_id', '=', 'section_setups.id')
                    ->join('class_setups', 'invoices.class_id', '=', 'class_setups.id')
                    ->join('users', 'invoices.created_by', '=', 'users.id')
                    ->when($class_id, function ($query, $class_id) {
                        return $query->where('invoices.class_id', $class_id);
                    })
                    ->orderBy('invoices.id', 'desc')->get();
                    $sum_payed_amt = $data->sum('payed_amt');
       }
       
      
              
        return view('backend.exports.head_wise_collection', [
            'data'=>$data,
            'fromDate'=>$this->fromDate,
            'toDate'=>$this->toDate,
            'sum_payed_amt'=>$sum_payed_amt
            
        ]);
    }
}
