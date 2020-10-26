$(document).ready(function () {
    getEvents();
});

function loadCalendar(events) {
    let eventsCalendar = [];
    $.each(events, function (key, value) {
        let time = new Date(value.date).getHours() + ":" + new Date(value.date).getMinutes();
        let year = new Date(value.date).getFullYear();
        let day = new Date(value.date).getDate();
        let month = new Date(value.date).getMonth();
        eventsCalendar.push({
            Date: new Date(year, month, day),
            Title: time + ' ' + value.category_name + ' , ' + value.home_team + ' - ' + value.away_team,
            Link: function () {
                deleteEvent(value.id)
            }
        })
    });

    $('#events-list').empty();
    caleandar(document.querySelector('#events-list'), eventsCalendar, calendarSetting);
}