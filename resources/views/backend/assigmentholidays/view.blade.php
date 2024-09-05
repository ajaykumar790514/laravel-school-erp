@extends('layouts.admin-theme')
@section('content')
        <div class="page-header page-header-default">
          <div class="page-header-content">
            <div class="page-title">
              <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Academics</span> ->Master->View Assignment/Holidays Homework</h4>
            </div>
          </div>
        </div>
        <!-- Content area -->
        <div class="content">
                    <!-- 2 columns form -->
                      <div class="panel panel-flat">
                            @include('layouts.massage') 
                            <div class="panel-heading">
                                 @can('dailydiaries-list')
                                    <a href="{{ url('/academics/assignment-holidays-list')}}" class="btn btn-primary "><i class="icon-list position-left"></i>Assignment/Holidays Homework List</a>
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
                                            <div class="form-group{{ $errors->has('session_id') ? ' has-error' : '' }}">
                                            <label class="text-semibold">Session </label>
                                            <div class="form-group ">
                                                {{$data->session_name}}
                                            </div>
                                          </div>
                                           <div class="form-group{{ $errors->has('class_id') ? ' has-error' : '' }}">
                                            <label class="text-semibold">Class </label>
                                            <div class="form-group">
                                            {{$data->class_name}}
                                        </div>
                                          </div>

                                          <div class="form-group{{ $errors->has('section_id') ? ' has-error' : '' }}">
                                            <label class="text-semibold">Section</label>
                                            <div class="form-group">
                                                {{$data->section_name}}
                                             </div>   
                                          </div>
                                    </fieldset>
                                    </div>

                                    <div class="col-md-6">
                                        
                                          <div class="form-group{{ $errors->has('teacher_id') ? ' has-error' : '' }}">
                                            @if($data->attachment!='')
                                                @if($data->doc_type==0)
                                                <a href="/public/{{ $data->attachment}}" data-popup="lightbox">
    					                        <img src="/public/{{$data->attachment}}" alt="" class="img-rounded img-preview"></a>
                                                @elseif($data->doc_type==1 || $data->doc_type==2)
                                                 <a href="/public/{{ $data->attachment}}" target="_new" data-popup="lightbox">
                                                Download</a>
                                                @endif
                                            @endif


				                       
                                            
                                          </div>
                                        
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group{{ $errors->has('upload_content') ? ' has-error' : '' }}">
                                            <label class="text-semibold">Title</label>
                                            <div class="form-group">
                                            {{ $data->title}}
                                        </div>
                                        </div>
                                    </div>
                                     <div class="col-md-12">
                                        <div class="form-group{{ $errors->has('upload_content') ? ' has-error' : '' }}">
                                            <label class="text-semibold">Description</label>
                                            <div class="form-group">
                                            <?php print_R($data->upload_content)?>
                                        </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-right">
                                    <a href="{{ url('/academics/assignment-holidays-list')}}" class="btn btn-success"><i class="icon-backward position-left"></i> Back to List </a>
                                </div>
                            </div>
                        </div>
                    </form>
    </div>
@endsection

