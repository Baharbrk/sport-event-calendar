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
    }).done(function (result) {
        alert(result);
    }).fail();
};

function getEvents() {
    $.ajax({
        url: 'http://localhost:8000/events',
        method: 'GET'
    }).done(function (result) {
        $('#events-list').append(result);
    }).fail();
};

function filterEvents(e) {
    e.preventDefault();
    $.ajax({
        url: 'http://localhost:8000/events?category_id=' + $('#filter-category').val(),
        method: 'GET',
    }).done(function (result) {
        $("#events-list").append(result);
    }).fail();
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


    })
}