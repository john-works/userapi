<div class="row">
	<div class="col-md-2">
		Calendar Types
	</div>
	<div class="col-md-6">
		<form class="form-inline">
			<div class="form-group">
			  <label class="sr-only" for="exampleInputAmount">Amount (in dollars)</label>
			  <div class="input-group">
				{{-- <select class="form-control" id="calendarSelector" onchange="switchCalendar()">
					<option value="" selected disabled>Select Calendar</option>
					@foreach ($calendars as $calendar)
						<option value="{{ $calendar->id }}">{{ $calendar->name }}</option>
					@endforeach
					<option value="0">Show all</option>
				</select> --}}
			  </div>
			</div>
		  </form>
	</div>
</div>

<div class="row">
	<div class="col-md-2">
		Switch Calendar
	</div>
	<div class="col-md-4">
		<div class="container mt-5">
			<form class="form-inline">
				<div class="form-group mx-2">
					<input type="radio" class="form-check-input" id="month" name="viewType" value="month">
					<label class="form-check-label" for="monthly">Monthly</label>
				</div>
				<div class="form-group mx-2">
					<input type="radio" class="form-check-input" id="week" name="viewType" value="week" checked>
					<label class="form-check-label" for="weekly">Weekly</label>
				</div>
				<div class="form-group mx-2">
					<input type="radio" class="form-check-input" id="day" name="viewType" value="day">
					<label class="form-check-label" for="daily">Daily</label>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-2">
		Navigation
	</div>
	<div class="col-md-4">
		<div class="btn-group">
			<div  class="btn btn-primary btn-sm" onclick="reloadEvents()">Reload</div>
			<div class="btn btn-primary btn-sm" onclick="switchView('today')">Today</div>
			<div  class="btn btn-primary btn-sm" onclick="switchView('previous')">Previous</div>
			<div class="btn btn-primary btn-sm" onclick="switchView('next')">Next</div>
		</div>
    </div>
</div>
<div id="calendar" style="height:100vh"></div>
<script type="text/javascript" src="{{ asset('js/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/chance.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/tui-time-picker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/tui-date-picker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/toastui.min.js') }}"></script>
<script type="text/javascript">
$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
let currentViewType = 'week';
let calendars = [];
let totalCalendars = "{{ $calendars->count() }}";
let calendar = new tui.Calendar('#calendar', {
	defaultView: currentViewType,
	taskView: true,
	useFormPopup: true,
	useDetailPopup: true,
	useCreationPopup: true,
	usageStatistics: false,
	template: {
		monthGridHeader: function(model) {
			var date = new Date(model.date);
			var template = '<span class="tui-full-calendar-weekday-grid-date">' + date.getDate() + '</span>';
			return template;
		},
		time(event) {
			const { start, end, title } = event;
			return `<span style="color: black;">${event.title}</span>`;
		},
			allday(event) {
			return `<span style="color: white;">${event.title}</span>`;
		},
	},
});

function renderEvents(data, styling) {
    calendar.clear();
	if(styling == undefined){
        data.forEach(function (calendarData) {
            calendarData.events.forEach(function (event) {
                calendar.createEvents([{
                    id: event.id,
                    calendarId: event.calendar_id,
                    title: event.title,
                    body: event.body,
                    start: new Date(event.start),
                    end: new Date(event.end),
                    location: event.location,
                    category: event.category,
                    state: event.state,
					color:'#000',
					backgroundColor:'transparent',
					borderColor:'transparent',
					dragBackgroundColor:'transparent',
                    customStyle: {
                        backgroundColor: calendarData.styling.backgroundColor,
                        borderColor: calendarData.styling.borderColor,
                        color: calendarData.styling.color,
                    },
                }]);
            });
        });
    } else {
        data.forEach(function (event) {
            calendar.createEvents([{
                id: event.id,
                calendarId: event.calendar_id,
                title: event.title,
                body: event.body,
                start: new Date(event.start),
                end: new Date(event.end),
                location: event.location,
                category: event.category,
                state: event.state,
				color:'#000',
				backgroundColor:'transparent',
				borderColor:'transparent',
				dragBackgroundColor:'transparent',
                customStyle: {
					dragBackgroundColor:styling.dragBackgroundColor,
                    backgroundColor: styling.backgroundColor,
                    borderColor: styling.borderColor,
                    color: styling.color,
                },
            }]);
        });
    }
    calendar.render();
}

function loadEvents(calendarId) {
    let url = '/events';
    if (calendarId && calendarId != 0) {
        url += '?calendarId=' + calendarId;
    }else{
		url = '/events';
	}

    $.ajax({
        type: "GET",
        url: url,
		success: function (response) {
			if (calendarId && calendarId != 0) {
				renderEvents(response.events, response.styling);
				calendar.setCalendars(response.calendars);
   			} else {
				renderEvents(response.calendars);
				calendar.setCalendars(response.calendars);
			}
		},
        error: function (response) {
            console.log(response);
        }
    });
}

loadEvents();

