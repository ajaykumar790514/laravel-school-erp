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

class ClassWiseFeeCollectionExport implements FromView
{
    use Exportable;

    public function __construct($sessionID, $classID, $sectionID)
    {
        $this->sessionID = $sessionID;
         $this->classID = $classID;
        $this->sectionID = $sectionID;
    }
    
    public function view(): View
    {
        $data = StudentClassAllotments::where(['student_class_allotments.session_id'=>$this->sessionID, 'student_class_allotments.classsetup_id'=>$this->classID,
        'student_class_allotments.sectionsetup_id'=>$this->sectionID])
         ->join('students', 'student_class_allotments.student_id', '=', 'students.id')
            ->join('class_setups', 'student_class_allotments.classsetup_id', '=', 'class_setups.id')
            ->join('section_setups', 'student_class_allotments.sectionsetup_id', '=', 'section_setups.id')
           ->select('students.student_name', 'students.id', 'student_class_allotments.classsetup_id')
           //->where(['student_class_allotments.student_id'=>'19473'])
          // ->select('students.student_name', 'students.id', 'student_class_allotments.classsetup_id', 'student_class_allotments.sectionsetup_id')
           ->orderBy('students.student_name', 'asc')
           ->get();
           $className=ClassSetups::where(['id'=>$this->classID])->value('class_name');
           $sessionName=SessionSetups::where(['id'=>$this->sessionID])->value('session_name');
           $sectionName=SectionSetups::where(['id'=>$this->sectionID ])->value('section_name');
           $teacherID=ClassTeacherSetups::where(['session_id'=>$this->sessionID, 'class_id'=>$this->classID, 'section_id'=>$this->sectionID ])->value('teacher_id');
           $teacher=Employees::where(['id'=>$teacherID])->value('employee_name');
       
              
        return view('backend.exports.class_wise_collection_report', [
            'data'=>$data,
            'className'=>$className,
            'sessionName'=>$sessionName,
            'sectionName'=>$sectionName,
            'teacher'=>$teacher,
            'sessionID'=>$this->sessionID,
            'classID'=>$this->classID
            
        ]);
    }
}
