
<div>
    <div class="col-md-12 text-left um-primary-bg ">
        <div class="navbar-brand" style="float: none">
            <a href="{{ asset('') }}" class=" text-white">
                <small> PPDA Applications </small>
            </a>            

            <div class="pull-right" style="display: inline-block">

                @if(isset($appSelection))
                    @if(getAuthUser() != null)
                        @if(getAuthUser()->is_admin == 1)

                        <a class="btn btn-minier btn-out-of-office" href="{{route('offline.index')}}" target="_blank" >
                            Offline Access
                        </a>
                         {{-- <a class="btn btn-minier btn-out-of-office" href="{{route('shared_resouces.index')}}" target="_blank" >
                            Shared Resources
                        </a> --}}
                        <div class="dropdown" style="display: inline-block">
                            <a class="btn btn-minier btn-out-of-office" href="#" id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Administration
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dLabel">
                                <li><a title="Job Error Logs" class="clarify" href="{{route('administration.error_logs')}}"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span>Job Error Logs</a></li>
                                <li><a title="Run Jobs" class="clarify" href="{{route('administration.run_jobs')}}"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span>Run Jobs</a></li>
                             </ul>
                        </div>
                        <a title="View Session" class="btn btn-minier btn-out-of-office clarify" href="{{route('session-history')}}" >View Session</a>
                        <a title="All Trusted Devices" class="btn btn-minier btn-out-of-office clarify" href="{{route('trusted-devices.admin')}}" >All Trusted Devices</a>
                        <a class="btn btn-minier btn-out-of-office" target="_blank" href="{{route('users.access-app',['ppda-admin-app'])}}" >User Management</a>
                        @endif

                        @if(getAuthUser()->is_out_of_office_delegate_user == 1)
                            <a title="All Out of Offices" class="btn btn-minier btn-out-of-office clarify" href="{{route('out-of-office.admin')}}" >All Out of Offices</a>
                        @endif
                        <a title="Out of Office for {{ucwords(strtolower(session('user')->fullName))}}" class="btn btn-minier btn-out-of-office clarify" href="{{route('out-of-office')}}" >My Out of Office</a>
                        <a title="Resource Bookings for {{ucwords(strtolower(session('user')->fullName))}}" class="btn btn-minier btn-out-of-office clarify" href="{{route('bookings.index')}}" >Resource Bookings</a>
                        <div class="dropdown pull-right" style="display: inline-block">
                            <a class="link" href="#" id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="glyphicon glyphicon-user" aria-hidden="true" style="margin: 5px"></span>
                                @if(session()->has('user')){{strtoupper(session('user')->fullName)}}@else{{'USER'}}@endif
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dLabel">
                                <li><a title="Trusted Device Status" class="clarify" href="{{route('trusted-devices.status')}}"><span class="glyphicon glyphicon-check" aria-hidden="true"></span>Trusted Device Status</a></li>
                               <li><a title="Change Password" class="clarify" href="{{route('users.change-password-form')}}"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span>Change Password</a></li>
                                <li><a href="{{route('singout_admin')}}"><span class="glyphicon glyphicon-off" aria-hidden="true"></span>Logout</a></li>
                            </ul>
                        </div>
                    @endif
                @endif

            </div>


        </div>

    </div>
</div>

