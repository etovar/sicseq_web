$(document).ready(function() {
    var statusget = "";
    if(status != 'false'){
        statusget = "&status="+status;
    }
    else{
        statusget = "";
    }

    $('#datatable-obras').DataTable( {
        "pageLength": 20,
        "processing": true,
        dom: 'Bfrtip',
        order: [[ 0, "desc" ]],
        "search": {
            "search": num_obra
        },
        columnDefs: [
            { width: 75, targets: [0]},
            { width: 130, targets: [5]},
            { width: 60, targets: [2,3,4,6]},
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
                            '<img src="http://www2.queretaro.gob.mx/sicseq/imagenes/logo_pe.png" style="margin:auto" />'
                        );

                    $(win.document.body).find( 'table' )
                        .addClass( 'compact' )
                        .css( 'font-size', 'inherit' );
                }
            },
        ]
    });

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

    $('#modalFichaTecnica').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var obra_id = button.data('id');
        $.get( "../ajax/ficha_tecnica.php?obra_id="+obra_id, function( data ) {
            $( "#modalFichaTecnicaResult" ).html( data );
        });
    })
});
