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

if(!isset($_POST)){
    echo '<script language="JavaScript">location.href="./ejecutora_listado.php";</script>';
    exit;
}

//Procedminiento
$obraobj = new Obra($contraloriasocialDB);

//Revisando numero de obra unico
$obra_unico = $obraobj->getObraByNumero($_POST['num_obra']);

if($obra_unico){
    $sesion->set_flash('Número de obra repetido',"El número de obra ya existe en la base de datos", "error");
    echo '<script language="JavaScript">location.href="./nueva_obra.php";</script>';
}
else{
    $data = $_POST;
    $data['status'] = 'nueva';
    $obra = $obraobj->addObra($data);
    $sesion->set_flash('Obra dada de alta',"La obra se ha dado de alta correctamente", "success");
    echo '<script language="JavaScript">location.href="./ejecutora_listado.php";</script>';
}
