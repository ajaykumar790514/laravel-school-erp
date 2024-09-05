@extends('layouts.admin-theme')
@section('content')
<style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .invoice-header {
            display: flex;
            justify-content: space-between;
        }
        .invoice-header h1 {
            margin-top: 0;
        }
        .invoice-details {
            margin-top: 20px;
        }
        .invoice-details p {
            margin: 5px 0;
        }
        .invoice-footer {
            margin-top: 20px;
            text-align: right;
        }
    </style>
   
<div class="page-header page-header-default">
      <div class="page-header-content">
        <div class="page-title">
          <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Fees Module </span> ->Menu->Receive Invoice</h4>
        </div>
      </div>
</div>
<div class="content">
        <!-- 2 columns form -->
        <div class="panel panel-flat">
                @include('layouts.massage') 
                 @include('layouts.validation-error') 
                <div class="panel-heading">
                    <div class="heading-elements">
                        <ul class="icons-list">
                            <li><a data-action="collapse"></a></li>
                            <li><a data-action="close"></a></li>
                        </ul>
                    </div>
                </div>
                <div class="panel-body">
                   <div class="row">
                        <div class="col-md-3">
                            <fieldset>
                                <div class="form-group{{ $errors->has('session_id') ? ' has-error' : '' }}">
                                    <label class"text-semibold">Student Name/Roll No.</label>
                                    <h6 class"text-semibold">{{$data->student_name}}/{{$data->roll_no}}</h6>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-md-3">
                            <fieldset>
                               <div class="form-group{{ $errors->has('class_maping_id') ? ' has-error' : '' }}">
                                <label>Session</label>
                                 <h6>{{$data->session_name}}</h6>
                              </div>
                            </fieldset>
                        </div>
                        <div class="col-md-3">
                            <fieldset>
                               <div class="form-group{{ $errors->has('section_id') ? ' has-error' : '' }}">
                                <label>Class</label>
                                <h6>{{$data->class_name}}</h6>
                              </div>
                            </fieldset>
                        </div>
                        <div class="col-md-3">
                            <fieldset>
                               <div class="form-group{{ $errors->has('section_id') ? ' has-error' : '' }}">
                                <label>Section</label>
                                <h6>{{$data->section_name}}</h6>
                              </div>
                            </fieldset>
                        </div>
                    </div>
                    <form class="" method="POST" action='{{ url("recived-invoice/{$invoiceNo}")}}'>
                         {{ csrf_field() }}
                        <table>
                            <tr>
                                <th>Description</th>
                                <th>Amount</th>
                            </tr>
                            <?php $totalAmt=0;?>
                            @foreach(getMonthFeeCollection($data->studentId, $data->SessionID, $data->classId, $data->SectionId) as $feeCollectionDetails)
                            <tr>
                                <td colspan="2">
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
                                
                            </tr>
                             <?php 
                             $feecollection=app\Models\FeeCollections::where(['student_id'=>$data->studentId, 
                                'session_setup_id'=>$data->SessionID, 
                                'class_setup_id'=>$data->classId, 
                                'month_id'=>$feeCollectionDetails->month_id,
                                'section_setup_id'=>$data->SectionId])->get();?>
                            @foreach($feecollection as $collectionHeadDetails)
                            <?php $totalAmt=$totalAmt+$collectionHeadDetails->amount;?>
                            <tr>
                                <td>{{getFeeHeadName($collectionHeadDetails->fee_amount_setup_id)}}</td>
                                <td>Rs. {{getFeeHeadAmt($collectionHeadDetails->fee_amount_setup_id)}}/-</td>
                            </tr>
                            @endforeach
                        
                    @endforeach
                     <tr>
                        <td><strong>Total</strong></td>
                        <td><strong>Rs. {{$data->total_amt}}/-</strong></td>
                    </tr>
                    <tr>
                        <td>Old Balance (+)</td>
                        <td>Rs. {{$data->old_balance}}/- </td>
                    </tr>
                   <!-- <tr>
                        <td>Late Fees (+)</td>
                        <td>Rs.{{$data->late_fee}}/-</td>
                    </tr>-->
                    <tr>
                        <td>Concession(-)</td>
                        <td>Rs. {{$data->discount}}/-</td>
                    </tr>
                    <tr>
                        <td>Remarks</td>
                        <td>{{$data->remarks}}</td>
                    </tr>
                    <tr style="font-size:20px">
                        <td><strong>Grand Total</strong></td>
                        <td><strong>Rs. {{$data->grand_total}}/-</strong></td>
                    </tr>
                    <tr>
                        <td><strong>Fee Receipt Date </strong></td>
                        <td><strong><input type="date" class="form-control" name='receipt_date' id='receipt_date'  value="{{ date('Y-m-d', strtotime($data->receipt_date)) }}"></strong></td>
                    </tr>
                    <tr>
                        <td><strong>Fee Receipt No. </strong></td>
                        <td><strong><input type="text" class="form-control" name='receipt_no' id='receipt_no'  value="{{$data->receipt_no}}"></strong></td>
                    </tr>
                    <tr>
                        <td><strong>Recived Amount</strong></td>
                        <td><input type="text" class="form-control" name='received_amount' id='received_amount'  value="{{ $data->grand_total  }}" maxlength="5"></td>
                    </tr>
                </table>
                        <div class="invoice-footer">
                        <button type="submit" class="btn btn-primary" onclick="return confirm('Are you sure?');">Received Amount / Print Invoice</button>
                        </div>
                    </form>
                    
                    
                </div>
        </div>
        
    </div>
@endsection