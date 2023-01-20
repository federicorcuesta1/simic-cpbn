<?php
    if($peticionAjax){
        require_once "../modelos/miembrosModelo.php";
    }else{
        require_once "./modelos/miembrosModelo.php";
    }

    class miembrosControlador extends miembrosModelo{
        //funcion controladora que registra un nuevo miembro  
        public function agregar_miembro_controlador(){
            $dni=mainModel::limpiar_cadena($_POST['dni-reg']);
            $nombre=mainModel::limpiar_cadena($_POST['nombre-reg']);
            $apellido=mainModel::limpiar_cadena($_POST['apellido-reg']);
            $telefono=mainModel::limpiar_cadena($_POST['telefono-reg']);
            $email=mainModel::limpiar_cadena($_POST['email-reg']);
            $direccion=mainModel::limpiar_cadena($_POST['direccion-reg']);
            $ciudad=mainModel::limpiar_cadena($_POST['ciudad-reg']);
            $nacimiento=mainModel::limpiar_cadena($_POST['nacimiento-reg']);
            $lugarn=mainModel::limpiar_cadena($_POST['lugarN-reg']);
            $edad=mainModel::limpiar_cadena($_POST['edad-reg']);
            $etnia=mainModel::limpiar_cadena($_POST['etnia-reg']);
            $estadoc=mainModel::limpiar_cadena($_POST['estadoC-reg']);
            $conyuge=mainModel::limpiar_cadena($_POST['conyuge-reg']);
            $hijos=mainModel::limpiar_cadena($_POST['hijos-reg']);
            $matrimonio=mainModel::limpiar_cadena($_POST['matrimonio-reg']);
            $nacionalidad=mainModel::limpiar_cadena($_POST['nacionalidad-reg']);
            $genero=mainModel::limpiar_cadena($_POST['optionsGenero-reg']);
            $sangre=mainModel::limpiar_cadena($_POST['sangre-reg']);
            $ocupacion=mainModel::limpiar_cadena($_POST['ocupacion-reg']);
            $titulo=mainModel::limpiar_cadena($_POST['titulo-reg']);
            $instituto=mainModel::limpiar_cadena($_POST['instituto-reg']);
            $grado=mainModel::limpiar_cadena($_POST['grado-reg']);
            $conversion=mainModel::limpiar_cadena($_POST['conversion-reg']);
            $bautismo=mainModel::limpiar_cadena($_POST['bautismo-reg']);
            $lugarb=mainModel::limpiar_cadena($_POST['lugarB-reg']);
            $pastor=mainModel::limpiar_cadena($_POST['pastor-reg']);
            $retiro=mainModel::limpiar_cadena($_POST['retiro-reg']);
            $estado=mainModel::limpiar_cadena($_POST['optionsEstado-reg']);

            
            $consulta1=mainModel::ejecutar_consulta_simple("SELECT MiemDNI FROM miembros WHERE MiemDNI='$dni'");
            
            if($consulta1->rowCount()<=0){

                $datosMiembro=[
                    "DNI"=>$dni,
                    "Nombres"=>$nombre,
                    "Apellidos"=>$apellido,
                    "Telefono"=>$telefono,
                    "Email"=>$email,
                    "Direccion"=>$direccion,
                    "Ciudad"=>$ciudad,
                    "FechaNacimiento"=>$nacimiento,
                    "LugarNacimiento"=>$lugarn,
                    "Edad"=>$edad,
                    "Etnia"=>$etnia,
                    "EstadoCivil"=>$estadoc,
                    "NombreConyuge"=>$conyuge,
                    "NumeroHijos"=>$hijos,
                    "FechaMatrimonio"=>$matrimonio,
                    "Nacionalidad"=>$nacionalidad,
                    "Sexo"=>$genero,
                    "TipoSangre"=>$sangre,
                    "Ocupacion"=>$ocupacion,
                    "Titulo"=>$titulo,
                    "Institucion"=>$instituto,
                    "FechaGrado"=>$grado,
                    "FechaConversion"=>$conversion,
                    "FechaBautismo"=>$bautismo,
                    "LugarBautismo"=>$lugarb,
                    "PastorBautizo"=>$pastor,
                    "RetiroIglesia"=>$retiro,
                    "Estado"=>$estado
                ];
                $guardarMiembro=miembrosModelo::agregar_miembro_modelo($datosMiembro);

                if($guardarMiembro->rowCount()>=1){
                    $alerta=[
                        "Alerta"=>"recargar",
                        "Titulo"=>"MIEMBRO REGISTRADO",
                        "Texto"=>"Los datos del NUEVO MIEMBRO se registrarón con éxito.",
                        "Tipo"=>"success"
                    ];
                }else{
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrio un Error Inexperado",
                        "Texto"=>"No hemos podido guardar los datos del MIEMBRO NUEVO, por favor intente nuevamente.",
                        "Tipo"=>"error"
                    ];
                }
            }else{
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un Error Inexperado",
                    "Texto"=>"El Documento de Identidad que acaba de ingresar ya existe registrado en el Sistema.",
                    "Tipo"=>"error"
                ];
            }
            return mainModel::sweet_alert($alerta);
        }

        //funcion controladora para registro de datos del miembro
        public function datos_miembro_controlador($tipo,$codigo){
            $codigo=mainModel::limpiar_cadena($codigo);
            $tipo=mainModel::limpiar_cadena($tipo);

            return miembrosModelo::datos_miembro_modelo($tipo,$codigo);
        }

        //funcion controladora para administrar el paginador de los miembros
        public function paginador_miembro_controlador($pagina,$registros,$privilegio,$busqueda){
            
            $pagina=mainModel::limpiar_cadena($pagina);
            $registros=mainModel::limpiar_cadena($registros);
            $privilegio=mainModel::limpiar_cadena($privilegio);
            $busqueda=mainModel::limpiar_cadena($busqueda);
            $tabla="";

            $pagina= (isset($pagina) && $pagina>0) ? (int) $pagina : 1;
            $inicio= ($pagina>0) ? (($pagina*$registros)-$registros) : 0;

            if(isset($busqueda) && $busqueda!=""){
                $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM miembros WHERE (MiemNombres LIKE '%$busqueda%' OR MiemApellidos LIKE '%$busqueda%' OR MiemDNI LIKE '%$busqueda%' OR MiemTelefono LIKE '%$busqueda%' OR MiemEstado LIKE '%$busqueda%') ORDER BY MiemNombres ASC LIMIT $inicio,$registros";
                $paginaurl="membersearch";
            }else{
                $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM miembros ORDER BY MiemNombres ASC LIMIT $inicio,$registros";
                $paginaurl="memberlist";
            }

            $conexion = mainModel::conectar();

            $datos = $conexion->query($consulta);
            $datos= $datos->fetchAll();

            $total= $conexion->query("SELECT FOUND_ROWS()");
            $total= (int) $total->fetchColumn();

            $Npaginas= ceil($total/$registros);

            $tabla.='
            <div class="table-responsive">
                <table class="table table-hover text-center">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">DOCUMENTO</th>
                            <th class="text-center">NOMBRES</th>
                            <th class="text-center">APELLIDOS</th>
                            <th class="text-center">TELÉFONO</th>
                            <th class="text-center">EDAD</th>
                            <th class="text-center">ESTADO USUARIO</th>';
                        if($privilegio<=3){
                            $tabla.='<th class="text-center">ACTUALIZAR</th>';
                            $tabla.='<th class="text-center">CERTIFICAR</th>';
                        }
                        if($privilegio==1){
                            $tabla.=' <th class="text-center">ELIMINAR</th>';
                        }

            $tabla.='</tr>
                    </thead>
                    <tbody>
            ';

            if($total>=1 && $pagina<=$Npaginas){
                $contador=$inicio+1;
                foreach($datos as $rows){
                    $tabla.='
                        <tr>
                            <td>'.$contador.'</td>
                            <td>'.$rows['MiemDNI'].'</td>
                            <td>'.$rows['MiemNombres'].'</td>
                            <td>'.$rows['MiemApellidos'].'</td>
                            <td>'.$rows['MiemTelefono'].'</td>
                            <td>'.$rows['MiemEdad'].'</td>
                            <td>'.$rows['MiemEstado'].'</td>';
                            if($privilegio<=3){
                                $tabla.='
                                    <td>
                                    
                                        <a href="'.SERVERURL.'memberinfo/'.$rows['MiemDNI']. '/" class="btn btn-success btn-raised btn-xs"><input type="hidden" name="codigo" value="'.mainModel::encryption($rows['MiemDNI']).'">
                                        <i class="zmdi zmdi-refresh zmdi-hc-2x"></i>
                                        </a>
                                    </td>
                                    <td>                                    
                                        <a href="' . SERVERURL . 'certificado/'.$rows['MiemDNI'].'" class="btn btn-success btn-raised btn-xs"><input type="hidden" name="codigo" value="'.$rows['MiemDNI'].'">
                                        <i class="zmdi zmdi-print zmdi-hc-2x"></i>
                                        </a>
                                    </td>
                                ';
                            }
                            if($privilegio==1){
                                $tabla.='
                                    <td>
                                        <form action="'.SERVERURL.'ajax/miembrosAjax.php" method="POST" class="FormularioAjax" data-form="delete" entype="multipart/form-data" autocomplete="off">
                                        <input type="hidden" name="codigo-del" value="'.mainModel::encryption($rows['MiemDNI']).'">
                                        <input type="hidden" name="privilegio-admin" value="'.mainModel::encryption($privilegio). '">
                                            <button type="submit" class="btn btn-danger btn-raised btn-xs">
                                                <i class="zmdi zmdi-delete zmdi-hc-2x"></i>
                                            </button>
                                            <div class="RespuestaAjax"></div>
                                        </form>
                                    </td>
                                ';
                            }
                    $tabla.='</tr>';
                    $contador++;
                }
            }else{
                if($total>=1){
                    $tabla.='
                        <tr>
                            <td colspan="8">
                                <a href="'.SERVERURL.$paginaurl.'/" class="btn btn-sm btn-info btn-raised">
                                    Haga Click Aqui para Recargar el Listado
                                </a>
                            </td>
                        </tr>
                    ';
                }else{
                    $tabla.='
                        <tr>
                            <td colspan="8"> NO EXISTEN REGISTROS EN EL SISTEMA. </td>
                        </tr>
                    ';
                }
            }

            $tabla.='</tbody></table></div>';

            if($total>=1 && $pagina<=$Npaginas){
                $tabla.='<nav class="text-center"><ul class="pagination pagination-sm">';

                if($pagina==1){
                    $tabla.='<li class="disabled"><a><i class="zmdi zmdi-arrow-left"></i></a></li>';
                }else{
                    $tabla.='<li><a href="'.SERVERURL.$paginaurl.'/'.($pagina-1).'/"><i class="zmdi zmdi-arrow-left"></i></a></li>';
                }

                for($i=1; $i<=$Npaginas; $i++){
                    if($pagina==$i){
                        $tabla.='<li class="active"><a href="'.SERVERURL.$paginaurl.'/'.$i.'/">'.$i.'</a></li>';
                    }else{
                        $tabla.='<li><a href="'.SERVERURL.$paginaurl.'/'.$i.'/">'.$i.'</a></li>';
                    }
                }

                if($pagina==$Npaginas){
                    $tabla.='<li class="disabled"><a><i class="zmdi zmdi-arrow-right"></i></a></li>';
                }else{
                    $tabla.='<li><a href="'.SERVERURL.$paginaurl.'/'.($pagina+1).'/"><i class="zmdi zmdi-arrow-right"></i></a></li>';
                }

                $tabla.='</ul></nav>';
            }
            return $tabla;
        }

        //funcion controladora para eliminar miembros
        public function eliminar_miembro_controlador(){
            $codigo=mainModel::decryption($_POST['codigo-del']);
            $adminPrivilegio=mainModel::decryption($_POST['privilegio-admin']);

            $codigo=mainModel::limpiar_cadena($codigo);
            $adminPrivilegio=mainModel::limpiar_cadena($adminPrivilegio);

            if($adminPrivilegio==1){
                $consulta1=mainModel::ejecutar_consulta_simple("SELECT MiemDNI FROM miembros WHERE MiemDNI='$codigo'");
                if($consulta1->rowCount()<=0){
                    $DelMiem=miembrosModelo::eliminar_miembro_modelo($codigo);

                    if($DelMiem->rowCount()>=1){
                        $alerta=[
                            "Alerta"=>"recargar",
                            "Titulo"=>"MIEMBRO ELIMINADO",
                            "Texto"=>"Se ha realizado la eliminacion del Miembro, Débera volver a registrar todos los datos completos como Miembro Nuevo.",
                            "Tipo"=>"success"
                        ];
                    }else{
                        $alerta=[
                            "Alerta"=>"simple",
                            "Titulo"=>"Ocurrio un Error Inexperado",
                            "Texto"=>"Lo sentimos no se ha realizado la eliminación del Miembro.",
                            "Tipo"=>"error"
                        ];
                    }
                }else{
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrio un Error Inexperado",
                        "Texto"=>"No podemos realizar la eliminación de este miembro por que hay personas asociadas a su documento de identidad.",
                        "Tipo"=>"error"
                    ];
                }
            }else{
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un Error Inexperado",
                    "Texto"=>"No tienes los permisos necesarios para realizar esta operación.",
                    "Tipo"=>"error"
                ];
            }
            return mainModel::sweet_alert($alerta);
        }
        
        //funcion controladora para actualizar datos del miembro de la iglesia.
        public function actualizar_miembro_controlador(){
            $cuenta=mainModel::limpiar_cadena($_POST['codigo']);
            $dni=mainModel::limpiar_cadena($_POST['dni-up']);
            $nombre=mainModel::limpiar_cadena($_POST['nombre-up']);
            $apellido=mainModel::limpiar_cadena($_POST['apellido-up']);
            $telefono=mainModel::limpiar_cadena($_POST['telefono-up']);
            $email=mainModel::limpiar_cadena($_POST['email-up']);
            $direccion=mainModel::limpiar_cadena($_POST['direccion-up']);
            $ciudad=mainModel::limpiar_cadena($_POST['ciudad-up']);
            $nacimiento=mainModel::limpiar_cadena($_POST['nacimiento-up']);
            $lugarN=mainModel::limpiar_cadena($_POST['lugarN-up']);
            $edad=mainModel::limpiar_cadena($_POST['edad-up']);
            $etnia=mainModel::limpiar_cadena($_POST['etnia-up']);
            $estadoC=mainModel::limpiar_cadena($_POST['estadoC-up']);
            $conyuge=mainModel::limpiar_cadena($_POST['conyuge-up']);
            $hijos=mainModel::limpiar_cadena($_POST['hijos-up']);
            $matrimonio=mainModel::limpiar_cadena($_POST['matrimonio-up']);
            $nacionalidad=mainModel::limpiar_cadena($_POST['nacionalidad-up']);
            $genero=mainModel::limpiar_cadena($_POST['optionsGenero-up']);
            $sangre=mainModel::limpiar_cadena($_POST['sangre-up']);
            $ocupacion=mainModel::limpiar_cadena($_POST['ocupacion-up']);
            $titulo=mainModel::limpiar_cadena($_POST['titulo-up']);
            $instituto=mainModel::limpiar_cadena($_POST['instituto-up']);
            $grado=mainModel::limpiar_cadena($_POST['grado-up']);
            $conversion=mainModel::limpiar_cadena($_POST['conversion-up']);
            $bautismo=mainModel::limpiar_cadena($_POST['bautismo-up']);
            $lugarB=mainModel::limpiar_cadena($_POST['lugarB-up']);
            $pastor=mainModel::limpiar_cadena($_POST['pastor-up']);
            $retiro=mainModel::limpiar_cadena($_POST['retiro-up']);           
            $estado=mainModel::limpiar_cadena($_POST['optionsEstado-up']);

            $query1=mainModel::ejecutar_consulta_simple("SELECT * FROM miembros WHERE MiemDNI='$cuenta'");
            $DatosMiem=$query1->fetch();
            
            if($dni!=$DatosMiem['MiemDNI']){
                $consulta1=mainModel::ejecutar_consulta_simple("SELECT MiemDNI FROM miembros WHERE MiemDNI='$dni'");
                if($consulta1->rowCount()>=1){
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrio un error Inesperado",
                        "Texto"=>"El Número de Documento que acaba de ingresar ya se encuentra registrado en el sistema.",
                        "Tipo"=>"error"
                    ];
                    return mainModel::sweet_alert($alerta);
                    exit();
                }
            }

            $dataMiem=[
                "DNI"=>$dni,
                "Nombres"=>$nombre,
                "Apellidos"=>$apellido,
                "Telefono"=>$telefono,
                "Email"=>$email,
                "Direccion"=>$direccion,
                "Ciudad"=>$ciudad,                
                "FechaN"=>$nacimiento,
                "LugarN"=>$lugarN,
                "Edad"=>$edad,
                "Etnia"=>$etnia,
                "EstadoC"=>$estadoC,
                "NombreC"=>$conyuge,
                "NumeroH"=>$hijos,
                "FechaM"=>$matrimonio,
                "Nacionalidad"=>$nacionalidad,
                "Sexo"=>$genero,
                "TipoS"=>$sangre,
                "Ocupacion"=>$ocupacion,
                "Titulo"=>$titulo,
                "Institucion"=>$instituto,
                "FechaG"=>$grado,
                "FechaC"=>$conversion,
                "FechaB"=>$bautismo,
                "LugarB"=>$lugarB,
                "PastorB"=>$pastor,
                "RetiroI"=>$retiro,
                "Estado"=>$estado
            ];

            if(miembrosModelo::actualizar_miembro_modelo($dataMiem)){
                $alerta=[
                    "Alerta"=>"recargar",
                    "Titulo"=>"¡DATOS ACTUALIZADOS!",
                    "Texto"=>"Los datos ingresados han sido actualizados satisfactoriamente.",
                    "Tipo"=>"success"
                ];
            }else{
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un Error Inexperado",
                    "Texto"=>"No hemos podido realizar la ACTUALIZACIÓN de los datos, por favor intentelo nuevamente.",
                    "Tipo"=>"error"
                ];                
            }
            return mainModel::sweet_alert($alerta);
        }

        //funcion controladora para calcular la edad del miembro de la iglesia
        public function calculaedad($fechanacimiento){
            list($ano,$mes,$dia) = explode("-",$fechanacimiento);
            $ano_diferencia  = date("Y") - $ano;
            $mes_diferencia = date("m") - $mes;
            $dia_diferencia   = date("d") - $dia;
            if ($dia_diferencia < 0 || $mes_diferencia < 0)
              $ano_diferencia--;
            return $ano_diferencia;
          }        
    }