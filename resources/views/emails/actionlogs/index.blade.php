<div>

    <table style="width: 80%; border-collapse: collapse ">
        <thead>
        <tr style="background-color: #00008A; color: white">
            <th colspan="2" style="text-align: right; padding: 5px; width: 40%;">
                {{APP_NAME_CUSTOM}}
            </th>
        </tr>
        <tr style="background-color: #4747FF; color: white">
            <th colspan="2" style="text-align: left; padding: 5px;width: 60%">
                New action log action
            </th>
        </tr>
        </thead>
        <tbody>
        <tr style="background-color: #d7faf8; padding: 5px;">
            <td style="font-weight: bold;">Action Log Type:</td>
            <td>{{$notification->actionLogType}}</td>
        </tr>
        <tr style="background-color: white; padding: 5px;">
            <td style="font-weight: bold;">Date Opened:</td>
            <td>{{$notification->dateOpened}}</td>
        </tr>
        <tr style="background-color: #d7faf8; padding: 5px;">
            <td style="font-weight: bold;">Required Action:</td>
            <td>{{$notification->requiredAction}}</td>
        </tr>
        <tr style="background-color: white; padding: 5px;">
            <td style="font-weight: bold;">Task Details:</td>
            <td>{{$notification->nextAction}}</td>
        </tr>
        <tr style="background-color: #d7faf8; padding: 5px;">
            <td style="font-weight: bold;">Task User:</td>
            <td>{{$notification->nextActionUser}}</td>
        </tr>
        <tr style="background-color: #d7faf8; padding: 5px;">
            <td style="font-weight: bold;">Planned Completion Date:</td>
            <td>{{get_user_friendly_date_time($notification->nextActionDate)}}</td>
        </tr>
        </tbody>
    </table>

</div>

