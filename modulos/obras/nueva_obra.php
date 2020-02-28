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
$dependenciaobj = new Dependencia($contraloriasocialDB);
$dependencias = $dependenciaobj->getDependencias();

//Llamando vista
require("../../views/obras/nueva_obra.php");
