@extends('layouts.admin-theme')
@section('content')
<div class="page-header page-header-default">
  <div class="page-header-content">
    <div class="page-title">
      <h4><span class="text-semibold">Website</span> <i class="icon-arrow-right6 position-centre"></i> {{$title}}</h4>
    </div>
  </div>
</div>
<!-- /page header -->
<!-- Content area -->
<div class="content">
     @include('layouts.massage') 
    @include('layouts.validation-error') 
    
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-flat">
                    <div class="panel-body">
                        <div class="row">
                            <h4 class="header-title">{{__("SMTP Settings")}}</h4>
                            <form action="{{url('update-smtp-settings')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="form-group">
                                <label for="site_smtp_mail_host">{{__('SMTP Mail Host')}}</label>
                                <input type="text" name="site_smtp_mail_host"  class="form-control" value="{{$host}}">
                            </div>
                            <div class="form-group">
                                <label for="site_smtp_mail_port">{{__('SMTP Mail Port')}}</label>
                                 <select name="site_smtp_mail_port" class="form-control">
                                    <option value="587" @if($port == '587') selected @endif>{{__('587')}}</option>
                                    <option value="465" @if($port == '465') selected @endif>{{__('465')}}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="site_smtp_mail_username">{{__('SMTP Mail Username')}}</label>
                                <input type="text" name="site_smtp_mail_username"  class="form-control" value="{{$username}}" id="site_smtp_mail_username">
                            </div>
                            <div class="form-group">
                                <label for="site_smtp_mail_password">{{__('SMTP Mail Password')}}</label>
                                <input type="password" name="site_smtp_mail_password"  class="form-control" value="{{$password}}" id="site_smtp_mail_password">
                            </div>
                            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Update SMTP Settings')}}</button>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-flat">
                    <div class="row">
                        <div class="panel-body">
                            <h4 class="header-title">{{__("SMTP Test")}}</h4>
                            <form action="{{url('mail-test')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="email">{{__('Email')}}</label>
                                    <input type="email" name="email"  class="form-control" >
                                </div>
                                <div class="form-group">
                                    <label for="subject">{{__('Subject')}}</label>
                                    <input type="text" name="subject"  class="form-control" >
                                </div>
                                <div class="form-group">
                                    <label for="message">{{__('Message')}}</label>
                                    <textarea name="message" class="form-control"  cols="30" rows="10"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">{{__('Send Mail')}}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
</div>
@endsection
