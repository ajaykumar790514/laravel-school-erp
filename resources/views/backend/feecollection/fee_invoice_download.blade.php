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
          <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Fees Module </span> ->Menu->Generate Invoice</h4>
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
                        <div class="col-md-4">
                            <a class="btn btn-primary btn-xs" href='{{url("fee-invoice-pdf/{$invoiceNo}")}}'>Download Invoice</a>
                        </div>
                        
                        <div class="col-md-4">
                            <a class="btn btn-success  btn-xlg" href="{{url('student-list-for-fee-collection')}}">Back to Student List</a>
                        </div>
                    </div>
                    
                    
                </div>
        </div>
        
    </div>
@endsection