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

if(!isset($_GET['comite_id'])){
    echo '<script language="JavaScript">location.href="'.$sesion->baseurl.'obras/ejecutora_listado.php";</script>';
    exit;
}

//Procedminiento
$comiteobj = new Comite($contraloriasocialDB);

//Revisando numero de obra unico
$comite = $comiteobj->getComite($_GET['comite_id']);

if(!$comite){
    $sesion->set_flash('Ha ocurrido ',"El número de comité no es válido", "error");
    echo '<script language="JavaScript">location.href="'.$sesion->baseurl.'obras/ejecutora_listado.php";</script>';
}
else{
    $comiteobj->deleteComite($comite['id_comite']);
    //cambiando status a nueva si no hat comites
    $comites = $comiteobj->getComitesByObra($comite['obra_id']);
    if(count($comites) == 0){
        $dataobra['status'] = 'nueva';
        $obraobj = new Obra($contraloriasocialDB);
        $obraobj->updateObra($comite['obra_id'],$dataobra);
    }

    $sesion->set_flash('Comité eliminado',"El comité {$comite['num_comite']} se ha eliminado correctamente", "success");
    echo '<script language="JavaScript">location.href="./ejecutora_listado.php?obra_id='.$comite['obra_id'].'";</script>';
}
