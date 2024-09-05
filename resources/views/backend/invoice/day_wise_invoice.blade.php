@extends('layouts.admin-theme')
@section('content')
                <!-- Page header -->
                <div class="page-header page-header-default">
                      <div class="page-header-content">
                        <div class="page-title">
                          <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Fee Madule</span>->Reports->Reports->Day Wise</h4>
                        </div>
                      </div>
        
                </div>
                <!-- /page header -->
                <!-- Content area -->
                <div class="content">
                    <!-- 2 columns form -->
                    <form class="" method="POST" action="{{ url('day-wise-invoice')}}" >
                       {{ csrf_field() }}
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
                                           <div class="form-group{{ $errors->has('from_date') ? ' has-error' : '' }}">
                                            <label>From Date</label>
                                             <input type="date" class="form-control" name='from_date' id='from_date'  value="{{ $fromDate!=""?date('Y-m-d', strtotime($fromDate)):""  }}">
                                           </div>
                                     </fieldset>
                                    </div>
                                    <div class="col-md-3">
                                        <fieldset>
                                           <div class="form-group{{ $errors->has('to_date') ? ' has-error' : '' }}">
                                            <label>To Date</label>
                                             <input type="date" class="form-control" name='to_date' id='to_date'  value="{{ $toDate!=""?date('Y-m-d', strtotime($toDate)):''  }}">
                                           </div>
                                     </fieldset>
                                    </div>
                                    <div class="col-md-3">
                                        <fieldset>
                                           
                                           <div class="form-group{{ $errors->has('class_id') ? ' has-error' : '' }}">
                                            <label>Class</label>
                                             <select id="class_id"  class="form-control select" name="class_id" >
                                                <option value=''>--Select--</option>
                                                @if(count(getClasses())>0)
                                                    @foreach(getClasses() as $class)
                                                     <option value='{{$class->id}}' <?php echo $class_id==$class->id?"selected":"";?>>{{$class->class_name}}</option>   
                                                      @endforeach
                                                @endif  
                                            </select>
                                           </div>
                                     </fieldset>
                                        
                                    </div>
                                      <div class="col-md-3">
                                        <fieldset>
                                            <div class="form-group" style="margin-top: 26px;">
                                                 <button type="submit" class="btn btn-default"><i class="icon-zoomin3 position-left"></i> Search Student </button>
                                     </div>
                                        </fieldset>
                                    </div>

                                </div>

                               
                            </div>
                        </div>
                    </form>
                    <div class="panel panel-flat">
                         @if(count($data)>0)
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-md-4"><h6>Students ({{count($data)}}) (Recived Amount: Rs. {{$sum_payed_amt}}/-)</h6></div>
                                <div class="col-md-8 float-left">
                                    @can('export-day-wise-collection')
                                        <a href='{{ url("export-day-wise-collection/{$fromDate}/{$toDate}/{$class_id}")}}' class="btn btn-primary"></i>Download General Report</a>
                                    @endcan
                                    @can('export-head-wise-collection')
                                     <a href='{{ url("export-head-wise-collection/{$fromDate}/{$toDate}/{$class_id}")}}' class="btn btn-primary"></i>Download Head Wise Report</a>
                                     @endcan
                                </div>
                            </div>
                            
                            
                             <div class="heading-elements">
                              <ul class="icons-list">
                                <li><a data-action="collapse"></a></li>
                                <li><a data-action="close"></a></li>
                              </ul>
                            </div>
                        </div>
                            <div class="panel-body table-responsive">
                                <table class="table  table-bordered  table-hover " id="domainTable">
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
                                                            <li><a href='{{url("removeInvoice/{$dataDetails->invoice_no}")}}' onclick="return confirm('Are you sure?');" class='delete' id='deleteID'><i class=' icon-cancel-circle2'></i> Move to trash</a></li>
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
                            <h6>{{config('app.emptyrecords')}}</h6>
                             
                        </div>
                    @endif
                    </div>
               
                </div>
@endsection
@section('script') 
    <!-- /page container -->
    <script type="text/javascript">
        
    </script>
@endsection
