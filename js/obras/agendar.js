$(document).ready(function(){
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay,listWeek'
        },
        navLinks: true,
        eventLimit: false,
        locale: 'es',
        eventColor: '#169F85',
        events: events,
        selectable: true,
        select: function (start, end, jsEvent, view) {
            var check = start.format('YYYY-MM-DD');
			var today = $.format.date(new Date(),'yyyy-MM-dd');
		
			var fecha_xd = new Date();
			fecha_xd.setDate(fecha_xd.getDate() + 5);
			var fecha_5d = $.format.date(fecha_xd, 'yyyy-MM-dd');
				
            if(check < fecha_5d) //*********************
            {
                new PNotify({
                    title: 'Fecha Incorrecta',
                    text: 'No puedes agendar eventos en fechas pasadas ni menores a 5 días',
                    type: 'error',
                    styling: 'bootstrap3'
                });
            }
            else
            {
                $('#agenda_fecha').val(start.format('YYYY-MM-DD'));
                $('#modalAgendar').modal('show');
            }	
        },
        eventClick: function(calEvent, jsEvent, view) {
            if(calEvent.id){
                window.location.href = "./agendar.php?comite_id="+calEvent.id;
            }
            else{
                new PNotify({
                    title: 'Evento de la Contraloría',
                    text: 'No pudes ver el detalle de este evento',
                    type: 'warning',
                    styling: 'bootstrap3'
                });
                return false
            }
        }
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

    $(".btnFicha").click(function(){
        $("#modalFichaTecnica").modal('show');
        var obra_id = $(this).data('id');
        $.get( "../ajax/ficha_tecnica.php?obra_id="+obra_id, function( data ) {
            $( "#modalFichaTecnicaResult" ).html( data );
        });
    });


});
