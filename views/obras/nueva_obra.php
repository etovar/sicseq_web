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
                            <li>Nueva Obra</li>
                        </ol>
                    </div>
                </div>
                <!-- fin mapa sitio -->
                <div class="page-title">
                    <h3>Nueva Obra</h3>
                </div>
                <div class="clearfix"></div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_content">
                                <form id="frmNuevaObra" class="form-horizontal form-label-left" method="post" action="./procesar_nueva_obra.php">
                                    <p class="alert  alert-primary" style="color:#fff"><i class="fa fa-info-circle"></i> Ingrese los datos de la nueva Obra</p>
                                    <hr/>
                                    <div class="row">
                                        <div class="col-md-8 col-sm-12">
                                            <div class="form-group">
                                                <label  class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Número de Obra:</label>
                                                <div class="col-md-9 col-sm-9col-xs-12">
                                                    <input name="num_obra" type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12" value="">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label  class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Nombre de la Obra:</label>
                                                <div class="col-md-9 col-sm-9col-xs-12">
                                                    <input name="nombre_obra"  type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12" value="">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label  class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Inicio de obra:</label>
                                                <div class="col-md-9 col-sm-9col-xs-12">
                                                    <input name="inicio_contrato"  type="date" id="first-name" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo date('Y-m-d') ;?>">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label  class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Fondo:</label>
                                                <div class="col-md-9 col-sm-9col-xs-12">
                                                    <input name="fondo" type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12" value="">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label  class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Último fondo aprobado:</label>
                                                <div class="col-md-9 col-sm-9col-xs-12">
                                                    <input name="ultimo_fondo_aprobado" type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12" value="">
                                                </div>
                                            </div>

                                            <?php if($sesion->urol_id_x_contraloriasocial == 2) { ?>
                                                <div class="form-group">
                                                    <label  class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Ejecutora:</label>
                                                    <div class="col-md-9 col-sm-9col-xs-12">
                                                        <select name="ejecutora" class="form-control col-md-7 col-xs-12" required>
                                                            <option value=""> Seleccione una Dependencia</option>
                                                            <?php
                                                                foreach($dependencias as $dependencia){
                                                                    echo "<option value='{$dependencia['nombre']}'>{$dependencia['nombre']}</option>";
                                                                }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            <?php } else{?>
                                                <div class="form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Ejecutora
                                                    </label>
                                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                                        <input readonly type="text" required="required" name="ejecutora" class="form-control col-md-7 col-xs-12" value="<?php echo $sesion->dependencia_x?>">
                                                    </div>
                                                </div>
                                            <?php }?>

                                            <div class="form-group">
                                                <label  class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Promotora:</label>
                                                <div class="col-md-9 col-sm-9col-xs-12">
                                                    <select name="promotora" class="form-control col-md-7 col-xs-12">
                                                        <option value=""> Seleccione una Dependencia</option>
                                                        <?php
                                                        foreach($dependencias as $dependencia){
                                                            echo "<option value='{$dependencia['nombre']}'>{$dependencia['nombre']}</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label  class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Total Aprobado:</label>
                                                <div class="col-md-9 col-sm-9col-xs-12">
                                                    <input name="total_aprobado" type="number" id="first-name" required="required" class="form-control col-md-7 col-xs-12" value="">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label  class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Total Contratado:</label>
                                                <div class="col-md-9 col-sm-9col-xs-12">
                                                    <input name="total_contratado" type="number" id="first-name" required="required" class="form-control col-md-7 col-xs-12" value="">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label  class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Total Ejercido:</label>
                                                <div class="col-md-9 col-sm-9col-xs-12">
                                                    <input name="total_ejercido" type="number" id="first-name" required="required" class="form-control col-md-7 col-xs-12" value="">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label  class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Total por Ejercer:</label>
                                                <div class="col-md-9 col-sm-9col-xs-12">
                                                    <input name="total_por_ejercer" type="number" id="first-name" required="required" class="form-control col-md-7 col-xs-12" value="">
                                                </div>
                                            </div>
                                            <hr/>
                                            <p style="text-align: right">
                                                <button type="submit"  onclick="document.getElementById('frmNuevaObra').submit();" class="btn btn-primary"><i class="fa fa-save"></i> Guardar</button>
                                                <a class="btn btn-default" href="./ejecutora_listado.php"><i class="fa fa-arrow-left"></i> Cancelar </a>
                                            </p>
                                        </div>
                                    </div>
                                    <input type="hidden" name="ejecutora_id" value="<?php echo $_SESSION['dependencia_id_x'] ?>">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include(dirname(__FILE__)."/../layout/pie.php"); ?>
    <script src="../../js/obras/nueva_obra.js"></script>
</body>
</html>
