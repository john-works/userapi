<div class="">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('generate.app.usage.report') }}" method="post" class="form-horizontal" id="form_{{ time() }}">
                        {{csrf_field()}}
                        <div class="form-group row">
                            <label for="request_date" class="col-md-4 col-form-label text-md-right text-bold">Start Date:</label> 
                            <div class="col-md-8">
                                <input type="text" name="start_date" value="{{ date('j M Y') }}" class="form-control calendar" required id="start_date"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="request_by" class="col-md-4 col-form-label text-md-right text-bold">End Date:</label> 
                            <div class="col-md-8">
                                <input type="text" name="end_date" value="{{ date('j M Y') }}" class="form-control calendar" required id="end_date"/>
                            </div>
                        </div>
                        @php
                            $report_types = ['Summary','Detailed'];
                        @endphp
                        <div class="form-group row">
                            <label for="request_for" class="col-md-4 col-form-label text-md-right text-bold">Report Type:</label>
                            <div class="col-md-8">
                                <select name="report_type" id="report_type" required class="form-control selectize">
                                    @foreach($report_types as $type)
                                        <option value="{{$type}}">{{$type}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary btnGenerateReport pull-right btn-sm">
                                    Generate
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="results" id="report_data"></div>