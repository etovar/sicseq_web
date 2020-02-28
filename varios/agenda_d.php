<? session_name('csocial');
session_start();
$ini_sesion_contraloriasocial=$_SESSION["ini_sesion_contraloriasocial"];	
if($ini_sesion_contraloriasocial<>"siinicontraloriasocial")
  echo '<script language="JavaScript">location.href="index.php";</script>';
date_default_timezone_set('America/Mexico_City');
$usuario_x_contraloriasocial=$_SESSION["usuario_x_contraloriasocial"];
$nombre_usu_x_contraloriasocial=$_SESSION["nombre_usu_x_contraloriasocial"];
$ambito_usu_x_contraloriasocial=$_SESSION["ambito_usu_x_contraloriasocial"];
$cve_area_x_contraloriasocial=$_SESSION["cve_area_x_contraloriasocial"];
$area_cve_nivel1_usu_x_contraloriasocial=$_SESSION["area_cve_nivel1_usu_x_contraloriasocial"];
$tipo_usu_x_contraloriasocial=$_SESSION["tipo_usu_x_contraloriasocial"];
$rol_usu_x_contraloriasocial=$_SESSION["rol_usu_x_contraloriasocial"];
$esquema_x_contraloriasocial=$_SESSION["esquema_x_contraloriasocial"]; 

require_once ("contraloriasocialDB.php");

//if(isset($_POST['action']) or isset($_GET['view'])) {
    //if(isset($_GET['view'])) {
        header('Content-Type: application/json');
        $inicio=$_GET["start"];
        $fin=$_GET["end"];
		
//$inicio="08/01/2019";
//$fin="08/31/2019";
//echo "SELECT id,inicio,fin,titulo FROM agenda WHERE (date(start)>='".$inicio."' AND date(start)<='".$fin."')";
		$i=0;
		$vista_agenda=$contraloriasocialDB->SelectLimit("SELECT id,inicio,fin,titulo FROM agenda WHERE (date(inicio)>='".$inicio."' AND date(fin)<='".$fin."')") or die($contraloriasocialDB->ErrorMsg());
		while(!$vista_agenda->EOF) {
            $eventos[$i]=$vista_agenda->Fields('id').",".strtotime("d/m/Y",$vista_agenda->Fields('inicio')).",".strtotime("d/m/Y",$vista_agenda->Fields('fin')).",".$vista_agenda->Fields('titulo');
			//$ordendiaArray[$i]['id']
			$i++;
        $vista_agenda->MoveNext(); }
		echo json_encode($eventos); 
        exit();
    //}
//}
?>