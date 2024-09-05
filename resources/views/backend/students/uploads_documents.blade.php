@extends('layouts.admin-theme')
@section('content')
<link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
<link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet"/>
                <div class="page-header page-header-default">
                  <div class="page-header-content">
                    <div class="page-title">
                        <?php $studentId=base64_decode($id);?>
                      <h4><i class="icon-arrow-left52 position-left"></i> 
                        <span class="text-semibold">Admission</span> ->Master->Upload Student Documents (<span style="color: red">{{ getStudentName($studentId)}}</span>)
                      </h4>
                    </div>
                  </div>
                </div>
                <!-- /page header -->
                <!-- Content area -->
                <div class="content">
                    <!-- 2 columns form -->
                    <form class="" method="POST" action='{{ url("/student-upload-documents/{$id}") }}' enctype="multipart/form-data">
                       {{ csrf_field() }}
                        <div class="panel panel-flat">
                            @include('layouts.massage') 
                            <div class="panel-heading">
                                 @can('student-list')
                                    <a href="{{ url('/student-list')}}" class="btn btn-primary"><i class=" icon-people position-left"></i>Student List</a>

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
                                                @if(count(getDocumentsType())>0)
                                                    @foreach(getDocumentsType() as $documents)
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
                                            <input type="file" 
                                                class="filepond"
                                                id='documents'
                                                name="documents" 
                                                allowImagePreview='true'
                                                data-allow-reorder="true"
                                                data-max-file-size="3MB"
                                                data-max-files="1">
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
                                    <button type="submit" class="btn btn-success"><i class="icon-upload4 position-left"></i> Upload {{ getStudentName($studentId)}}'s Documents </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="panel panel-flat">
                            @include('layouts.massage') 
                            <div class="panel-heading">
                                 <h3>Uploaded Documents</h3>
                                <div class="heading-elements">
                                    <ul class="icons-list">
                                        <li><a data-action="collapse"></a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="panel-body table-responsive">
                                            <table class="table  table-bordered table-striped table-hover">
                                                <thead class="thead-dark">
                                                    <tr role="row">
                                                         <th>Id</th>
                                                         <th>Documents Type</th>
                                                         <th>Documents</th>
                                                         <th>Action</th>
                                                     </tr>
                                                </thead>
                                                @foreach($documentsData as $documentsDetails)
                                                <?php $id=base64_encode($documentsDetails->id);?>
                                                <tr>
                                                    <th>{{$documentsDetails->id}}</th>
                                                    <th>{{$documentsDetails->name}}</th>
                                                    <th><a href="/public/{{$documentsDetails->documents}}">{{$documentsDetails->documents}}</a></th>
                                                    <th>
                                                        @can('student-delete-documents')
                                                        <a href='{{ url("/student-delete-documents/{$id}")}}' class="btn btn-primary"><i class=" icon-cancel-circle2 position-left"></i>Delete</a>
                                                        @endcan
                                                    </th>
                                                </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <!-- /content area -->
@endsection
@section('script')    
<script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
 <script type="text/javascript">  
      $(document).ready(function () {
            //for banner
                FilePond.registerPlugin(FilePondPluginImagePreview);
                const bannerElement = document.querySelector('input[id="documents"]');
                FilePond.create(bannerElement, {
                server:{
                    url: '/uploadDocuments',
                    headers: {
                          'X-CSRF-TOKEN': '{{ csrf_token() }}'
                          }
                        }
                })
    });
 </script>
@endsection