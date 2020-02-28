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
                            <li>Asignar Cita</li>
                        </ol>
                    </div>
                </div>
                <!-- fin mapa sitio -->
                <br/>
                <div class="clearfix"></div>
                <div class="row">
                    <div class="col-md-4 col-sm-12 col-xs-4">
                        <?php if($obra['status'] == 'asignada') {?>
                            <div class="x_panel">
                                <div class="x_title">
                                    <h4>Comités Asignados</h4>
                                </div>
                                <div class="x_content">
                                    <br/>
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>Comité</th>
                                            <th>Método</th>
                                            <th>Asignado a</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        foreach($obra['comites'] as $comite){
                                            echo '<tr>';
                                                echo "<td >{$comite['num_comite']}</td>";
                                                echo "<td ><span class='label label-default'>{$comite['metodo']}</span></td>";
                                                echo "<td >{$comite['usuario']['nombres']} {$comite['usuario']['apellido_p']}</td>";
                                            echo '</tr>';
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="x_panel">
                            <div class="x_title">
                                <h4>Personal de la Dependencia</h4>
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
                        <div class="x_panel">
                            <div class="x_title">
                                <h4>Comité(s) de obra, acción o apoyo</h4>
                            </div>
                            <div class="x_content">
                                <form id="formAsignar" class="form-horizontal form-label-left" method="post" action="./procesar_asignar.php">
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">No. de Obra o Apoyo
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input readonly type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $obra['num_obra'] ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Cantidad de Comités
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input readonly id="baja_avance" type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $obra['no_comites']?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Configuración
                                        </label>
                                        <div class=" radio control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                                            <input id="radioTodosComites" checked name="configuracion" type="radio" value="todosComite" >Todos los comités
                                        </div>
                                        <div class=" radio control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                                            <input id="radioPorComite" name="configuracion" type="radio" value="porComite">Por comité
                                        </div>
                                    </div>
                                    <hr/><br/>
                                    <div id="divTodosComites">
                                        <div class="form-group">
                                            <label  class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Asignado a:</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
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
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <select name="metodo" required  class="form-control col-md-6 col-xs-6">
                                                    <option value=""> Seleccione un método</option>
                                                    <option value="digital"> Digital</option>
                                                    <option value="fisico"> Físico</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="divPorComite" style="display: none">
                                        <?php
                                            foreach($obra['comites'] as $comite){
                                                echo '<br/>';
                                                echo '<div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">No. de Comité
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input readonly type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12" value="'.$comite['num_comite'].'">
                                                    </div>
                                                </div>';

                                                echo '<div class="form-group">
                                                        <label  class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Asignado a:</label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <select name="usuario_id_todos['.$comite["id_comite"].']" required  class="form-control col-md-6 col-xs-12">
                                                                <option value=""> Seleccione un usuario</option>';
                                                foreach($personal_array as $personal){
                                                    echo "<option value='{$personal['id_usuario']}'>{$personal['idpersonal']} - {$personal['nombres']} {$personal['apellido_p']} {$personal['apellido_m']}</option>";
                                                }
                                                echo       '</select>
                                                        </div>
                                                    </div>';

                                                echo '<div class="form-group">
                                                            <label  class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Método de documentación:</label>
                                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                                <select name="metodo_todos['.$comite["id_comite"].']" required  class="form-control col-md-6 col-xs-6">
                                                                    <option value=""> Seleccione un método</option>
                                                                    <option value="digital"> Digital</option>
                                                                    <option value="fisico"> Físico</option>
                                                                </select>
                                                            </div>
                                                        </div>';
                                            }
                                        ?>
                                    </div>
                                    <br/><br/><br/><br/>
                                    <p style="text-align: right">
                                        <a href="<?php echo $sesion->baseurl?>modulos/obras/ejecutora_listado.php" class="btn btn-default"><i class="fa fa-arrow-left"></i> Cancelar</a>
                                        <button type="submit" onclick="document.getElementById('formAsignar').submit();" class="btn btn-primary"><i class="fa fa-users"></i>
                                            <?php
                                            if($obra['status'] == 'asignada'){
                                                echo 'Modificar';
                                            }
                                            else{
                                                echo 'Asignar';
                                            }
                                            ?>
                                        </button>
                                    </p>
                                    <input type="hidden" id="obra_id" name="obra_id" value="<?php echo $obra['id_obra'] ?>"/>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="application/javascript">
        var ejecutora_id = <?php echo $sesion->dependencia_id_x ?>;
    </script>
    <?php include(dirname(__FILE__)."/../layout/pie.php"); ?>
    <script src="../../js/obras/asignar.js"></script>
</body>
</html>
