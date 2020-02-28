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
                                <h5>Comités Agendados</h5>
                            </div>
                            <div class="x_content">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Comité</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            foreach($eventos as $evento){
                                                echo "<tr>";
                                                    echo "<td>{$evento['agenda_fecha']}</td>";
                                                    echo "<td><strong>{$evento['num_comite']}</strong><p style='width: 150px;' class='nombre_single'>{$evento['obra']['nombre_obra']}</p></td>";
                                                echo "<td>{$evento['status']}</td>";
                                                echo "</tr>";
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <br/>
                        <div class="x_panel">
                            <div class="x_title">
                                <h5>Personal</h5>
                            </div>
                            <div class="x_content">
                                <br/>
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Carga del trabajo</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach($personal_array as $personal){
                                        echo '<tr>';
                                        echo "<td><span class='idpersonal' style='background-color: {$personal['color']}'>{$personal['idpersonal']}</span></td>";
                                        echo "<td>{$personal['nombres']} {$personal['apellido_p']} {$personal['apellido_m']}<br/><span class='label label-info'>{$personal['cargo']}</span></span></td>";
                                        echo "<td>                                                
                                                <div  class=\"progress progress_sm\" style='width: 76%; margin-bottom: 0px;margin-top: 5px;'>
                                                    <div class=\"progress-bar bg-green\" role=\"progressbar\" data-transitiongoal=\"80\" aria-valuenow=\"79\" style=\"width: 80%;\"></div>                                                     
                                                </div>
                                                <span style='color: #AAA; font-size: 10px;'>Carga de trabajo al 70%</span>
                                            </td>";
                                        echo '</tr>';
                                    }
                                    ?>
                                    </tbody>
                                </table>
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
    <div class="modal fade" id="modalAsignar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="exampleModalLabel">Confirmación de cita</h4>
                </div>
                <div class="modal-body">
                    <form id="formAsignar" class="form-horizontal form-label-left" method="post" action="./procesar_asignar_contraloria.php">
                        <div class="form-group">
                            <p>Detalles de la cita</p>
                            <div id="ajaxDetalleFicha"></div>
                            <hr/>
                            <label  class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Respuesta de la contraloría:</label>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <select id="cboRespuesta" name="respuesta" required  class="form-control col-md-6 col-xs-12">
                                    <option value=""> Seleccione una respuesta</option>
                                    <option value="1"> La contraloría asistirá a la cita</option>
                                    <option value="2"> La contraloría no asistirá a la cita</option>
                                    <option value="3"> La contraloría solicita un cambio de fecha</option>
                                    <option value="4"> La contraloría requiere más información</option>
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div id="divRespuestaSi" class="divRespuestaDetail" style="display: none">
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
                                    <select name="metodo_contraloria" required  class="form-control col-md-6 col-xs-6">
                                        <option value=""> Seleccione un método</option>
                                        <option value="digital"> Digital</option>
                                        <option value="fisico"> Físico</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div id="divRespuestaNo" class="divRespuestaDetail" style="display: none">
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Detalles:
                                </label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <textarea rows="6" id="first-name" required name="detalle_no_asistencia" class="form-control col-md-7 col-xs-12" ></textarea>
                                </div>
                            </div>
                        </div>

                        <div id="divRespuestacambio" class="divRespuestaDetail" style="display: none">
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"> Detalles de cambio:
                                </label>
                                <div class="col-md-8 col-sm-8 col-xs-12">
                                    <textarea rows="6" id="first-name" required name="detalle_cambio" class="form-control col-md-7 col-xs-12" ></textarea>
                                </div>
                            </div>
                        </div>


                        <input id="hdnComite_id" type="hidden" name="id_comite" value="">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"  data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="document.getElementById('formAsignar').submit();"><i class="fa fa-check"></i> Confirmar</button>
                </div>
            </div>
        </div>
    </div>


    <script type="application/javascript">
        var events = <?php  echo $eventos_json; ?>;
        var event_id = <?php  echo $comite_id; ?>
    </script>
    <?php include(dirname(__FILE__)."/../layout/pie.php"); ?>
    <script src="../../js/obras/agendar_contraloria.js"></script>
</body>
</html>
