<?php
// Listado de obras para el rol de ejecutora
// Rafael Reyna
require_once ("../../contraloriasocialDB.php");
require_once ("../../helpers/sesiones.php");
require_once ("../../models/notificacion.php");
$sesion = new Sesion($contraloriasocialDB);
if(!$sesion->sesion_activa()){
    echo '<script language="JavaScript">location.href="../../index.php";</script>';
    exit;
}

//Procedminiento
$notificacionobj = new Notificacion($contraloriasocialDB);
$data['status'] = 'Atendida';
$notificacionobj->updateNotificacion($_GET['notificacion_id'], $data);

//redireccion
?>
<script language="JavaScript">
        if(document.referrer)
            location.href=document.referrer;
        else
            location.href = '<?php echo $sesion->baseurl;?>';
</script>

