<?php
    require_once ("./contraloriasocialDB.php");
    require_once ("./helpers/sesiones.php");
    $sesion = new Sesion($contraloriasocialDB);
    $sesion->cerrar_sesion();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="UTF-8">
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
	<link rel="stylesheet" href="thickbox/thickbox.css" type="text/css">
	<script>
		function f_entrar() {
			if (1==2) alert ("Temporalmente fuera de servicio");
			else
				if (document.login.entrar_x.value=='Si')
					if (document.login.usuario_x.value!="" && document.login.clave_log.value!="") {
						if (document.login.entro_cambia_contra_x.value!="Si") document.login.clave_log.value=hex_md5(document.login.clave_log.value);
						document.login.submit(); 
						}
					else { alert ("Favor de capturar los datos de Usuario y Contraseña."); document.login.entrar_x.value=''; }
				else
					if (document.login.usuario_x.value!="") document.login.clave_log.focus();
					else document.login.usuario_x.focus();
		}		
		function ventana_TB() {
			TB_show('', 'cambia_contra.php?TB_iframe=true&height=330&width=300&tb_usu_log='+document.login.usuario_x.value, null);
		}
	</script>
  </head>
  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>
      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
			<img src="imagenes/logo_pe.png" alt="">
			  <div style="padding-bottom: 30px;"></div>
			 <form name="login" action="index.php" method="post" onSubmit="return false;">
				<h1 style="font-size: 25px;">SICSEQ</h1>
				<h3>Sistema de Contraloría Social del Estado de Querétaro</h3>
              <div style="padding-top: 20px;">
                <input type="text" class="form-control" placeholder="Usuario" required="required" name="usuario_x" id="usuario_x">
              </div>
              <div>
                <input type="password" name="clave_log" id="clave_log" class="form-control" placeholder="Contraseña" required="required">
              </div>
              <div>
				  <button type="submit" class="btn btn-default btn-sm" onClick="document.login.entrar_x.value='Si'; f_entrar();">Entrar</button>
				  <!--<a class="reset_pass" onClick="" style="cursor:pointer;">Perdiste tu contrase�a?</a>&nbsp;-->
				  <a class="reset_pass" onClick="ventana_TB();" style="cursor:pointer;">Cambiar contraseña</a>
              </div>
              <div class="clearfix"></div>
			  <input name="entrar_x" type="hidden">
			  <input name="entro_cambia_contra_x" type="hidden">
			  <?php if(isset($_POST["usuario_x"]) && $_POST["usuario_x"]=='') echo '<script>document.getElementById("usuario_x").focus();</script>'; else echo '<script>document.getElementById("clave_log").focus();</script>'; ?>
			  </form>
          </section>
        </div>
      </div>
    </div>
	  
	<!-- jQuery -->
    <script src="js/jquery.js"></script>
    <!-- validator -->
	<script src="js/validator.js"></script>
<?php	if (isset($_POST["entrar_x"]) && $_POST["entrar_x"]=='Si') {
	if($sesion->login()) {
		if($sesion->contrasena == $_POST["clave_log"]) {
			if($sesion->num_contra > 0) {
				$cambia_contra_x="";
                $sesion->cargar_usuaro_sesion();
				if($sesion->urol_id_x_contraloriasocial == 1 && $sesion->usuario_adminsitrador_x_contraloriasocial){
				    $sesion->set_flash('Sesión Iniciada',"Bienvenido {$sesion->nombres_x}, has iniciado sesión correctamente");
				    echo '<script>location.href="modulos/notificaciones/dashboard.php";</script>';
                }
                if($sesion->urol_id_x_contraloriasocial == 1 && !$sesion->usuario_adminsitrador_x_contraloriasocial){
                    $sesion->set_flash('Sesión Iniciada',"Bienvenido {$sesion->nombres_x}, has iniciado sesión correctamente");
                    echo '<script>location.href="modulos/notificaciones/dashboard.php";</script>';
                }
                if($sesion->urol_id_x_contraloriasocial == 2 && $sesion->usuario_adminsitrador_x_contraloriasocial){
                    $sesion->set_flash('Sesión Iniciada',"Bienvenido {$sesion->nombres_x}, has iniciado sesión correctamente");
                    echo '<script>location.href="modulos/notificaciones/dashboard.php";</script>';
                }
                if($sesion->urol_id_x_contraloriasocial == 2 && !$sesion->usuario_adminsitrador_x_contraloriasocial){
                    $sesion->set_flash('Sesión Iniciada',"Bienvenido {$sesion->nombres_x}, has iniciado sesión correctamente");
                    echo '<script>location.href="modulos/notificaciones/dashboard.php";</script>';
                }

				echo '<script>alert("Su usuario no cuenta con los permisos para acceder a esta pantalla. Póngase en contacto con el adminsitrador del sistema.");</script>';

				/*
				else {
					$vista_aplicacionb=$contraloriasocialDB->SelectLimit("SELECT bloqueo FROM config_ava_final") or die($contraloriasocialDB->ErrorMsg());
						$bloqueo_x=$vista_aplicacionb->Fields('bloqueo');
					$vista_aplicacionb->Close();
					if($bloqueo_x=="")
						header('location:inicio.php'); //echo '<script>location.href="principal.php";< /script>';
					else { 
						$usuario_x="";
						$contrasena_x="";
						echo '<script>alert("Sistema temporalmente fuera de servicio.\nIntente nuevamente m�s tarde, gracias.");</script>';
						//header('location:inicio.php');
					}
				}
				*/
			}
			else { 
				$cambia_contra_x="Si";
				echo '<script>alert("Su contraseña actual es temporal por lo que debe cambiarla.");</script>';
				echo '<script>ventana_TB();</script>'; 
			} 
		}
		else echo '<script>alert("Su contraseña no es valida, verifique e intente nuevamente, gracias."); document.login.clave_log.focus();</script>';
	}
	else echo '<script>alert("El usuario no puede ser identificado, verifique e intente nuevamente, gracias.");</script>';
}
?>	  
  </body>
</html>
