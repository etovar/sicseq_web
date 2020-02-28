<?php
// DB table to use
require_once (dirname(__FILE__)."/../contraloriasocialDB.php");
$table = 'comites_datatable';

// Table's primary key
$primaryKey = 'id_comite';

$columns = array(
    array( 'db' => 'num_comite', 'dt' => 0, ),
    array( 'db' => 'num_obra',  'dt' => 1,),
    array( 'db' => 'nombre_obra',   'dt' => 2 ),
    array( 'db' => 'fecha_integracion',   'dt' => 3 ,),
    array(
        'db'        => 'status',
        'dt'        => 4,
        'formatter' => function( $val, $row ) {
            switch($val){
                case 'asignado': $result = "<span class='label label-info'><i class='fa fa-user'></i> Asignado</span>"; break;
                case 'integrado': $result = "<span class='label label-success' style='background-color: #115749'><i class='fa fa-users'></i> Integrado</span>"; break;
                case 'capacitado': $result = "<span class='label label-info'>Capacitado</span>"; break;
                default: $result = "<span class='label label-success' style='background-color: #777'>Indefinido</span>";
            }

            return $result;
        }
    ),
    array(
        'db'        => 'metodo',
        'dt'        => 5,
        'formatter' => function( $val, $row ) {
            switch($val){
                case 'digital': $result = "<span class='label label-info'><i class='fa fa-tablet'></i> Digital</span>"; break;
                case 'fisico': $result = "<span class='label label-success' style='background-color: #115749'><i class='fa fa-file-text'></i> F&iacute;sico</span>"; break;
                default: $result = "<span class='label label-success' style='background-color: #777'>Indefinido</span>";
            }
            return $result;
        }
    ),
    array(
        'db'        => 'id_comite',
        'dt'        => 6,
        'formatter' => function( $val, $row ) {
            $result = '<a href="./agendar.php?obra_id='.$row['id_comite'].'" class="btn btn-appb btn-info" title="Agendar" data-toggle="tooltip" data-placement="bottom" data-original-title="Agendar"><i class="fa fa-print"></i></a>';

            if($row['metodo'] == 'fisico'){
                $result .= '<button type="button" class="btn btn-appb" style="background-color:#EFAB4A; border: 1px solid #E8B051;" data-toggle="modal" data-target="#modalSolicitudBaja" data-id="'.$val.'" title="Dar de baja" data-toggle="tooltip" data-placement="bottom" data-original-title="Dar de baja"><i class="fa fa-pencil"></i></button>';
            }

            if($row['status'] == 'agendada' || $row['status'] == 'asignada'){
                $result .= '<a href="./asignar.php?obra_id='.$row['id_comite'].'" type="button" class="btn btn-primary btn-appb"  title="Asignar" data-toggle="tooltip" data-placement="bottom" data-original-title="Asignar"><i class="fa fa-upload"></i></a>';
            }else{
                $result .= '<button type="button" class="btn  btn-appb  btn-primary"  ><i class="fa fa-upload"></i></button>';
            }
            return $result;
        },
    )
);

$sql_details = array(
    'user' => $MM_contraloriasocialDB_USERNAME,
    'pass' => $MM_contraloriasocialDB_PASSWORD,
    'db'   => $MM_contraloriasocialonlyDB_DATABASE,
    'host' => '127.0.0.1'
);

require(dirname(__FILE__). '/ssp.class.pg.php' );

$filtros = array();
//recibiendo data de ejecutora
if(isset($_GET['ejecutora_id']) && $_GET['ejecutora_id']){
    $filtros[] = "ejecutora_id = {$_GET['ejecutora_id']}";
}

//recibiendo data de ejecutora
if(isset($_GET['status']) && $_GET['status']){
    $filtros[] = "status = '{$_GET['status']}'";
}

if(count($filtros) > 0){
    $filtro = implode(' AND ',$filtros);
}
else{
    $filtro = null;
}
//echo $filtro;exit;

echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $filtro)
);


