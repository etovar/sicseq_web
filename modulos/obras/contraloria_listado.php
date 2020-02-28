<?php
// Listado de obras para el rol de ejecutora
// Rafael Reyna
require_once ("../../contraloriasocialDB.php");
require_once ("../../helpers/sesiones.php");
require_once ("../../models/obra.php");
require_once ("../../models/dependencia.php");


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
if(isset($_GET['ejecutora_id']) && $_GET['ejecutora_id']){
    $ejecutorajs = "'{$_GET['ejecutora_id']}'";
}
else{
    $ejecutorajs = "false";
}
if(isset($_GET['num_obra']) && $_GET['num_obra']){
    $num_obra = "'{$_GET['num_obra']}'";
}
else{
    $num_obra = "";
}

$dependenciaobj = new Dependencia($contraloriasocialDB);
$dependencias = $dependenciaobj->getDependencias();

//Llamando vista
if($sesion->usuario_adminsitrador_x_contraloriasocial){
    require("../../views/obras/contraloria_listado.php");
}
else{
    if($sesion->usuario_movil_x_contraloriasocial){
        $obrasobj = new Obra($contraloriasocialDB);
        $obras = $obrasobj->getObrasByAsignadoContraloria($sesion->usuario_id);
        require("../../views/obras/contraloria_listado_asignado.php");
    }
}
?>
