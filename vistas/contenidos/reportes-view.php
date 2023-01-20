<div class="container-fluid">
    <div class="page-header">
        <h1 class="text-titles"><i class="zmdi zmdi-folder-outline zmdi-hc-fw"></i> REPORTES <small>Miembros</small></h1>
    </div>
    <p class="lead">En esta página se generan los informes de los miembros de la iglesia segun su edad, sexo, grupo etnico, estado.</p>
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

<div class="container-fluid">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="zmdi zmdi-file-plus"></i> &nbsp; LISTADO DE REPORTES </h3>
        </div>
        <div class="panel-body">
            <form>            
                <fieldset>
                    <div class="container-fluid">
                        <div class="row">                            
                            <label for="TipoReporte" class="control-label">Elija el tipo de Reporte: </label>
                            <select onchange="cambia_seleccion()" name="elige">
                                <option value="0">¡Seleccione Tipo de Reporte!</option>
                                <option value="1">POR EDAD</option>
                                <option value="2">POR GRUPO ÉTNICO</option>
                                <option value="3">POR GÉNERO</option>
                                <option value="4">POR ESTADO</option>
                            </select>

                            <select name="eleccion">
                                <option value="-">-
                            </select>
                        </div>
                </fieldset><br>                
            </form>

            <script>
                var eleccion_1 = new Array("-", "niños", "adolescentes", "jovenes", "adultos", "adultos mayores", "...")
                var eleccion_2 = new Array("-", "mestizos", "Afrocolombianos", "Caucásicos", "Indígenas", "Árabes", "Judíos", "Gitanos", "...")
                var eleccion_3 = new Array("-", "Masculino", "Femenino", "...")
                var eleccion_4 = new Array("-", "Activo", "Inactivo", "...")

                var todasElecciones = [
                    [],
                    eleccion_1,
                    eleccion_2,
                    eleccion_3,
                    eleccion_4,
                ];

                function cambia_seleccion() {
                    //tomo el valor del select del reporte elegido 
                    var reporte
                    reporte = document.f1.reporte[document.f1.reporte.selectedIndex].value
                        //miro a ver si el reporte está definido 
                    if (reporte != 0) {
                        //si estaba definido, entonces coloco las opciones de la eleccion correspondiente. 
                        //selecciono el array de eleccion adecuado 
                        mis_elecciones = todaselecciones[reporte]
                            //calculo el numero de elecciones 
                        num_elecciones = mis_elecciones.length
                            //marco el número de elecciones en el select 
                        document.f1.eleccion.length = num_elecciones
                            //para cada eleccion del array, la introduzco en el select 
                        for (i = 0; i < num_elecciones; i++) {
                            document.f1.eleccion.options[i].value = mis_elecciones[i]
                            document.f1.eleccion.options[i].text = mis_elecciones[i]
                        }
                    } else {
                        //si no había eleccion seleccionada, elimino las elecciones del select 
                        document.f1.eleccion.length = 1
                            //coloco un guión en la única opción que he dejado 
                        document.f1.eleccion.options[0].value = "-"
                        document.f1.eleccion.options[0].text = "-"
                    }
                    //marco como seleccionada la opción primera de eleccion 
                    document.f1.eleccion.options[0].selected = true
                }
            </script>
        </div>
    </div>
</div>