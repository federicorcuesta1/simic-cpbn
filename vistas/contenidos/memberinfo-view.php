<?php 
    if($_SESSION['tipo_simic']!="Administrador" || $_SESSION['privilegio_simic']<1 || $_SESSION['privilegio_simic']>3){
        echo $lc->redireccionar_usuario_controlador($_SESSION['tipo_simic']);
    }
?>
<div class="container-fluid">
    <div class="page-header">
        <h1 class="text-titles"><i class="zmdi zmdi-balance zmdi-hc-fw"></i> ACTUALIZAR <small>MIEMBRO</small></h1>
    </div>
    <p class="lead">En esta página vamos a realizar la ACTUALIZACIÓN de los miembros de la iglesia, por favor tener en cuenta que las casillas marcadas con asteristico son requerimientos indispensables para realizar el registro de un nuevo miembro.</p>
</div>

<div class="container-fluid">
    <ul class="breadcrumb breadcrumb-tabs">
    <li>
            <a href="<?php echo SERVERURL; ?>membernew/" class="btn btn-info">
                <i class="zmdi zmdi-plus"></i> &nbsp; NUEVO MIEMBRO
            </a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>memberlist/" class="btn btn-success">
                <i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE MIEMBROS
            </a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>membersearch/" class="btn btn-primary">
                <i class="zmdi zmdi-search"></i> &nbsp; BUSQUEDA DE MIEMBROS
            </a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>reportes/" class="btn btn-info">
                <i class="zmdi zmdi-folder-outline"></i> &nbsp; REPORTES
            </a>
        </li>
    </ul>
</div>

