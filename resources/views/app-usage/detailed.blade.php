<a href="javascript://" class="btn btn-mini btn-primary pull-right" onclick="export_to('detailed')">Export to Excel</a>
<table class="table table-striped table-bordered table-hover no-margin-bottom no-border-top dataTable no-footer" id="detailed">
    <thead>
        <tr>
            <th colspan="6">Detailed Application Usage Report for period:  {{$period}}</th>
        </tr>
        <tr>
            <th>Application</th>
            <th>Module</th>
            <th>Section</th>
            <th>Sub Section</th>
            <th>Access User</th>
            <th>Access Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($records as $rec)
            <tr>
                <td>{{ $rec->application }}</td>
                <td>{{ $rec->module }}</td>
                <td>{{ $rec->section }}</td>
                <td>{{ $rec->sub_section }}</td>
                <td>{{ $rec->username }}</td>
                <td>{{ get_user_friendly_date_time($rec->access_datetime) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>