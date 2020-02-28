<?php
// Listado de obras para el rol de ejecutora
// Rafael Reyna
require_once ("../../contraloriasocialDB.php");
require_once ("../../helpers/sesiones.php");
require_once ("../../models/obra.php");
$sesion = new Sesion($contraloriasocialDB);
if(!$sesion->sesion_activa()){
    echo '<script language="JavaScript">location.href="../../index.php";</script>';
    exit;
}

//proceso
$obraobj = new Obra($contraloriasocialDB);
//verificando el id
if(isset($_GET['obra_id']) && $_GET['obra_id']){
    if(!is_numeric($_GET['obra_id'])){
        $sesion->set_flash('Error',"El id de obra no existe, intente nuevamente o contacte con su administrador", "error");
        echo '<script language="JavaScript">location.href="./ejecutora_listado.php";</script>';
        exit;
    }

    $obra = $obraobj->getObra($_GET['obra_id']);
    if(!$obra){
        $sesion->set_flash('Error',"El id de obra es incorrecto, intente nuevamente o contacte con su administrador", "error");
        echo '<script language="JavaScript">location.href="./ejecutora_listado.php";</script>';
        exit;
    }
}
else{
    $obra = false;
}


$eventos = $obraobj->getEventosByEjecutora($sesion->dependencia_id_x);
$eventos_contraloria = $obraobj->getEventosContraloria();

$eventos_json = array();
foreach($eventos as $evento){
    $eventojson = new stdClass();
    $eventojson->id = $evento['id_obra'];
    $eventojson->title = "{$evento['num_obra']}";
    if(isset($evento['nombre_obra']) && $evento['nombre_obra']){
        $eventojson->title .= " ". utf8_encode($evento['nombre_obra']);
    }
    $eventojson->start = date("Y-m-d",strtotime($evento['agendada_fecha']))."T{$evento['agendada_hora_inicio']}";
    $eventojson->end = date("Y-m-d",strtotime($evento['agendada_fecha']))."T{$evento['agendada_hora_fin']}";
    if($evento['agendada_confirmada']){
        $eventojson->color = '#31708f';
    }
    $eventos_json[] = $eventojson;
}

foreach($eventos_contraloria as $evento){
    if($evento['ejecutora_id'] != $sesion->dependencia_id_x){
        $eventojson = new stdClass();
        $eventojson->title = "OCUPADO";
        $eventojson->start = date("Y-m-d",strtotime($evento['agendada_fecha']))."T{$evento['agendada_hora_inicio']}";
        $eventojson->end = date("Y-m-d",strtotime($evento['agendada_fecha']))."T{$evento['agendada_hora_fin']}";
        if($evento['agendada_confirmada']){
            $eventojson->color = '#333333';
        }
        $eventos_json[] = $eventojson;
    }
}
$eventos_json = json_encode($eventos_json);

//filtrado
if(isset($_POST['num_obra']) && $_POST['num_obra']){
    $obras = $obraobj->buscarObrasByNumero($_POST['num_obra']);
}
else{
    $obras = $obraobj->getObrasByEjecutora($sesion->dependencia_id_x);
}

//Llamando vista
require("../../views/obras/agendar.php");
?>
