@php
    $summary = [];
    foreach ($records as $rec) {
        $application = $rec->application;
        $module = $rec->module;
        $section = $rec->section;
        $sub_section = $rec->sub_section;
        @++$summary[$application][$module][$section][$sub_section];
    }

@endphp
<a href="javascript://" class="btn btn-mini btn-primary pull-right" onclick="export_to('summary')">Export to Excel</a>
<table class="table table-striped table-bordered table-hover no-margin-bottom no-border-top dataTable no-footer" id="summary">
    <thead>
        <tr>
            <th colspan="5">Summary Application Usage Report for period:  {{$period}}</th>
        </tr>
        <tr>
            <th>Application</th>
            <th>Module</th>
            <th>Section</th>
            <th>Sub Section</th>
            <th>Count</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($summary as $application => $modules)
            @foreach ($modules as $module => $sections)
                @foreach ($sections as $section => $subs)
                    @foreach ($subs as $sub => $count)
                        <tr>
                            <td>{{ $application }}</td>
                            <td>{{ $module }}</td>
                            <td>{{ $section }}</td>
                            <td>{{ $sub }}</td>
                            <td>{{ number_format($count) }}</td>
                        </tr>
                    @endforeach
                @endforeach
            @endforeach
        @endforeach
    </tbody>
</table>