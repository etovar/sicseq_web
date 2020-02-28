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
if(isset($_POST['respuesta']) && $_POST['respuesta'] == 1){
    if($obra['solicitud_baja'] == 1){
        $data['status'] = 'no_integracion';

        $notificacion['titulo'] = 'Solicitud de No Aplica Aceptada';
        $notificacion['descripcion'] = "La contraloría ha Aceptado tu solicitud de No Integración de Comités, bajo el término No aplica para la Obra {$obra['num_obra']}";
        $notificacion['tipo'] = 'Aviso';
        $notificacion['prioridad'] = 4;
        $notificacion['rol'] = 1;
        $notificacion['dependencia_id'] = $dependencia['id_dependencia'];
        $notificacion['obra_id'] = $obra['id_obra'];
        $notificacion['status'] = 'Nueva';
        $notificacionobj->enviarNotificacionAdmin(1,$notificacion);
    }
    if($obra['solicitud_baja'] == 2){
        $data['status'] = 'subobras';
        $notificacion['titulo'] = 'Solicitud de Sub-Obras Aceptada';
        $notificacion['descripcion'] = "La contraloría ha Aceptado tu solicitud de No Integración de Comités, bajo el término Sub-obras Obra {$obra['num_obra']}. Ahora debes dar de alta las sub-obras correspondientes";
        $notificacion['tipo'] = 'Accion';
        $notificacion['prioridad'] = 3;
        $notificacion['call_to_action'] = 'Capturar sub Obras';
        $notificacion['url'] = '/modulos/obras/ejecutora_listado.php?num_obra='.$obra['num_obra'];
        $notificacion['rol'] = 1;
        $notificacion['dependencia_id'] = $dependencia['id_dependencia'];
        $notificacion['obra_id'] = $obra['id_obra'];
        $notificacion['status'] = 'Nueva';

        $notificacionobj->addNotificacion($notificacion);
    }
}else{
    $data['status'] = 'nueva';

    $notificacion['titulo'] = 'La contraloría rechazó tu solicitud';
    $notificacion['descripcion'] = "La Contraloría no aceptó la solicitud de No Integreación para la Obra {$obra['num_obra']}. Es necesario que generes comités para esa obra <br/><br/>Detalles: {$_POST['baja_respuesta']}";
    $notificacion['tipo'] = 'Accion';
    $notificacion['prioridad'] = 3;
    $notificacion['call_to_action'] = 'Configurar comités';
    $notificacion['url'] = '/modulos/comites/ejecutora_listado.php?obra_id='.$obra['id_obra'];
    $notificacion['rol'] = 1;
    $notificacion['dependencia_id'] = $dependencia['id_dependencia'];
    $notificacion['obra_id'] =  $obra['id_obra'];
    $notificacion['status'] = 'Nueva';

    $notificacionobj->addNotificacion($notificacion);
}

$data['baja_respuesta'] = $_POST['baja_respuesta'];
$obraobj->updateObra($_POST['obra_id'], $data);

//redireccion
$sesion->set_flash('Baja solicitada',"Se ha enviado la respuesta a la ejecutora", "success");
echo '<script language="JavaScript">location.href="./contraloria_listado.php";</script>';
