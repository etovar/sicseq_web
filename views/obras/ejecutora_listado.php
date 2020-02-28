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
                            <li>Listado de Obras</li>
                        </ol>
                    </div>
                </div>
                <!-- fin mapa sitio -->
                <div class="page-title">
                    <div class="col-lg-2 col-sm-2 col-xs-12 title_left" style="width: 15%; vertical-align:middle; padding-top: 20px;">
                        <br/><br/><br/>
                        <!--<a href="./nueva_obra.php" type="button" class="btn btn-primary">Nueva obra</a>-->
                        <a type="button" class="btn btn-default">Nueva obra</a>
                    </div>
                    <div class="col-lg-10 col-sm-10 col-xs-12" style="widows: 75%">
                        <h4>Busqueda específica</h4><br>
                        <div>
                            <div class="col-md-4">

                            </div>
                            <div class="col-md-4">

                            </div>
                            <div class="col-md-2">
                                Estatus
                                    <div class="control-group">
                                        <div class="controls">
                                            <div class="input-prepend input-group">
                                                <select id="cboStatus" class="form-control">
                                                    <option  value="">Seleccionar</option>
                                                    <option <?php if($statusjs == "'nueva'") echo "selected"?> value="nueva">Nueva</option>
                                                    <option <?php if($statusjs == "'solicitud_no_integracion'") echo "selected"?> value="solicitud_no_integracion">Solicitud de no Integración</option>
                                                    <option <?php if($statusjs == "'no_integracion'") echo "selected"?> value="no_integracion">No Integración de Comité</option>
                                                    <option <?php if($statusjs == "'solicitud_subobras'") echo "selected"?> value="solicitud_subobras">Solicitud de Subobras</option>
                                                    <option <?php if($statusjs == "'subobras'") echo "selected"?> value="subobras">Subobras</option>
                                                    <option <?php if($statusjs == "'primera_sesion'") echo "selected"?> value="primera_sesion">Primera Sesión</option>
                                                    <option <?php if($statusjs == "'primera_sesion_seguimiento'") echo "selected"?> value="primera_sesion_seguimiento">Primera Sesión / Seguimiento</option>
                                                    <option <?php if($statusjs == "'seguimiento'") echo "selected"?> value="seguimiento">Seguimiento</option>
                                                    <option <?php if($statusjs == "'concluido'") echo "selected"?> value="concluido">Concluido</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <div class="col-md-2">
                                <br/>
                                <p style="text-align: right">
                                    <a href="./ejecutora_listado.php" class="btn btn-default" title="Eliminar Filtros" data-toggle="tooltip" data-placement="bottom" data-original-title="Eliminar Filtros">
                                        <i class="fa fa-undo"></i>
                                    </a>
                                    <a id="btnFiltrar" class="btn btn-info" title="Filtrar" data-toggle="tooltip" data-placement="bottom" data-original-title="Filtrar">
                                        <i class="fa fa-search"></i>
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_content">
                                <p class="text-muted font-13 m-b-30">
                                </p>
                                <table style="table-layout:fixed;width: 100%; min-width: 960px;" id="datatable-obras" class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th style="width: 50px;">No. de Obra<br>/Sub-Obra</th>
                                        <th style="text-align: center">Obra</th>
                                        <th style="width: 100px!important;">Localidad Municipio</th>
                                        <th>Inicio Término</th>
                                        <th>Fondo</th>
                                        <th>Estatus</th>
                                        <th>Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                            <br/>
                            <p style="text-align: right">
                                <a target="_blank" href="./imprimir_lista.php" class="btn btn-primary"><i class="fa fa-print"></i> Imprimir Lista</a>
                                <a target="_blank" href="./exportar_excel.php" class="btn btn-primary"><i class="fa fa-file-excel-o"></i> Exportar a Excel</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Ventanas modales -->
    <!-- modal de solicitar baja -->
    <div class="modal fade" id="modalSolicitudBaja" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Solicitud de no integración de comité</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formBaja" class="form-horizontal form-label-left" method="post" action="./procesar_solicitud_baja.php">
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Fecha de Solicitud
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input readonly type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo date('d M Y') ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Avance de la Obra
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input readonly id="baja_avance" type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Motivo
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="solicitud_baja" class="form-control">
                                    <option value="">Seleccione</option>
                                    <option value="1">Este tipo de obra o apoyo no aplica</option>
                                    <option value="2">Esta obra se subdividirá en otras obras</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Justificación
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <textarea rows="6" id="first-name" required name="baja_justificacion" class="form-control col-md-7 col-xs-12" ></textarea>
                            </div>
                        </div>
                        <input type="hidden" id="baja_obra_id" name="obra_id" value=""/>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"  data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="document.getElementById('formBaja').submit();">Solicitar Baja</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalRespuestaBaja" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Respuesta a solicitud de no integración de comité</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Respuesta de la Contraloría
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <textarea disabled rows="6" id="respuesta" required name="baja_justificacion" class="form-control col-md-7 col-xs-12" ></textarea>
                            </div>
                        </div>
                    <div class="clearfix"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary"  data-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>

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
        <?php
            if($num_obra)
                echo 'var num_obra = '.$num_obra.';';
            else
                echo 'var num_obra = "";';
            ?>
        var status = <?php echo $statusjs?>;
        var ejecutora_id = <?php echo $sesion->dependencia_id_x ?>;
    </script>
    <?php include(dirname(__FILE__)."/../layout/pie.php"); ?>
    <script src="../../js/obras/ejecutora_listado.js"></script>
</body>
</html>
