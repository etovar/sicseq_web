<?php
// Listado de obras para el rol de ejecutora
// Rafael Reyna
require_once("../../contraloriasocialDB.php");
require_once("../../helpers/sesiones.php");
require_once("../../models/obra.php");
require_once("../../models/comite.php");
require_once("../../models/dependencia.php");
require_once("../../models/notificacion.php");
$sesion = new Sesion($contraloriasocialDB);
if(!$sesion->sesion_activa()){
    echo '<script language="JavaScript">location.href="../../index.php";</script>';
    exit;
}

if(!isset($_POST)){
    echo '<script language="JavaScript">location.href="../obras/ejecutora_listado.php";</script>';
    exit;
}



//Procedminiento
$comiteobj = new Comite($contraloriasocialDB);
$dependenciaobj = new Dependencia($contraloriasocialDB);
$notificacionobj = new Notificacion($contraloriasocialDB);


$comite = $comiteobj->getComite($_POST['id_comite']);
$dependencia =  $dependenciaobj->getDependenciaByNombre($comite['obra']['ejecutora']);
switch ($_POST['respuesta']){
    case 1:
        $data['status'] = 'confirmado';
        $data['agenda_confirmada'] = 1;

        //notificacion
        $notificacion['titulo'] = 'La contraloría asistirá';
        $notificacion['descripcion'] = "La contraloría ha confirmado su asistencia para la primera sesión del comité  {$comite['num_comite']}";
        $notificacion['tipo'] = 'Aviso';
        $notificacion['prioridad'] = 2;
        $notificacion['rol'] = 1;
        $notificacion['dependencia_id'] = $dependencia['id_dependencia'];
        $notificacion['obra_id'] = $comite['obra_id'];
        $notificacion['status'] = 'Nueva';
        $notificacionobj->enviarNotificacionAdmin(1,$notificacion);
        break;
    case 2:
        $data['status'] = 'confirmado';
        $data['agenda_confirmada'] = 2;
        //notificacion
        $notificacion['titulo'] = 'La contraloría NO asistirá';
        $notificacion['descripcion'] = "La contraloría ha autorizado la fecha para la primera sesión del comité {$comite['num_comite']}. <br/><br/>Detalles: {$_POST['detalle_no_asistencia']}";
        $notificacion['tipo'] = 'Aviso';
        $notificacion['prioridad'] = 2;
        $notificacion['rol'] = 1;
        $notificacion['dependencia_id'] = $dependencia['id_dependencia'];
        $notificacion['obra_id'] = $comite['obra_id'];
        $notificacion['status'] = 'Nueva';
        $notificacionobj->enviarNotificacionAdmin(1,$notificacion);
        break;
    case 3:
        $notificacion['titulo'] = 'La contraloría solicita un cambio de fecha';
        $notificacion['descripcion'] = "La Contraloría solicita un cambio de fecha para el comité {$comite['num_comite']}. <br/><br/>Detalles: {$_POST['detalle_cambio']}";
        $notificacion['tipo'] = 'Accion';
        $notificacion['prioridad'] = 2;
        $notificacion['call_to_action'] = 'Cambiar fecha';
        $notificacion['url'] = '/modulos/comites/agendar.php?comite_id='.$comite['id_comite'];
        $notificacion['rol'] = 1;
        $notificacion['dependencia_id'] = $dependencia['id_dependencia'];
        $notificacion['obra_id'] = $comite['obra_id'];
        $notificacion['status'] = 'Nueva';

        $notificacionobj->addNotificacion($notificacion);
        break;
}

if(isset($_POST['usuario_id']) && $_POST['usuario_id']){
    $data['contraloria_usuario_id'] = intval($_POST['usuario_id']);
}

if(isset($_POST['detalle_no_asistencia']) && $_POST['detalle_no_asistencia']){
    $data['detalle_no_asistencia'] = $_POST['detalle_no_asistencia'];
}

if(isset($_POST['detalle_cambio']) && $_POST['detalle_cambio']){
    $data['detalle_cambio'] = $_POST['detalle_cambio'];
}

if(isset($_POST['metodo_contraloria']) && $_POST['metodo_contraloria']){
    $data['metodo_contraloria'] = $_POST['metodo_contraloria'];
}

$comiteobj->updateComite($_POST['id_comite'],$data);
$comite = $comiteobj->getComite($_POST['id_comite']);

//redireccion
$sesion->set_flash('Comite Asignado',"El comité  se ha asignado correctamente", "success");
echo '<script language="JavaScript">location.href="./agendar_contraloria.php";</script>';
