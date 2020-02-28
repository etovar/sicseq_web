<?php
// Listado de obras para el rol de ejecutora
// Rafael Reyna
require_once("../../contraloriasocialDB.php");
require_once("../../helpers/sesiones.php");
require_once("../../models/obra.php");
require_once("../../models/comite.php");
$sesion = new Sesion($contraloriasocialDB);
if (!$sesion->sesion_activa()) {
    echo '<script language="JavaScript">location.href="../../index.php";</script>';
    exit;
}

$comitesobj = new Comite($contraloriasocialDB);
if (isset($_GET['listafoto_id']) && $_GET['listafoto_id']) {
    $listafoto = $comitesobj->getListafoto($_GET['listafoto_id']);
    $base64Image = $listafoto['imagen'];
} else {
    $imagen = false;
}

$data = explode(',', $base64Image);
$imageData = base64_decode($data[1]);
$imageput = file_put_contents('image.jpg',$imageData);

$source = imagecreatefromstring($imageData);

$angle = 90;
$rotate = imagerotate($source, $angle, 0); // if want to rotate the image

$imageName = "./image3.jpg";
//$imageSave = @imagejpeg($rotate,$imageName,75);
//echo "ok";exit;
header('Content-type: image/jpeg');
echo file_get_contents($sesion->baseurl."modulos/ajax/image.jpg");
?>

