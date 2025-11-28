<div>
    NOTE: The person you are delegating to will be out of office on some days in the range selected. See details below:
</div>

<ol style="margin-top: 20px;margin-bottom: 20px">
    @foreach ($outOfOffices as $outOfOffice)
        <li>
            <span style="text-decoration: underline">{{$outOfOffice->delegation_by_name}} </span>
            is currently out of office from {{get_user_friendly_date_time_with_day($outOfOffice->start_date)}} to {{get_user_friendly_date_time_with_day($outOfOffice->end_date)}} ,
            Letter movement will be sent to <span style="text-decoration: underline">{{$outOfOffice->delegation_to_name}}</span>
        </li>
    @endforeach
</ol>
