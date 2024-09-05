@extends('layouts.admin-theme')
@section('content')
    <!-- Page header -->
    <div class="page-header page-header-default">
          <div class="page-header-content">
            <div class="page-title">
                <?php $studentId=base64_decode($id);?>
              <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Employee</span>->Menu->Upload Employee Documents (<span style="color: red">{{ App\Models\Employees::getEmployeeName($employeeId)}}</span>)</h4>
            </div>
          </div>
    </div>
    <!-- /page header -->
    <!-- Content area -->
    <div class="content">
                    <!-- 2 columns form -->
                    <form class="" method="POST" action='{{ url("employees-upload-documents/{$id}") }}' enctype="multipart/form-data">
                       {{ csrf_field() }}
                        <div class="panel panel-flat">
                            @include('layouts.massage') 
                            <div class="panel-heading">
                                 @can('employees-list')
                                    <a href="{{ url('employees-list')}}" class="btn btn-primary"><i class=" icon-people position-left"></i>Employee List</a>
                                 @endcan
                                <div class="heading-elements">
                                    <ul class="icons-list">
                                        <li><a data-action="collapse"></a></li>
                                        <li><a data-action="close"></a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="panel-body">
                                @include('layouts.validation-error') 
                                <div class="row">
                                    <div class="col-md-6">
                                        <fieldset>
                                            <div class="form-group{{ $errors->has('document_type') ? ' has-error' : '' }}">
                                            <label>Select Documents Type <span class="text-danger">*</span></label>
                                            <select id="document_type"  class="select" name="document_type" >
                                                <option value=''>--Select--</option>
                                                @if(count($documentsSetups)>0)
                                                    @foreach($documentsSetups as $documents)
                                                     <option value='{{$documents->id}}' <?php echo old('document_type')==$documents->id?"selected":"";?>>{{$documents->name}}</option>   
                                                      @endforeach
                                                @endif  
                                               
                                            </select>
                                            @if ($errors->has('document_type'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('document_type') }}</strong>
                                                </span>
                                            @endif
                                           
                                        </div>
                                        <div class="form-group{{ $errors->has('documents') ? ' has-error' : '' }}">
                                            <label>Documents<span class="text-danger">*</span></label>
                                            <input type="file" name="documents" class="file-styled">
                                            <span class="help-block">Accepted formats: jpeg, png, jpg. Max file size 1Mb</span>
                                            @if ($errors->has('documents'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('documents') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </fieldset>
                                    </div>

                                    <div class="col-md-6">
                                        <fieldset>
                                           <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                                            <label>Status <span class="text-danger">*</span></label>
                                            <select id="status"  class="form-control" name="status" >
                                                <option value=''>--Select--</option>
                                                <option value='0' {{ old('status')==0?"selected":""}}>Active</option>   
                                                <option value='1' {{old('status')==1?"selected":""}}>Inactive</option>
                                            </select>
                                            
                                        </div>
                                       
                                        </fieldset>
                                    </div>
                                </div>

                                <div class="text-right">
                                    <button type="submit" class="btn btn-success"><i class="icon-upload4 position-left"></i> Upload {{ App\Models\Employees::getEmployeeName($studentId)}}'s Documents </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
@endsection
