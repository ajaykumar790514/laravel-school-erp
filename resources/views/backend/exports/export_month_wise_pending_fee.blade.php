 <table>
	<thead class="thead-dark">
	    <tr>
	        <td colspan="5" style="text-align: center; font-weight: bold;">Student List for Pending Fees of month {{getMonthNameById($month)}}</td>
	    </tr>
      <tr role="row">
         <th>Admission No</th>
         <th>Roll No. </th>
         <th>Class</th>
         <th>Name</th>
         <th>Father Name</th>
         <th>Mobile</th>
         <th>Gender</th>
      </tr>
    </thead>

	<tbody>
	     @if(count($data)>0)
           @foreach($data as $dataDetails)
               <?php $studentClassAttment=base64_encode($dataDetails->studentAllmentId);?>
                <tr role="row">
                     <td>{{$dataDetails->admission_no}}</td>
                    <td>{{$dataDetails->roll_no}}</td>
                    <td>{{$dataDetails->class_name}}</td>
                     <td>{{$dataDetails->student_name}}</td>
                     <td>{{$dataDetails->father_name}}</td>
                     <td>{{$dataDetails->father_mobile_no}}</td>
                     <td>{{$dataDetails->gender==0?"Male":"Female"}}</td>
              </tr>
            @endforeach 
        @endif
	</tbody>
</table>