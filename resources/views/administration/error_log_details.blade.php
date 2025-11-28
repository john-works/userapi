<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <table style="width: 100%; border-collapse: collapse ">
            <thead>
            <tr style="background-color: #4747FF; color: white"><th colspan="2" style="text-align: left; padding: 5px;width: 60%">Error Details</th></tr>
            </thead>
            <tbody>

            @if(isset($jobName) && $jobName != 'N/A')
                <tr style="background-color: white; padding: 5px;"><td style="font-weight: bold;width:15%;padding: 5px">Job Name:</td><td style="padding: 5px">{{$jobName}}</td></tr>
            @endif
            <tr style="background-color: #d7faf8; padding: 5px;"><td style="font-weight: bold;width:15%;padding: 5px">Error:</td><td style="color: red;padding: 5px">{{$error->error_message}}</td></tr>
            <tr style="background-color: white; padding: 5px;"><td style="font-weight: bold;width:15%;padding: 5px">Error Code:</td><td style="padding: 5px">{{$error->error_code}}</td></tr>
            <tr style="background-color: #d7faf8; padding: 5px;"><td style="font-weight: bold;width:15%;padding: 5px">Class:</td><td style="color: red;padding: 5px">{{$error->class_name}}</td></tr>
            <tr style="background-color: white; padding: 5px;"><td style="font-weight: bold;width:15%;padding: 5px">Method:</td><td style="padding: 5px">{{$error->method}}</td></tr>
            <tr style="background-color: #d7faf8; padding: 5px;"><td style="font-weight: bold;width:15%;padding: 5px">Line:</td><td style="color: red;padding: 5px">{{$error->line_number}}</td></tr>
            <tr style="background-color: white; padding: 5px;"><td style="font-weight: bold;width:15%;padding: 5px">Stack Trace:</td><td style="padding: 5px">{{$error->stack_trace}}</td></tr>

            </tbody>
        </table>
    </div>
</div>
