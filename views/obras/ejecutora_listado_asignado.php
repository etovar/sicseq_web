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
                    </div>
                    <div class="col-lg-10 col-sm-10 col-xs-12" style="width: 75%">
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
                                        <th style="width: 50px;">No. de Obra</th>
                                        <th style="text-align: center">Obra</th>
                                        <th style="width: 100px!important;">Localidad Municipio</th>
                                        <th>Inicio Término</th>
                                        <th>Fondo</th>
                                        <th>Estatus</th>
                                        <th>Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($obras as $obra) { ?>
                                            <tr>
                                                <td><?php echo $obra['num_obra']; ?></td>
                                                <td><a style='cursor:pointer;' data-toggle="modal" data-target="#modalFichaTecnica" data-id="<?php echo $obra['id_obra']; ?>"><?php echo $obra['nombre_obra']; ?></a></td>
                                                <td><?php echo "{$obra['localidad']}, {$obra['mmunicipio']}";?></td>
                                                <td><?php echo "{$obra['inicio_obra']} - {$obra['termino_obra']}";?></td>
                                                <td><?php echo $obra['fondo']; ?> (<?php echo $obra['normatividad'];?>)</td>
                                                <?php
                                                $result= "";
                                                    switch($obra['status']){
                                                        case 'nueva': $result = "<span class='label label-success' style='background-color: #27B89B'><i class='fa fa-warning'></i> Nueva</span>"; break;
                                                        case 'solicitud_no_integracion': $result = "<span class='label label-warning'><i class='fa fa-user-times'></i> Solicitud de no Integraci&oacute;n</span>"; break;
                                                        case 'no_integracion': $result = "<span class='label label-default'><i class='fa fa-times'></i> No integraci&oacute;n</span>"; break;
                                                        case 'solicitud_subobras': $result = "<span class='label label-warning'><i class='fa fa-code-fork'></i> Solicitud de sub obras</span>"; break;
                                                        case 'subobras': $result = "<span class='label label-info'><i class='fa fa-code-fork'></i> Subobras</span>"; break;
                                                        case 'primera_sesion': $result = "<span class='label label-info'><i class='fa fa-pencil'></i> Primera Sesi&oacute;n</span>"; break;
                                                        case 'primera_sesion_seguimiento': $result = "<span class='label label-info'><i class='fa fa-pencil'></i> Primera Sesión / Seguimiento</span>"; break;
                                                        case 'seguimiento': $result = "<span class='label label-info'><i class='fa fa-search'></i> Seguimiento</span>"; break;
                                                        case 'concluido': $result = "<span class='label label-default'><i class='fa fa-check'></i> Concluida</span>"; break;
                                                        default: $result = "<span class='label label-success' style='background-color: #777'>{$obra['status']}</span>";
                                                    }
                                                ?>
                                                <td><?php echo $result; ?></td>
                                                <td>
                                                    <a href="../comites/ejecutora_listado.php?obra_id=<?php echo $obra['id_obra']?>" class="btn btn-appb btn-primary"  title="Comités" data-toggle="tooltip" data-placement="bottom" data-original-title="Comités"><i class="fa fa-users"></i></a>
                                                </td>
                                            </tr>
                                        <?php } ?>
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
            echo 'var num_obra = " ";';
        ?>
        var status = <?php echo $statusjs?>;
        var ejecutora_id = <?php echo $sesion->dependencia_id_x ?>;
    </script>
    <?php include(dirname(__FILE__)."/../layout/pie.php"); ?>
    <script src="../../js/obras/ejecutora_listado_asignado.js"></script>
</body>
</html>
