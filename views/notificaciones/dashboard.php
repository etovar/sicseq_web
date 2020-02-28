<!DOCTYPE html>
<html>
<head>
    <?php include(dirname(__FILE__) . "/../layout/head.php"); ?>
</head>
<body class="nav-md"> <!--class="nav-md footer_fixed"-->
<div class="container body">
    <div class="main_container">
        <?php include(dirname(__FILE__) . "/../layout/menu.php"); ?>
        <!-- page content -->
        <div class="right_col" role="main">
            <div class="">
                <!-- mapa sitio -->
                <div class="row">
                    <div class="col-sm-8" style="padding-left: 7px;">
                        <ol class="breadcrumb">
                            <li>Inicio</li>
                            <li>Obras</li>
                            <li>Agendar Obra</li>
                        </ol>
                    </div>
                </div>
                <!-- fin mapa sitio -->
                <br/>
                <div class="clearfix"></div>
                <div class="row">
                    <div class="col-md-7 col-sm-12 col-xs-4">
                        <div class="x_panel">
                            <div class="x_title">
                                <h5>Acciones requeridas</h5>
                            </div>
                            <div class="x_content">
                                <?php foreach($acciones as $notificacion){?>
                                    <?php
                                    switch ($notificacion['prioridad']){
                                        case 1: $color = "#f2b3b3"; $nombre_prioridad = "<span style='color:#540000'>¡Prioridad Urgente!</span>"; break;
                                        case 2: $color = "#f2d1b3"; $nombre_prioridad = "<span style='color:#754600'>Proridad Alta</span>"; break;
                                        case 3: $color = "#f2e7b3"; $nombre_prioridad = "<span style='color:#948000'>Prioridad Media</span>"; break;
                                        case 4: $color = "#ededed"; $nombre_prioridad = "<span style='color:#5c5c5b'>Prioridad Baja</span>"; break;
                                    }
                                    ?>
                                    <div style="padding:10px; background-color: <?php echo $color;?>">
                                  <span class="image">
                                      <?php
                                      if($notificacion['tipo'] == 'Aviso')
                                          echo '<i class="fa fa-envelope"></i> <small>Aviso</small>';
                                      else
                                          echo '<i class="fa fa-warning" style="color: #990000"></i> <small style="color: #990000">Acción requerida</small>';
                                      ?>
                                  </span>
                                            <span>
                                  <span style="position:absolute;right: 15px!important" class="time">
                                      <?php
                                      echo $nombre_prioridad;
                                      ?>
                                  </span>
                                      <h5><br/><stroong><?php echo $notificacion['titulo']?></stroong></h5>

                            </span>
                                            <p class="message"><?php echo $notificacion['descripcion']?></p>
                                        <p style="text-align: right">
                                            <a class="btn btn-default" href="<?php if($notificacion['tipo'] != 'Aviso') echo $sesion->baseurl.$notificacion['url']; else echo $sesion->baseurl.'modulos/notificaciones/procesar_aviso.php?notificacion_id='.$notificacion['id'];?>"><?php echo $notificacion['call_to_action']?></a>
                                        </p>

                                    </div><br/>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-5 col-sm-12 col-xs-4">
                        <div class="x_panel">
                            <div class="x_title">
                                <h5>Avisos</h5>
                            </div>
                            <div class="x_content">
                                <?php foreach($avisos as $notificacion){?>
                                    <?php
                                    switch ($notificacion['prioridad']){
                                        case 1: $color = "#f2b3b3"; $nombre_prioridad = "<span style='color:#540000'>¡Prioridad Urgente!</span>"; break;
                                        case 2: $color = "#f2d1b3"; $nombre_prioridad = "<span style='color:#754600'>Proridad Alta</span>"; break;
                                        case 3: $color = "#f2e7b3"; $nombre_prioridad = "<span style='color:#948000'>Prioridad Media</span>"; break;
                                        case 4: $color = "#ededed"; $nombre_prioridad = "<span style='color:#5c5c5b'>Prioridad Baja</span>"; break;
                                    }
                                    ?>
                                    <div style="padding:10px; background-color: <?php echo $color;?>">
                                  <span class="image">
                                      <?php
                                      if($notificacion['tipo'] == 'Aviso')
                                          echo '<i class="fa fa-envelope"></i> <small>Aviso</small>';
                                      else
                                          echo '<i class="fa fa-warning" style="color: #990000"></i> <small style="color: #990000">Acción requerida</small>';
                                      ?>
                                  </span>
                                        <span>
                                  <span style="position:absolute;right: 15px!important" class="time">
                                      <?php
                                      echo $nombre_prioridad;
                                      ?>
                                  </span>
                                      <h5 style="font-size: 13px;"><?php echo $notificacion['titulo']?></h5>

                            </span>
                                        <p style="font-size: 11px;" class="message"><?php echo $notificacion['descripcion']?></p>
                                        <p style="text-align: right">
                                            <a class="btn-sm btn-default" href="<?php if($notificacion['tipo'] != 'Aviso') echo $notificacion['url']; else echo $sesion->baseurl.'modulos/notificaciones/procesar_aviso.php?notificacion_id='.$notificacion['id'];?>">Aceptar</a>
                                        </p>

                                    </div><br/>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-8">
                            <div class="x_panel">
                                <div class="x_title">
                                    <h4>Calendario</h4>
                                </div>
                                <div class="x_content">
                                    <div id="calendar"></div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Ventanas modales -->
    <script type="application/javascript">
        var events = <?php  echo $eventos_json; ?>;
    </script>
    <?php include(dirname(__FILE__)."/../layout/pie.php"); ?>
    <script src="../../js/obras/dashboard.js"></script>
</body>
</html>
