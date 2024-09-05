@extends('parents.app')
@section('content')
 <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
        <div class="page-header page-header-default">
          <div class="page-header-content">
            <div class="page-title">
              <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Children</span></h4>
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
                                <th>Reg. No<br>Admission</th>
                                <th>Reg. Date</th>
                                <th>Roll no.</th>
                                <th>Name</th>
                                <th>DOB</th>
                                <th>Class</th>
                                 <th>Section</th>
                                <th>Last Fee Submitted</th>
                                <th>Action</th>
                              </tr>
                           </thead>
                           @foreach($data as $details)
                           <?php $id=base64_encode($details->id);
                                  $studentDetail=getStudentByID($details->id, getSessionDefault());
                                  $invoiceDetails=getLastInvoiceByStudentID(getSessionDefault(), $details->id)
                           ?>
                               <tr>
                                   <td>{{$studentDetail->admission_no}}</td>
                                   <td>{{date('d F Y', strtotime($studentDetail->reg_date))}}</td>
                                   <td>{{$studentDetail->roll_no}}</td>
                                   <td>{{$details->student_name}}</td>
                                   <td>{{date('d F Y', strtotime($details->dob))}}</td>
                                   <td>{{$studentDetail->class_name}}</td>
                                   <td>{{$studentDetail->section_name}}</td>
                                   <td>@if(!empty($invoiceDetails))
                                       Amount: {{$invoiceDetails->payed_amt}}/-<br>
                                       Receipt no/Date : {{$invoiceDetails->receipt_no}} / {{date('d F Y', strtotime($invoiceDetails->receipt_date))}}
                                      @endif   
                                    </td>
                                    <td><a href='{{url("parents/student-view/{$id}")}}'>View</a></td>
                               </tr>
                           @endforeach
                            <tfoot class="thead-dark">
                             <th>Reg. No<br>Admission</th>
                                <th>Regi. Date</th>
                                <th>Roll no.</th>
                                <th>Name</th>
                                <th>DOB</th>
                                <th>Class</th>
                                 <th>Section</th>
                                <th>Last Fee Submitted</th>
                                <th>Action</th>
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



