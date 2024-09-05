<?php

namespace App\Exports;
use App\Models\Students;
use App\Models\Parents;
use App\Models\SessionSetups;
use App\Models\ClassSetups;
use App\Models\Religions;
use App\Models\CastCategorySetups;
use App\Models\Cities;
use App\Models\StudentClassAllotments;
use App\Models\SectionSetups;
use App\Models\ClassTeacherSetups;
use App\Models\Employees;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class MonthWisePendingFeeExport implements FromView
{
    use Exportable;

    public function __construct($month, $sessionID, $classID)
    {
        $this->month = $month;
         $this->sessionID = $sessionID;
        $this->classID = $classID;
    }
    
    public function view(): View
    {
        $month=  $this->month;
        $sessionID = $this->sessionID;
        $classID = $this->classID;
        $data =  $data = DB::table('student_class_allotments')
                    //->where('student_class_allotments.session_id', $sessionId)
                    ->where('student_class_allotments.session_id', $sessionID)
                    ->where('student_class_allotments.classsetup_id', $classID)
                    ->whereNotIn('student_class_allotments.student_id', function ($query) use ($month, $sessionID, $classID) {
                        $query->select('student_id')
                            ->from('fee_collections')
                            ->where('month_id', $month)
                            ->where('payment_status', 1)
                            ->where('session_setup_id', $sessionID)
                            ->where('class_setup_id', $classID);;
                    })
                     ->join('students', 'student_class_allotments.student_id', '=', 'students.id')
             ->join('parents', 'students.parent_id', '=', 'parents.id')
             ->join('session_setups', 'student_class_allotments.session_id', '=', 'session_setups.id')
             ->join('class_setups', 'student_class_allotments.classsetup_id', '=', 'class_setups.id')
             ->join('section_setups', 'student_class_allotments.sectionsetup_id', '=', 'section_setups.id')
             ->select('students.*','parents.father_name', 'parents.mothers_name', 'parents.father_mobile_no', 'section_setups.section_name',
             'session_setups.session_name', 'class_setups.class_name', 'student_class_allotments.created_at', 
             'student_class_allotments.roll_no', 'student_class_allotments.id as studentAllmentId',  
             'student_class_allotments.action_type' ,  'student_class_allotments.performeance_status')
             ->orderBy('students.student_name', 'asc')->get();
       
              
        return view('backend.exports.export_month_wise_pending_fee', [
            'data'=>$data,
            'month'=>$this->month
        ]);
    }
}
