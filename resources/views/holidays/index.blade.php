<div class="">
    <div class="row justify-content-center">
        <div class="card">
            <div class="card-body">
                <div class="col-md-12">
                <div class="row">
                    <form class="form-horizontal" action="{{route('public_holidays.get_range')}}" method="post" id="form_{{time()}}">
                        {{Form::hidden('ext',null, ['value'=>'0'])}}
                        @csrf
                        <div class="col-md-4" >
                            <label for="range_start"  style="font-weight: bold" class="col-md-12 col-form-label text-md-left">{{ __('From Date:') }}</label>
                            <div class="col-md-12" >
                                <input required type="date" class="form-control" id="range_start"  name="range_start"/>
                            </div>
                        </div>
                        <div class="col-md-4" >
                            <label for="range_end"  style="font-weight: bold" class="col-md-12 col-form-label text-md-left">{{ __('To Date:') }}</label>
                            <div class="col-md-12" >
                                <input required type="date" class="form-control" id="range_end"  name="range_end"/>
                            </div>
                        </div>
                        <div class="col-md-3 center">
                            <label for="ranges"  style="font-weight: bold" class="col-md-12 col-form-label text-md-left">&nbsp;</label>
                            {{Form::submit("Get Public Holidays", ['class'=>'btn btn-primary btn-sm getRangeHolidays'])}}
                        </div>
                    </form>
                </div>
                <div class="row hidden" id="range_results">
                    <div class="form-horizontal col-md-6" style="margin: 10px! important;">
                        <table class="table table-bordered table-striped table-hover" id="range_holidays_table">
                            <thead>
                                <tr>
                                    <th>Holiday Name</th>
                                    <th>Holiday Date</th>
                                </tr>
                            </thead>
                            <tbody id="range_holidays_body">
                            </tbody>
                        </table>
                    </div>

                </div>       
                <div class="row">
                    <form class="form-horizontal" action="{{route('public_holidays.get_year')}}" method="post" id="form_{{time()}}">
                        {{Form::hidden('ext',null, ['value'=>'0'])}}
                        @csrf
                        <div class="col-md-4" >
                            <label for="calendar_year"  style="font-weight: bold" class="col-md-12 col-form-label text-md-left">{{ __('Year:') }}</label>
                            <div class="col-md-12" >
                                <input required type="text" class="yearpicker form-control" id="selected_year" name="selected_year"/>
                            </div>
                        </div>
                        <div class="col-md-3 center">
                            <label for="years"  style="font-weight: bold" class="col-md-12 col-form-label text-md-left">&nbsp;</label>
                            {{Form::submit("Get Public Holidays", ['class'=>'btn btn-primary btn-sm getYearHolidays'])}}
                        </div>
                    </form>
                </div>
                <div class="row hidden" id="year_results">
                    <div class="form-horizontal col-md-6" style="margin: 10px! important;">
                        <table class="table table-bordered table-striped table-hover" id="year_holidays_table">
                            <thead>
                                <tr>
                                    <th>Holiday Name</th>
                                    <th>Holiday Date</th>
                                </tr>
                            </thead>
                            <tbody id="year_holidays_body">
                            </tbody>
                        </table>
                    </div>

                </div>       
            </div>
            </div>
        </div>

    </div>
</div>