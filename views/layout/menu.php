<?php require_once("../../helpers/notificaciones_generales.php"); ?>
		<div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="index.html" class="site_title">
				<img src="../../imagenes/secon.png">
			 </a>
            </div>
            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic" style="padding-top: 20px;">
                <img src="../../imagenes/usuario.png" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info" style="padding-top: 25px;">
                <span>Bienvenido(a)</span>
                <h2><? echo $nombre_usu_x_contraloriasocial; ?></h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3></h3>
                  <?php if($_SESSION['urol_id_x_contraloriasocial'] == 1) {?>
                      <ul class="nav side-menu">
                  <li><a><i class="fa fa-line-chart"></i> Principal <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="<?php echo $sesion->baseurl?>modulos/notificaciones/dashboard.php" style="cursor: pointer;">Tareas</a></li>
                      <li><a onClick="location.href=''" style="cursor: pointer;">Reportes</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-university"></i> Obras <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo $sesion->baseurl?>modulos/obras/ejecutora_listado.php" style="cursor: pointer;">Lista</a></li>
                      <li><a href="<?php echo $sesion->baseurl?>modulos/comites/agendar.php" style="cursor: pointer;">Agenda</a></li>
                        <!-- <li><a href="<?php echo $sesion->baseurl?>modulos/comites/ejecutora_listado.php" style="cursor: pointer;">Comités agendados</a></li> -->
                    </ul>
                  </li>
                    <li><a><i class="fa fa-gears"></i> Configuración <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <!-- <li><a disabled="disabled" href="<?php echo $sesion->baseurl?>modulos/configuracion/personal.php" style="cursor: pointer;">Personal</a></li> --!>
                            <li><a disabled="disabled"onClick="location.href=''" style="cursor: pointer;">Personal</a></li>
                        </ul>
                    </li>
                </ul>
                  <?php } else {?>
                      <ul class="nav side-menu">
                          <li><a><i class="fa fa-line-chart"></i> Principal <span class="fa fa-chevron-down"></span></a>
                              <ul class="nav child_menu">
                                  <li><a href="<?php echo $sesion->baseurl?>modulos/notificaciones/dashboard.php" style="cursor: pointer;">Tareas</a></li>
                                  <li><a onClick="location.href=''" style="cursor: pointer;">Reportes</a></li>
                              </ul>
                          </li>
                          <li><a><i class="fa fa-university"></i> Obras <span class="fa fa-chevron-down"></span></a>
                              <ul class="nav child_menu">
                                  <li><a href="<?php echo $sesion->baseurl?>modulos/obras/contraloria_listado.php" style="cursor: pointer;">Lista</a></li>
                                  <li><a href="<?php echo $sesion->baseurl?>modulos/comites/agendar_contraloria.php" style="cursor: pointer;">Agenda</a></li>
                              </ul>
                          </li>
                          <li><a><i class="fa fa-gears"></i> Configuración <span class="fa fa-chevron-down"></span></a>
                              <ul class="nav child_menu">
                                  <li><a href="<?php echo $sesion->baseurl?>modulos/configuracion/personal.php" style="cursor: pointer;">Personal</a></li>
                              </ul>
                          </li>
                      </ul>
                  <?php } ?>
              </div>
            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Logout" href="../../index.php">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>
				  <div align="center" style="left:20%; width: 70%;position: absolute; margin:auto; text-align: center;">
                      <?php if($_SESSION['urol_id_x_contraloriasocial'] == 1) {?>
                      <h2 ><?php echo $_SESSION['dependencia_x']?> - EJECUTORA</h2>
                      <?php }else{?>
                      <h2 >USUARIO CONTRALORÍA</h2>
                      <?php } ?>
				  </div>
              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="../../imagenes/usuario.png" alt=""><? echo $nombre_usu_x_contraloriasocial; ?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">

                    <li><a href="../../index.php"><i class="fa fa-sign-out pull-right"></i> Cerrar sesión</a></li>
                  </ul>
                </li>
                <li role="presentation" class="dropdown">
                  <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-envelope-o"></i>
                      <?php
                       if(count($notificaciones_generales) > 0){
                           echo '<span class="badge bg-red">'.count($notificaciones_generales).'</span>';
                       }
                      ?>

                  </a>
                  <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                      <?php foreach($notificaciones_generales as $notificacion){?>
                          <?php
                            switch ($notificacion['prioridad']){
                                case 1: $color = "#f2b3b3"; $nombre_prioridad = "<span style='color:#540000'>¡Urgente!</span>"; break;
                                case 2: $color = "#f2d1b3"; $nombre_prioridad = "<span style='color:#754600'>Alta</span>"; break;
                                case 3: $color = "#f2e7b3"; $nombre_prioridad = "<span style='color:#948000'>Media</span>"; break;
                                case 4: $color = "#ededed"; $nombre_prioridad = "<span style='color:#5c5c5b'>Baja</span>"; break;
                            }
                          ?>
                          <li style="background-color: <?php echo $color;?>">
                              <a href="<?php if($notificacion['tipo'] != 'Aviso') echo $notificacion['url']; else echo $sesion->baseurl.'modulos/notificaciones/procesar_aviso.php?notificacion_id='.$notificacion['id'];?>">
                                  <span class="image">
                                      <?php
                                        if($notificacion['tipo'] == 'Aviso')
                                            echo '<i class="fa fa-envelope"></i>';
                                        else
                                            echo '<i class="fa fa-warning" style="color: #990000"></i>';
                                      ?>
                                  </span>
                                  <span>
                                  <span style="right: 10px!important" class="time">
                                      <?php
                                      echo $nombre_prioridad;
                                      ?>
                                  </span>
                                      <span><br/><strong><?php echo $notificacion['titulo']?></strong></span>

                            </span>
                                  <span class="message">
                              <?php echo $notificacion['descripcion']?>
                            </span>
                              </a>
                          </li>
                      <?php } ?>
                        <li>
                          <div class="text-center">
                            <a>
                              <strong>Ver todas las notificaciones</strong>
                              <i class="fa fa-angle-right"></i>
                            </a>
                          </div>
                        </li>
                  </ul>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->
