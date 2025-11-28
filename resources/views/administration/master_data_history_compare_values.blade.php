

<div class="row compare_values">
    <div class="col-md-12">

        <table style="width: 80%; border-collapse: collapse;margin: 20px auto ">
            <thead>
            <tr style="background-color: #4747FF; color: white"><th colspan="2" style="text-align: left; padding: 5px;width: 60%">General Details</th></tr>
            </thead>
            <tbody>
            <tr style="background-color: white; padding: 5px;"><td style="font-weight: bold;">Parent Master Data Type:</td><td>{{$history->parent_master_data_type}}</td></tr>
            <tr style="background-color: white; padding: 5px;"><td style="font-weight: bold;">Master Data Type:</td><td>{{$history->master_data_type}}</td></tr>
            <tr style="background-color: #d7faf8; padding: 5px;"><td style="font-weight: bold;">Action Type:</td><td>{{$history->action_type}}</td></tr>
            <tr style="background-color: white; padding: 5px;"><td style="font-weight: bold;">Action User:</td><td>{{user_full_name(getEmployee($history->action_user))}}</td></tr>
            <tr style="background-color: #d7faf8; padding: 5px;"><td style="font-weight: bold;">Action Date:</td><td>{{get_user_friendly_date_time($history->action_date)}}</td></tr>
            </tbody>
        </table>

        <!-- #show changes -->
        <table style="width: 80%; border-collapse: collapse; margin: 20px auto">
            <thead>
            <tr style="background-color: #4747FF; color: white">
                <th style="width: 50%;text-align: left;padding: 5px;">Old Value</th>
                <th style="width: 50%;text-align: left;padding: 5px;">New Value</th>
            </tr>
            </thead>
            <tbody>

            <tr style="background-color: white;">
                @if(!isset($history->old_value) || $history->old_value == 'N/A')
                    <td class="no-value">N/A</td>
                @else
                    <td>{!! json_print($history->old_value) !!}</td>
                @endif

                @if(!isset($history->new_value) || $history->new_value == 'N/A')
                    <td class="no-value">N/A</td>
                @else
                    <td>{!! json_print($history->new_value) !!}</td>
                @endif

            </tr>
            </tbody>
        </table>

    </div>
</div>
