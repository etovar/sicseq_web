<?php
// Listado de obras para el rol de ejecutora
// Rafael Reyna
require_once ("../../contraloriasocialDB.php");
require_once ("../../helpers/sesiones.php");
require_once ("../../models/comite.php");
require_once ("../../models/notificacion.php");
require_once ("../../models/dependencia.php");
require_once ("../../models/usuario.php");



$sesion = new Sesion($contraloriasocialDB);
if(!$sesion->sesion_activa()){
    echo '<script language="JavaScript">location.href="../../index.php";</script>';
    exit;
}
//Procedminiento
$notificacionobj = new Notificacion($contraloriasocialDB);
$comiteobj = new Comite($contraloriasocialDB);
$obraobj = new Obra($contraloriasocialDB);
$usuarioobj = new Usuario($contraloriasocialDB);

if($sesion->usuario_adminsitrador_x_contraloriasocial){
    if($sesion->urol_id_x_contraloriasocial == 1){ //Ejecutora
        $acciones = $notificacionobj->getAccionesAdmin($sesion->usuario_id,1, $sesion->dependencia_id_x);
        $avisos = $notificacionobj->getAvisosAdmin($sesion->usuario_id,1, $sesion->dependencia_id_x);

        //Eventos
        $eventos = $comiteobj->getEventosByEjecutora($sesion->dependencia_id_x);
        $eventos_contraloria = $comiteobj->getEventosContraloria();

        $eventos_json = array();
        foreach($eventos as $evento){
            $eventojson = new stdClass();
            $eventojson->id = $evento['id_comite'];
            $eventojson->title = "{$evento['num_comite']}";
            if(isset($evento['nombre_obra']) && $evento['nombre_obra']){
                $eventojson->title .= " ". utf8_encode($evento['nombre_obra']);
            }
            $eventojson->start = date("Y-m-d",strtotime($evento['agenda_fecha']))."T{$evento['agenda_hora_inicio']}";
            $eventojson->end = date("Y-m-d",strtotime($evento['agenda_fecha']))."T{$evento['agenda_hora_fin']}";
            if($evento['agenda_confirmada']){
                $eventojson->color = '#31708f';
            }
            $eventos_json[] = $eventojson;
        }

        foreach($eventos_contraloria as $evento){
            if(isset($evento['ejecutora_id'])){
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
        }
        $eventos_json = json_encode($eventos_json);
    }
    else{ //contraloria
        $acciones = $notificacionobj->getAccionesAdmin($sesion->usuario_id,2);
        $avisos = $notificacionobj->getAvisosAdmin($sesion->usuario_id,2);

        //eventos
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

        $eventos_json = json_encode($eventos_json);
    }
}
else{ // usuario asignado
    $acciones = $notificacionobj->getAcciones($sesion->usuario_id);
    $avisos = $notificacionobj->getAvisos($sesion->usuario_id);

    //eventos
    $eventos = $comiteobj->getEventosByUser($sesion->usuario_id, $sesion->urol_id_x_contraloriasocial);

    if($sesion->urol_id_x_contraloriasocial == 1){
        $eventos_json = array();
        foreach($eventos as $evento){
            $eventojson = new stdClass();
            $eventojson->id = $evento['id_comite'];
            $eventojson->title = "{$evento['num_comite']}";
            if(isset($evento['nombre_obra']) && $evento['nombre_obra']){
                $eventojson->title .= " ". utf8_encode($evento['nombre_obra']);
            }
            $eventojson->start = date("Y-m-d",strtotime($evento['agenda_fecha']))."T{$evento['agenda_hora_inicio']}";
            $eventojson->end = date("Y-m-d",strtotime($evento['agenda_fecha']))."T{$evento['agenda_hora_fin']}";
            if($evento['agenda_confirmada']){
                $eventojson->color = '#31708f';
            }
            $eventos_json[] = $eventojson;
        }
    }
    else{
        $eventos_json = array();
        foreach($eventos as $evento) {
            $eventojson = new stdClass();
            $eventojson->id = $evento['id_comite'];
            $eventojson->normatividad = $comiteobj->getNormatividad($evento['id_comite']);
            $eventojson->title = "{$evento['num_comite']}";
            if (isset($evento['nombre_obra']) && $evento['nombre_obra']) {
                $eventojson->title .= " " . utf8_encode($evento['nombre_obra']);
            }
            $eventojson->start = date("Y-m-d", strtotime($evento['agenda_fecha'])) . "T{$evento['agenda_hora_inicio']}";
            $eventojson->end = date("Y-m-d", strtotime($evento['agenda_fecha'])) . "T{$evento['agenda_hora_fin']}";
            if ($evento['agenda_confirmada'] == 1) {
                $personal = $usuarioobj->getUsuario($evento['contraloria_usuario_id']);
                $eventojson->color = $personal['color'];
                $eventojson->title = "{$personal['idpersonal']}" . $eventojson->title;
            }
            if ($evento['agenda_confirmada'] == 2) {
                $eventojson->color = "#000000";
            }
            $eventos_json[] = $eventojson;
        }
    }


    $eventos_json = json_encode($eventos_json);
}



$dependenciaobj = new Dependencia($contraloriasocialDB);
$dependencias = $dependenciaobj->getDependencias();

//Llamando vista
require("../../views/notificaciones/dashboard.php");
?>
