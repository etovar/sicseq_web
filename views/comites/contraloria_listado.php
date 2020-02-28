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
                <div class="page-title">
                    <div class="col-lg-12 col-sm-12 col-xs-12" style="widows: 75%">
                        <h4>Busqueda específica</h4><br>
                        <div>
                            <div class="col-md-2">
                                &nbsp;
                            </div>

                            <div class="col-md-2">
                                No. Comité
                                <div class="control-group">
                                    <div class="controls">
                                        <div class=" ">
                                            <select id="cboStatus" class="form-control">
                                                <option  value="">Seleccionar</option>
                                                <?php
                                                foreach($comites as $comite){
                                                    echo "<option value='{$comite['id_comite']}'>{$comite['num_comite']}</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2">
                                No. Obra
                                <div class="control-group">
                                    <div class="controls">
                                        <div class=" ">
                                            <select id="cboStatus" class="form-control">
                                                <option  value="">Seleccionar</option>
                                                <?php
                                                foreach($obras as $obra_filtro){
                                                    $selected = "";
                                                    if($obra){
                                                        if($obra['id_obra'] == $obra_filtro['id_obra']){
                                                            $selected = "selected";
                                                        }
                                                    }

                                                    echo "<option {$selected} value='{$obra_filtro['id_obra']}'>{$obra_filtro['num_obra']}</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="col-md-2">
                                Método
                                <div class="control-group">
                                    <div class="controls">
                                        <div class=" ">
                                            <select id="cboStatus" class="form-control">
                                                <option  value="">Seleccionar</option>
                                                <option <?php if($statusjs == "'sin_agendar'") echo "selected"?> value="sin_agendar">Físico</option>
                                                <option <?php if($statusjs == "'agendada'") echo "selected"?> value="agendada">Digital</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2">
                                Estatus
                                <div class="control-group">
                                    <div class="controls">
                                        <div class=" ">
                                            <select id="cboStatus" class="form-control">
                                                <option  value="">Seleccionar</option>
                                                <option <?php if($statusjs == "'sin_agendar'") echo "selected"?> value="sin_agendar">Asignado</option>
                                                <option <?php if($statusjs == "'agendada'") echo "selected"?> value="agendada">Integrado</option>
                                                <option <?php if($statusjs == "'agendada'") echo "selected"?> value="agendada">Capacitado</option>
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
                        <div class="x_content">
                            <div class="x_title">
                                <p style="float: right">
                                    <button id="btnComitesTarjetas" class="btn btn-sm btn-default"><i class="fa fa-square"></i></button><button id="btnComitesLista" class="btn btn-sm btn-default"><i class="fa fa-list-ul"></i></button>
                                </p>
                                <h3>
                                    Comités
                                    <?php
                                    if($obra){
                                        echo "para {$obra['num_obra']}";
                                        switch($obra['status']){
                                            case 'nueva': $result = "<span class='label label-success' style='background-color: #27B89B'><i class='fa fa-warning'></i> Nueva</span>"; break;
                                            case 'solicitud_no_integracion': $result = "<span class='label label-warning'><i class='fa fa-user-times'></i> Solicitud de no Integraci&oacute;n</span>"; break;
                                            case 'no_integracion': $result = "<span class='label label-default'><i class='fa fa-times'></i> No integración</span>"; break;
                                            case 'solicitud_subobras': $result = "<span class='label label-warning'><i class='fa fa-code-fork'></i> Solicitud de sub obras</span>"; break;
                                            case 'subobras': $result = "<span class='label label-info'><i class='fa fa-tree'></i> Subobras</span>"; break;
                                            case 'primera_sesion': $result = "<span class='label label-info'><i class='fa fa-pencil'></i> Primera Sesión</span>"; break;
                                            case 'primera_sesion_seguimiento': $result = "<span class='label label-info'><i class='fa fa-pencil'></i> Primera Sesi&oacute;n / Seguimiento</span>"; break;
                                            case 'seguimiento': $result = "<span class='label label-info'><i class='fa fa-search'></i> Seguimiento</span>"; break;
                                            case 'concluido': $result = "<span class='label label-default'><i class='fa fa-check'></i> Concluida</span>"; break;
                                            default: $result = "<span class='label label-success' style='background-color: #777'>$val</span>";
                                        }
                                        echo " {$result}";
                                    }
                                    ?>
                                </h3>
                                <?php
                                if($obra){
                                    echo "<p>{$obra['nombre_obra']}</p>";
                                    $normatividad = $obrasobj->getNormatividad($obra['id_obra']);
                                    echo "<p>Normatividad: {$normatividad}</p>";
                                }
                                ?>

                            </div>
                            <div id="vistaComitesCards">
                                <?php
                                if(isset($_GET['obra_id']) && $_GET['obra_id']){
                                    if(count($comites) <= 0){
                                        echo "<p class='alert alert-warning'><i class='fa fa-warning'></i> La dependencia aún no ha determinado el número de comités a generar</p>";
                                    }
                                }
                                foreach($comites as $comite){
                                    echo "<div class=\"animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12\">
                                            <div class=\"tile-stats\">
                                                <div class=\"icon\"><i class=\"fa fa-users\"></i></div>";

                                    switch($comite['status']){
                                        case 'sin_agendar': echo "<p><span class='label label-default'><i class='fa fa-calendar-times-o'></i> Sin agendar </span></p>"; break;
                                        case 'agendado': echo "<p><span style='background-color: #27B89B' class='label label-success'><i class='fa fa-calendar-check-o'></i> Agendado</span></p>"; break;
                                        case 'asignado': echo "<p><span class='label label-info'><i class='fa fa-user'></i> Asignado </span></p>"; break;
                                        case 'confirmado': echo "<p><span class='label label-primary'><i class='fa fa-check'></i> Confirmado por la Contraloría </span></p>"; break;
                                        default: echo "<p><span class='label label-default'><i class='fa fa-question'></i> No definido </span></p>"; break;
                                    }
                                    echo "<br/>                                                
                                                <h3>{$comite['num_comite']}</h3>                                                
                                                <p title='{$comite['obra']['nombre_obra']}' style='white-space: nowrap;overflow: hidden;text-overflow: ellipsis;'>{$comite['obra']['nombre_obra']}</p>";
                                    $normatividad = $comitesobj->getNormatividad($comite['id_comite']);
                                    echo "<p>Normatividad: {$normatividad}</p><br/>";

                                    if(isset($comite['agenda_fecha']) ){
                                        echo "<p class='text-info'><i class='fa fa-calendar-check-o'></i> {$comite['agenda_fecha']} - de {$comite['agenda_hora_inicio']} a {$comite['agenda_hora_fin']}</p>";
                                    }
                                    else{
                                        echo "<p><i class='fa fa-calendar-times-o'></i> Sin agendarasdasd</p>";
                                    }

                                    if(isset($comite['usuario_id']) && $comite['usuario_id']){
                                        $usuarioobj = new Usuario($contraloriasocialDB);
                                        $usuario = $usuarioobj->getUsuario($comite['usuario_id']);
                                        echo "<p class='text-info'><i class='fa fa-user'></i> Asignado a {$usuario['nombres']} {$usuario['apellido_p']} {$usuario['apellido_m']}</p>";
                                        echo "<p class='text-info'><i class='fa fa-map-marker'></i> {$comite['agenda_lugar']}</p>";
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
                                        echo "<p><i class='fa fa-user-times'></i> Sin asignar CS</p>";
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

                                    echo "<br/><div class='row comite_status'>";
                                    if($comite['status'] == 'confirmado'){
                                        echo "<div class='col-md-4 '><a href='./detalle.php?comite_id={$comite['id_comite']}' ><i class='fa fa-edit'></i></a><br/>Primera Sesión</div>";
                                        echo "<div class='col-md-4 '><a href='./imprimir_integracion.php?comite_id={$comite['id_comite']}'><i class='fa fa-binoculars'></i></a><br/>Seguimiento</div>";
                                        echo "<div class='col-md-4'><a  href='./imprimir_capacitacion.php?comite_id={$comite['id_comite']}'><i class='fa fa-archive'></i></a><br/>Conclusión</div>";
                                    }
                                    else{
                                        echo "<div class='col-md-4 '><a style='cursor:not-allowed;'><i class='fa fa-list'></i></a><br/>Primera Sesió</div>";
                                        echo "<div class='col-md-4 '><a style='cursor:not-allowed;'><i class='fa fa-users'></i></a><br/>Seguimiento</div>";
                                        echo "<div class='col-md-4'><a style='cursor:not-allowed;'><i class='fa fa-graduation-cap'></i></a><br/>Conclusión</div>";
                                    }

                                    echo  "</div>";

                                    echo "  <br/>                                            
                                           </div>                                            
                                        </div>";
                                }
                                ?>
                            </div>
                            <div class="clearfix"></div>
                            <div id="vistaComitesList" style="display:none">
                                <?php
                                if(isset($_GET['obra_id']) && $_GET['obra_id']){
                                    if(count($comites) <= 0){
                                        echo "<p class='alert alert-warning'><i class='fa fa-warning'></i> La dependencia aún no ha determinado el número de comités a generar</p>";
                                    }
                                }
                                foreach($comites as $comite){
                                    echo "<div class=\"animated flipInY col-lg-12 col-md-12 col-sm-12 col-xs-12\">
                                             <div class='tile-stats' style='padding: 10px;'>";
                                    switch($comite['status']){
                                        case 'sin_agendar': echo "<p><span style='float: right' class='label label-default'><i class='fa fa-calendar-times-o'></i> Sin agendar </span></p>"; break;
                                        case 'agendado': echo "<p><span style='float: right; background-color: #27B89B' class='label label-success'><i class='fa fa-calendar-check-o'></i> Agendado</span></p>"; break;
                                        case 'asignado': echo "<p><span style='float: right' class='label label-info'><i class='fa fa-user'></i> Asignado </span></p>"; break;
                                        case 'confirmado': echo "<p><span class='label label-primary'><i class='fa fa-check'></i> Confirmado por la Contraloría </span></p>"; break;
                                        default: echo "<p><span class='label label-default'><i class='fa fa-question'></i> No definido </span></p>"; break;
                                    }

                                    echo "<h4 style='display: inline'><i class='fa fa-user'></i> {$comite['num_comite']}</h4>                                                                                                
                                                <p title='{$comite['obra']['nombre_obra']}' style='white-space: nowrap;overflow: hidden;text-overflow: ellipsis;'>{$comite['obra']['nombre_obra']}</p>";
                                    $normatividad = $comitesobj->getNormatividad($comite['id_comite']);
                                    echo "<p>Normatividad: {$normatividad}</p><br/>";

                                    echo "<br/><div class='row comite_status' style='width: 50%; margin: inherit'>
                                            <div class='col-md-4 '><i class='fa fa-list'></i>Pase de lista</div>
                                            <div class='col-md-4 '><i class='fa fa-users'></i>Integración</div>
                                            <div class='col-md-4'><i class='fa fa-graduation-cap'></i>Capacitación</div>
                                        </div>";

                                    echo "                                                
                                            </div>                                            
                                        </div>";
                                }
                                ?>
                            </div>

                            <div class="clearfix"></div>
                            <br/>
                            <?php
                            if(!$obra){
                                echo '<p style="text-align: right"><a target="_blank" href="./imprimir_lista.php" class="btn btn-primary"><i class="fa fa-print"></i> Imprimir Lista</a></p>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Ventanas modales -->
    <div class="modal fade" id="modalAsignar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Fecha de integración de comités</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formAsignar" class="form-horizontal form-label-left" method="post" action="./procesar_asignar.php">
                        <div class="form-group">
                            <label  class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Asignado a:</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <select name="usuario_id" required  class="form-control col-md-6 col-xs-12">
                                    <option value=""> Seleccione un usuario</option>
                                    <?php
                                    foreach($personal_array as $personal){
                                        echo "<option value='{$personal['id_usuario']}'>{$personal['idpersonal']} - {$personal['nombres']} {$personal['apellido_p']} {$personal['apellido_m']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label  class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Método de documentación:</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <select name="metodo" required  class="form-control col-md-6 col-xs-6">
                                    <option value=""> Seleccione un método</option>
                                    <option value="digital"> Digital</option>
                                    <option value="fisico"> Físico</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label  class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Representante de la dependencia normativa:</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input name="representante_dependencia_normativa" type="text" class="form-control" />
                            </div>
                        </div>
                        <input id="hdnComite_id" type="hidden" name="id_comite" value="">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"  data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="document.getElementById('formAsignar').submit();"><i class="fa fa-user-plus"></i> Asignar Usuario</button>
                </div>
            </div>
        </div>
    </div>

    <script type="application/javascript">
        var status = <?php echo $statusjs?>;
        var ejecutora_id = <?php echo $sesion->dependencia_id_x ?>;
    </script>
    <?php include(dirname(__FILE__)."/../layout/pie.php"); ?>
    <script src="../../js/comites/ejecutora_listado.js"></script>
</body>
</html>
