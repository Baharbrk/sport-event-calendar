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
        alert('Event is added successfully');
        getEvents();
    }).fail(function () {
        alert('Unable to add event');
    });
};
function updateEvent(eventId, eventDate) {
    $.ajax({
        url: 'http://localhost:8000/events/update',
        method: 'POST',
        data: {
            event_id: eventId,
            new_date: eventDate,
        }
    }).done(function () {
        alert('Event is updated');
        getEvents();
    }).fail(function () {
        alert('Unable to Update the event');
    });
}
function deleteEvent(eventId) {
    if (confirm('Are you sure you want to delete this event?')) {
        $.ajax({
            url: 'http://localhost:8000/events/delete',
            method: 'POST',
            data: {
                event_id: eventId
            }
        }).done(function () {
            alert('Event is removed');
            getEvents();
        }).fail(function () {
            alert('Unable to remove the event');
        });
    }
}

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