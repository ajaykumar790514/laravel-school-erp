<table class="table table-responsive">
  <thead>
   <tr role="row">
     <th>Receipt No.</th>
     <th>Receipt Date</th>
     <th>Name</th>
     <th>Father Name</th>
     <th>Class</th>
     <th>Total Amount</th>
     <th>Received Amount</th>
     <th>Balance</th>
     <th>Action</th>
  </tr>
  </thead>
  <tbody>
   @if(count($data)>0)
               @foreach($data as $dataDetails)
               <?php $invoiceID=base64_encode($dataDetails->invoice_no);?>
                <tr role="row">
                     <td>{{$dataDetails->receipt_no}}</td>
                     <td>{{date('d F Y', strtotime($dataDetails->receipt_date))}}</td>
                     <td>{{$dataDetails->student_name}}</td>
                     <td>{{$dataDetails->father_name}}</td>
                     <td>{{$dataDetails->class_name}}</td>
                     <td>Rs.{{$dataDetails->grand_total}}/-</td>
                     <td>Rs.{{$dataDetails->payed_amt}}/-</td>
                     <td>Rs.{{$dataDetails->curent_balance}}/-</td>
                     <td>
                        <ul class="icons-list">
                            <li class="dropdown">
                            	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            		<i class="icon-menu9"></i>
                            	</a>
                            	<ul class="dropdown-menu dropdown-menu-right">
                            	    @if($dataDetails->status==1)
                            		<li><a class="" href='{{url("parents/fee-invoice-for-parents-pdf/{$dataDetails->invoice_no}")}}'><i class="icon-download"></i> Download</a></li>
                            		@endif
                                    
                            	</ul>
                                </li>
                            </ul> 
                         
                     </td>
              </tr>
                @endforeach 
            @endif
  </tbody>
</table>