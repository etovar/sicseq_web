<!DOCTYPE html>
<html>
<head>
    <?php include (dirname(__FILE__)."/../layout/head.php"); ?>
</head>
<body class="nav-md"> <!--class="nav-md footer_fixed"-->
<div class="container body">
    <div class="main_container">
        <?php include(dirname(__FILE__)."/../layout/menu.php"); ?>
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
                    <div class="col-md-4 col-sm-12 col-xs-4">
                        <div class="x_panel">
                            <div class="x_title">
                                <h5>Obra, Apoyo o Servicio seleccionado</h5>
                            </div>
                            <div class="x_content">
                                <?php if($obra){ ?>
                                <div style="border-color: #CCC; border-width: 1px; border-style: solid; padding: 10px">
                                    <p style="float: left"><strong>Obra seleccionada</strong></p>
                                    <p style="float:right; text-align: right"><?php echo $obra['num_obra'] ?></p>
                                    <div class="clearfix"></div>
                                    <p><?php echo utf8_encode($obra['nombre_obra']) ?></p>
                                    <?php
                                        if($obra['agendada_fecha']){
                                            if(!$obra['agendada_confirmada']){
                                                echo '<p style="text-align: right"><button data-toggle="modal" data-target="#modalAgendar"  class="btn btn-sm btn-success"><i class="fa fa-calendar-plus-o"></i> Modificar Fecha</button></p>';
                                            }
                                            else{
                                                echo '<p class="alert alert-info"><i class="fa fa-info-circle"></i> Esta cita ha sido confirmada por Contraloría</p>';
                                            }
                                        }
                                        else{
                                            echo '<p style="text-align: right"><button data-toggle="modal" data-target="#modalAgendar"  class="btn btn-sm btn-success"><i class="fa fa-calendar-plus-o"></i> Agregar Fecha</button></p>';
                                        }
                                    ?>
                                </div>
                                <?php }else{ ?>
                                    <p class="alert alert-warning"><i class="fa fa-info-circle"></i> No se ha seleccionado ninguna obra</p>
                                    <br/><br/><br/><br/><br/>
                                <?php } ?>
                            </div>
                        </div>
                        <br/>
                        <div class="x_panel">
                            <div class="x_title">
                                <h5>Obras, apoyos o servicios</h5>
                            </div>
                            <div class="x_content">
                                <form id="frmFiltrar" method="post" action="">
                                <p style="text-align: right">
                                    <input placeholder="Búsqueda por No. de obra" name="num_obra" id="baja_avance" type="text" required="required" class="form-control" style="max-width: 70%; display: inline;" value="<?php if(isset($_POST['num_obra'])) echo $_POST['num_obra']; ?>">&nbsp;&nbsp;
                                    <?php if($obra) $obra_get = "?obra_id={$obra['id_obra']}"; else $obra_get = ""; ?>
                                    <a href="./agendar.php<?php echo $obra_get ?>" class="btn btn-default" title="Eliminar Filtros" data-toggle="tooltip" data-placement="bottom" data-original-title="Eliminar Filtros">
                                        <i class="fa fa-undo"></i>
                                    </a>
                                    <button onclick="document.getElementById('frmFiltrar').submit();" id="btnFiltrar" type="submit" class="btn btn-info" title="Filtrar" data-toggle="tooltip" data-placement="bottom" data-original-title="Filtrar">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </p>
                                </form>
                                <br/>
                                <div style="height: 350px; overflow-y: auto; overflow-x: hidden">
                                    <table style="max-width:100%; width: 100%!important; table-layout: fixed;" class="table ">
                                        <thead>
                                        <tr>
                                            <th style="width:100px!important;">No. de Obra</th>
                                            <th >Nombre</th>
                                            <th style='width:100px!important;'>Acciones</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                foreach($obras as $obra_tabla){
                                                    echo "<tr>";
                                                    echo "<td>{$obra_tabla['num_obra']}</td>";
                                                    echo "<td >".utf8_encode($obra_tabla['nombre_obra'])."</td>";
                                                    echo "<td>";
                                                        echo "<a href='./agendar.php?obra_id={$obra_tabla['id_obra']}' class='btn btn-success' style='background-color:#27B89B; border: 1px solid #24B28A;' title='Agendar' data-toggle='tooltip' data-placement='bottom' data-original-title='Agendar'><i class='fa fa-file-text-o'></i></a>";
                                                        echo "&nbsp;";
                                                        echo "<button class='btn btn-info' title='Datos' data-toggle='tooltip' data-placement='bottom' data-original-title='Datos'><i class='fa fa-eye'></i></button>";
                                                    echo "</td>";
                                                    echo "</tr>";
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8 col-sm-12 col-xs-8">
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
    <!-- modal de agendar fecha -->
    <?php if($obra) {?>
    <div class="modal fade" id="modalAgendar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Fecha de integración de comités para Obra</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formAgendar" class="form-horizontal form-label-left" method="post" action="./procesar_agendar.php">
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Obra
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input readonly type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $obra['num_obra'] ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Fecha
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input name="agendada_fecha" id="baja_avance" type="date" required="required" class="form-control col-md-7 col-xs-12" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Hora
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input required type="text" id="irsHora" name="agendada_hora" class="form-control col-md-7 col-xs-12" value="" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Número de comités a integrar
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input name="no_comites" <?php if(count($obra['comites']) > 0) echo 'readonly'?> id="baja_avance" type="number" required="required" class="form-control col-md-7 col-xs-12" value="1">
                            </div>
                        </div>
                        <input type="hidden" name="obra_id" value="<?php echo $obra['id_obra']?>"/>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"  data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="document.getElementById('formAgendar').submit();"><i class="fa fa-calendar"></i> Agendar fecha</button>
                </div>
            </div>
        </div>
    </div>
    <?php }?>
    <script type="application/javascript">
        var ejecutora_id = <?php echo $sesion->dependencia_id_x ?>;
        var events = <?php  echo $eventos_json; ?>;
    </script>
    <?php include(dirname(__FILE__)."/../layout/pie.php"); ?>
    <script src="../../js/obras/agendar.js"></script>
</body>
</html>
