<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="Cache-control" content="no-cache">
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta http-equiv="Content-Language" content="en" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<META name=GENERATOR content="MSHTML 8.00.7600.16385" />

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<meta name="title" content="@yield('title')" />

<meta property="og:site_name" content="@yield('title')" />

<meta name="revisit-after" content="3 days" />

<title>@yield('title') | PPDA Applications</title>

<link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
<link rel="stylesheet" href="{{ asset('css/jquery.gritter.css') }}" />
<link rel="stylesheet" href="{{ asset('css/app-styles.min.css') }}" />
<link rel="stylesheet" href="{{ asset('css/dropdown_filter.css') }}" />
<link rel="stylesheet" href="{{ asset('css/tui-date-picker.min.css') }}" />
<link rel="stylesheet" href="{{ asset('css/tui-time-picker.min.css') }}" />
<link rel="stylesheet" href="{{ asset('css/toastui.min.css') }}" />
<link rel="stylesheet" href="{{ asset('css/yearpicker.css') }}" />
		<!--[if lte IE 9]>
			<link rel="stylesheet" href="{{ asset('css/ace-part2.css') }}" class="ace-main-stylesheet" />
		<![endif]-->

		<!--[if lte IE 9]>
		  <link rel="stylesheet" href="{{ asset('css/ace-ie.css') }}" />
		<![endif]-->

        <!-- inline styles related to this page -->
        @yield('stylesheets')


		<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

		<!--[if lte IE 8]>
		<script src="{{ asset('js/html5shiv.js') }}"></script>
		<script src="{{ asset('js/respond.js') }}"></script>
        <![endif]-->

        <style>
            .dataTables_wrapper{
                background: #F5F5F5;
            }
            .dataTables_wrapper .row:last-child{
                border-bottom: none;
                background: #F5F5F5;
            }
            .form-actions:last-child{
                border-top: none;
                border-bottom: 1px solid #E5E5E5;
                margin-top: 0;
                padding-top: 0;
            }
            .entity-selector{
                margin-top: 5px;
            }
            .chosen-container > .chosen-single, [class*="chosen-container"] > .chosen-single{
                height: 34px;
                padding-top: 2px;
            }
            .submit_msg{
                display: none;
                left: 0;
                margin: 0 25%;
                position: fixed;
                top: 0;
                width: 50%;
                z-index: 1000000000;
            }
            .tab-pane{
                overflow: hidden;
            }
            .master_data .sidebar{
                background: none;
                width: inherit;
                padding-right:8px;
            }
            .master_data .sidebar ul{
                list-style:none;
            }
            .master_data .sidebar ul li{
                margin-bottom: 5px;
            }
            .master_data .tab-content{
                margin-left: 200px;
                border: none;
                overflow: hidden;
                padding-top: 0;
            }
            .master_data .form-actions{
                margin-top: 0;
            }
            .form-horizontal .col-form-label{
                margin-bottom: 0;
                padding-top: 7px;
                font-size: 11px;
                padding-top: 0 !important;
            }
            .text-md-right{
                text-align: right;
            }
            .gritter-item-wrapper{
                top: auto;
            }
            .text-select-entity{
                font-size: 70px;
                color: #a19898;
                text-align: center;
            }
            .selected-entity-header{
                text-align: right;
                float: right;
            }
            .data-table .dropdown-toggle{
                border: none;
                background-color: transparent !important;
                padding: 0 5px 0 8px;
            }
            .main-content .btn, #randomActionModal .btn{
                border-radius: 4px;
            }
            .profile-info-row .profile-info-value, .profile-info-row .profile-info-name{
                vertical-align: top;
            }
            .profile-info-row span.editable{width:100%;}
            .editable-container.editable-inline, .form-horizontal .editable.actual{
                display: none;
            }
            form .editable-container.editable-inline{
                display: inline-block;
                width: 100%;
            }

            .activity-profile .profile-info-row div.profile-info-value:nth-child(2){
                background: rgba(195, 32, 4,.2);
                width: 35%
            }
            body.public .activity-profile .profile-info-row div.profile-info-value:nth-child(2){
                display:none;
            }

            .activity-profile .profile-info-row div.profile-info-name:nth-child(1){
                font-size: 100%;
                font-weight: bold;
            }

            .activity-profile .profile-info-row div.profile-info-value:nth-child(3){
                padding-bottom: 0px;
                padding-top: 3px;
            }

            .activity-profile input, .activity-profile select{
                font-size: 100%;
                padding: 5px 10px;
            }

            .text-white,.text-white-50{
                color: #ffffff !important;
            }

            .actions {
                position: relative;
                z-index: 0;
                top: 10px;
                width: 20px;
                -webkit-transform: translateY(-50%);
                transform: translateY(-50%);
                font-size: 18px;
                color: #047bf8;
                text-decoration: none;
                cursor: pointer;
            }
            .actions .actions-list {
                position: absolute;
                background-color: #0068B3;
                color: #fff;
                font-size: 0.9rem;
                padding: 12px 12px;
                border-radius: 5px;
                visibility: hidden;
                opacity: 0;
                -webkit-transform: translateY(10px);
                transform: translateY(10px);
                -webkit-transition: all 0.2s ease;
                transition: all 0.2s ease;
                right: 7px;
                bottom: 11px;
            }
            .actions .actions-list::after{
                display: inline-block;
                content: "";
                position: absolute;
                z-index: 23;
                border: 1px solid transparent;
                border-width: 7px 7px;
                border-top-color: #0068B3;
                right: 2px;
                bottom: -13px;
            }
            tr td:not(:last-child) .actions .actions-list{left: 7px; right: auto;}
            tr td:not(:last-child) .actions .actions-list::after{left:2px; right: auto;}
            .actions:hover{
                z-index: 10;
            }
            .actions:hover > i {
                transform: rotate(180deg);
                opacity:0;
            }
            .actions:hover .actions-list{
                visibility: visible;
                transform: translateY(0px);
                opacity: 1;
            }
            .actions-list a {
                display: block;
                padding: 5px 10px;
                border-bottom: 1px solid rgba(255,255,255,0.05);
                color: #fff;
                text-decoration: none;
                white-space: nowrap;
            }
            .actions-list a:last-child{
                border-bottom: none;
            }
            .actions-list a i {
                font-size: 17px;
                display: inline-block;
                vertical-align: middle;
                margin-right: 10px;
                color: #fff;
            }
			.actions-list a span {
                color: rgba(255,255,255,0.7);
                display: inline-block;
                vertical-align: middle;
                transition: all 0.2s ease;
            }
            .actions-list a:hover span {
                color: #fff;
                transform: translateX(-3px);
            }
			.actions-list a.danger i {
                color: #ff5b5b;
            }
            .actions-list a.danger span {
                color: #ff5b5b;
            }


            .um-primary-bg {
                background-color: #0D47A1 !important;
            }

            .um-primary-text {
                color: #0D47A1 !important;
            }

            .text-white{
                color: white;
            }

            .footer .footer-inner .footer-content {
                left: 0px;
                right: 0px;
                border-top: unset;
            }

            .parallax {

                /* Set a specific height */
                min-height: 650px;
                /* Create the parallax scrolling effect */
                background-attachment: fixed;
                background-position: center;
                background-repeat: no-repeat;
                background-size: cover;
            }

            .spacer{
                height: 15px;
            }

            .spacer-small{
                height: 15px;
            }

            .spacer-top{
                margin-top: 15px;
            }

            .spacer-bottom{
                margin-bottom: 15px;
            }

            .divider{height:1px;overflow:hidden;background-color:#e0e0e0}


            #signin_form{
                margin-top: 10px;
                margin-bottom: 10px;
                padding-top: 20px;
                padding-bottom: 5px;
            }

            .btn.um-primary-bg{
                border: 1px solid  #0D47A1;
                border-radius: 4px;
            }

            #login_button{
                margin-top: 30px;
            }

            .fill-parent{
                width: 100%;
            }

            .invalid{
                color: #ef5350;
                font-size: 0.8em;
                list-style-type: none;
            }

            .btn-out-of-office{
                line-height: 24px !important;
                height: 30px;
                color: #0D47A1 !important;
                font-size: 12px;
                background-color:  white !important;
                border: 1px #0D47A1 solid;
                border-radius: 3px;
                margin-right: 10px;
                padding: 3px 10px;
            }

            .btn-out-of-office:hover{
                color: orangered !important;
                background-color:  white !important;
                border: 1px #0D47A1 solid !important;
            }

            .navbar-brand .link{
                background: transparent;
                color: white;
                font-size: 12px;
            }

            .navbar-brand a:hover{
                text-decoration: none;
                color: #cecece;
            }

            .timo-transparent-bg {
                font-weight: lighter;
                font-size: 22px;
                background-color: rgba(030	,144,	255,.3);
                padding: 1.2rem;
                border-radius: 10px;
            }
            .table-hover>tbody>tr:hover,
            .table>tbody>tr.active>td,
            .table>tbody>tr.active>th,
            .table>tbody>tr>td.active,
            .table>tbody>tr>th.active,
            .table>tfoot>tr.active>td,
            .table>tfoot>tr.active>th,
            .table>tfoot>tr>td.active,
            .table>tfoot>tr>th.active,
            .table>thead>tr.active>td,
            .table>thead>tr.active>th,
            .table>thead>tr>td.active,
            .table>thead>tr>th.active {
                background-color:#abbac3;
            }
            .timo-sub-text-app-selection{
                font-size: 18px;
            }

            .pt-20{
                padding-top: 20px;
            }

            @font-face {
                src: url('/iconfont/MaterialIcons-Regular.eot'); /* For IE6-8 */
                src: local('Material Icons'),
                local('MaterialIcons-Regular'),
                url('/iconfont/MaterialIcons-Regular.woff2') format('woff2'),
                url('/iconfont/MaterialIcons-Regular.woff') format('woff'),
                url('/iconfont/MaterialIcons-Regular.ttf') format('truetype');
            }

            .material-icons {
                font-family: 'Material Icons';
                font-weight: normal;
                font-style: normal;
                font-size: 24px;  /* Preferred icon size */
                display: inline-block;
                line-height: 1;
                text-transform: none;
                letter-spacing: normal;
                word-wrap: normal;
                white-space: nowrap;
                direction: ltr;

                /* Support for all WebKit browsers. */
                -webkit-font-smoothing: antialiased;
                /* Support for Safari and Chrome. */
                text-rendering: optimizeLegibility;

                /* Support for Firefox. */
                -moz-osx-font-smoothing: grayscale;

                /* Support for IE. */
                font-feature-settings: 'liga';
            }

            .dropdown-menu>li>a{
                color: #0D47A1;
            }

            .dropdown-menu>li>a>span{
                padding: 8px;
            }

            .font-bold{
                font-weight: bold;
            }

            .error{
                display: inline-block;
                color: red;
            }
            .success{
                color: #00BE67;
            }

            .timo-appraisal-th{
                text-transform: uppercase;
                font-weight: 700;
                color: #0D47A1;
                font-size: 11px;
            }

            .btn.um-primary-bg:hover {
                background-color: #2bbbad !important;
                border-color: #2bbbad;
            }

            .hide-first-column tr th:first-child,.hide-first-column tr td:first-child
            {
                display: none;
            }

            .datatable-no-search .dataTables_filter{
                display: none;
            }

            .datatable-no-paginate .dataTables_paginate{
                display: none;
            }

            .out_of_office input[type=time] {
                font-size: 12px;
                line-height: 0.6em;
                padding: 1px;
                height: 32px;
            }

            .mr-5{
                margin-right: 5px !important;
            }
            .image_preview_fuel_issue{
                height: 600px;
            }

            .image_preview_fuel_issue img{
                width: 95%;
                height: auto;
                margin: 10px auto;
                max-height: 580px !important;
            }
            .fuel_issue_review_section{
                background-color: #e4e6e9!important;
                min-height: 600px!important;
                border-left: 1px dotted #ccc!important;
            }

            .fuel_issue_review_section .preview_header{
                font-weight: 700 !important;
                font-size: 1.4rem !important;
                text-transform: uppercase !important;
                text-align: center !important;
                margin-top: 10px !important;
                margin-bottom: 12px !important;
                border-bottom: 1px dotted #ccc !important;
                padding-bottom: 5px !important;
            }

            .fuel_issue_field_sz{
                font-size: 1em !important;
            }

            .fuel_issue_field_mb{
                margin-bottom: 5px !important;
            }
            .login_mobile{
                margin-top: 3rem;
                margin-bottom: 3rem;
            }
            .mobile-form {
                margin-top: 2rem;
                background-color: #ffffff;
                padding: 2rem;
                border-radius: 5px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }
            .mobile_btn{
                padding: 10px 5px;
                height: 5rem;
                border-radius: 5px;
                background-color: #3f83f0; /* Light Purple */
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                color: #ffffff;
                font-weight: bold;
                text-align: center;
                display: flex;
                justify-content: center;
                align-items: center;
            }
        </style>
    </head>
    <body class="no-skin public">
        <div class="submit_msg"></div>
        <!-- #section:basics/navbar.layout -->
        <!-- /section:basics/navbar.layout -->
        <div class="main-container">
            <script type="text/javascript">
                try{ace.settings.check('main-container' , 'fixed')}catch(e){}
            </script>
            <!-- #section:basics/sidebar.horizontal -->
            <!-- /section:basics/sidebar.horizontal -->
            <div class="main-content">
                <div class="main-content-inner">
                    <div class="page-content-">
                        <div class="row">
                            <div class="col-xs-12">
                                @yield('content')
                            </div>
                        </div><!-- /.row -->
                    </div><!-- /.page-content -->
                </div><!-- /.main-content-inner -->
            </div><!-- /.main-content -->
            <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
                <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
            </a>
        </div><!-- /.main-container -->
        <!-- basic scripts -->
        @include('layouts.webparts.footer')
        @yield('scripts')
    </body>
</html>