<?php 
    require_once "./controladores/miembrosControlador.php";
    $iMiem= new miembrosControlador();    

    $datos=explode("/", $_GET['views']);

    $filesMiem=$iMiem->datos_miembro_controlador("Unico",$datos[1]);

    if($filesMiem->rowCount()==1){
        $campos=$filesMiem->fetch();
        if($_SESSION['privilegio_simic']<1 || $_SESSION['privilegio_simic']>3){
            echo $lc->redireccionar_usuario_controlador($_SESSION['tipo_simic']);
        }
?>
<!-- panel datos del miembro nuevo -->
<div class="container-fluid">
    <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="zmdi zmdi-refresh"></i> &nbsp; ACTUALIZAR DATOS DEL MIEMBRO</h3>
            </div>
            <div class="panel-body">
                <form action="<?php echo SERVERURL; ?>ajax/miembrosAjax.php" method="POST" data-form="update" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
                <input type="hidden" name="codigo" value="<?php echo $datos[1]; ?>">
                    <fieldset>
                        <legend><i class="zmdi zmdi-assignment"></i> &nbsp; Datos básicos</legend>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Documento de Identidad *</label><br>
                                        <input pattern="[0-9-]{1,30}" class="form-control" type="text" name="dni-up" required="" maxlength="200" value="<?php echo $campos['MiemDNI']; ?>" >
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Nombres *</label><br>
                                        <input pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ./- ]{1,40}" class="form-control" type="text" name="nombre-up" required="" maxlength="200" value="<?php echo $campos['MiemNombres']; ?>" >
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Apellidos *</label><br>
                                        <input pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ./- ]{1,40}" class="form-control" type="text" name="apellido-up" required="" maxlength="200" value="<?php echo $campos['MiemApellidos']; ?>" >
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Teléfono *</label><br>
                                        <input class="form-control" type="tel" name="telefono-up" maxlength="200" required="" value="<?php echo $campos['MiemTelefono']; ?>">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4">
                                    <div class="form-group label-floating">
                                        <label class="control-label">E-mail</label><br>
                                        <input class="form-control" type="email" name="email-up" maxlength="200" value="<?php echo $campos['MiemEmail']; ?>" >
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-8">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Dirección</label><br>
                                        <input class="form-control" type="text" name="direccion-up" maxlength="200" value="<?php echo $campos['MiemDireccion']; ?>" >
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Ciudad *</label><br>
                                        <input class="form-control" type="text" name="ciudad-up" maxlength="200" required="" value="<?php echo $campos['MiemCiudad']; ?>" >
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Fecha Nacimiento *</label><br>
                                        <input class="form-control" type="date" name="nacimiento-up" required="" date="dd-mm-YY" value="<?php echo $campos['MiemFechaNacimiento']; ?>" >
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Lugar Nacimiento *</label><br>
                                        <input class="form-control" type="text" name="lugarN-up" maxlength="200" required="" value="<?php echo $campos['MiemLugarNacimiento']; ?>" >
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Edad *</label><br>
                                        <input class="form-control" type="text" name="edad-up" maxlength="200" value="<?php echo $campos['MiemEdad']; ?>" required="">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Etnia *</label><br>
                                        <input class="form-control" type="text" name="etnia-up" maxlength="200" value="<?php echo $campos['MiemEtnia']; ?>" required="">
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Estado Civil *</label><br>
                                        <input class="form-control" type="text" name="estadoC-up" maxlength="200" required="" value="<?php echo $campos['MiemEstadoCivil']; ?>" >
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Nombres Conyuge</label><br>
                                        <input pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ./- ]{1,40}" class="form-control" type="text" name="conyuge-up" maxlength="200" value="<?php echo $campos['MiemNombreConyuge']; ?>" >
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Numero Hijos</label><br>
                                        <input pattern="[0-9+]{1,15}" class="form-control" type="text" name="hijos-up" maxlength="200" value="<?php echo $campos['MiemNumeroHijos']; ?>" >
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Fecha Matrimonio</label><br>
                                        <input class="form-control" type="date" name="matrimonio-up" date="dd-mm-YY" value="<?php echo $campos['MiemFechaMatrimonio']; ?>" >
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Nacionalidad *</label><br>
                                        <input pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ./- ]{1,40}" class="form-control" type="text" name="nacionalidad-up" maxlength="200" value="<?php echo $campos['MiemNacionalidad']; ?>" required="" >
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="form-group">
                                        <label class="control-label">Genero *</label><br>
                                        <div class="radio radio-primary">
                                            <label>
                                                <input type="radio" name="optionsGenero-up" id="optionsRadios1" <?php if ($campos['MiemSexo']=="Masculino"){echo 'checked=""';} ?> value="Masculino" >
                                                <i class="zmdi zmdi-male-alt"></i> &nbsp; Masculino
                                            </label>
                                        </div>
                                        <div class="radio radio-primary">
                                            <label>
                                                <input type="radio" name="optionsGenero-up" id="optionsRadios2"  <?php if ($campos['MiemSexo']=="Femenino"){echo 'checked=""';} ?> value="Femenino" >
                                                <i class="zmdi zmdi-female"></i> &nbsp; Femenino
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Tipo Sangre</label><br>
                                        <input class="form-control" type="text" name="sangre-up" maxlength="200" value="<?php echo $campos['MiemTipoSangre']; ?>" >
                                    </div>
                                </div>                            
                                <div class="col-xs-12 col-sm-4">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Ocupación</label><br>
                                        <input pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ./- ]{1,40}" class="form-control" type="text" name="ocupacion-up" maxlength="200" value="<?php echo $campos['MiemOcupacion']; ?>" >
                                    </div>
                                </div>                             
                            </div>
                        </div>
                    </fieldset><br>

                    <fieldset>
                        <legend><i class="zmdi zmdi-assignment"></i> &nbsp; Estudios</legend>
                        <div class="container-fluid">
                            <div class="row">                            
                                <div class="col-xs-12 col-sm-4">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Titulo *</label><br>
                                        <input pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ./- ]{1,40}" class="form-control" type="text" name="titulo-up" maxlength="200" value="<?php echo $campos['MiemTitulo']; ?>" >
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Institución</label><br>
                                        <input pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ./- ]{1,40}" class="form-control" type="text" name="instituto-up" maxlength="200" value="<?php echo $campos['MiemInstitucion']; ?>" >
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Fecha de Graduacion</label><br>
                                        <input class="form-control" type="date" name="grado-up" date="dd-mm-YY" value="<?php echo $campos['MiemFechaGrado']; ?>" >
                                    </div>
                                </div>                                                 
                            </div>
                        </div>
                    </fieldset><br>

                    <fieldset>
                        <legend><i class="zmdi zmdi-assignment"></i> &nbsp; Datos Iglesia</legend>
                        <div class="container-fluid">
                            <div class="row">                            
                                <div class="col-xs-12 col-sm-4">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Fecha de Conversión *</label><br>
                                        <input class="form-control" type="date" name="conversion-up" required="" date="dd-mm-YY" value="<?php echo $campos['MiemFechaConversion']; ?>" >
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Fecha de Bautismo</label><br>
                                        <input class="form-control" type="date" name="bautismo-up" date="dd-mm-YY" value="<?php echo $campos['MiemFechaBautismo']; ?>" >
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Lugar de Bautismo</label><br>
                                        <input pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ./- ]{1,40}" class="form-control" type="text" name="lugarB-up" maxlength="200" value="<?php echo $campos['MiemLugarBautismo']; ?>" >
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Pastor Bautizo</label><br>
                                        <input pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ./- ]{1,40}" class="form-control" type="text" name="pastor-up" maxlength="200" value="<?php echo $campos['MiemPastorBautizo']; ?>" >
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4">
                                    <div class="form-group label-floating">
                                        <label class="control-label">Fecha de Retiro Iglesia</label><br>
                                        <input class="form-control" type="date" name="retiro-up" date="dd-mm-YY" value="<?php echo $campos['MiemRetiroIglesia']; ?>" >
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label">Estado del Miembro *</label>
                                        <div class="radio radio-primary">
                                            <label>
                                                <input type="radio" name="optionsEstado-up" <?php if ($campos['MiemEstado']=="Activo"){echo 'checked=""';} ?> value="Activo" >
                                                <i class="zmdi zmdi-lock-open"></i> &nbsp; Activo
                                            </label>
                                        </div>
                                        <div class="radio radio-primary">
                                            <label>
                                                <input type="radio" name="optionsEstado-up" <?php if ($campos['MiemEstado']=="Inactivo"){echo 'checked=""';} ?> value="Inactivo" >
                                                <i class="zmdi zmdi-lock"></i> &nbsp; Inactivo
                                            </label>
                                        </div>
                                    </div>
                                </div>                                               
                            </div>
                        </div>
                    </fieldset><br>

                    <p class="text-center" style="margin-top: 20px;">                    
                        <button type="submit" class="btn btn-success btn-raised btn-sm"><i class="zmdi zmdi-refresh"></i> Actualizar</button>
                    </p>
                    <div class="RespuestaAjax"></div>                
                </form>
            </div>
        </div>
    </div>
</div>
<?php }else{ ?>
    <div class="alert alert-dismissible alert-warning text-center">
        <button type="button" class="close" data-dismiss="alert">x</button>
        <i class="zmdi zmdi-alert-triangle zmdi-hc-5x"></i>
        <h2>¡Lo sentimos!</h2>
        <h3>No podemos Mostrar la información del Miembro en este momento.</h3>
    </div>
<?php } ?>