<?php
// Listado de obras para el rol de ejecutora
// Rafael Reyna
require_once ("../../contraloriasocialDB.php");
require_once ("../../helpers/sesiones.php");
require_once ("../../models/obra.php");
require_once ("../../models/notificacion.php");
require_once ("../../models/dependencia.php");
$sesion = new Sesion($contraloriasocialDB);
if(!$sesion->sesion_activa()){
    echo '<script language="JavaScript">location.href="../../index.php";</script>';
    exit;
}

if(!isset($_POST)){
    echo '<script language="JavaScript">location.href="./ejecutora_listado.php";</script>';
    exit;
}

//Procedminiento
$obraobj = new Obra($contraloriasocialDB);
$obra = $obraobj->getObra($_POST['obra_id']);
$notificacionobj = new Notificacion($contraloriasocialDB);
$dependenciaobj = new Dependencia($contraloriasocialDB);
$dependencia =  $dependenciaobj->getDependenciaByNombre($obra['ejecutora']);
if($_POST['solicitud_baja'] == 1){
    $data['status'] = 'solicitud_no_integracion';
    $causa = "No Aplica";
}
else{
    $data['status'] = 'solicitud_subobras';
    $causa = "Sub Obras";
}
$data['solicitud_baja'] = $_POST['solicitud_baja'];
$data['baja_justificacion'] = $_POST['baja_justificacion'];
$obraobj->updateObra($_POST['obra_id'], $data);

$notificacion['titulo'] = 'Solicitud de No Integración de Comités';
$notificacion['descripcion'] = "La Ejecutora ha generado una nueva solicitud de No Integración con la causa {$causa}. Se debe dar respuesta a dicha solicitud.";
$notificacion['tipo'] = 'Accion';
$notificacion['prioridad'] = 3;
$notificacion['call_to_action'] = 'Responder Solicitud';
$notificacion['url'] = '/modulos/obras/contraloria_listado.php?num_obra='.$obra['num_obra'];
$notificacion['rol'] = 2;
$notificacion['obra_id'] = $obra['id_obra'];
$notificacion['status'] = 'Nueva';
$notificacionobj->addNotificacion($notificacion);

//redireccion
$sesion->set_flash('Baja solicitada',"Se ha enviado la solicitud de baja, la Contraloría dará respuesta", "warning");
echo '<script language="JavaScript">location.href="./ejecutora_listado.php";</script>';

