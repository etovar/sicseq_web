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
        eventColor: '#444444',
        events: events,
        selectable: true,
        select: function (start, end, jsEvent, view) {
            $('#agenda_fecha').val(start.format('YYYY-MM-DD'));
            $('#modalAgendar').modal('show');
        },
        eventClick: function(calEvent, jsEvent, view) {
            if(calEvent.normatividad == 'ESTATAL'){
                $('#hdnComite_id').val(calEvent.id);
                $.get( "../ajax/detalle_cita.php?comite_id="+calEvent.id, function( data ) {
                    $( "#ajaxDetalleFicha" ).html( data );
                });
                $('#modalAsignar').modal('show');
            }
            else{
                alert("Este evento tiene normatividad federal");
            }
        },
        eventRender: function( event, element, view ) {
            element.find('.fc-title').prepend('<i class="fa fa-user"></i>');
        }
    });

    $("#cboRespuesta").change(function(){
        switch ($(this).val()) {
            case '1':
                $(".divRespuestaDetail").hide(500);
                $("#divRespuestaSi").show(500);
                break;
            case '2':
                $(".divRespuestaDetail").hide(500);
                $("#divRespuestaNo").show(500);
                break;
            case '3':
                $(".divRespuestaDetail").hide(500);
                $("#divRespuestacambio").show(500);
                break;
        }
    });

    if(event_id){
        $('#hdnComite_id').val(event_id);
        $.get( "../ajax/detalle_cita.php?comite_id="+event_id, function( data ) {
            $( "#ajaxDetalleFicha" ).html( data );
        });
        $('#modalAsignar').modal('show');
    }

});
