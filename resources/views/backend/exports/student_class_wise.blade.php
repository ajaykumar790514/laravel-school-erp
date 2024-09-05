<table>
    <thead>
    <tr>
        <th>Admission No.</th>
        <th>Roll No.</th>
        <th>Session</th>
        <th>New/Old</th>
        <th>Reg. Date</th>
        <th>Class</th>
        <th>Section</th>
        <th>Student Name</th>
        <th>Father Name</th>
        <th>Father Mobile</th>
        <th>Father Email</th>
        <th>Mother Name</th>
        <th>Mother Mobile</th>
        <th>Address</th>
        <th>City</th>
        <th>State</th>
        <th>Category</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $student)
        <tr>
            <th>{{ $student->admission_no }}</th>
            <th>{{ $student->roll_no }}</th>
            <th>{{ $student->session_name }}</th>
            <th>{{ $student->action_type==0?"New":"Old" }}</th>
            <th>{{ $student->reg_date!="1970-01-01"?date('d F Y', strtotime($student->reg_date)):"" }}</th>
            <th>{{ $student->class_name }}</th>
            <th>{{ $student->section_name }}</th>
            <th>{{ $student->student_name }}</th>
            <th>{{ $student->father_name }}</th>
            <th>{{ $student->father_mobile_no }}</th>
            <th>{{ $student->father_email }}</th>
            <th>{{ $student->mothers_name }}</th>
            <th>{{ $student->mother_mobile_no }}</th>
            <th>{{ $student->address }}</th>
            <th>{{ $student->city }}</th>
            <th>{{ $student->state }}</th>
            <th>{{ getStdCat($student->cast_category_setups_id)}}</th>
            
        </tr>
    @endforeach
    </tbody>
</table>