@extends('layouts.admin-theme')
@section('content')
        <div class="page-header page-header-default">
          <div class="page-header-content">
            <div class="page-title">
              <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Academics</span> ->Master->View School Events</h4>
            </div>
          </div>
        
        </div>
        <!-- /page header -->
        <!-- Content area -->
        <div class="content">
                    <!-- 2 columns form -->
                      <div class="panel panel-flat">
                            @include('layouts.massage') 
                            <div class="panel-heading">
                                 @can('events-list')
                                    <a href="{{ url('/academics/events-list')}}" class="btn btn-primary "><i class="icon-list position-left"></i>School Event List</a>
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
                                           
                                          <div class="form-group">
                                            <label class="text-semibold">To Date </label>
                                            <div class="form-group">{{date('d F Y', strtotime($data-> date_to))}}</div>
                                          </div>
                                          <div class="form-group">
                                            <label class="text-semibold">From Date</label>
                                            <div class="form-group">{{date('d F Y', strtotime($data->date_from))}}</div>   
                                          </div>
                                    </fieldset>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-semibold">Category </label>
                                            <div class="form-group">{{$data->catName}}</div>
                                          </div>
                                        <div class="form-group">
                                            <label class="text-semibold">Note </label>
                                            <div class="form-group">{{$data->note}}</div>
                                          </div>
                                          <div class="form-group">
                                            @if($data-> attachments !='')
                                               <a href="/public/{{ $data->attachments}}" data-popup="lightbox">
    					                        <img src="/public/{{$data->attachments}}" alt="" class="img-rounded img-preview"></a>
                                               @endif
                                            </div>
                                        
                                    </div>
                                     <div class="col-md-12">
                                        <div class="form-group{{ $errors->has('descriptions') ? ' has-error' : '' }}">
                                            <label class="text-semibold">Description</label>
                                            <div class="form-group">
                                            <?php print_R($data->descriptions)?>
                                        </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-right">
                                    <a href="{{ url('/academics/events-list')}}" class="btn btn-success"><i class="icon-backward position-left"></i> Back to List </a>
                                </div>
                            </div>
                        </div>
                    </form>
        </div>
@endsection