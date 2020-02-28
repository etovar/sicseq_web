<?php
include_once ('./config.php');
switch($_POST['accion']){
    case 'generales':
        $url = $config_picaso['base_url'] . $_POST['url'];
        break;
    case 'porobra':
        $url = $config_picaso['base_url'] . $_POST['url']."?numeroObra=".$_POST['num_obra'];
        break;

}

ini_set('default_socket_timeout', 1000);
//LLAMADA AL API REST
$context = stream_context_create(array(
    'http' => array(
        'timeout' => 1000,
        //'header'  => "Authorization: Basic " . base64_encode("{$config_picaso['username']}:{$config_picaso['password']}")
    )
));
//echo $url;
set_time_limit(1000);

//$data = file_get_contents($url, false, $context);
//$data_php = json_decode($data);

//traer coordenadas
//var_dump($data_php);exit;
require_once("../../contraloriasocialDB.php");
require_once("../../models/obra.php");
$obrasobj = new Obra($contraloriasocialDB);
$obras = $obrasobj->getObras();
foreach($obras as $obra){
    set_time_limit(1000);
    if(!isset($obra['picaso_croquis']) || !$obra['picaso_croquis']){
        $url = $config_picaso['base_url'] . $_POST['url']."?numeroObra=".$obra['num_obra'];
        $data = file_get_contents($url, false, $context);
        $data_php = json_decode($data);
        $dataupdate['picaso_croquis'] = json_encode($data_php->datos);
        $geodatos = str_replace('@','"',$data_php->datos->ubicacion);
        $geodatos = json_decode($geodatos);
        if($geodatos && isset($geodatos->centro)){
            $dataupdate['lat'] = $geodatos->centro->lat;
            $dataupdate['lon'] = $geodatos->centro->lng;
            $dataupdate['zoom'] = $geodatos->zoom;
            $obrasobj->updateObra($obra['id_obra'],$dataupdate);
            echo "Obra actualizada {$obra['num_obra']}<br/>";
        }
        else{
            echo "Obra sin datos {$obra['num_obra']}<br/>";
        }
    }
}
exit;



if(isset($_POST['archivo']) && $_POST['archivo']){
    $nombre_array = explode('/',$_POST['url']);
    switch($_POST['accion']){
        case 'generales':
            $nombre_archivo = $nombre_array[0];
            break;
        case 'porobra':
            $nombre_archivo = $nombre_array[0]."porObra_".$_POST['num_obra'];
            break;
    }

    file_put_contents("./{$nombre_archivo}.json", $data);
    echo "Archivo generado {$nombre_array[0]}.json"; exit;
}
?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">
<h2><?php echo $url;?></h2>;
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php
            echo "<table id='table_id'>";
            echo "<thead>";
            echo "<tr>";
            foreach($data_php->datos[0] as $dato=>$valor){
                echo "<th>{$dato}</th>";
            }
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            foreach($data_php->datos as $obra){
                echo"<tr>";
                foreach($obra as $dato=>$valor){
                    echo "<td>{$valor}</td>";
                }
                echo"</tr>";
            }
            echo "</tbody>";
            echo "</table>";
            ?>
        </div>
    </div>
</div>
<script
    src="https://code.jquery.com/jquery-3.4.1.min.js"
    integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
    crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" integrity="sha384-xrRywqdh3PHs8keKZN+8zzc5TX0GRTLCcmivcbNJWm2rs5C8PRhcEn3czEjhAO9o" crossorigin="anonymous"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.2.2/jszip.min.js" integrity="sha256-gy5W5/rXWluWXFRvMWFFMVhocfpBe7Tf4SW2WMfjs4E=" crossorigin="anonymous"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
<script type="application/javascript">
    $(document).ready( function () {
        $('#table_id').DataTable( {
            "pageLength": 20,
            "processing": true,
            dom: 'Bfrtip',
            buttons: [
                { extend: 'copy', text: 'Copiar al Portapapeles', title: 'fondos' },
                { extend: 'csv', text: 'Exportar a CSV', title: 'fondos' },
                { extend: 'excel', text: 'Exportar a Excel', title: 'fondos' },
            ]
        });
    } );
</script>
