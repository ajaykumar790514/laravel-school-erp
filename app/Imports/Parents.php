<?php

namespace App\Imports;

use App\Models\Parents;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;

class Parents implements ToCollection , WithHeadingRow, SkipsOnError, WithValidation, SkipsOnFailure
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
            echo $row['admission_no'];
                
            
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
