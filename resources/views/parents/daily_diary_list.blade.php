@extends('parents.app')
@section('content')
 <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
        <div class="page-header page-header-default">
          <div class="page-header-content">
            <div class="page-title">
              <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Academics</span> ->Menu->Daily Diary</h4>
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
                    @can('dailydiaries-create')
                   <a href="{{ url('/academics/dailydiaries-create')}}" class="btn btn-primary"><i class=" icon-office position-left"></i>Create Daily Diary</a>
                    @endcan
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
                                <th>Session</th>
                                <th>Class</th>
                                 <th>Section</th>
                                <th>Teacher</th>
                                <th>Title</th>
                                <th>Created at</th>
                                <th>Action</th>
                              </tr>
                           </thead>
                           @foreach($data as $details)
                           <?php $id=base64_encode($details->id);?>
                               <tr>
                                   <td>{{$details->session_name}}</td>
                                   <td>{{$details->class_name}}</td>
                                   <td>{{$details->section_name}}</td>
                                   <td>{{$details->employee_name}}</td>
                                   <td>{{$details->title}}</td>
                                   <td>{{date('d F Y H:i:s', strtotime($details->created_at))}}</td>
                                   <td><a href='{{url("parents/daily-diary-view/{$id}")}}'>View</a></td>
                               </tr>
                           @endforeach
                            <tfoot class="thead-dark">
                            <tr role="row">
                                
                                <th>Session</th>
                                <th>Class</th>
                                 <th>Section</th>
                                <th>Teacher Id</th>
                                <th>Title</th>
                                <th >Created at</th>
                                <th >Action</th>
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



