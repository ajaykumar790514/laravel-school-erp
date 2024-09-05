@extends('layouts.admin-theme')
@section('content')
                <!-- Page header -->
                <div class="page-header page-header-default">
                      <div class="page-header-content">
                        <div class="page-title">
                          <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Fee Madule</span>->Reports->Curent Month Balance Fees</h4>
                        </div>
                      </div>
        
                </div>
                <!-- /page header -->
                <!-- Content area -->
                <div class="content">
                    <!-- 2 columns form -->
                    <div class="panel panel-flat">
                         @if(count($data)>0)
                        <div class="panel-heading">
                            <h6>Student List ({{count($data)}}) (Total Recived Amount: Rs. {{$sum_payed_amt}}/-)</h6>
                             <div class="heading-elements">
                              <ul class="icons-list">
                                <li><a data-action="collapse"></a></li>
                                <li><a data-action="close"></a></li>
                              </ul>
                            </div>
                        </div>
                            <div class="panel-body table-responsive">
                                <table class="table  table-bordered  table-hover datatable-basic" id="domainTable">
                               <thead class="thead-dark">
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
                                                		<li><a class="" href='{{url("fee-invoice-pdf/{$dataDetails->invoice_no}")}}'><i class="icon-download"></i> Download</a></li>
                                                		@endif
                                                        
                                                        @if($dataDetails->status==0)
                                                            <li><a href='{{url("removeInvoice/{$dataDetails->invoice_no}")}}' onclick="return confirm('Are you sure?');" class='delete' delete-id='{{$id}}' id='deleteID'><i class=' icon-cancel-circle2'></i> Move to trash</a></li>
                                                		@endif
                                                	</ul>
                                                    </li>
                                                </ul> 
                                             
                                         </td>
                                  </tr>
                                    @endforeach 
                                 @else
                                    <tr>
                                        <th colspan="8" style="text-align: center;"> {{config('app.emptyrecords')}}</th>
                                </tr>
                                @endif
                                </table>
                            
                        </div>
                           
                     @else
                           <div class="panel-heading">
                            <h6>{{"Record not found"}}</h6>
                             
                        </div>
                    @endif
                    </div>
               
                </div>
@endsection
@section('script') 
    <script type="text/javascript" src="{{  asset('admin/js/plugins/tables/datatables/datatables.min.js')}}"></script>
<script type="text/javascript" src="{{  asset('admin/js/pages/datatables_basic.js')}}"></script>
@endsection
