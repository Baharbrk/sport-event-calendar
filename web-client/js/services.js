function addEvent(e) {
    e.preventDefault();
    $.ajax({
        url: 'http://localhost:8000/events/add',
        method: 'POST',
        data: {
            date: $('#date').val() + ' ' + $('#time').val(),
            category: $('#category').val(),
            home_team: $('#home-team').val(),
            away_team: $('#away-team').val()
        }
    }).done(function () {
        getEvents();
    }).fail(function () {
        alert('Unable to add event');
    });
};

function deleteEvent(id) {
    if (confirm('Are you sure you want to delete this event?')) {
        $.ajax({
            url: 'http://localhost:8000/events/delete',
            method: 'POST',
            data: {
                event_id: id
            }
        }).done(function () {
            getEvents();
        }).fail(function () {
            alert('Unable to remove the event');
        });
    }
}

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

function getEvents() {
    $.ajax({
        url: 'http://localhost:8000/events',
        method: 'GET'
    }).done(function (result) {
        let events = JSON.parse(result);
        loadCalendar(events);
    }).fail(function () {
        alert('Unable to load events');
    });
};


function filterEvents(e) {
    e.preventDefault();
    $.ajax({
        url: 'http://localhost:8000/events?category_id=' + $('#filter-category').val(),
        method: 'GET',
    }).done(function (result) {
        let events = JSON.parse(result);
        loadCalendar(events);
    }).fail(function () {
        alert('Unable to filter events');
    });
}

function filterTeams() {
    $.ajax({
        url: 'http://localhost:8000/team/filter',
        method: 'POST',
        data: {
            category_id: $('#category').val(),
        }
    }).done(function (result) {
        var homeTeamSelect = $('#home-team');
        var awayTeamSelect = $('#away-team');
        homeTeamSelect.empty();
        awayTeamSelect.empty();
        homeTeamSelect.append(
            $('<option disabled selected value></option>').html('- Home Team -')
        );
        awayTeamSelect.append(
            $('<option disabled selected value></option>').html('- Aaway Team -')
        );
        $.each(JSON.parse(result), function (key, value) {
            homeTeamSelect.append(
                $('<option></option>').val(value.id).html(value.name)
            );
            awayTeamSelect.append(
                $('<option></option>').val(value.id).html(value.name)
            );
        })
    }).fail(function () {
        alert('Unable to filter Teams by their category');
    });
}