<?php
// DB table to use
require_once (dirname(__FILE__)."/../contraloriasocialDB.php");
$table = 'obras_normatividad';

// Table's primary key
$primaryKey = 'id_obra';

$columns = array(
    array( 'db' => 'subobra_id', ),
    array( 'db' => 'num_obra', 'dt' => 0,'formatter' => function( $d, $row ) {
        return "{$row['num_obra']}/ {$row['subobra_id']}";
    }, ),
    array(
        'db' => 'ejecutora',
        'dt' => 1,
        'formatter' => function( $val, $row ) {
            $result = utf8_decode($val);
            return $result;
        }),
    array(
        'db' => 'nombre_obra',
        'dt' => 2,
        'formatter' => function( $val, $row ) {
            $result = "<a style='cursor:pointer;' data-toggle=\"modal\" data-target=\"#modalFichaTecnica\" data-id=\"'{$row["id_obra"]}'\">".utf8_decode($val)."</a>";
            return $result;
        }),
    array( 'db' => 'mmunicipio',   'dt' => 3 ,'formatter' => function( $d, $row ) {
        return "{$row['localidad']}, {$row['mmunicipio']}";
    },),
    array(
        'db'        => 'inicio_obra',
        'dt'        => 4,
        'formatter' => function( $d, $row ) {
            return "{$row['inicio_obra']} - {$row['termino_obra']}";
        },
    ),
    array(
        'db'        => 'fondo',
        'dt'        => 5,
        'formatter' => function( $d, $row ) {
            if($row['norma_cs_aplica']){
                $normatividad = $row['norma_cs_aplica'];
            }
            else{
                $normatividad = "<span style='color: #900;'>Sin Normatividad de Fondo</span>";
            }
            return "$d <br/>({$normatividad})";
        },
    ),
    array(
        'db'        => 'solicitud_baja',
        'dt'        => 7,
        'visible'        => false,
    ),
    array(
        'db'        => 'baja_justificacion',
        'dt'        => 8,
        'visible'        => false,
    ),
    array(
        'db'        => 'baja_respuesta',
        'dt'        => 9,
        'visible'        => false,
    ),
    array(
        'db'        => 'localidad',
        'dt'        => 10,
        'visible'        => false,
    ),
    array(
        'db'        => 'termino_obra',
        'dt'        => 11,
        'visible'        => false,
    ),
    array(
        'db'        => 'norma_cs_aplica',
        'dt'        => 12,
        'visible'        => false,
    ),
    array(
        'db'        => 'status',
        'dt'        => 6,
        'formatter' => function( $val, $row ) {
            switch($val){
                case 'nueva': $result = "<span class='label label-success' style='background-color: #27B89B'><i class='fa fa-warning'></i> Nueva</span>"; break;
                case 'solicitud_no_integracion': $result = "<span class='label label-warning'><i class='fa fa-user-times'></i> Solicitud de no Integraci&oacute;n</span>"; break;
                case 'no_integracion': $result = "<span class='label label-default'><i class='fa fa-times'></i> No integraci&oacute;n</span>"; break;
                case 'solicitud_subobras': $result = "<span class='label label-warning'><i class='fa fa-code-fork'></i> Solicitud de sub obras</span>"; break;
                case 'subobras': $result = "<span class='label label-info'><i class='fa fa-code-fork'></i> Subobras</span>"; break;
                case 'primera_sesion': $result = "<span class='label label-info'><i class='fa fa-pencil'></i> Primera Sesi&oacute;n</span>"; break;
                case 'primera_sesion_seguimiento': $result = "<span class='label label-info'><i class='fa fa-pencil'></i> Primera Sesión / Seguimiento</span>"; break;
                case 'seguimiento': $result = "<span class='label label-info'><i class='fa fa-search'></i> Seguimiento</span>"; break;
                case 'concluido': $result = "<span class='label label-default'><i class='fa fa-check'></i> Concluida</span>"; break;
                default: $result = "<span class='label label-success' style='background-color: #777'>$val</span>";
            }
            if($row['baja_respuesta'] && $row['status'] == 'nueva'){
            $result .= " <br/><span class='label label-danger' title='Solicitud rechazada'>!</span>";
            }

            return $result;
        }
    ),
    array(
        'db'        => 'id_obra',
        'dt'        => 7,
        'formatter' => function( $val, $row ) {
            if($row['status'] != 'subobras' && $row['status'] != 'no_integracion'){
                $result = '<a href="../comites/contraloria_listado.php?obra_id='.$row['id_obra'].'" class="btn btn-appb btn-primary"  title="Comités" data-toggle="tooltip" data-placement="bottom" data-original-title="Comités"><i class="fa fa-users"></i></a>';
            }
            else{
                $result = '<a  class="btn btn-appb btn-disabled"  title="Comités" data-toggle="tooltip" data-placement="bottom" data-original-title="Comités"><i class="fa fa-users"></i></a>';
            }
            if($row['status'] == 'solicitud_no_integracion' || $row['status'] == 'solicitud_subobras'){
                $result .= '<button type="button" class="btn btn-appb" style="background-color:#EFAB4A; border: 1px solid #E8B051;" data-toggle="modal" data-target="#modalSolicitudBaja" data-id="'.$val.'" data-solicitud="'.$row['solicitud_baja'].'" data-justificacion="'.$row['baja_justificacion'].'" title="Dar de baja" data-toggle="tooltip" data-placement="bottom" data-original-title="Dar de baja"><i class="fa fa-caret-square-o-down"></i></button>';
            }else{
                $result .= '<button type="button" class="btn btn-appb btn-disabled"  ><i class="fa fa-caret-square-o-down"></i></button>';
            }
            return utf8_decode($result);
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

echo json_encode(SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $filtro));


