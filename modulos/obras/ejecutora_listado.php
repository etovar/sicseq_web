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
//Procedminiento
if(isset($_GET['status']) && $_GET['status']){
    $statusjs = "'{$_GET['status']}'";
}
else{
    $statusjs = "false";
}

if(isset($_GET['num_obra']) && $_GET['num_obra']){
    $num_obra = "'{$_GET['num_obra']}'";
}
else{
    $num_obra = "";
}

//Llamando vista de acuerdo a permiso
if($sesion->usuario_adminsitrador_x_contraloriasocial){
    require("../../views/obras/ejecutora_listado.php");
}
else{
    if($sesion->usuario_movil_x_contraloriasocial){
        $obrasobj = new Obra($contraloriasocialDB);
        $obras = $obrasobj->getObrasByAsignado($sesion->usuario_id);
        require("../../views/obras/ejecutora_listado_asignado.php");
    }
}



?>
