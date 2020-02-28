<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="iso-8859-1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<!--<link rel="icon" href="imagenes/favicon.ico" type="image/ico" />-->

    <title>Comites Contraloría Social</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="css/font-awesome.css" rel="stylesheet">
	<!-- NProgress -->
    <link href="css/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="css/animate.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="css/custom.css" rel="stylesheet">
	<script type="text/javascript" src="md5/md5.js"></script>
	<script type="text/javascript" src="thickbox/jquery.js"></script>
	<script type="text/javascript" src="thickbox/thickbox.js"></script>
	  
<?php
$usuario_x = '';
if (isset($_POST["entrar_cambia_contra_x"]) && $_POST["entrar_cambia_contra_x"]=="Si") {
	require_once ("contraloriasocialDB.php"); 	// acceso a la base de datos
	$rs_usuarios=$contraloriasocialDB->SelectLimit("Select usuario,num_contra from usuarios Where usuario='".$_POST["usuario_cc_x"]."' and contrasena='".$_POST["contrasena_ant_x"]."'") or die($contraloriasocialDB->ErrorMsg());
	$cuantos_x=$rs_usuarios->RecordCount();
	if ($cuantos_x=="1") {
		$fecha_contra_m_x=date("d/m/Y - H:m:s")."|".$_POST["usuario_cc_x"].";";
		$num_contra_x=$rs_usuarios->Fields('num_contra')+1;
		$sql_update="UPDATE usuarios SET contrasena='".$_POST["contrasena_nueva1_x"]."',num_contra=".$num_contra_x.",fecha_contra=fecha_contra||'".$fecha_contra_m_x."; ' Where usuario='".$_POST["usuario_cc_x"]."'";
		echo $sql;
		$update=$contraloriasocialDB->Execute($sql_update) or die($contraloriasocialDB->ErrorMsg());
		?>
        <form name="cambia_contra_entra" action="index.php" method="post" target="_parent">
            <input type="hidden" name="usuario_x" value='<?php echo $_POST["usuario_cc_x"]; ?>'>
            <input type="hidden" name="clave_log" value='<?php echo $_POST["contrasena_nueva1_x"]; ?>'>
            <input type="hidden" name="entrar_x" value='Si'>
            <input type="hidden" name="entro_cambia_contra_x" value='Si'>
        </form>
        <script>
            window.parent.document.getElementById("TB_closeWindowButton").click(TB_remove);
            //alert ("La contraseña fue cambiada.");
            //document.cambia_contra_entra.submit();
        </script>
		<?php
		exit(); }
	else { 
		$tb_usu_log=$_POST["usuario_cc_x"];
		echo "<script>alert('El usuario y/o contraseña anterior no son validos.');</script>";
	}
	$rs_usuarios->Close();
} ?>
<script  type="text/javascript">
function f_entrar() {
	if (document.cambia_contra.usuario_cc_x.value!="" && document.cambia_contra.contrasena_ant_x.value!="" && document.cambia_contra.contrasena_nueva1_x.value!="" && document.cambia_contra.contrasena_nueva2_x.value!="")
		if (document.cambia_contra.contrasena_nueva1_x.value==document.cambia_contra.contrasena_nueva2_x.value)
			if (document.cambia_contra.contrasena_nueva1_x.value.length>5)
				if (document.cambia_contra.contrasena_nueva1_x.value!=document.cambia_contra.contrasena_ant_x.value) {
					document.cambia_contra.entrar_cambia_contra_x.value="Si";
					document.cambia_contra.contrasena_ant_x.value=hex_md5(document.cambia_contra.contrasena_ant_x.value);
					document.cambia_contra.contrasena_nueva1_x.value=hex_md5(document.cambia_contra.contrasena_nueva1_x.value);
					document.cambia_contra.contrasena_nueva2_x.value="";
					document.cambia_contra.submit(); }
				else alert ("La Contraseña Nueva debe ser diferente a la Contraseña Anterior, favor de intentar nuevamente.");
			else alert ("La Contraseña Nueva debe contener almenos 6 caracteres, favor de intentar nuevamente.");
		else alert ("La Contraseña Nueva y su confirmación son diferentes, favor de intentar nuevamente.");
	else alert ("Favor de capturar los datos de Usuario, Contraseña Anterior, Contraseña Nueva y la Confirmación de esta.");
}
</script>
  
	</head>

  <body class="login" style="overflow:hidden;">
    <div style="width: 90%">
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>
      <div class="login_wrapper" style="padding-top: 0px;">
        <div id="register" class="animate form login_form">
          <section class="login_content">
            <form class="login-form" name="cambia_contra" action="cambia_contra.php" method="post" onSubmit="return false;" style="margin: 0; padding-top:0px;">
              <h4>Cambiar contraseña</h4>
              <div>
                <input type="text" class="form-control" placeholder="Usuario" required="requiered" value="<?php echo $usuario_x; ?>" name="usuario_cc_x" id="usuario_cc_x">
              </div>
              <div>
                <input type="password" class="form-control" placeholder="Contrase�a Anterior" name="contrasena_ant_x" id="contrasena_ant_x">
              </div>
              <div>
                <input type="password" class="form-control" placeholder="Contrase�a Nueva" name="contrasena_nueva1_x" id="contrasena_nueva1_x">
              </div>
			  <div>
				<input type="password" class="form-control" placeholder="Confirmar Contrase�a Nueva" name="contrasena_nueva2_x" id="contrasena_nueva2_x">				
			  </div>				
              <div>
                <a class="btn btn-default submit" onClick="f_entrar()">Cambiar Contraseña</a>
              </div>
              <div class="clearfix"></div>
			  <input name="entrar_x" type="hidden">
		      <input name="entrar_cambia_contra_x" type="hidden">
			</form>
          </section>
        </div>
      </div>
   <script>
	tb_usu_log='<?php echo $tb_usu_log; ?>';
	document.cambia_contra.usuario_cc_x.value=tb_usu_log;
	if(document.cambia_contra.usuario_cc_x.value!="") document.cambia_contra.contrasena_ant_x.focus();
	else document.cambia_contra.usuario_cc_x.focus();
</script></div>
	  
  </body>
</html>
