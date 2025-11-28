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
    <title>PPDA Applications | @yield('title') </title>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery.gritter.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/chosen.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/app-styles.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/dropdown_filter.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/bootstrap-timepicker.css') }}" />
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
                /* width: inherit; */
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

            #gritter-notice-wrapper{
                width: 100%;
                right: 0;
                left: 0;
            }
            .gritter-item-wrapper{
                top: 0/* auto */;
                left: 30%;
                width: 40%;
                position: fixed;
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
            .main-content .btn, .modal .btn{
                border-radius: 4px;
            }
            .profile-info-row .profile-info-value, .profile-info-row .profile-info-name{
                vertical-align: top;
                padding-top: 3px;
            }
            .profile-info-row span.editable{width:100%;}
            .editable-container.editable-inline, .form-horizontal .editable.actual{
                display: none;
            }
            form .editable-container.editable-inline{
                display: inline-block;
                width: 100%;
            }

            .activity-profile ol{
                margin-left: 14px;
            }
            .activity-profile .profile-info-row div.profile-info-value:nth-child(2){
                background: rgba(195, 32, 4,.2);
                width: 35%
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
            .entity_counts_table .table tr th:nth-child(2),.entity_counts_table .table tr:nth-child(2) th:nth-child(1),.entity_counts_table .table tr:last-child th:nth-child(3),.entity_counts_table .table tr td:nth-child(2),.entity_counts_table .table tr td:nth-child(3){
                background: rgba(195, 32, 4,.2);
            }
            .entity_counts_table .table td table th, .entity_counts_table .table td table td{
              background: none !important;
            }
            table.table_custom_bg tr th,  table.table_custom_bg tr td{
                background: rgba(195, 32, 4,.2);
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

            .bs-fill-modal .modal-dialog{
                height: 98%;
                left: 10%;
                margin: 1% 0 0;
                overflow: auto;
                position: absolute;
                width: 80%;
            }
            #randomActionModal .modal-dialog{
                left: 5%;
                width: 90%;
            }
            #megaModal .modal-dialog{
                width: 88%;
            }
            #calendarModal .modal-dialog{
                width: 100%;
                height: 100%;
                margin: 1px;
                padding: 1px;
            }
            #calendarModal .modal-content {
                height: 100%;
                border-radius: 0;
            }
            .cb_participants td, .pm_teams td, .pm_teams td label, .pm_teams td i{
                font-size: 11px;
            }
            .cb_participants td, .pm_teams td, .cb_participants th, .pm_teams th{
                padding: 5px 5px !important;
            }

            .audit_history tr td:first-child, .audit_history tr th:first-child, .pm_history tr td:first-child, .pm_history tr th:first-child{
                display:none;
            }
            .audit_history_hide .form-inline .row{
                display:none;
            }
            .inner-list-with-action li div.actions,.inner-list-with-action li input{
                float: right;
                width: 13px;
            }
            .inner-list-with-action li{
                border-bottom: thin dotted #ccc;
            }
            .inner-list-with-action li:hover{
                background: #c1c1c1;
            }
            .inner-list-with-action li label{
                width: 100%;
                cursor: pointer;
                margin-bottom: -5px;
            }
            .empty-input input,.invalid-input input{
                border: thin solid red;
            }
            .error{
                display: inline-block;
                color: red;
            }
            .valid-input input:not(type="submit") {
                border: thin solid #9ac59a;
            }
            .inner-table.cb_history tr td:first-child, .inner-table.cb_history tr th:first-child,
            .data-table.pm_activities tr td:first-child, .data-table.pm_activities tr th:first-child,.data-table.cb_plans tr td:first-child,.data-table.cb_plans tr th:first-child, .inner-table.pm_teams tr th:first-child,.inner-table.pm_teams tr td:first-child,.data-table.mgt_letter_sections tr th:first-child, .data-table.mgt_letter_sections tr td:first-child, .decisions_table tr th:first-child,.decisions_table tr td:first-child, .recommendations_table tr th:first-child,.recommendations_table tr td:first-child, .followup_table tr th:first-child,.followup_table tr td:first-child, .hide_first_column tr th:first-child,.hide_first_column tr td:first-child
            {
              display: none;
            }
            .distancecalculator .action-links{
                float:right;
            }
            .dataTables_processing{
                position: absolute;
                margin-top: 100px;
                left: 45%;
                padding-top: 50px;
                background: url({{ asset('ajax-loader.gif') }}) center no-repeat;
            }
            .report .bio{width:100%;}
            .report .docs{display:none;}
            .report .activity-profile .profile-info-row div.profile-info-value:nth-child(2){display:none;}
            .separator{
              border:thin solid #d1d1d1;
            }
            .font-bold{
              font-weight: bold !important;
            }
            .pm_activity_page hr{
                margin: 5px auto;
            }
            .pm_activity_page h4{
                margin: 0 auto;
            }
            .pm_activity_page .pm_dates{
                margin-top: 10px;
            }
            .pm_activity_page .page-header{
                padding-bottom: 10px;
            }
            .pm_activity_page .inner-list-with-action li label{
                margin: 5px auto;
            }
            .pm_activity_page .profile-user-info-striped .profile-info-name{
                width: 35%;
                text-align: left;
            }
            .bootstrap-timepicker-widget.dropdown-menu{
                z-index: 10000;
            }
            .input-group[class*="col-"]{
                padding-left: 12px;
                padding-right: 12px;
            }
            .inner-forms{
                background: #f0e9e9;
                border: thin solid #ccc;
                left: 0;
                margin-top: 10px;
                padding-top: 10px;
                border-left: none;
                border-right: none;
            }
            .active_caption,.form-heading{
                display: none;
            }
            .active .active_caption,.active.form-heading{
                display: block;
            }
            .active .closed_caption{
                display: none;
            }
            .active.btn-people-form{
                background: red;
            }
            .chosen-disabled .chosen-drop,.chosen-disabled .chosen-results, .chosen-disabled input,.chosen-disabled{
                display: none;
            }

            input[type=number]::-webkit-inner-spin-button,
            input[type=number]::-webkit-outer-spin-button {
                -webkit-appearance: none !important;
                -moz-appearance: none !important;
                appearance: none !important;
                margin: 0 !important;
            }
            .text-small{
              font-size: 12px;
            }
            .mt-5{
              margin-top: 5px;
            }
            .mt-10{
              margin-top: 10px;
            }
            .panel-title a.accordion-toggle{
                width: 100%;
                display: block !important;
                font-weight: bolder !important;
                background-color: rgba(030 ,144, 255,.3) !important;
                margin-top: 5px;
                margin-bottom: 5px;
                padding: 2.5rem !important;
                font-size: 110% !important;
            }
            .management_letter_accordion .panel-title a.accordion-toggle{
                padding: 1.5rem !important;
                font-size: 105%;
            }
            .accordion-style1.panel-group .panel-heading .accordion-toggle{
                color: blue;
            }
            .management_letter_accordion .inner-accordion .panel-title a.accordion-toggle{
                padding: 1rem !important;
                font-size: 90% !important;
                background-color: #f0e7e7 !important;
                color: #374c5e;
            }
            .management_letter_accordion .inner-accordion .panel-title a.accordion-toggle.collapsed{
                color: #818b95;
            }
            .chosen-container.chosen-container-single{
                width: 100% !important;
            }
            .tooltip-info{
                background-color:#D2E1EA;
                font-size:80%;
                padding: 5px;
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
            .selectize[disabled]{
                display: block !important;
            }
            .dataTable > thead > tr > th[class*="sorting_"]{
                color: inherit;
            }
            .data-table.annual_procurement_plans.table tr th:nth-child(3),.data-table.annual_procurement_plans.table tr td:nth-child(3),.data-table.annual_procurement_plans.table tr th:nth-child(4),.data-table.annual_procurement_plans.table tr td:nth-child(4),.monthly_reports.table tr th:nth-child(4),.monthly_reports.table tr td:nth-child(4),.monthly_reports.table tr th:nth-child(5),.monthly_reports.table tr td:nth-child(5){
                background: rgba(195, 32, 4,.2);
            }
            .data-table.annual_procurement_plans.table tr th:nth-child(5),.data-table.annual_procurement_plans.table tr td:nth-child(5),.data-table.annual_procurement_plans.table tr th:nth-child(6),.data-table.annual_procurement_plans.table tr td:nth-child(6),.monthly_reports.table tr th:nth-child(6),.monthly_reports.table tr td:nth-child(6),.monthly_reports.table tr th:nth-child(7),.monthly_reports.table tr td:nth-child(7){
                background: rgba(32, 195, 4,.2);
            }

            .uploadimg,.upload_attached_docs{
                margin-top: -35px;
                opacity: 0;
            }
            .hide_row .row{
                display:none;
            }
            #TertiaryModal .modal-dialog{
                height: 98%;
                left: 20%;
                margin: 1% 0 0;
                overflow: auto;
                position: absolute;
                width: 60%;
            }
            .PdfViewerModal .modal-dialog{
                height: 98%;
                left: 10%;
                margin: 1% 0 0;
                overflow: auto;
                position: absolute;
                width: 80%;
            }
            #modalRenameFile .modal-dialog{
                left: 15%;
                margin: 1% 0 0;
                overflow: auto;
                position: absolute;
                width: 70%;
            }
            .btnSubmit{margin:auto;min-width: 120px}
            .table .radio{padding-top:0;}
            .btn-group-minier>.btn, .btn-minier {
                margin: 5px;
                border-radius: 4px;
                padding: 0 4px;
                line-height: 18px;
                border-width: 2px;
                font-size: 12px;
            }
            .bold-text {
                font-weight: 500;
            }
            .warning{
                color: #ffa02e;
            }
            .success{
                color: #00BE67;
            }
            .center-modal .modal-content {
                margin-top: 25%;
            }

            @media only screen and (min-width: 992px){
                .sidebar.h-sidebar .nav-list>li.hover>.submenu {
                    width: 200px;
                }
            }
            .right{
                text-align: right !important;
            }
            .datatable-no-number-limit .dataTables_length{
                display: none;
            }
            .datatable-no-search .dataTables_filter{
                display: none;
            }
            .datatable-no-paginate .dataTables_paginate {
                display: none;
            }
            .datatable-no-length .dataTables_length{
                display: none;
            }
            .datatable-no-info .dataTables_info{
                display: none;
            }
            #action_log_panel .panel-title a.accordion-toggle {
                width: 100%;
                display: block !important;
                font-weight: bolder !important;
                background-color: rgba(030 ,144, 255,.3) !important;
                margin-top: 2px;
                margin-bottom: 2px;
                padding: 1rem !important;
            }
        </style>
    </head>
    <body class="no-skin">
        <div class="submit_msg"></div>
        @include('layouts.webparts.titlebar')
        <div class="main-container hidden-xs" id="desktop_view">
            <script type="text/javascript">
                try{ace.settings.check('main-container' , 'fixed')}catch(e){}
            </script>
            @include('layouts.webparts.navbar')
            <div class="main-content">
                <div class="main-content-inner">
                    <div class="page-content">
                        <div class="row">
                            <div class="col-xs-12">
                                @yield('content')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
                <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
            </a>
        </div>
        @include('layouts.webparts.footer')
        @yield('scripts')
    </body>
</html>
