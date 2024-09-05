<!DOCTYPE html>
<html>
<head>
    <title>School Fee Collection Invoice</title>
	<!-- Global stylesheets -->
	<!-- /global stylesheets -->

    <style>
    @page { margin-top: 5px; }
    html { margin: 5px}
        body {
            font-family: Arial, sans-serif;
             font-family: 'arial';
            font-size:12px!important;
            margin:0px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            align-self: center;
            margin:0px;
            
        }
        th, td {
            border: 0px solid black;
            padding: 2px;
            text-align: left;
        }
        th {
            font-weight: bold;
        }
        .invoice-header {
            display: flex;
            justify-content: space-between;
        }
        .invoice-header h1 {
            margin-top: 0;
        }
        .invoice-details {
            margin-top: 10px;
        }
        .invoice-details p {
            margin: 5px 0;
        }
        .invoice-footer {
            margin-top: 20px;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="content" style="margin-left:50px:margin-right:50px; margin-top:10px; text-align: center;">
        <table>
            <tr>
                <td style="padding-right:80px; padding-left:80px; vertical-align: top;">
                     <table>
                        <tr>
                            <td style="text-align:right">Student Copy</td>
                        </tr>
                        <tr>
                            <td style="text-align:center">
                                <img width="70" src="{{ asset(getSiteLogo()) }}" alt="{{ config('app.name', '') }}">
                                <h3 class="no-margin text-thin" style="height:0px; font-size:12px">{{strtoupper("(Managed By Shri Omar Vaishya Vidyalaya Commitee)")}}</h3></td>
                        </tr>
                        <tr>
                            <td style="text-align:center;padding-top:0px"><h3 class="no-margin text-semibold" style="height:0px; font-size:14px">{{getsiteTitle()}}</h3>
                            {{getaddress()}}, Mobile:{{getMobile()}}
                            <hr>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align:center">
                                <table>
                                    <tr>
                                        <th>Receipt No. </th>
                                        <td>{{$data->receipt_no}}</td>
                                        <th>Date</th>
                                        <td>{{date('d F Y H:i:s', strtotime($data->receipt_date))}}</td>
                                    </tr>
                                    <tr>
                                        <th>Name/Roll No.</th>
                                        <td>{{$data->student_name}}/{{$data->roll_no}}</td>
                                        <th>Father Name</th>
                                        <td>{{$data->father_name}}</td>
                                    </tr>
                                    <tr>
                                        <th>Reg.No./Session</th>
                                        <td>{{$data->admission_no}}/{{$data->session_name}}</td>
                                        <th>Class/Section</th>
                                        <td>{{$data->class_name}}/{{$data->section_name}}</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
            <tr>
                <td>
                  <table>
                            <tr style="border: 1px solid black;">
                                <th>Description</th>
                                <th>Amount</th>
                            </tr>
                            @foreach(getMonthFeeCollectionforPDF($data->studentId, $data->SessionID, $data->classId, $data->SectionId, $invoiceNo) as $feeCollectionDetails)
                            <tr>
                                <td>
                                <?php
                                 
                                  if($feeCollectionDetails->month_id==4){
                                      echo "<strong>April</strong>";
                                  }
                                  if($feeCollectionDetails->month_id==5){
                                      echo "<strong>May</strong>";
                                  }
                                  if($feeCollectionDetails->month_id==6){
                                      echo "<strong>June</strong>";
                                  }
                                  if($feeCollectionDetails->month_id==7){
                                      echo "<strong>July</strong>";
                                  }
                                  if($feeCollectionDetails->month_id==8){
                                      echo "<strong>Aug</strong>";
                                  }
                                  if($feeCollectionDetails->month_id==9){
                                      echo "<strong>Sep</strong>";
                                  }
                                  if($feeCollectionDetails->month_id==10){
                                      echo "<strong>Oct</strong>";
                                  }
                                  if($feeCollectionDetails->month_id==11){
                                      echo "<strong>Nov</strong>";
                                  }
                                  if($feeCollectionDetails->month_id==12){
                                      echo "<strong>Dec</strong>";
                                  }
                                  if($feeCollectionDetails->month_id==1){
                                      echo "<strong>Jan</strong>";
                                  }
                                  if($feeCollectionDetails->month_id==2){
                                      echo "<strong>Feb</strong>";
                                  }
                                  if($feeCollectionDetails->month_id==3){
                                      echo "<strong>March</strong>";
                                  }
                                ?>
                                </td>
                                <td>
                                    <?php 
                                    $total=0;
                                     $feecollection=app\Models\FeeCollections::where(['student_id'=>$data->studentId, 
                                        'session_setup_id'=>$data->SessionID, 
                                        'class_setup_id'=>$data->classId, 
                                        'month_id'=>$feeCollectionDetails->month_id,
                                        'section_setup_id'=>$data->SectionId])->get();?>
                                    @foreach($feecollection as $collectionHeadDetails)
                                    <?php $total=$total+getFeeHeadAmt($collectionHeadDetails->fee_amount_setup_id);?>
                                    
                                    @endforeach
                                    
                                    Rs. {{$total}}/-</strong></td>
                                
                            </tr>

                    @endforeach
                     <tr>
                        <td><strong>Total</strong></td>
                        <td><strong>Rs. {{$data->total_amt}}/-</strong></td>
                    </tr>
                    <tr>
                        <td>Old Balance (+)</td>
                        <td>Rs. {{$data->old_balance}}/- </td>
                    </tr>
                    
                    <tr>
                        <td>Concession(-)</td>
                        <td>Rs. {{$data->discount}}/-</td>
                    </tr>
                    <tr>
                        <td>Remarks</td>
                        <td>{{$data->remarks}}</td>
                    </tr>
                    <tr>
                        <td><strong>Grand Total</strong></td>
                        <td><strong>Rs. {{$data->grand_total}}/-</strong></td>
                    </tr>
                    <tr>
                        <td><strong>Recived Amount</strong></td>
                        <td>Rs. {{$data->payed_amt}}/-</td>
                    </tr>
                    <tr>
                        <td><strong>Balance</strong></td>
                        <td>Rs. {{$data->curent_balance}}/-</td>
                    </tr>
                </table>  
                </td>
            </tr>
            <tr>
                <td><hr></td>
            </tr>
            <tr>
                <td style="text-align:center">
                    <table>
                        <tr>
                            <th>Amount in words :<br> {{strtoupper(amountToWord($data->grand_total))}}</th>
                            <th stle="text-align:right">Prepared By </th>
                            <td>{{$data->name}}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
