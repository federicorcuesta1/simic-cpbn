<div class="container-fluid">
    <div class="page-header">
        <h1 class="text-titles"><i class="zmdi zmdi-account-circle zmdi-hc-fw"></i> MIS DATOS</small></h1>
    </div>
    <p class="lead">En el siguiente formulario podemos actualizar los datos personales de los usuarios.</p>
</div>

<!-- Panel mis datos -->
<div class="container-fluid">
    <?php 
        $datos=explode("/", $_GET['views']);

        //ADMINISTRADOR
        if($datos[1]=="admin"){           
            if($_SESSION['tipo_simic']!="Administrador"){
                echo $lc->forzar_cierre_sesion_controlador();
            }

            require_once "./controladores/usuarioControlador.php";
            $classUsua= new usuarioControlador();

            $filesU=$classUsua->datos_usuario_controlador("Unico",$datos[2]);
            if($filesU->rowCount()==1){
                $campos=$filesU->fetch();

                if($campos['CuentaCodigo']!=$_SESSION['codigo_cuenta_simic']){
                    if($_SESSION['privilegio_simic']<1 || $_SESSION['privilegio_simic']>3){
                        echo $lc->redireccionar_usuario_controlador($_SESSION['tipo_simic']);
                    }
                }

    ?>
    <div class="panel panel-success">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="zmdi zmdi-refresh"></i> &nbsp; MIS DATOS</h3>
        </div>
        <div class="panel-body">
            <form action="<?php echo SERVERURL; ?>ajax/usuarioAjax.php" method="POST" data-form="update" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
                <input type="hidden" name="cuenta-up" value="<?php echo $datos[2]; ?>">
                <fieldset>
                    <legend><i class="zmdi zmdi-account-box"></i> &nbsp; Información personal</legend>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group label-floating">
                                    <label class="control-label">Numero de Documento *</label>
                                    <input pattern="[0-9-]{1,30}" class="form-control" type="text" name="dni-up" value="<?php echo $campos['AdminDNI']; ?>" required="" maxlength="30">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">Nombres *</label>
                                    <input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" type="text" name="nombre-up" value="<?php echo $campos['AdminNombre']; ?>" required="" maxlength="30">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">Apellidos *</label>
                                    <input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" type="text" name="apellido-up" value="<?php echo $campos['AdminApellido']; ?>" required="" maxlength="30">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">Teléfono</label>
                                    <input pattern="[0-9+]{1,15}" class="form-control" type="text" name="telefono-up" value="<?php echo $campos['AdminTelefono']; ?>" maxlength="15">
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <div class="form-group label-floating">
                                    <label class="control-label">Dirección</label>
                                    <textarea name="direccion-up" class="form-control" rows="2" maxlength="100"><?php echo $campos['AdminDireccion']; ?></textarea>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">Tipo Usuario *</label>
                                    <input required="" class="form-control" type="text" name="tipo-up" value="<?php echo $campos['AdminTipo']; ?>" maxlength="50">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group label-floating">
                                    <label for="estado" class="control-label">Estado Usuario *</label><br>
                                    <select name="estado-up" value="<?php echo $campos['AdminEstado']; ?>" id="estado" required="" class="form-control">
                                        <option value="" selected="selected">-- Selecciona la opción --</option>
                                        <option value="Activo">Activo</option>
                                        <option value="Inactivo">Inactivo</option>
                                    </select>                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <p class="text-center" style="margin-top: 20px;">
                    <button type="submit" class="btn btn-success btn-raised btn-sm"><i class="zmdi zmdi-refresh"></i> Actualizar</button>
                </p>
                <div class="RespuestaAjax"></div>
            </form>
        </div>
    </div>
    <?php }else{ ?>
    <div class="alert alert-dismissible alert-warning text-center">
        <button type="button" class="close" data-dismiss="alert">x</button>
        <i class="zmdi zmdi-alert-triangle zmdi-hc-5x"></i>
        <h3>¡Lo sentimos!</h3>
        <p>No podemos mostrar la información de la cuenta debido a un error</p>
    </div>
    <?php 
            }
        //CONTABILIDAD
        }elseif($datos[1]=="contab"){
            
            require_once "./controladores/contabControlador.php";
            $classContab= new contabControlador();

            $filesC=$classContab->datos_contab_controlador("Unico",$datos[2]);

            if($filesC->rowCount()==1){
                $campos=$filesC->fetch();

                if($campos['CuentaCodigo']!=$_SESSION['codigo_cuenta_simic']){
                    if($_SESSION['privilegio_simic']<1 || $_SESSION['privilegio_simic']>2){
                        echo $lc->forzar_cierre_sesion_controlador();
                    }
                }
?>
<div class="container-fluid">
    <div class="panel panel-success">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="zmdi zmdi-refresh"></i> &nbsp; ACTUALIZAR USUARIO CONTABILIDAD</h3>
        </div>

        <div class="panel-body">
            <form action="<?php echo SERVERURL; ?>ajax/contabAjax.php" method="POST" data-form="update" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
                <input type="hidden" name="cuenta-up" value="<?php echo $datos[2]; ?>">
                <fieldset>
                    <legend><i class="zmdi zmdi-account-box"></i> &nbsp; Información personal</legend>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group label-floating">
                                    <label class="control-label">Numero de Documento *</label>
                                    <input pattern="[0-9-]{1,30}" class="form-control" type="text" name="dni-up" value="<?php echo $campos['ContabDNI']; ?>" required="" maxlength="30">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">Nombres *</label>
                                    <input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" type="text" name="nombre-up" value="<?php echo $campos['ContabNombre']; ?>" required="" maxlength="30">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">Apellidos *</label>
                                    <input pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,30}" class="form-control" type="text" name="apellido-up" value="<?php echo $campos['ContabApellido']; ?>" required="" maxlength="30">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">Teléfono</label>
                                    <input pattern="[0-9+]{1,15}" class="form-control" type="text" name="telefono-up" value="<?php echo $campos['ContabTelefono']; ?>" maxlength="15">
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <div class="form-group label-floating">
                                    <label class="control-label">Dirección</label>
                                    <textarea name="direccion-up" class="form-control" rows="2" maxlength="100"><?php echo $campos['ContabDireccion']; ?></textarea>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">Tipo Usuario *</label>
                                    <input required="" class="form-control" type="text" name="tipo-up" value="<?php echo $campos['ContabTipo']; ?>" maxlength="50">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group label-floating">
                                    <label for="estado" class="control-label">Estado Usuario *</label><br>
                                    <select name="estado-up" value="<?php echo $campos['ContabEstado']; ?>" id="estado" required="" class="form-control">
                                        <option value="" selected="selected">-- Selecciona la opción --</option>
                                        <option value="Activo">Activo</option>
                                        <option value="Inactivo">Inactivo</option>
                                    </select>                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <br>               
                <p class="text-center" style="margin-top: 20px;">
                    <button type="submit" class="btn btn-success btn-raised btn-sm"><i class="zmdi zmdi-refresh"></i> Actualizar</button>
                </p>
                <div class="RespuestaAjax"></div>
            </form>
        </div>
    </div>
</div>

<?php }else{ ?>
            <div class="alert alert-dismissible alert-warning text-center">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <i class="zmdi zmdi-alert-triangle zmdi-hc-5x"></i>
                <h3>¡Lo sentimos!</h3>
                <p>No podemos mostrar la información de la cuenta debido a un error</p>
            </div>
<?php 
            }

        //ERROR
        }else{
    ?>
    <div class="alert alert-dismissible alert-warning text-center">
        <button type="button" class="close" data-dismiss="alert">x</button>
        <i class="zmdi zmdi-alert-triangle zmdi-hc-5x"></i>
        <h3>¡Lo sentimos!</h3>
        <p>No podemos mostrar la información de la cuenta debido a un error</p>
    </div>
    <?php } ?>
</div>