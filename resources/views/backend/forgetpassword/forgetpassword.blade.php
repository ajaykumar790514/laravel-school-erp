<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Forgot Password : {{ App\Models\Settings::getSettingValue('website_title')}}</title>
    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="{{ asset('admin/css/icons/icomoon/styles.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('admin/css/bootstrap.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('admin/css/core.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('admin/css/components.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('admin/css/colors.css') }}" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script type="text/javascript" src="{{ asset('admin/js/plugins/loaders/pace.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admin/js/core/libraries/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admin/js/core/libraries/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admin/js/plugins/loaders/blockui.min.js') }}"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script type="text/javascript" src="{{ asset('admin/js/plugins/forms/styling/uniform.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('admin/js/core/app.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admin/js/pages/login.js') }}"></script>
    <!-- /theme JS files -->
    <!-- Fevicon icon -->
        <?php $logofavicon=App\Models\Settings::getSettingValue('favicon');?>
        <link rel="shortcut icon" href="{{ asset($logofavicon)}}" />
        <link rel="icon" href="{{ asset($logofavicon)}}" type="image/x-icon">
    <!-- /Fevicon icon -->
    
</head>
<body class="login-container login-cover">
    <!-- Page container -->
    <div class="page-container">
        <!-- Page content -->
        <div class="page-content">
            <!-- Main content -->
            <div class="content-wrapper">
                <!-- Content area -->
                <div class="content pb-20">
                    <!-- Advanced login -->
                    <form action="{{ url('forgotpassword') }}" method='POST'>
                        {{ csrf_field() }}
                         
                        <div class="panel panel-body login-form">
                            <div class="text-center">
                                <?php $logo=App\Models\Settings::getSettingValue('logo');?>
                                <img width="100" src="{{ asset($logo) }}" alt="{{ config('app.name', '') }}">
                                <h5 class="content-group-lg"> <small class="display-block">Enter your credentials</small></h5>
                            </div>
                                @include('layouts.massage') 
                            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }} has-feedback has-feedback-left">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="email">
                                <div class="form-control-feedback">
                                    <i class="icon-user text-muted"></i>
                                </div>
                                 @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group login-options">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label class="checkbox-inline">
                                            <input type="hidden" class="styled" {{ old('remember') ? 'checked' : '' }}>
                                           
                                        </label>
                                    </div>

                                    <div class="col-sm-6 text-right">
                                        <a href="{{ url('login') }}">Login</a>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn bg-blue btn-block">Login <i class="icon-arrow-right14 position-right"></i></button>
                            </div>

                              
                        </div>
                    </form>
                    <!-- /advanced login -->

                </div>
                <!-- /content area -->

            </div>
            <!-- /main content -->

        </div>
        <!-- /page content -->

    </div>
    <!-- /page container -->

</body>
</html>
