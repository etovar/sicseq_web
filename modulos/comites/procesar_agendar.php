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
$data = $_POST;
$comite = $comiteobj->getComite($_POST['id_comite']);
if($comite['usuario_id']){
    $data['status'] = 'agendado';
}

if(isset($data['agenda_hora']) && $data['agenda_hora']){
    $hora_array = explode(";",$data['agenda_hora']);
    $data['agenda_hora_inicio'] = date("H:i",$hora_array[0]);
    $data['agenda_hora_fin'] = date("H:i",$hora_array[1]);
    unset($data['agenda_hora']);
}

$obra = $comiteobj->updateComite($_POST['id_comite'], $data);

//redireccion
$sesion->set_flash('Comité Agendado',"El comité se ha agendado correctamente", "success");
echo '<script language="JavaScript">location.href="./agendar.php?comite_id='.$_POST['id_comite'].'";</script>';

