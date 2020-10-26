$('#exampleModal').modal({
    show: 'false'
});
const calendarSetting = {
    Color: '#999',                //(string - color) font color of whole calendar.
    LinkColor: '#333',            //(string - color) font color of event titles.
    NavShow: true,                //(bool) show navigation arrows.
    NavVertical: false,           //(bool) show previous and coming months.
    NavLocation: '#foo',          //(string - element) where to display navigation, if not in default position.
    DateTimeShow: true,           //(bool) show current date.
    DateTimeFormat: 'mmm, yyyy',  //(string - dateformat) format previously mentioned date is shown in.
    DatetimeLocation: '',         //(string - element) where to display previously mentioned date, if not in default position.
    EventClick: '',               //(function) a function that should instantiate on the click of any event. parameters passed in via data link attribute.
    EventTargetWholeDay: false,   //(bool) clicking on the whole date will trigger event action, as opposed to just clicking on the title.
    DisabledDays: [],             //(array of numbers) days of the week to be slightly transparent. ie: [1,6] to fade Sunday and Saturday.
};

function openModal(eventId) {
    $('#exampleModal').modal('show');
    $('#delete-button').on('click', function () {
        $('#exampleModal').modal('hide');
        deleteEvent(eventId);
    });
    $('#update-button').on('click', function () {
        
        if ($('#update-date').val() && $('#update-time').val()) {
            let newDate = $('#update-date').val() + ' ' + $('#update-time').val();
            $('#exampleModal').modal('hide');
            updateEvent(eventId, newDate);
        } else {
            alert('Please Provide Date time');
        }
    });
}

function loadCalendar(events) {
    let eventsCalendar = [];
    $.each(events, function (key, value) {
        let time = new Date(value.date).getHours() + ":" + new Date(value.date).getMinutes();
        let year = new Date(value.date).getFullYear();
        let day = new Date(value.date).getDate();
        let month = new Date(value.date).getMonth();
        let eventColor = '#' + value.hex_color;
        let title = '<div class="event" style="background-color:' + eventColor + '">';
        title += time + ' ' + value.category_name + ' , ' + value.home_team + ' - ' + value.away_team;
        title += '</div>';
        eventsCalendar.push({
            Date: new Date(year, month, day),
            Title: title,
            Link: function () {
                openModal(value.id);
            }
        })
    });

    $('#events-list').empty();
    caleandar(document.querySelector('#events-list'), eventsCalendar, calendarSetting);
}

$(document).ready(function () {
    getEvents();
});
