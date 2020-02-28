<?php
// Listado de obras para el rol de ejecutora
// Rafael Reyna
require_once ("../../contraloriasocialDB.php");
require_once ("../../helpers/sesiones.php");
require_once ("../../models/obra.php");
require_once ("../../models/comite.php");
$sesion = new Sesion($contraloriasocialDB);
if(!$sesion->sesion_activa()){
    echo '<script language="JavaScript">location.href="../../index.php";</script>';
    exit;
}

if(!isset($_GET['obra_id'])){
    echo '<script language="JavaScript">location.href="'.$sesion->baseurl.'obras/ejecutora_listado.php";</script>';
    exit;
}

//Procedminiento
$obraobj = new Obra($contraloriasocialDB);
$comiteobj = new Comite($contraloriasocialDB);

//Revisando numero de obra unico
$obra = $obraobj->getObra($_GET['obra_id']);

if(!$obra){
    $sesion->set_flash('Ha ocurrido ',"El número de obra no es válido", "error");
    echo '<script language="JavaScript">location.href="'.$sesion->baseurl.'obras/ejecutora_listado.php";</script>';
}
else{
    $data = array();
    $data['status'] = 'sin_agendar';
    $data['obra_id'] = $obra['id_obra'];
    $data['num_comite'] = $obra['num_obra'].'-'.$comiteobj->getNumComiteSiguiente($obra['id_obra']);
    $comiteobj->addComite($data);

    //agregando status
    if($obra['status'] == 'nueva'){
        $comites = $comiteobj->getComitesByObra($obra['id_obra']);
        if(count($comites) > 0){
            $dataobra['status'] = 'primera_sesion';
            $obraobj->updateObra($obra['id_obra'],$dataobra);
        }
    }

    $sesion->set_flash('Comité generado',"El comité se ha genedaro correctamente", "success");
    echo '<script language="JavaScript">location.href="./ejecutora_listado.php?obra_id='.$obra['id_obra'].'";</script>';
}
