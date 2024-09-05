@extends('parents.app')
@section('content')
 <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
        <div class="page-header page-header-default">
          <div class="page-header-content">
            <div class="page-title">
              <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Fee Details</span></h4>
            </div>
          </div>
      </div>
        <!-- /page header -->
        <!-- Content area -->
        <div class="content">
           @include('layouts.massage') 
           <!-- Vertical form options -->
              <div class="panel panel-flat">
                  <div class="panel-heading">
                     <div class="heading-elements">
                      <ul class="icons-list">
                                <li><a data-action="collapse"></a></li>
                                <li><a data-action="close"></a></li>
                              </ul>
                            </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <table class="table  datatable-basic table-bordered table-striped table-hover " id="laravel_datatable" data-order='[[0, "desc" ]]'>
                           <thead class="thead-dark">
                              <tr role="row">
                                <th>Receipt No.</th>
                                <th>Receipt Date</th>
                                <th>Name</th>
                                <th>Class</th>
                                <th>Section</th>
                                <th>Total Amount</th>
                                 <th>Paid Amount</th>
                                <th>Balance</th>
                                <th>Action</th>
                              </tr>
                           </thead>
                            @if(count($invoices)>0)
                                   @foreach($invoices as $details)
                                   <?php $id=base64_encode($details->id);
                                          //$studentDetail=getStudentByID($details->id, getSessionDefault());
                                          //$invoiceDetails=getLastInvoiceByStudentID(getSessionDefault(), $details->id)
                                   ?>
                                       <tr>
                                           <td>{{$details->receipt_no}}</td>
                                           <td>{{date('d F Y', strtotime($details->receipt_date))}}</td>
                                           <td>{{$details->student_name}}</td>
                                           <td>{{$details->class_name}}</td>
                                           <td>{{$details->section_name}}</td>
                                           <td>{{$details->grand_total}}/-</td>
                                           <td>{{$details->payed_amt}}/-</td>
                                            <td>{{$details->curent_balance}}/-</td>
                                            <td><a href='{{url("parents/fee-invoice-for-parents-pdf/{$details->invoice_no}")}}'>View</a></td>
                                       </tr>
                                   @endforeach
                            @endif
                            <tfoot class="thead-dark">
                              <tr role="row">
                                <th>Receipt No.</th>
                                <th>Receipt Date</th>
                                <th>Class</th>
                                <th>Section</th>
                                <th>Name</th>
                                <th>Total Amount</th>
                                 <th>Paid Amount</th>
                                <th>Balance</th>
                                <th>Action</th>
                              </tr>
                            </tfoot>
                        </table>
                      </div>
         </div>
  
</div>
@endsection
@section('script')  
<script type="text/javascript" src="{{ asset('admin/js/pages/datatables_basic.js')}}"></script>
<script type="text/javascript" src="{{ asset('admin/js/plugins/tables/datatables/datatables.min.js')}}"></script>
@endsection



