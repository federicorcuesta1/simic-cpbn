<?php 
    if($_SESSION['tipo_simic']!="Administrador"){
        echo $lc->redireccionar_usuario_controlador($_SESSION['tipo_simic']);
    }
?>
<div class="container-fluid">
    <div class="page-header">
        <h1 class="text-titles"><i class="zmdi zmdi-balance zmdi-hc-fw"></i> NUEVO <small>Miembro</small></h1>
    </div>
    <p class="lead">En esta página vamos a realizar el REGISTRO de los NUEVOS MIEMBROS de la iglesia, por favor tener en cuenta que las casillas marcadas con asteristico son requerimientos indispensables para realizar el registro de un nuevo miembro.</p>
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

<!--CON EL SIGUIENTE CODIGO PONEMOS UN LIMITE AL NUMERO DE MIEMBROS QUE PODEMOS INGRESAR AL SISTEMA-->
<?php 
    require_once "./controladores/miembrosControlador.php";

    $iMiem= new miembrosControlador();

    $cMiem=$iMiem->datos_miembro_controlador("Conteo",0);

    if($cMiem->rowCount()<=150){
    
?>
<!-- panel datos del miembro nuevo -->
<div class="container-fluid">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="zmdi zmdi-plus"></i> &nbsp; DATOS DEL NUEVO MIEMBRO</h3>
        </div>
        <div class="panel-body">
            <form action="<?php echo SERVERURL; ?>ajax/miembrosAjax.php" method="POST" data-form="save" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">            
                <fieldset>
                    <legend><i class="zmdi zmdi-assignment"></i> &nbsp; Datos básicos</legend>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">Documento de Identidad *</label><br>
                                    <input pattern="[0-9-]{1,30}" class="form-control" type="text" name="dni-reg" required="" maxlength="200">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">Nombres *</label><br>
                                    <input pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ./- ]{1,40}" class="form-control" type="text" name="nombre-reg" required="" maxlength="200">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4">
                                <div class="form-group label-floating">
                                    <label class="control-label">Apellidos *</label><br>
                                    <input pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ./- ]{1,40}" class="form-control" type="text" name="apellido-reg" required="" maxlength="200">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4">
                                <div class="form-group label-floating">
                                    <label class="control-label">Teléfono *</label><br>
                                    <input class="form-control" type="tel" name="telefono-reg" maxlength="200" required="">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4">
                                <div class="form-group label-floating">
                                    <label class="control-label">E-mail</label><br>
                                    <input class="form-control" type="email" name="email-reg" maxlength="200">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-8">
                                <div class="form-group label-floating">
                                    <label class="control-label">Dirección</label><br>
                                    <input class="form-control" type="text" name="direccion-reg" maxlength="200">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4">
                                <div class="form-group label-floating">
                                    <label class="control-label">Ciudad *</label><br>
                                    <input class="form-control" type="text" name="ciudad-reg" maxlength="200" required="">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4">
                                <div class="form-group label-floating">
                                    <label class="control-label">Fecha Nacimiento *</label><br>
                                    <input class="form-control" type="date" name="nacimiento-reg" required="" date="dd-mm-YY">
                                </div>
                            </div>                            
                            <div class="col-xs-12 col-sm-4">
                                <div class="form-group label-floating">
                                    <label class="control-label">Lugar Nacimiento *</label><br>
                                    <input class="form-control" type="text" name="lugarN-reg" maxlength="200" required="">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4">
                                <div class="form-group label-floating">
                                    <label class="control-label">Edad *</label><br>
                                    <input class="form-control" name="edad-reg" required="">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4">
                                <div class="form-group label-floating">
                                    <label class="control-label">Etnia *</label><br>
                                    <select name="etnia-reg" id="etnia" class="form-control" required="">
                                    <option value="">Seleccione una opción</option>
                                        <option value="Mestizo">Mestizo</option>
                                        <option value="AfroColombiano">AfroColombiano</option>
                                        <option value="Caucásico">Caucásico</option>
                                        <option value="Indígena">Indígena</option>
                                        <option value="Árabe">Árabe</option>
                                        <option value="Judío">Judío</option>
                                        <option value="Gitano">Gitano</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4">
                                <div class="form-group label-floating">
                                    <label class="control-label">Estado Civil *</label><br>
                                    <input class="form-control" type="text" name="estadoC-reg" maxlength="200" required="">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4">
                                <div class="form-group label-floating">
                                    <label class="control-label">Nombres Conyuge</label><br>
                                    <input pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ./- ]{1,40}" class="form-control" type="text" name="conyuge-reg" maxlength="200">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4">
                                <div class="form-group label-floating">
                                    <label class="control-label">Numero Hijos</label><br>
                                    <input pattern="[0-9+]{1,15}" class="form-control" type="text" name="hijos-reg" maxlength="200">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4">
                                <div class="form-group label-floating">
                                    <label class="control-label">Fecha Matrimonio</label><br>
                                    <input class="form-control" type="date" name="matrimonio-reg" date="dd-mm-YY">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4">
                                <div class="form-group label-floating">
                                    <label class="control-label">Nacionalidad *</label><br>
                                    <select class="form-control" type="text" name="nacionalidad-reg" required="">
                                        <option value="" selected>Seleccione su Nacionalidad</option>
                                        <option value = "Alemán"> Alemán </option>
                                        <option value="Argentino"> Argentino </option>
                                        <option value="Australiano"> Australiano </option>
                                        <option value="Austriaco"> Austriaco </option> 
                                        <option value="Boliviano"> Boliviano </option>
                                        <option value="Brasileño"> Brasileño </option>
                                        <option value="Britanico"> Británico </option>
                                        <option value="Búlgaro"> Búlgaro </option>
                                        <option value="Camerunés"> Camerunés </option>
                                        <option value="Canadiense"> Canadiense </option>
                                        <Opción value="Centroafricano"> Centroafricano </opción>
                                        <option value="Chileno"> Chileno </option>
                                        <option value="Chino"> Chino </option>
                                        <option value="Colombiano"> Colombiano </option>
                                        <Opción value="Congoleño"> Congoleño </opción>
                                        <Opción value="Costaricense"> Costaricense </opción>
                                        <option value  Croata"> Croata </option>
                                        <option value="Cubano"> Cubano </option>
                                        <option value="Checo"> Checo </option>
                                        <option value="Danés"> Danés </option>
                                        <option value="Dominicano"> Dominicano </option>
                                        <Opción value="Ecuatoriano"> Ecuatoriano </opción>
                                        <option value="Egipcio"> Egipcio </option>
                                        <option value="Etíope"> Etíope </option>
                                        <option value="Escocés"> Escocés </option>
                                        <Opción value="Eslovaco"> Eslovaco </opción>
                                        <option value="Esloveno"> Esloveno </option>
                                        <option value="Español"> Español </option>
                                        <option value= "Estadounidense"> Estadounidense </option>
                                        <option value="Filipino"> Filipino </option>
                                        <option value="Finlandés"> Finlandés </option>
                                        <option value="Francés"> Francés </option>
                                        <option value= "Galés"> Galés </option>
                                        <option value="Ghanés"> Ghanés </option>
                                        <option value="Griego"> Griego </option>
                                        <option value="Granadino"> Granadino </opción>
                                        <option value="Guatemalteco"> Guatemalteco </option>
                                        <option value="Guyanés"> Guyanés </option>
                                        <option value="Haitiano"> Haitiano </option>
                                        <option value="Holandés"> Holandés </option>
                                        <option value="Hondureño"> Hondureño </option>
                                        <option value="Húngaro"> Húngaro </option>
                                        <Opción value="Islandés"> Islandés </opción>
                                        <option value="Indonesio"> Indonesio </option>
                                        <option value="Iraní"> Iraní </option>
                                        <option value="Iraquí"> Iraquí </option>
                                        <option value="Irlandés"> Irlandés </option>
                                        <Opción value="Israelí"> Israelí </opción>
                                        <option value="Italiano"> Italiano </option>
                                        <option value="Jamaiquino"> Jamaiquino </option>
                                        <option value="Japonés"> Japonés </option>
                                        <option value="Jordano"> Jordano </option>
                                        <option value="Katarí"> Katarí </option>
                                        <option value="Kazajo"> Kazajo </option>
                                        <option value="Keniano"> Keniano </option>
                                        <option value="Letón"> Letón </option>
                                        <option value="Libanés"> Libanés </option>
                                        <option value="Liberiano"> Liberiano </option>
                                        <option value="Macedonio"> Macedonio </option>
                                        <option value="Marfileño"> Marfileño </option>
                                        <option value="Mexicano"> Mexicano </option>
                                        <option value="Mongol"> Mongol </option>
                                        <option value="Marroquí"> Marroquí </option>
                                        <option value="Nicaragüense"> Nicaragüense </option>
                                        <option value="Noruego"> Noruego </option>
                                        <option value="Paquistaní"> Paquistaní </option>
                                        <option value="Panameño"> Panameño </option>
                                        <option value="Paraguayo"> Paraguayo </option>
                                        <option value="Peruano"> Peruano </option>
                                        <option value="Polaco"> Polaco </option>
                                        <option value="Portugués"> Portugués </option>
                                        <option value="Rumano"> Rumano </option>
                                        <option value="Ruso"> Ruso </option>
                                        <option value="Salvadoreño"> Salvadoreño </option>
                                        <option value="Senegalés"> Senegalés </option>
                                        <option value="Serbio"> Serbio </option>
                                        <option value="Sudafricano"> Sudafricano </option>
                                        <option value="Surcoreano"> Surcoreano </option>
                                        <option value="Sirio"> Sirio </opción>
                                        <option value="Taiwanés"> Taiwanés </option>
                                        <option value="Tailandés"> Tailandés </option>
                                        <option value="Turco"> Turco </option >
                                        <option value="Ucraniano"> Ucraniano </option>
                                        <option value="Uruguayo"> Uruguayo </option>
                                        <option value="Venezolano"> Venezolano </option>
                                        <option value="Vietnamita"> Vietnamita </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label class="control-label">Genero *</label><br>
                                    <div class="radio radio-primary">
                                        <label>
                                            <input type="radio" name="optionsGenero-reg" id="optionsRadios1" value="Masculino">
                                            <i class="zmdi zmdi-male-alt"></i> &nbsp; Masculino
                                        </label>
                                    </div>
                                    <div class="radio radio-primary">
                                        <label>
                                            <input type="radio" name="optionsGenero-reg" id="optionsRadios2" value="Femenino">
                                            <i class="zmdi zmdi-female"></i> &nbsp; Femenino
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4">
                                <div class="form-group label-floating">
                                    <label class="control-label">Tipo Sangre</label><br>
                                    <input class="form-control" type="text" name="sangre-reg" maxlength="200">
                                </div>
                            </div>                            
                            <div class="col-xs-12 col-sm-4">
                                <div class="form-group label-floating">
                                    <label class="control-label">Ocupación</label><br>
                                    <input pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ./- ]{1,40}" class="form-control" type="text" name="ocupacion-reg" maxlength="200">
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
                                    <input pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ./- ]{1,40}" class="form-control" type="text" name="titulo-reg" maxlength="200">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4">
                                <div class="form-group label-floating">
                                    <label class="control-label">Institución</label><br>
                                    <input pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ./- ]{1,40}" class="form-control" type="text" name="instituto-reg" maxlength="200">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4">
                                <div class="form-group label-floating">
                                    <label class="control-label">Fecha de Graduacion</label><br>
                                    <input class="form-control" type="date" name="grado-reg" date="dd-mm-YY">
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
                                    <input class="form-control" type="date" name="conversion-reg" required="" date="dd-mm-YY">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4">
                                <div class="form-group label-floating">
                                    <label class="control-label">Fecha de Bautismo</label><br>
                                    <input class="form-control" type="date" name="bautismo-reg" date="dd-mm-YY">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4">
                                <div class="form-group label-floating">
                                    <label class="control-label">Lugar de Bautismo</label><br>
                                    <input pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ./- ]{1,40}" class="form-control" type="text" name="lugarB-reg" maxlength="200">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4">
                                <div class="form-group label-floating">
                                    <label class="control-label">Pastor Bautizo</label><br>
                                    <input pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ./- ]{1,40}" class="form-control" type="text" name="pastor-reg" maxlength="200">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4">
                                <div class="form-group label-floating">
                                    <label class="control-label">Fecha de Retiro Iglesia</label><br>
                                    <input class="form-control" type="date" name="retiro-reg" date="dd-mm-YY">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4">
								<div class="form-group">
									<label class="control-label">Estado del Miembro *</label>
									<div class="radio radio-primary">
										<label>
											<input type="radio" name="optionsEstado-reg" value="Activo">
											<i class="zmdi zmdi-lock-open"></i> &nbsp; Activo
										</label>
									</div>
									<div class="radio radio-primary">
										<label>
											<input type="radio" name="optionsEstado-reg" value="Inactivo">
											<i class="zmdi zmdi-lock"></i> &nbsp; Inactivo
										</label>
									</div>
								</div>
		    				</div>                                               
                        </div>
                    </div>
                </fieldset><br>

                <p class="text-center" style="margin-top: 20px;">                    
                    <button type="submit" class="btn btn-info btn-raised btn-sm"><i class="zmdi zmdi-floppy"></i> Guardar</button>
                </p>
                <div class="RespuestaAjax"></div>                
            </form>
        </div>
    </div>
</div>
<?php }else{ ?>
    <div class="alert alert-dismissible alert-primary text-center">
        <button type="button" class="close" data-dismiss="alert">X</button>
        <i class="zmdi zmdi-alert-octagon zmdi-hc-5x"></i>
        <h4>¡Lo sentimos!</h4>
        <p>Ya ha llegado al MÁXIMO de MIEMBROS permitidos por el sistema; Comuniquese con el Administrador del Sistema para realizar la compra de una licencia más amplia.</p>
    </div>
<?php } ?>