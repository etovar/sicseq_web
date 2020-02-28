$(document).ready(function(){
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            right: 'title',
            center: ''
        },
        navLinks: true,
        eventLimit: false,
        locale: 'es',
        eventColor: '#169F85',
        events: events,
        selectable: true,
        defaultView: 'agendaWeek',
        minTime: "08:00:00",
        maxTime: "15:00:00",
        height: 650,
    });

    $("#irsHora").ionRangeSlider({
        type: "double",
        min: +moment().set({hour:9,minute:0}).format("X"),
        max: +moment().set({hour:14,minute:0}).format("X"),
        from: +moment().set({hour:10,minute:0}).format("X"),
        to: +moment().set({hour:12,minute:0}).format("X"),
        grid: true,
        force_edges: true,
        prettify: function(num) {
            var m = moment(num, "X");
            return m.format("HH:mm");
        }
    });

});
