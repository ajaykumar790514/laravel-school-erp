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

class StudentsAllExport implements FromView
{
    use Exportable;

   
    public function view(): View
    {
       
         $data = DB::table('student_class_allotments')
            ->join('students', 'student_class_allotments.student_id', '=', 'students.id')
             ->join('parents', 'students.parent_id', '=', 'parents.id')
             ->join('session_setups', 'student_class_allotments.session_id', '=', 'session_setups.id') 
             ->join('class_setups', 'student_class_allotments.classsetup_id', '=', 'class_setups.id')
             ->join('section_setups', 'student_class_allotments.sectionsetup_id', '=', 'section_setups.id')
             ->select('students.*','parents.father_name', 'parents.father_mobile_no', 'parents.father_email', 'parents.mothers_name', 'parents.mother_mobile_no', 
             'parents.address', 'parents.city', 'parents.state', 'section_setups.section_name',
             'session_setups.session_name', 'class_setups.class_name', 'student_class_allotments.created_at', 
             'student_class_allotments.roll_no', 'student_class_allotments.id as studentAllmentId',  
             'student_class_allotments.action_type' ,  'student_class_allotments.performeance_status', 'students.cast_category_setups_id')
             ->orderBy('students.student_name', 'asc')
             ->get();;

        return view('backend.exports.student_class_wise', [
            'data' =>$data
        ]);
    }
}
