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
                    <div class="col-md-4 col-sm-12 col-xs-4">
                        <div class="x_panel">
                            <div class="x_title">
                                <h5>Comités de Obra, Apoyo o Servicio</h5>
                            </div>
                            <div class="x_content">
                                <?php if($obra){ ?>
                                <div style="border-color: #CCC; border-width: 1px; border-style: solid; padding: 10px">
                                    <p style="float: left"><strong>Obra seleccionada</strong></p>
                                    <p style="float:right; text-align: right"><?php echo $obra['num_obra'] ?></p>
                                    <div class="clearfix"></div>
                                    <p class="nombre_single"><?php echo utf8_encode($obra['nombre_obra']) ?></p>
                                    <table style="max-width:100%; width: 100%!important; table-layout: fixed;" class="table ">
                                        <thead>
                                        <tr>
                                            <th style="width:100px!important;">No. de comité</th>
                                            <th style='width:100px!important;'>Acciones</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        foreach($obra['comites'] as $comiteobra){
                                            echo "<tr>";
                                            echo "<td>{$comiteobra['num_comite']}</td>";
                                            echo "<td>";
                                            echo "<a href='./agendar.php?comite_id={$comiteobra['id_comite']}' class='btn btn-success' style='background-color:#27B89B; border: 1px solid #24B28A;' title='Agendar' data-toggle='tooltip' data-placement='bottom' data-original-title='Agendar'><i class='fa fa-calendar'></i></a>";
                                            echo "&nbsp;";
                                            echo "<button class='btn btn-info' title='Datos' data-placement='bottom' data-original-title='Datos'><i class='fa fa-eye'></i></button>";
                                            echo "</td>";
                                            echo "</tr>";
                                        }
                                        ?>
                                        </tbody>
                                    </table>
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
                                                    echo "<td ><p class='nombre_single'>".utf8_encode($obra_tabla['nombre_obra'])."</p></td>";
                                                    echo "<td>";
                                                        echo "<a href='./agendar.php?obra_id={$obra_tabla['id_obra']}' class='btn btn-success' style='background-color:#27B89B; border: 1px solid #24B28A;' title='Agendar' data-toggle='tooltip' data-placement='bottom' data-original-title='Agendar'><i class='fa fa-file-text-o'></i></a>";
                                                        echo "&nbsp;";
                                                        echo "<button data-id='{$obra_tabla['id_obra']}' class='btn btn-info btnFicha' title='Datos' data-toggle='modalFichaTecnica' data-placement='bottom' data-original-title='Datos'><i class='fa fa-eye'></i></button>";
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
                        <?php if($comite){?>
                        <div class="x_panel">
                            <div class="x_title">
                                <p style="float: right; text-align: right"><a href="./ejecutora_listado.php?obra_id=<?php echo $comite['obra_id']?>" class="btn btn-link"><i class="fa fa-arrow-left"></i> Regresar a vista de comités</a></p>
                                <h4><i class="fa fa-users"></i> Comité - <?php echo $comite['num_comite']?></h4>
                            </div>
                            <div class="x_content">

                            </div>
                        </div>
                        <?php }?>

                        <?php if(true){?>
                            <div class="x_panel">
                                <div class="x_title">
                                    <h4>Calendario</h4>
                                </div>
                                <div class="x_content">
                                    <div id="calendar"></div>
                                </div>
                            </div>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Ventanas modales -->
    <!-- modal de agendar fecha -->
    <?php if($comite) {?>
    <div class="modal fade" id="modalAgendar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Fecha de integración de comités</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formAgendar" class="form-horizontal form-label-left" method="post" action="./procesar_agendar.php">
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Comite
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input readonly type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $comite['num_comite'] ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Fecha
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input name="agenda_fecha" id="agenda_fecha" type="date" required="required" class="form-control col-md-7 col-xs-12" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Hora
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input required type="text" id="irsHora" name="agenda_hora" class="form-control col-md-7 col-xs-12" value="" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Lugar
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <textarea rows="6" id="lugar" required name="agenda_lugar" class="form-control col-md-7 col-xs-12" ></textarea>
                            </div>
                        </div>
                        <input type="hidden" name="id_comite" value="<?php echo $comite['id_comite']?>"/>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"  data-dismiss="modal">Cancelar</button>
                    <?php if($comite['status'] == 'confirmado'){?>
                        <button type="button" class="btn btn-danger" onclick="document.getElementById('formAgendar').submit();"><i class="fa fa-calendar"></i> Mover Cita</button>
                        <br/><br/>
                        <p class="alert alert-warning" style="color:#222;text-align: left"><i class="fa fa-warning"></i> Esta cita ya fue confirmada por la Contraloría, al mover la fecha será enviada una notificación.</p>
                    <?php }else{ ?>
                        <button type="button" class="btn btn-primary" onclick="document.getElementById('formAgendar').submit();"><i class="fa fa-calendar"></i> <?php if($comite['agenda_fecha']) echo "Mover cita"; else echo "Agendar fecha"; ?></button>
                    <?php }?>
                </div>
            </div>
        </div>
    </div>
    <?php }?>

    <div class="modal fade" id="modalFichaTecnica" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="exampleModalLabel">Resumen del Expediente Técnico de Obras, Apoyos y/o Servicios.</h4>
                </div>
                <div class="modal-body" id="modalFichaTecnicaResult">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"  data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script type="application/javascript">
        var ejecutora_id = <?php echo $sesion->dependencia_id_x ?>;
        var events = <?php  echo $eventos_json; ?>;
    </script>
    <?php include(dirname(__FILE__)."/../layout/pie.php"); ?>
    <script src="../../js/obras/agendar.js"></script>
</body>
</html>