calendar.on('beforeCreateEvent', (data) => {
	let title = data.title	
    let location = data.location
    let parsedStart = new Date(data.start.d.d)
	let start = parsedStart.toISOString().slice(0, 19).replace('T', ' ');
    let parsedEnd = new Date(data.end.d.d)
	let end = parsedEnd.toISOString().slice(0, 19).replace('T', ' ');
    let isAllDay = data.isAllDay ? 1 : 0;
    let calendarId = document.getElementById('calendarSelector').value; // Get the selected calendarId
    let category = data.category
    let isPrivate = data.isPrivate ? 1 : 0;
    let state = data.state ? data.state : 'Busy';

    $.ajax({
        type: "POST",
        url: '/events/store',
        data: {
			title: title,
            location: location,
            start: start,
            end: end,
            isAllDay: isAllDay,
            calendarId: calendarId, // Include the selected calendarId
            category: category,
            isPrivate: isPrivate,
            state: state
        },
        cache: false,
        success: function (response) {
            calendar.createEvents([
                {
                    id: response.id,
                    calendarId: response.calendar_id,
                    title: response.title,
                    body: response.body,
                    start: new Date(response.start),
                    end: new Date(response.end),
                    location: response.location,
                    category: response.category,
                    state: response.state,
                },
            ]);
            calendar.render();
        },
        error: function (response) {
            // If fail, then show error response
            console.log(response);
        }
    });
});
// Update event
calendar.on('beforeUpdateEvent', ({ event, changes }) => {
	let title = changes.title ? changes.title : event.title;
	let location = changes.location? changes.location : event.location;
	let parsedStart = changes.start.d.d ? new Date(changes.start.d.d) :new Date(event.start.d.d);
	let start = parsedStart.toISOString().slice(0, 19).replace('T', ' ');
	let parsedEnd = changes.end.d.d? new Date(changes.end.d.d) : new Date(event.end.d.d);
	let end = parsedEnd.toISOString().slice(0, 19).replace('T', ' ');
	let isAllDay = (Boolean((changes.isAllDay)? changes.isAllDay : event.isAllDay))? 1 : 0;
	let calendarId = changes.calendarId? changes.calendarId : event.calendarId;
	let category = changes.category? changes.category : event.category;
	let isPrivate = (Boolean((changes.isPrivate)? changes.isPrivate : event.isPrivate))? 1 : 0;
	let state = changes.state ? changes.state : event.state;
	$.ajax({
		type: "PUT",
		url: `/events/update/${event.id}`,
		data: {
			id: event.id,
			title: title,
			location: location,
			start: start,
			end: end,
			isAllDay: isAllDay,
			calendarId: calendarId,
			category: category,
			isPrivate: isPrivate,
			state: state
		},
		cache: false,
		success: function (response) {
			calendar.updateEvent(event.id, event.calendarId, changes);
			calendar.render();
		},
		error: function (response) {
			// If fail, then show error response
			console.log(response);
		}
	});
});

calendar.on('beforeDeleteEvent', (eventObj) => {
	$.ajax({
		type: "DELETE",
		url: `/events/delete/${eventObj.id}`,
		cache: false,
		success: function (response) {
			calendar.deleteEvent(eventObj.id, eventObj.calendarId);
		},
	});

});

  function getDefaultCalendarId() {
    return calendars.length > 0 ? calendars[0].id : null;
  }
  function reloadEvents() {
    let calendarId = document.getElementById('calendarSelector').value;
    loadEvents(calendarId);
  }

  // calendar views
  const radioButtons = document.getElementsByName('viewType');
    radioButtons.forEach(function(radioButton) {
        radioButton.addEventListener('change', function() {
          currentViewType = this.value;
            calendar.changeView(currentViewType);
        });
    });

    // function to switch views
  	function switchView(action) {
		if (action === 'today') {
			calendar.today();
		} else if (action === 'previous') {
			if (currentViewType === 'day') {
				calendar.prev();
			} else if (currentViewType === 'week') {
				calendar.prev();
			} else if (currentViewType === 'month') {
				calendar.prev();
			}
		} else if (action === 'next') {
			if (currentViewType === 'day') {
				calendar.next();
			} else if (currentViewType === 'week') {
				calendar.next();
			} else if (currentViewType === 'month') {
				calendar.next();
			}
		}
	};

	//Function to switch calendars
	function switchCalendar(calendar) {
		var calendarId = document.getElementById('calendarSelector').value;
		if(calendarId == 0){
			showAllCalendars(totalCalendars);
			reloadEvents();
		}else{
			hideAllCalendars(totalCalendars);
			showSelectedCalendar(calendarId);
			reloadEvents();
			getCalendarUsers(calendarId);
		}
	}

	function hideAllCalendars(totalCalendars){
		if(totalCalendars == 0){
		for (var i = 1; i <= totalCalendars; i++) {
				calendar.setCalendarVisibility(i,false);
			}
		}
	}
	function showAllCalendars(totalCalendars){
		if(totalCalendars == 0){
			for (var i = 1; i <= totalCalendars; i++) {
				calendar.setCalendarVisibility(i,true);
			}
		}
	}

	function showSelectedCalendar(calendarId){
		calendar.setCalendarVisibility(calendarId,true);
	}
	
	function getCalendarUsers(calendarId){
		$.ajax({
			type: "GET",
			url: `/calendar_users/${calendarId}`,
			cache: false,
			success: function (response) {
				$('#calendar_users').html(response);
			},
		});

	}
	function getEventTemplate(event, isAllday) {
    var html = [];
    var start = moment(event.start.toDate().toUTCString());
    if (!isAllday) {
      html.push('<strong>' + start.format('HH:mm') + '</strong> ');
    }

    if (event.isPrivate) {
      html.push('<span class="calendar-font-icon ic-lock-b"></span>');
      html.push(' Private');
    } else {
      if (event.recurrenceRule) {
        html.push('<span class="calendar-font-icon ic-repeat-b"></span>');
      } else if (event.attendees.length > 0) {
        html.push('<span class="calendar-font-icon ic-user-b"></span>');
      } else if (event.location) {
        html.push('<span class="calendar-font-icon ic-location-b"></span>');
      }
      html.push(' ' + event.title);
    }

    return html.join('');
  }
</script>