@extends('layouts.admin-theme')
@section('content')
    <!-- Page header -->
    <div class="page-header page-header-default">
                      <div class="page-header-content">
                        <div class="page-title">
                          <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Admission</span>->Reports->Not Enrolled Students</h4>
                        </div>
                      </div>
        
                </div>
    <!-- /page header -->
    <!-- Content area -->
    <div class="content">
	    <div class="panel panel-flat">
			<table class="table datatable-basic">
				<thead>
					<tr>
						<th>Session</th>
						<th>Class</th>
						<th>Student Name</th>
						<th>Father Name</th>
						<th>Mobile</th>
						<th>Email</th>
						<th>Address</th>
						<th>Created</th>
					</tr>
				</thead>
				<tbody>
				    @if(count(getNotEnrolledStudent())>0)
				        @foreach(getNotEnrolledStudent() as $studentDetails)
					        <tr>
									<td>{{$studentDetails->session_name}}</td>
									<td>{{$studentDetails->class_name}}</td>
									<td>{{$studentDetails->student_name}}</td>
									<td>{{$studentDetails->father_name}}</td>
									<td>{{$studentDetails->father_mobile_no}}</td>
									<td>{{$studentDetails->father_email}}</td>
									<td>{{$studentDetails->address}}</td>
									<td>{{date('d F Y', strtotime($studentDetails->created_at))}}</td>
								</tr>
						@endforeach
					@else
					    <tr>
					        <th colspan='8'>No Record Found</th>
					    </tr>
					@endif
				</tbody>
			</table>
		</div>
	</div>
@endsection
@section('script') 
<script type="text/javascript" src="{{  asset('admin/js/plugins/tables/datatables/datatables.min.js')}}"></script>
<script type="text/javascript" src="{{  asset('admin/js/pages/datatables_basic.js')}}"></script>
@endsection