$(document).ready(function() {
    var statusget = "";
    if(status != 'false'){
        statusget = "&status="+status;
    }
    else{
        statusget = "";
    }

    $('#btnFiltrar').click(function(){

        var url = "./ejecutora_listado.php";
        var gets = "";
        var filtros = 0;

        if($("#cboStatus").val() != ""){
            filtros ++;
            if(filtros = 1){
                gets = "?";
            }
            else{
                gets = gets + "&";
            }
            gets = gets + "status="+$("#cboStatus").val();
        }
        url = url +gets;
        window.location.href = url;
    });

    $("#btnComitesLista").click(function(){
       $("#vistaComitesList").show('500');
       $("#vistaComitesCards").hide('500');
    });

    $("#btnComitesTarjetas").click(function(){
        $("#vistaComitesList").hide('500');
        $("#vistaComitesCards").show('500');
    });

    $(".btnAsignar").click(function(){
        $('#hdnComite_id').val($(this).attr('id'));
        $('#modalAsignar').modal('show');
    });

    $('#modalComiteTimeline').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var comite_id = button.data('id');
        $.get( "../ajax/comite_timeline.php?comite_id="+comite_id, function( data ) {
            $( "#divComiteTimeline" ).html( data );
        });
    })

});
