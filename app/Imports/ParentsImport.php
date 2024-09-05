<?php

namespace App\Imports;

use App\Models\Parents;
use App\Models\Students;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Illuminate\Support\Facades\Auth;

class ParentsImport implements ToCollection , WithHeadingRow, SkipsOnError, WithValidation, SkipsOnFailure
{
    use Importable, SkipsErrors, skipsFailures;
    
    private $countRecord = 0;
    private $insertCountRecord = 0;
    public $divisioncodecheck;
    public $billingDatecheck;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
     public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $this->countRecord++;
            $datarow=array();
            $this->insertCountRecord++;
            $parentsCunt=Parents::where(['father_mobile_no'=>$row['father_mobile_no'], 'father_name'=>$row['father_name']])->first();
            //if(empty($parentsCunt)){
                 $data1 = new Parents;
                 $data1->father_name               = $row['father_name'];
                 $data1->father_dob                = date('Y-m-d', strtotime($row['father_dob']));
                 $data1->father_occupation         = $row['father_occupation'];
                 $data1->father_qualification      = $row['father_qualification'];
                 $data1->father_mobile_no          = $row['father_mobile_no'];
                 $data1->father_whatsapp_mobile    = $row['father_whatsapp_mobile'];
                 $data1->fathere_income            = $row['fathere_income'];
                 $data1->father_email              = $row['father_email'];
                 $data1->mothers_name              = $row['mothers_name'];
                 $data1->mother_dob                = date('Y-m-d', strtotime($row['mother_dob']));
                $data1->mother_occup              = $row['mother_occup'];
                $data1->mother_qalification       = $row['mother_qalification'];
                $data1->mother_mobile_no          = $row['mother_mobile_no'];
                $data1->mother_whatsapp_no        = $row['mother_whatsapp_no'];
                $data1->guardian_name             = $row['guardian_name'];
                $data1->guardian_occupation       = $row['guardian_occupation'];
                $data1->guardian_qualification    = $row['guardian_qualification'];
                $data1->guardian_mobile           =$row['guardian_mobile'];
                $data1->address                   =$row['address'];
                $data1->city                      =$row['city'];
                $data1->state                    = $row['state'];
                $data1->country                   = $row['country'];
                $data1->relatives_first_name      = $row['relatives_first_name'];
                $data1->relative_first_class      = $row['relative_first_class'];
                $data1->relative_second_name      = $row['relative_second_name'];
                $data1->relative_second_class     = $row['relative_second_class'];
                $data1->users_id                  = Auth::id();
                if(empty($parentsCunt)){
                    $reply=$data1->save();
                }    
                //$data1->id."<br>";
                //Student 
                    $data = new Students;
                    $data->admission_no             = $row['admission_no'];
                    $data->reg_date                 = date('Y-m-d', strtotime($row['reg_date']));
                    $data->session_id               = $row['session_id'];
                    $data->class_id                 = $row['class_id'];
                    $data->parent_id                = $parentsCunt==''?$data1->id:$parentsCunt->id;
                    $data->student_name             = $row['student_name'];
                    $data->dob                      = date('Y-m-d', strtotime($row['dob']));
                    $data->gender                   = $row['gender']=="Male"?"0":"1";
                    $data->religions_id             = $row['religions_id'];
                    $data->cast_category_setups_id  = $row['cast_category_setups_id'];
                    $data->last_attended_class      = $row['last_attended_class'];
                    $data->last_attended_school     = $row['last_attended_school'];
                    $data->blood_group              = $row['blood_group'];
                    $data->mark_identification      = $row['mark_identification'];
                    $data->route                    = $row['route'];
                    $data->scholarship_no           = $row['scholarship_no'];
                    $data->users_id                 = Auth::id();
                    $data->save();
            /*} else{
                $data = new Students;
                    $data->admission_no             = $row['admission_no'];
                    $data->reg_date                 = date('Y-m-d', strtotime($row['reg_date']));
                    $data->session_id               = $row['session_id'];
                    $data->class_id                 = $row['class_id'];
                    $data->parent_id                = $parentsCunt->id;
                    $data->student_name             = $row['student_name'];
                    $data->dob                      = date('Y-m-d', strtotime($row['dob']));
                    $data->gender                   = $row['gender']=="Male"?"0":"1";
                    $data->religions_id             = $row['religions_id'];
                    $data->cast_category_setups_id  = $row['cast_category_setups_id'];
                    $data->last_attended_class      = $row['last_attended_class'];
                    $data->last_attended_school     = $row['last_attended_school'];
                    $data->blood_group              = $row['blood_group'];
                    $data->mark_identification      = $row['mark_identification'];
                    $data->route                    = $row['route'];
                    $data->scholarship_no           = $row['scholarship_no'];
                    $data->users_id                 = Auth::id();
                    $data->save();
            }*/
                
            
        }
        

    }
    public function getRowCount(): int
    {
        return $this->countRecord;
    }
    
    public function getInsertRowCount(): int
    {
        return $this->insertCountRecord;
    }
    
    public function rules(): array
    {
        return [
          //  '.*decoms_id'=>['required'],

        ];
    }
}
