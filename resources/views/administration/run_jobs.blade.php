
<table class=" table table-striped table-bordered table-hover no-margin-bottom no-border-top">
    <thead>
    <tr>
        <th >Job Name</th>
        <th >Description</th>
        <th style="width: 20%">Schedule</th>
        <th style="width: 15%">Mailing List</th>
        <th style="width: 5%"></th>
    </tr>
    </thead>
    <tbody>
    @foreach($jobs as $job)
        <tr>
            <td>{{$job->jobName}}</td>
            <td>{{$job->description}}</td>
            <td>{{$job->schedule}}</td>
            <td>{{$job->mailingListName}}</td>
            <td>{!! $job->actions !!}</td>
        </tr>
    @endforeach
    </tbody>
</table>