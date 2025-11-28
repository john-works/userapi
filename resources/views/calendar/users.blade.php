<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12 mb-5">
                <a title="Add Calendar Users" class="pull-right btn btn-primary btn-sm clarify_secondary" href="{{route('calendar_users.create')}}">
                    Add Calendar Users
                </a>
            </div>
        </div>
        <table class="data-table calendar_users table table-striped table-bordered table-hover no-margin-bottom no-border-top">
            <thead class="admin-table-head">
                <tr>
                    <th>User</th>
                    <th>Calendar</th>
                    <th>Actions</th>
                </tr>
            </thead>
            {{-- <tbody id="calendar_users_table">
            @if(is_null($calendarusers) || count($calendarusers) == 0)
                <tr><td class="center" colspan="3">No calendar users found</td></tr>
            @else
                @foreach($calendarusers as $calendaruser)
                    <tr>
                        <td>{{$calendaruser->first_name}} {{$calendaruser->last_name}}</td>
                        <td>{{$calendaruser->calendar_name}}</td>
                        <td>
                            <a data-delete-url="{{route('calendar_users.delete',$calendaruser->id)}}" data-item-gp="user" data-item-name="{{$calendaruser->name}}" class="text-danger" href="{{route('calendar_users.delete',$calendaruser->id)}}" >
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody> --}}
        </table>
    </div>
</div>