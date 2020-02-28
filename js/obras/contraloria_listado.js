$(document).ready(function() {
    var statusget = "";
    var statusarray = [];
    if(status != 'false'){
        statusarray['status'] = status;
    }
    if(ejecutora_id != false){
        statusarray['ejecutora_id'] = ejecutora_id;
    }
    for (var key in statusarray) {
        if (statusget != "") {
            statusget += "&";
        }
        statusget += key + "=" + statusarray[key];
    }

    $('#datatable-obras').DataTable( {
        "pageLength": 20,
        "processing": true,
        "serverSide": true,
        "ajax": "../../lib/ordenes_datatable_c.php?"+statusget,
        dom: 'Bfrtip',
        order: [[ 0, "desc" ]],
        "search": {
            "search": num_obra
        },
        columnDefs: [
            { width: 75, targets: [0,1]},
            { width: 130, targets: [6]},
            { width: 60, targets: [3,4,5,7]},
        ],
        buttons: [
            { extend: 'copy', text: 'Copiar al Portapapeles' },
            { extend: 'csv', text: 'Exportar a CSV' },
            { extend: 'excel', text: 'Exportar a Excel' },
            {
                extend: 'print',
                text: 'Imprimir Listado' ,
                customize: function ( win ) {
                    $(win.document.body)
                        .css( 'font-size', '10pt' )
                        .prepend(
                            '<img src="http://200.57.190.146/sicseq/imagenes/logo_pe.png" style="margin:auto" />'
                        );

                    $(win.document.body).find( 'table' )
                        .addClass( 'compact' )
                        .css( 'font-size', 'inherit' );
                }
            },
        ]
    });

    $('#btnFiltrar').click(function(){

        var url = "./contraloria_listado.php";
        var gets = "";
        var filtros = 0;

        if($("#cboStatus").val() != ""){
            filtros ++;
            if(filtros == 1){
                gets = "?";
            }
            else{
                gets = gets + "&";
            }
            gets = gets + "status="+$("#cboStatus").val();
        }
        if($("#cboEjecutora").val() != ""){
            filtros ++;
            if(filtros == 1){
                gets = "?";
            }
            else{
                gets = gets + "&";
            }
            gets = gets + "ejecutora_id="+$("#cboEjecutora").val();
        }

        url = url +gets;
        window.location.href = url;
    });

    $('#modalSolicitudBaja').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var obra_id = button.data('id');
        var solicitud = button.data('solicitud');
        var justificacion = button.data('justificacion');
        var modal = $(this);
        modal.find('#baja_obra_id').val(obra_id);
        if(solicitud == 1){
            modal.find('#solicitud_baja').val("La obra no aplica");
        }
        if(solicitud == 12){
            modal.find('#solicitud_baja').val("La obra se dividirá en sub-obras");
        }

        modal.find('#baja_justificacion').val(justificacion);
    });

    $('#modalFichaTecnica').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var obra_id = button.data('id');
        $.get( "../ajax/ficha_tecnica.php?obra_id="+obra_id, function( data ) {
            $( "#modalFichaTecnicaResult" ).html( data );
        });
    })
});
