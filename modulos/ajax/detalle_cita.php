<?php
// Listado de obras para el rol de ejecutora
// Rafael Reyna
require_once ("../../contraloriasocialDB.php");
require_once ("../../helpers/sesiones.php");
require_once ("../../models/comite.php");


$sesion = new Sesion($contraloriasocialDB);
if(!$sesion->sesion_activa()){
    echo '<script language="JavaScript">location.href="../../index.php";</script>';
    exit;
}
//Procedminiento
if(isset($_GET['comite_id']) && $_GET['comite_id']){
    $comitesobj = new Comite($contraloriasocialDB);
    $comite = $comitesobj->getComite($_GET['comite_id']);
}else{
    $comite = false;
}


//Llamando vista
require("../../views/ajax/detalle_cita.php");
?>
