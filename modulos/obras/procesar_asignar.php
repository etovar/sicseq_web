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

if(!isset($_POST)){
    echo '<script language="JavaScript">location.href="./ejecutora_listado.php";</script>';
    exit;
}



//Procedminiento
$comiteobj = new Comite($contraloriasocialDB);
//Asignar personal a comité todos los comites
if(isset($_POST['configuracion']) && $_POST['configuracion'] == 'todosComite'){
    $data['usuario_id'] = $_POST['usuario_id'];
    $data['metodo'] = $_POST['metodo'];
    $comites = $comiteobj->getComitesByObra($_POST['obra_id']);
    foreach($comites as $comite){
        $comiteobj->updateComite($comite['id_comite'],$data);
    }
}
//Asignar personal por comité
if(isset($_POST['configuracion']) && $_POST['configuracion'] == 'porComite'){
    //var_dump($_POST);exit;
    $comites = $comiteobj->getComitesByObra($_POST['obra_id']);
    foreach($comites as $comite){
        $data['usuario_id'] = $_POST['usuario_id_todos'][intval($comite['id_comite'])];
        $data['metodo'] = $_POST['metodo_todos'][$comite['id_comite']];
        $comiteobj->updateComite($comite['id_comite'],$data);
    }
}

$obraobj = new Obra($contraloriasocialDB);
$dataobra['status'] = 'asignada';
$obraobj->updateObra($_POST['obra_id'], $dataobra);


//redireccion
$sesion->set_flash('Obra Asignada',"La obra se ha asignado correctamente", "success");
echo '<script language="JavaScript">location.href="./ejecutora_listado.php";</script>';
