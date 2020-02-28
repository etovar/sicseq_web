<?php
// Listado de obras para el rol de ejecutora
// Rafael Reyna
require_once("../../contraloriasocialDB.php");
require_once("../../helpers/sesiones.php");
require_once("../../models/obra.php");
require_once("../../models/comite.php");
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
$comite = $comiteobj->getComite($_POST['comite_id']);

//Validacon
if($comiteobj->subirDocumento($_POST['comite_id'],$_FILES['documento'],$_POST['tipo'])){
    $sesion->set_flash('Carga de Archivo',"El documento se ha cargado correctamente", "success");
    echo '<script language="JavaScript">location.href="./detalle.php?comite_id='.$comite['id_comite'].'";</script>';
}
else{
    $sesion->set_flash('Carga de Archivo',"Ah ocurrido un error, asegúrese de subir un archivo PDF", "error");
    echo '<script language="JavaScript">location.href="./detalle.php?comite_id='.$comite['id_comite'].'";</script>';
}

