@extends('layouts.admin-theme')
@section('content')
                <!-- Page header -->
                <div class="page-header page-header-default">
          <div class="page-header-content">
            <div class="page-title">
              <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Admission</span> ->Master ->Edit Class & Section Mapping Details</h4>
            </div>
          </div>
         </div>
                <!-- /page header -->
                <!-- Content area -->
                <div class="content">
                    <!-- 2 columns form -->
                    <?php $id=base64_encode($data->id);?>
                    <form class="" method="POST" action='{{ url("classsectionmaping-edit/{$id}") }}' enctype="multipart/form-data">
                       {{ csrf_field() }}
                        <div class="panel panel-flat">
                            @include('layouts.massage') 
                            <div class="panel-heading">
                                 @can('classsectionmaping-list')
                                <a href='{{ url("classsectionmaping-list") }}' class="btn btn-primary "><i class="icon-list position-left"></i> Class & Section Mapping List</a>
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
                                           <div class="form-group{{ $errors->has('class_setups_id') ? ' has-error' : '' }}">
                                            <label>Class <span class="text-danger">*</span></label>

                                            <select id="class_setups_id"  class="form-control" name="class_setups_id" >
                                                <option value=''>--Select--</option>
                                                @if(count($classmapings)>0)
                                                    @foreach($classmapings as $classmaping)
                                                     <option value='{{$classmaping->id}}' <?php echo $data->class_setups_id==$classmaping->id?"selected":"";?>>{{$classmaping->class_name}}</option>   
                                                      @endforeach
                                                @endif  
                                               
                                            </select>
                                          </div>
                                        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                                            <label>Status <span class="text-danger">*</span></label>
                                            <select id="status"  class="form-control" name="status" >
                                                <option value=''>--Select--</option>
                                                <option value='0' {{ $data->status==0?'selected':''}}>Active</option>   
                                                <option value='1' {{$data->status==1?"selected":""}}>Inactive</option>
                                            </select>
                                           </div>
                                        
                                    </fieldset>
                                    </div>

                                    <div class="col-md-6">
                                        <fieldset>
                                            <div class="form-group{{ $errors->has('section_setup_id') ? ' has-error' : '' }}">
                                            <label>Section <span class="text-danger">*</span></label>
                                            <select id="section_setup_id"  class="form-control" name="section_setup_id" >
                                                <option value=''>--Select--</option>
                                                @if(count($sections)>0)
                                                    @foreach($sections as $section)
                                                     <option value='{{$section->id}}' <?php echo $data->section_setup_id==$section->id?"selected":"";?>>{{$section->section_name}}</option>   
                                                      @endforeach
                                                @endif  
                                               
                                            </select>
                                           </div>

                                           
                                       
                                        </fieldset>
                                    </div>
                                </div>

                               <div class="text-right">
                                            <button type="submit" class="btn btn-success"><i class="icon-add position-left"></i> Update Records </button>
                                </div>
                            </div>
                        </div>
                    </form>
                   
                </div>
                <!-- /content area -->
@endsection
