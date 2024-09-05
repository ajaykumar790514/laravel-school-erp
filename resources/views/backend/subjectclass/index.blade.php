@extends('layouts.admin-theme')
@section('content')
    <div class="page-header page-header-default">
          <div class="page-header-content">
            <div class="page-title">
              <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Academics</span> ->Master->Subject & Class Mapping</h4>
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
                    @can('subject-class-maping-list')
                   <a href="{{ url('/academics/subject-class-maping-create')}}" class="btn btn-primary"><i class="icon-calendar position-left"></i>Create Subject & Class Mapping</a>
                    @endcan
                     <div class="heading-elements">
                      <ul class="icons-list">
                                <li><a data-action="collapse"></a></li>
                                <li><a data-action="close"></a></li>
                              </ul>
                            </div>
                    </div>
                        <div class="panel-body table-responsive">
                    <table class="table  table-bordered table-striped table-hover " id="laravel_datatable" data-order='[[0, "desc" ]]'>
                       <thead class="thead-dark">
                          <tr role="row">
                             <th>Id</th>
                             <th>Class</th>
                             <th>Subject</th>
                             <th>Status</th>
                             <th >Created at</th>
                             <th >Action</th>
                          </tr>
                       </thead>
                       
                        <tfoot class="thead-dark">
                        <tr role="row">
                              <th>Id</th>
                             <th>Class</th>
                             <th>Subject</th>
                             <th>Status</th>
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
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script>
   $(document).ready( function () {
    $('#laravel_datatable').DataTable({
          fixedHeader: {
            header: true,
            footer: true
        },
        "stripeClasses": [ 'odd-row', 'even-row' ],
           processing: true,
           serverSide: true,

           ajax: "{{ url('academics/subjectclassmappingdata') }}",
           columns: [
                    { data: 'id', name: 'id' },
                    { data: 'class_name', name: 'class_setups_id' },
                    { data: 'subject_name', name: 'subject_setups_id' },
                    { data: 'status', name: 'status' },
                    { data: 'created_at', name: 'created_at' },
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                    

                 ],
        columnDefs: [
                  {
                      "render": function(data, type, row) {
                          if (row.stataus==0) {
                              return '<span class="label label-success">Active</span>';
                          }else {
                              return '<span class="label label-default">Inactive</span>';
                          }
                       }, "targets": [3]
                  },
                  
                  
                  
              ],
              
        });

     });
  </script>
@endsection



