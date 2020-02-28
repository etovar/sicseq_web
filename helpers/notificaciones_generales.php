<?php
require_once ("../../models/notificacion.php");
$notificacionobj = new Notificacion($contraloriasocialDB);

if($sesion->usuario_adminsitrador_x_contraloriasocial){ //adminsitrador
    if($sesion->urol_id_x_contraloriasocial == 1){ //Ejecutora
        $notificaciones_generales = $notificacionobj->getNotificacionesAdmin($sesion->usuario_id,1, $sesion->dependencia_id_x);
    }
    else{ //contraloria
        $notificaciones_generales = $notificacionobj->getNotificacionesAdmin($sesion->usuario_id,2);
    }
}
else{
    $notificaciones_generales = $notificacionobj->getNotificaciones($sesion->usuario_id);
}

