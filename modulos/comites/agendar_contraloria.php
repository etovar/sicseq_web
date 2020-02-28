<?php
// Listado de obras para el rol de ejecutora
// Rafael Reyna
require_once("../../contraloriasocialDB.php");
require_once("../../helpers/sesiones.php");
require_once("../../models/obra.php");
require_once("../../models/comite.php");
require_once("../../models/usuario.php");
$sesion = new Sesion($contraloriasocialDB);
if(!$sesion->sesion_activa()){
    echo '<script language="JavaScript">location.href="../../index.php";</script>';
    exit;
}

$obra = false;
$comiteobj = new Comite($contraloriasocialDB);
//verificando el id
if(isset($_GET['comite_id']) && $_GET['comite_id']){
    if(!is_numeric($_GET['comite_id'])){
        $sesion->set_flash('Error',"El id de comité no existe, intente nuevamente o contacte con su administrador", "error");
        echo '<script language="JavaScript">location.href="../obras/contraloria_listado.php";</script>';
        exit;
    }

    $comite = $comiteobj->getComite($_GET['comite_id']);
    if(!$comite){
        $sesion->set_flash('Error',"El id de comité es incorrecto, intente nuevamente o contacte con su administrador", "error");
        echo '<script language="JavaScript">location.href="./contraloria_listado.php";</script>';
        exit;
    }
    $obra = $comite['obra'];
}
else{
    $comite = false;
}


$obraobj = new Obra($contraloriasocialDB);
$usuarioobj = new Usuario($contraloriasocialDB);
//verificando el id
if(isset($_GET['obra_id']) && $_GET['obra_id']){
    if(!is_numeric($_GET['obra_id'])){
        $sesion->set_flash('Error',"El id de obra no existe, intente nuevamente o contacte con su administrador", "error");
        echo '<script language="JavaScript">location.href="../obras/contraloria_listado.php";</script>';
        exit;
    }

    $obra = $obraobj->getObra($_GET['obra_id']);
    if(!$obra){
        $sesion->set_flash('Error',"El id de obra es incorrecto, intente nuevamente o contacte con su administrador", "error");
        echo '<script language="JavaScript">location.href="./contraloria_listado.php";</script>';
        exit;
    }
}

if($obra){
    $obra['comites'] = $comiteobj->getComitesByObra($obra['id_obra']);
}

if($sesion->usuario_adminsitrador_x_contraloriasocial) { //administrador
    $eventos = $comiteobj->getEventos();

    $eventos_json = array();
    foreach($eventos as $evento){
        $eventojson = new stdClass();
        $eventojson->id = $evento['id_comite'];
        $eventojson->normatividad = $comiteobj->getNormatividad($evento['id_comite']);
        $eventojson->title = "{$evento['num_comite']}";
        if(isset($evento['nombre_obra']) && $evento['nombre_obra']){
            $eventojson->title .= " ". utf8_encode($evento['nombre_obra']);
        }
        $eventojson->start = date("Y-m-d",strtotime($evento['agenda_fecha']))."T{$evento['agenda_hora_inicio']}";
        $eventojson->end = date("Y-m-d",strtotime($evento['agenda_fecha']))."T{$evento['agenda_hora_fin']}";
        if($evento['agenda_confirmada'] == 1){
            $personal = $usuarioobj->getUsuario($evento['contraloria_usuario_id']);
            $eventojson->color = $personal['color'];
            $eventojson->title = "{$personal['idpersonal']}" . $eventojson->title;
        }
        if($evento['agenda_confirmada'] == 2){
            $eventojson->color = "#000000";
        }
        $eventos_json[] = $eventojson;
    }
}
else{ // usuario movil
    $eventos = $comiteobj->getEventosByUser($sesion->usuario_id,2);

    $eventos_json = array();
    foreach($eventos as $evento){
        $eventojson = new stdClass();
        $eventojson->id = $evento['id_comite'];
        $eventojson->normatividad = $comiteobj->getNormatividad($evento['id_comite']);
        $eventojson->title = "{$evento['num_comite']}";
        if(isset($evento['nombre_obra']) && $evento['nombre_obra']){
            $eventojson->title .= " ". utf8_encode($evento['nombre_obra']);
        }
        $eventojson->start = date("Y-m-d",strtotime($evento['agenda_fecha']))."T{$evento['agenda_hora_inicio']}";
        $eventojson->end = date("Y-m-d",strtotime($evento['agenda_fecha']))."T{$evento['agenda_hora_fin']}";
        if($evento['agenda_confirmada'] == 1){
            $personal = $usuarioobj->getUsuario($evento['contraloria_usuario_id']);
            $eventojson->color = $personal['color'];
            $eventojson->title = "{$personal['idpersonal']}" . $eventojson->title;
        }
        if($evento['agenda_confirmada'] == 2){
            $eventojson->color = "#000000";
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
    $obras = $obraobj->getObras();
}

$usuarioobj = new Usuario($contraloriasocialDB);
$personal_array = $usuarioobj->getPersonalContraloria();

if(isset($_GET['comite_id']) && $_GET['comite_id']){
    $comite_id = $_GET['comite_id'];
}
else{
    $comite_id = 0;
}

//Llamando vista
require("../../views/comites/agendar_contraloria.php");
?>
