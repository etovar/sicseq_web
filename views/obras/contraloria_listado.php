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
                        <a type="button" class="btn btn-default">Nueva obra x</a>
                    </div>
                    <div class="col-lg-10 col-sm-10 col-xs-12" style="widows: 75%">
                        <h4>Busqueda específica</h4><br>
                        <div>
                            <div class="col-md-4">

                            </div>
                            <div class="col-md-4">
                                Ejecutora
                                <div class="control-group">
                                    <div class="controls">
                                        <div class="input-prepend input-group">
                                            <select id="cboEjecutora" class="form-control">
                                                <option value="">Seleccionar</option>
                                                <?php
                                                    foreach($dependencias as $dependencia){
                                                        if($ejecutorajs == "'{$dependencia['id_dependencia']}'")
                                                            $selected = "selected";
                                                        else
                                                            $selected = "";
                                                        echo "<option value='{$dependencia['id_dependencia']}' {$selected}>{$dependencia['nombre']}</option>";
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                Estatus
                                <div class="control-group">
                                    <div class="controls">
                                        <div class="input-prepend input-group">
                                            <select id="cboStatus" class="form-control">
                                                <option  value="">Seleccionar</option>
                                                <option <?php if($statusjs == "'nueva'") echo "selected"?> value="nueva">Nueva</option>
                                                case 'solicitud_no_integracion': $result = "<span class='label label-warning'><i class='fa fa-user-times'></i> Solicitud de no Integraci&oacute;n</span>"; break;
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
                                    <a href="./contraloria_listado.php" class="btn btn-default" title="Eliminar Filtros" data-toggle="tooltip" data-placement="bottom" data-original-title="Eliminar Filtros">
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
                                        <th>Dependencia</th>
                                        <th style="text-align: center">Nombre de la Obra</th>
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
                    <h4 class="modal-title" id="exampleModalLabel">Respuesta a Solicitud de no integración de comité</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formBaja" class="form-horizontal form-label-left" method="post" action="./procesar_respuesta_baja.php">
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Motivo de solicitud
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="solicitud_baja" readonly type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Justificación
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <textarea id="baja_justificacion" disabled rows="6" id="first-name" required name="solicitud_baja" class="form-control col-md-7 col-xs-12" ></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Respuesta de la Contraloría
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <textarea rows="6" id="first-name" required name="baja_respuesta" class="form-control col-md-7 col-xs-12" ></textarea>
                            </div>
                        </div>
                        <input type="hidden" id="baja_obra_id" name="obra_id" value=""/>
                        <input id="respuesta" type="hidden" id="respuesta" name="respuesta" value="1"/>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"  data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="document.getElementById('formBaja').submit();"><i class="fa fa-check"></i> Aceptar solicitud</button>
                    <button type="button" class="btn btn-danger" onclick="document.getElementById('respuesta').value = 0;document.getElementById('formBaja').submit();"><i class="fa fa-times"></i> Rechazar solicitud</button>
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
        var ejecutora_id = <?php echo $ejecutorajs?>;
    </script>
    <?php include(dirname(__FILE__)."/../layout/pie.php"); ?>
    <script src="../../js/obras/contraloria_listado.js"></script>
</body>
</html>
