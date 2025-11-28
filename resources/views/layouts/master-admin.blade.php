<!doctype html>
<html class="loading" lang="en" data-textdirection="ltr">

<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Cache-control" content="no-cache">
    <!-- Anti-flicker snippet (recommended)  -->
    <style>.async-hide { opacity: 0 !important} </style>
    <script>(function(a,s,y,n,c,h,i,d,e){s.className+=' '+y;h.start=1*new Date;
            h.end=i=function(){s.className=s.className.replace(RegExp(' ?'+y),'')};
            (a[n]=a[n]||[]).hide=h;setTimeout(function(){i();h.end=null},c);h.timeout=c;
        })(window,document.documentElement,'async-hide','dataLayer',400,
            {'OPT_CONTAINER_ID':true});</script>


    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">

    <title>@yield('title')</title>

    <link rel="icon" href="favicon.ico?v=2" type="image/x-icon"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- BEGIN: Page Level CSS-->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('pixinvent/app-assets/css/materialize.css')}}">
    @yield('page-level-css')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('pixinvent/app-assets/css/style.css')}}">
    <!-- END: Page Level CSS-->

    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/styles.css')}}">


</head>

<!-- END: Head-->

<body id="OPT_CONTAINER_ID" class="vertical-layout page-header-light vertical-menu-collapsible vertical-menu-nav-dark 2-columns  " data-open="click" data-menu="vertical-menu-nav-dark" data-col="2-columns">

<!-- BEGIN: Header-->
<header class="page-topbar" id="header">

    @include('includes.pixinvent.nav_header')

</header>
<!-- END: Header-->


<!-- BEGIN: SideNav-->
@include('includes.pixinvent.nav_side_bar')
<!-- END: SideNav-->



<!-- BEGIN: Page Main-->
<div id="main">

<div class="row">
    <div class="col s12">

@yield('content')

    </div>
</div>

</div>
<!-- END: Page Main-->



<!-- BEGIN: Footer-->
<footer class="page-footer footer footer-static footer-dark gradient-45deg-blue-indigo gradient-shadow navbar-border navbar-shadow">
    <div class="footer-copyright">
        <div class="container"><span>&copy; {{date('Y')}} <a href="https://www.ppda.go.ug/" target="_blank">PPDA Uganda</a> All rights reserved.</span></div>
    </div>
</footer>
<!-- END: Footer-->

{{-- Message modal --}}
@if(count($errors->all()) > 0) @include('includes.modal-general-error') @endif

@if(session('errorMsg') != null)
    <?php $isError = true; $msg = session('errorMsg')?>
    @include('includes.modal-message')
@elseif(session('successMsg') != null)
    <?php $isError = false; $msg = session('successMsg')?>
    @include('includes.modal-message')
@endif


<!-- BEGIN VENDOR JS-->
<script src="{{ URL::asset('pixinvent/app-assets/js/vendors.min.js')}}" type="text/javascript"></script>
<script src="{{ URL::asset('js/moment.min.js') }}" type="text/javascript"> </script>
<!-- BEGIN VENDOR JS-->

<!-- BEGIN PAGE VENDOR JS-->
<script src="{{ URL::asset('pixinvent/app-assets/vendors/chartjs/chart.min.js')}}"></script>
<!-- END PAGE VENDOR JS-->

<!-- BEGIN THEME  JS-->
<script src="{{ URL::asset('pixinvent/app-assets/js/plugins.js')}}" type="text/javascript"></script>
<!-- END THEME  JS-->

<!-- BEGIN PAGE LEVEL JS-->
<script src="{{ URL::asset('pixinvent/app-assets/js/scripts/dashboard-ecommerce.js')}}" type="text/javascript"></script>
@yield('page-level-js')
<script src="{{ URL::asset('js/scripts.js')}}" type="text/javascript"></script>
<!-- END PAGE LEVEL JS-->

</body>

</html>
 
