<?php
// Listado de obras para el rol de ejecutora
// Rafael Reyna
require_once("../../contraloriasocialDB.php");
require_once("../../helpers/sesiones.php");
require_once("../../models/obra.php");
require_once("../../models/comite.php");
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
$obraobj = new Obra($contraloriasocialDB);
$notificacionobj = new Notificacion($contraloriasocialDB);

$comite = $comiteobj->getComite($_POST['id_comite']);
if($comite['agenda_fecha']){
    $data['status'] = 'agendado';
}

$data['usuario_id'] = intval($_POST['usuario_id']);
$data['metodo'] = $_POST['metodo'];

$data['representante_dependencia_normativa'] = $_POST['representante_dependencia_normativa'];
$comiteobj->updateComite($_POST['id_comite'],$data);

$comite = $comiteobj->getComite($_POST['id_comite']);
$obra = $obraobj->getObra($comite['obra_id'],false);

$notificacion['titulo'] = 'Se ha agendado una reunión para Primera Sesión';
$notificacion['descripcion'] = "La ejecutora <strong>{$obra['ejecutora']}</strong> ha agendado una nueva reunión para Primera Sesión del comité {$comite['num_comite']}.";
$notificacion['tipo'] = 'Accion';
$notificacion['prioridad'] = 2;
$notificacion['call_to_action'] = 'Responder solicitud';
$notificacion['url'] = '/modulos/comites/agendar_contraloria.php?comite_id='.$comite['id_comite'];
$notificacion['rol'] = 2;
$notificacion['obra_id'] =  $comite['obra_id'];
$notificacion['status'] = 'Nueva';

$notificacionobj->addNotificacion($notificacion);

//redireccion
$sesion->set_flash('Comite Asignado',"El comité  se ha asignado correctamente", "success");
echo '<script language="JavaScript">location.href="./ejecutora_listado.php?obra_id='.$comite['obra_id'].'";</script>';
