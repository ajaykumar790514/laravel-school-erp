<?php

namespace App\Widgets;
use Illuminate\Support\Facades\DB;

use Arrilot\Widgets\AbstractWidget;

class FeeTransactions extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [
        'count' =>10
        ];
        
    public function placeholder()
    {
        return 'Loading...';
    }
    public $reloadTimeout = 10;

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $data=DB::table('invoices')->select('invoices.*','students.student_name', 'students.admission_no',  'parents.father_name', 'students.id as studentId', 
                    'invoices.roll_no', 'class_setups.class_name', 'class_setups.id as classId', 'section_setups.section_name', 'section_setups.id as SectionId', 'users.name')
                    ->join('students', 'invoices.student_id', '=', 'students.id')
                    ->join('parents', 'students.parent_id', '=', 'parents.id')
                    ->join('section_setups', 'invoices.section_id', '=', 'section_setups.id')
                    ->join('class_setups', 'invoices.class_id', '=', 'class_setups.id')
                    ->join('users', 'invoices.created_by', '=', 'users.id')->orderBy('invoices.id', 'desc')->limit(10)->get();

        return view('widgets.fee_transactions', [
            'config' => $this->config,
            'data'=>$data
        ]);
    }
}
