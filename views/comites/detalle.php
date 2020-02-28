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
                            <li>Comités Agendados</li>
                        </ol>
                    </div>
                </div>
                <!-- fin mapa sitio -->
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_content">
                            <div class="x_title">
                                <p style="float: right">
                                    <button id="btnComitesTarjetas" class="btn btn-sm btn-default"><i class="fa fa-square"></i></button><button id="btnComitesLista" class="btn btn-sm btn-default"><i class="fa fa-list-ul"></i></button>
                                </p>
                                <h3>
                                    Comité <?php echo $comite['num_comite']?>
                                </h3>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_content">
                            <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
                                <div class="panel">
                                    <a class="panel-heading collapsed" role="tab" id="headingOne" data-toggle="collapse" data-parent="#accordion" href="#collapseZero" aria-expanded="false" aria-controls="collapseZero">
                                        <h4 class="panel-title"><i class='fa fa-calendar'></i> Planeación</h4>
                                    </a>
                                    <div id="collapseZero" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne" style="">
                                        <div class="panel-body">
                                            <div class="x_panel">
                                                <div class="x_title">
                                                    <h4>Datos de planeación</h4>
                                                </div>
                                                <div class="x_content">
                                                    <?php
                                                    if(isset($comite['agenda_fecha']) ){
                                                        echo "<p class='text-info'><i class='fa fa-calendar-check-o'></i> {$comite['agenda_fecha']} - de {$comite['agenda_hora_inicio']} a {$comite['agenda_hora_fin']}</p>";
                                                        echo "<p class='text-info'><i class='fa fa-map-marker'></i> {$comite['agenda_lugar']}</p>";
                                                    }
                                                    else{
                                                        echo "<p><i class='fa fa-calendar-times-o'></i> Sin agendar</p>";
                                                    }

                                                    if(isset($comite['usuario_id']) && $comite['usuario_id']){
                                                        $usuarioobj = new Usuario($contraloriasocialDB);
                                                        $usuario = $usuarioobj->getUsuario($comite['usuario_id']);
                                                        echo "<p class='text-info'><i class='fa fa-user'></i> Asignado a {$usuario['nombres']} {$usuario['apellido_p']} {$usuario['apellido_m']}</p>";
                                                    }
                                                    else{
                                                        echo "<p><i class='fa fa-user-times'></i> Sin asignar</p>";
                                                    }

                                                    if(isset($comite['contraloria_usuario_id']) && $comite['contraloria_usuario_id']){
                                                        $usuarioobj = new Usuario($contraloriasocialDB);
                                                        $usuario = $usuarioobj->getUsuario($comite['contraloria_usuario_id']);
                                                        echo "<p class='text-info'><i class='fa fa-user'></i> Asignado CS: {$usuario['nombres']} {$usuario['apellido_p']} {$usuario['apellido_m']}</p>";
                                                    }
                                                    else{
                                                        echo "<p><i class='fa fa-user-times'></i> Sin asignar </p>";
                                                    }

                                                    if(isset($comite['representante_dependencia_normativa']) && $comite['representante_dependencia_normativa']){
                                                        echo "<p class='text-info'><i class='fa fa-user'></i> Representante D. N. {$comite['representante_dependencia_normativa']}</p>";
                                                    }
                                                    else{
                                                        echo "<p><i class='fa fa-user-times'></i> Sin responsable de la dependencia Normativa</p>";
                                                    }

                                                    if(isset($comite['metodo']) && $comite['metodo']){
                                                        echo "<p class='text-info'><i class='fa fa-pencil'></i> Método {$comite['metodo']}</p>";
                                                    }
                                                    else{
                                                        echo "<p><i class='fa fa-pencil'></i> Sin método definido</p>";
                                                    }
                                                    ?>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="panel">
                                    <a class="panel-heading collapsed" role="tab" id="headingOne" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                        <h4 class="panel-title"><i class='fa fa-edit'></i> Primera sesión</h4>
                                    </a>
                                    <div id="collapseOne" class="panel-collapse in collapse" role="tabpanel" aria-labelledby="headingOne" style="">
                                        <div class="panel-body">
                                            <div class="x_panel">
                                                <div class="x_title">
                                                    <h4><i class="fa fa-check-square-o"></i> Pase de Lista</h4>
                                                </div>
                                                <div class="x_content">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <h5>Fotografías (Check)</h5>
                                                            <div class="row">
                                                                <?php
                                                                foreach($listafotos as $foto){
                                                                    ?>
                                                                    <div class="col-md-4">
                                                                        <img data-url="listafoto_id=<?php echo $foto['id']?>" style="cursor:pointer" class="image-preview btnCheck" src="<?php $fotourl = $comitesobj->getListafoto($foto['id'],$sesion); echo $fotourl['url'];?>" />
                                                                    </div>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <h5>Documento</h5>
                                                            <form method="post" enctype="multipart/form-data" id="formDocumentoLista"  action="./procesar_subir_documento.php">
                                                                <label >
                                                                    Cargar Documento Escaneado
                                                                    <input required type="file" name="documento"/>
                                                                </label>
                                                                <input type="hidden" name="comite_id" value="<?php echo $comite['id_comite']?>">
                                                                <input type="hidden" name="tipo" value="lista">
                                                                <button type="button" class="btn btn-primary" onclick="document.getElementById('formDocumentoLista').submit();"><i class="fa fa-upload"></i> Subir Documento</button>
                                                            </form>

                                                            <?php if(file_exists("../../storage/documentos/lista_{$comite['id_comite']}.pdf")){ ?>
                                                                <br/>
                                                                <p style="text-align: center">
                                                                    <iframe style="margin:auto; width: 90%; height: 350px;" src="../../storage/documentos/lista_<?php echo $comite['id_comite']?>.pdf" frameborder="0" width="655" height="550" marginheight="0" marginwidth="0" id="pdf"></iframe>
                                                                </p>
                                                                <p style="text-align: right">
                                                                    <a target="_blank" href="./../../storage/documentos/lista_<?php echo $comite['id_comite']?>.pdf" class="btn btn-primary"><i class="fa fa-file-text"></i> Ver documento completo</a>
                                                                </p>
                                                            <?php }?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="x_panel">
                                                <div class="x_title">
                                                    <h4><i class="fa fa-users"></i> Integración</h4>
                                                </div>
                                                <div class="x_content">
                                                    <div class="row">
                                                        <!--
                                                        <div class="col-lg-6">
                                                            <h5>Impresión de documentos</h5>
                                                            <br/>
                                                            <a target="_blank" href="./imprimir_integracion.php?comite_id=<?php echo $comite['id_comite']?>" class="btn btn-primary"><i class="fa fa-print"></i> Impresión de Acta de Integración</a>
                                                        </div>
                                                        -->

                                                        <div class="col-lg-6">
                                                            <h5>Documento (Check)</h5>
                                                            <div class="row">
                                                                <?php
                                                                foreach($documentofotos_integracion as $foto){
                                                                    ?>
                                                                    <div class="col-md-4">
                                                                        <img data-url="documentofoto_integracion_id=<?php echo $foto['id']?>" style="cursor:pointer" class="image-preview btnCheck" src="<?php $fotourl = $comitesobj->getDocumentofoto($foto['id'],'integracion',$sesion); echo $fotourl['url'];?>" />
                                                                    </div>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>

                                                        <!--
                                                        <div class="col-lg-6">
                                                            <h5>Cargar datos de Integración</h5>
                                                            <br/>
                                                            <a target="_blank" href="./formulario_integracion.php?comite_id=<?php echo $comite['id_comite']?>" class="btn btn-primary"><i class="fa fa-edit"></i> Cargar datos de Integración</a>
                                                        </div>
                                                        -->

                                                        <div class="col-lg-6">
                                                            <h5>Generar Documento</h5>
                                                            <br/>
                                                            <a target="_blank" href="./imprimir_integracion.php?generar=true&comite_id=<?php echo $comite['id_comite']?>" class="btn btn-primary"><i class="fa fa-print"></i> Generar Acta de Integración</a>
                                                        </div>

                                                        <!--
                                                        <div class="col-lg-6">
                                                            <h5>Documento</h5>
                                                            <form method="post" enctype="multipart/form-data" id="formDocumentoIntegracion"  action="./procesar_subir_documento.php">
                                                                <label >
                                                                    Cargar Documento Escaneado
                                                                    <input required type="file" name="documento"/>
                                                                </label>
                                                                <input type="hidden" name="comite_id" value="<?php echo $comite['id_comite']?>">
                                                                <input type="hidden" name="tipo" value="integracion">
                                                                <button type="button" class="btn btn-primary" onclick="document.getElementById('formDocumentoIntegracion').submit();"><i class="fa fa-upload"></i> Subir Documento</button>
                                                            </form>

                                                            <?php if(file_exists("../../storage/documentos/integracion_{$comite['id_comite']}.pdf")){ ?>
                                                                <br/>
                                                                <p style="text-align: center">
                                                                    <iframe style="margin:auto; width: 90%; height: 350px;" src="../../storage/documentos/integracion_<?php echo $comite['id_comite']?>.pdf" frameborder="0" width="655" height="550" marginheight="0" marginwidth="0" id="pdf"></iframe>
                                                                </p>
                                                                <p style="text-align: right">
                                                                    <a target="_blank" href="../../storage/documentos/integracion_<?php echo $comite['id_comite']?>.pdf" class="btn btn-primary"><i class="fa fa-file-text"></i> Ver documento completo</a>
                                                                </p>
                                                            <?php }?>
                                                        </div>
                                                        -->

                                                        <div class="col-lg-6">
                                                            <h5>Evidencias (Check)</h5>
                                                            <div class="row">
                                                                <?php
                                                                foreach($evidenciafotos_integracion as $foto){
                                                                    ?>
                                                                    <div class="col-md-4">
                                                                        <img data-url="evidenciafoto_integracion_id=<?php echo $foto['id']?>" style="cursor:pointer" class="image-preview btnCheck" src="<?php $fotourl = $comitesobj->getEvidenciafoto($foto['id'],'integracion',$sesion); echo $fotourl['url'];?>" />
                                                                    </div>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="x_panel">
                                                <div class="x_title">
                                                    <h4><i class="fa fa-graduation-cap"></i> Capacitación</h4>
                                                </div>
                                                <div class="x_content">
                                                    <!--
                                                    <div class="col-lg-6">
                                                        <h5>Impresión de documentos</h5>
                                                        <br/>
                                                        <a target="_blank" href="./imprimir_capacitacion.php?comite_id=<?php echo $comite['id_comite']?>" class="btn btn-primary"><i class="fa fa-print"></i> Impresión de Acta de Capacitación</a>
                                                    </div>
                                                    -->


                                                    <div class="col-lg-6">
                                                        <h5>Documento (Check)</h5>
                                                        <div class="row">
                                                            <?php
                                                            foreach($documentofotos_capacitacion as $foto){
                                                                ?>
                                                                <div class="col-md-4">
                                                                    <img data-url="documentofoto_capacitacion_id=<?php echo $foto['id']?>" style="cursor:pointer" class="image-preview btnCheck" src="<?php $fotourl = $comitesobj->getDocumentofoto($foto['id'],'capacitacion',$sesion); echo $fotourl['url'];?>" />
                                                                </div>
                                                                <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>

                                                    <!--
                                                    <div class="col-lg-6">
                                                        <h5>Cargar datos de Capacitación</h5>
                                                        <br/>
                                                        <a target="_blank" href="./formulario_capacitacion.php?comite_id=<?php echo $comite['id_comite']?>" class="btn btn-primary"><i class="fa fa-edit"></i> Cargar datos de Capacitación</a>
                                                    </div>
    |                                               -->

                                                    <div class="col-lg-6">
                                                        <h5>Generar Documento</h5>
                                                        <br/>
                                                        <a target="_blank" href="./imprimir_capacitacion.php?generar=true&comite_id=<?php echo $comite['id_comite']?>" class="btn btn-primary"><i class="fa fa-print"></i> Generar Acta de Capacitacion</a>
                                                    </div>

                                                    <!--
                                                    <div class="col-lg-6">
                                                        <h5>Documento</h5>
                                                        <form method="post" enctype="multipart/form-data" id="formDocumentoCapacitacion"  action="./procesar_subir_documento.php">
                                                            <label >
                                                                Cargar Documento Escaneado
                                                                <input required type="file" name="documento"/>
                                                            </label>
                                                            <input type="hidden" name="comite_id" value="<?php echo $comite['id_comite']?>">
                                                            <input type="hidden" name="tipo" value="capacitacion">
                                                            <button type="button" class="btn btn-primary" onclick="document.getElementById('formDocumentoCapacitacion').submit();"><i class="fa fa-upload"></i> Subir Documento</button>
                                                        </form>

                                                        <?php if(file_exists("../../storage/documentos/capacitacion_{$comite['id_comite']}.pdf")){ ?>
                                                            <br/>
                                                            <p style="text-align: center">
                                                                <iframe style="margin:auto; width: 90%; height: 350px;" src="../../storage/documentos/capacitacion_<?php echo $comite['id_comite']?>.pdf" frameborder="0" width="655" height="550" marginheight="0" marginwidth="0" id="pdf"></iframe>
                                                            </p>
                                                            <p style="text-align: right">
                                                                <a target="_blank" href="../../storage/documentos/capacitacion_<?php echo $comite['id_comite']?>.pdf" class="btn btn-primary"><i class="fa fa-file-text"></i> Ver documento completo</a>
                                                            </p>
                                                        <?php }?>
                                                    </div>
                                                    -->

                                                    <div class="col-lg-6">
                                                        <h5>Evidencias (Check)</h5>
                                                        <div class="row">
                                                            <?php
                                                            foreach($evidenciafotos_capacitacion as $foto){
                                                                ?>
                                                                <div class="col-md-4">
                                                                    <img data-url="evidenciafoto_capacitacion_id=<?php echo $foto['id']?>" style="cursor:pointer" class="image-preview btnCheck" src="<?php $fotourl = $comitesobj->getEvidenciafoto($foto['id'],'capacitacion',$sesion); echo $fotourl['url'];?>" />
                                                                </div>
                                                                <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="x_panel">
                                                <div class="x_title">
                                                    <h4> Generales</h4>
                                                </div>
                                                <div class="x_content">
                                                    <div class="col-lg-6">
                                                        <h5>Evidencias Generales (Check)</h5>
                                                        <div class="row">
                                                            <?php
                                                            foreach($evidenciafotos_general as $foto){
                                                                ?>
                                                                <div class="col-md-4">
                                                                    <img data-url="evidenciafoto_general_id=<?php echo $foto['id']?>" style="cursor:pointer" class="image-preview btnCheck" src="<?php $fotourl = $comitesobj->getEvidenciafoto($foto['id'],'general',$sesion); echo $fotourl['url'];?>" />
                                                                </div>
                                                                <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel">
                                    <a class="panel-heading collapsed" role="tab" id="headingTwo" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        <h4 class="panel-title"><i class='fa fa-binoculars'></i> Seguimiento</h4>
                                    </a>
                                    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo" style="">
                                        <div class="panel-body">
                                            <p class="alert alert-warning" style="color: #333"><i class="fa fa-warning"></i> Aún no existe información de seguimiento</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel">
                                    <a class="panel-heading collapsed" role="tab" id="headingThree" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        <h4 class="panel-title"><i class='fa fa-archive'></i> Conclusión</h4>
                                    </a>
                                    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree" style="">
                                        <div class="panel-body">
                                            <p class="alert alert-warning" style="color: #333"><i class="fa fa-warning"></i> Aún no existe información de conclusión</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Ventanas modales -->
    <div class="modal fade" id="modalCheck" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="exampleModalLabel">Revisión del Check.</h4>
                </div>
                <div class="modal-body" id="modalCheckResult">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"  data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <?php include(dirname(__FILE__)."/../layout/pie.php"); ?>
    <script type="application/javascript">
        $(document).ready(function(){
            $('.btnCheck').click(function(){
                var url = $(this).data('url');
                $("#modalCheck").modal('show');
                $.get( "../ajax/check.php?"+url, function( data ) {
                    $( "#modalCheckResult" ).html( data );
                });
            });
        });
    </script>
</body>
</html>
