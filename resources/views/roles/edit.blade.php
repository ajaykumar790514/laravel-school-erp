<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Roles : {{ App\Models\Settings::getSettingValue('website_title')}} </title>
    <!-- Fivicon Icone  -->
    <?php $logofavicon=App\Models\Settings::getSettingValue('favicon');?>
    <link rel="shortcut icon" href="{{ asset($logofavicon)}}" />
    <link rel="icon" href="{{ asset($logofavicon)}}" type="image/x-icon">
    <!-- Fivicon Icone  -->

    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet"
        type="text/css">
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
    <script type="text/javascript" src="{{ asset('admin/js/plugins/forms/selects/select2.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::to('public/assets/js/plugins/forms/styling/uniform.min.js') }}">
    </script>

    <script type="text/javascript" src="{{ asset('admin/js/core/app.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admin/js/pages/form_layouts.js') }}"></script>
    <!-- /theme JS files -->
</head>

<body>
    <!-- Main navbar -->
    @include('layouts.topbar')
    <!-- /main navbar -->
    <!-- Page container -->
    <div class="page-container">

        <!-- Page content -->
        <div class="page-content">

            @include('layouts.sidebar-admin')


            <!-- Main content -->
            <div class="content-wrapper">

                <!-- Page header -->
                <div class="page-header page-header-default">
                    <div class="page-header-content">
                        <div class="page-title">
                            <h4><span class="text-semibold">User Managment</span> <i
                                    class="icon-arrow-right6 position-centre"></i> Edit Role</h4>
                        </div>
                    </div>


                </div>

                <!-- Content area -->
                <div class="content">

                    <!-- Vertical form options -->
                    <div class="row">
                        <div class="col-md-12">

                            <!-- Basic layout-->
                            <!-- Bootstrap switch -->

                            <!-- /bootstrap switch -->
                            <div class="panel panel-flat">
                                @include('layouts.massage')
                                <div class="panel-heading">
                                    @can('role-list')
                                    <a href="{{ url('role-list')}}" class="btn btn-primary "><i
                                            class="icon-list position-left"></i> Role List</a>
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

                                    </div>
                                    <form class="" method="POST" action="{{ url('role-edit/'.$id)}}" enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <strong>Name:</strong>
                                                <input class="form-control" name='name', id='name' value="{{ $role->name }}">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <strong>Permission:</strong>
                                            <div class="row">
                                                @foreach($permissionHeading as $Headingvalue)
                                                <div class="col-md-3">
                                                    <h4>{{ $Headingvalue->parent_id }}</h4>
                                                    <div class="form-group">
                                                        <?php
                                                            $permission1=App\Models\User::getPermission($Headingvalue->parent_id);
                                                            
                                                        ?>
                                                        @foreach($permission1 as $value)
                                                        <label>{{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, array('class' => 'name switchery')) }}
                                                            {{ $value->name }}</label>
                                                        <br />
                                                        @endforeach
                                                    </div>

                                                </div>

                                                @endforeach
                                            </div>


                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12 text-right">
                                            <button type="submit" class="btn btn-success">Update Roles</button>
                                        </div>
                                    </div>
                                    {!! Form::close() !!}



                                </div>
                            </div>

                            <!-- /basic layout -->

                        </div>

                    </div>
                    <!-- /vertical form options -->


                    <!-- Footer -->
                    @include('layouts.footer')
                    <!-- /footer -->

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