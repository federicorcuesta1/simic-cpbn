<?php
    if($peticionAjax){
        require_once "../modelos/usuarioModelo.php";
    }else{
        require_once "./modelos/usuarioModelo.php";
    }

    class usuarioControlador extends usuarioModelo{

        //funcion controladora para agregar usuarios al sistema
        public function agregar_usuario_controlador(){
            $dni=mainModel::limpiar_cadena($_POST['dni-reg']);
            $nombre=mainModel::limpiar_cadena($_POST['nombre-reg']);
            $apellido=mainModel::limpiar_cadena($_POST['apellido-reg']);
            $telefono=mainModel::limpiar_cadena($_POST['telefono-reg']);
            $direccion=mainModel::limpiar_cadena($_POST['direccion-reg']);

            $usuario=mainModel::limpiar_cadena($_POST['usuario-reg']);
            $password1=mainModel::limpiar_cadena($_POST['password1-reg']);
            $password2=mainModel::limpiar_cadena($_POST['password2-reg']);
            $email=mainModel::limpiar_cadena($_POST['email-reg']);            
            $genero=mainModel::limpiar_cadena($_POST['optionsGenero']);

            $privilegio=mainModel::decryption($_POST['optionsPrivilegio']);
            $privilegio=mainModel::limpiar_cadena($privilegio);

            if($genero=="Masculino"){
                $foto="Male3Avatar.png";
            }else{
                $foto="Female3Avatar.png";
            }
            
            if($privilegio<1 || $privilegio>3){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un Error Inexperado",
                    "Texto"=>"El nivel de privilegio que intenta asignar es incorrecto.",
                    "Tipo"=>"error"
                ];
            }
            else{
                if($password1!=$password2){
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrio un Error Inexperado",
                        "Texto"=>"Las CONTRASEÑAS ingresadas no coinciden, por favor intentelo nuevamente.",
                        "Tipo"=>"error"
                    ];
                }else{
                    $consulta1=mainModel::ejecutar_consulta_simple("SELECT AdminDNI FROM admin WHERE AdminDNI='$dni'");
                    if($consulta1->rowCount()>=1){
                        $alerta=[
                            "Alerta"=>"simple",
                            "Titulo"=>"Ocurrio un Error Inexperado",
                            "Texto"=>"El Numero de Documento que acaba de ingresar ya se encuentra regitrado en el sistema.",
                            "Tipo"=>"error"
                        ];
                    }
                    else{
                        if($email!=""){
                            $consulta2=mainModel::ejecutar_consulta_simple("SELECT CuentaEmail FROM cuenta WHERE CuentaEmail='$email'");
                            $ec=$consulta2->rowCount();
                        }
                        else{
                            $ec=0;
                        }        
                        if($ec>=1){
                            $alerta=[
                                "Alerta"=>"simple",
                                "Titulo"=>"Ocurrio un Error Inexperado",
                                "Texto"=>"El EMAIL que acaba de ingresar ya se encuentra regitrado en el sistema.",
                                "Tipo"=>"error"
                            ];
                        }
                        else{
                            $consulta3=mainModel::ejecutar_consulta_simple("SELECT CuentaUsuario FROM cuenta WHERE CuentaUsuario='$usuario'");
                            if($consulta3->rowCount()>=1){
                                $alerta=[
                                    "Alerta"=>"simple",
                                    "Titulo"=>"Ocurrio un Error Inexperado",
                                    "Texto"=>"El USUARIO que acaba de ingresar ya se encuentra regitrado en el sistema.",
                                    "Tipo"=>"error"
                                ];
                            }
                            else{
                                $consulta4=mainModel::ejecutar_consulta_simple("SELECT id FROM cuenta");
                                $numero=($consulta4->rowCount())+1;
                                
                                $codigo=mainModel::generar_codigo_aleatorio("UC",7,$numero);

                                $clave=mainModel::encryption($password1);

                                $dataUC=[
                                    "Codigo"=>$codigo,
                                    "Privilegio"=>$privilegio,
                                    "Usuario"=>$usuario,
                                    "Clave"=>$clave,
                                    "Email"=>$email,
                                    "Estado"=>"Activo",
                                    "Tipo"=>"Administrador",
                                    "Genero"=>$genero,
                                    "Foto"=>$foto
                                ];    
                                $guardarCuenta=mainModel::agregar_cuenta($dataUC);
        
                                if($guardarCuenta->rowCount()>=1){
                                    $dataUS=[
                                        "DNI"=>$dni,
                                        "Nombre"=>$nombre,
                                        "Apellido"=>$apellido,
                                        "Telefono"=>$telefono,
                                        "Direccion"=>$direccion,
                                        "Tipo"=>"Administrador",
                                        "Estado"=>"Activo",
                                        "Codigo"=>$codigo
                                    ];
        
                                    $guardarUsuario=usuarioModelo::agregar_usuario_modelo($dataUS);
                                        
                                    if($guardarUsuario->rowCount()>=1){
                                        $alerta=[
                                            "Alerta"=>"limpiar",
                                            "Titulo"=>"USUARIO REGISTRADO",
                                            "Texto"=>"El USUARIO se registro con exito en nuestro sistema.",
                                            "Tipo"=>"success"
                                        ];
                                    }
                                    else{
                                        mainModel::eliminar_cuenta($codigo);
                                        $alerta=[
                                            "Alerta"=>"simple",
                                            "Titulo"=>"Ocurrio un Error Inexperado",
                                            "Texto"=>"No se ha podido realizar el registro del USUARIO en nuestro sistema.",
                                            "Tipo"=>"error"
                                        ];
                                    }
                                }else{                                
                                    $alerta=[
                                        "Alerta"=>"simple",
                                        "Titulo"=>"Ocurrio un Error Inexperado",
                                        "Texto"=>"No se ha podido realizar el registro de la CUENTA USUARIO en nuestro sistema.",
                                        "Tipo"=>"error"
                                    ];
                                }
                            }
                        }
                    }
                }
            }
            return mainModel::sweet_alert($alerta);
        }

        //funcion controladora para administrar el paginador de los usuarios  y tabla de busqueda (lista de usuarios)
        public function paginador_usuario_controlador($pagina,$registros,$privilegio,$codigo,$busqueda){
            
            $pagina=mainModel::limpiar_cadena($pagina);
            $registros=mainModel::limpiar_cadena($registros);
            $privilegio=mainModel::limpiar_cadena($privilegio);
            $codigo=mainModel::limpiar_cadena($codigo);
            $busqueda=mainModel::limpiar_cadena($busqueda);
            $tabla="";

            $pagina= (isset($pagina) && $pagina>0) ? (int) $pagina : 1;
            $inicio= ($pagina>0) ? (($pagina*$registros)-$registros) : 0;

            if(isset($busqueda) && $busqueda!=""){
                $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM admin WHERE ((CuentaCodigo!='$codigo' AND id!='1') AND (AdminNombre LIKE '%$busqueda%' OR AdminApellido LIKE '%$busqueda%' OR AdminDNI LIKE '%$busqueda%' OR AdminTelefono LIKE '%$busqueda%' OR AdminEstado LIKE '%$busqueda%')) ORDER BY AdminNombre ASC LIMIT $inicio,$registros";
                $paginaurl="usuasearch";
            }else{
                $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM admin WHERE CuentaCodigo!='$codigo' AND id!='1' ORDER BY AdminNombre ASC LIMIT $inicio,$registros";
                $paginaurl="usualist";
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
                            <th class="text-center">TIPO USUARIO</th>
                            <th class="text-center">ESTADO USUARIO</th>';
                        if($privilegio<=3){
                            $tabla.='
                                <th class="text-center">A. CUENTA</th>
                                <th class="text-center">A. DATOS</th>
                            ';
                        }
                        if($privilegio==1){
                            $tabla.='
                                <th class="text-center">ELIMINAR</th>
                            ';
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
                            <td>'.$rows['AdminDNI'].'</td>
                            <td>'.$rows['AdminNombre'].'</td>
                            <td>'.$rows['AdminApellido'].'</td>
                            <td>'.$rows['AdminTelefono'].'</td>
                            <td>'.$rows['AdminTipo'].'</td>
                            <td>'.$rows['AdminEstado'].'</td>';
                            if($privilegio<=3){
                                $tabla.='
                                    <td>
                                        <a href="'.SERVERURL.'myaccount/admin/'.mainModel::encryption($rows['CuentaCodigo']).'/" class="btn btn-success btn-raised btn-xs">
                                            <i class="zmdi zmdi-refresh"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="'.SERVERURL.'mydata/admin/'.mainModel::encryption($rows['CuentaCodigo']).'/" class="btn btn-success btn-raised btn-xs">
                                            <i class="zmdi zmdi-refresh"></i>
                                        </a>
                                    </td>
                                ';
                            }
                            if($privilegio==1){
                                $tabla.='
                                    <td>
                                        <form action="'.SERVERURL.'ajax/usuarioAjax.php" method="POST" class="FormularioAjax" data-form="delete" entype="multipart/form-data" autocomplete="off">
                                        <input type="hidden" name="codigo-del" value="'.mainModel::encryption($rows['CuentaCodigo']).'">
                                        <input type="hidden" name="privilegio-admin" value="'.mainModel::encryption($privilegio).'">
                                            <button type="submit" class="btn btn-danger btn-raised btn-xs">
                                                <i class="zmdi zmdi-delete"></i>
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
                            <td colspan="7">
                                <a href="'.SERVERURL.$paginaurl.'/" class="btn btn-sm btn-info btn-raised">
                                    Haga Click Aqui para Recargar el Listado
                                </a>
                            </td>
                        </tr>
                    ';
                }else{
                    $tabla.='
                        <tr>
                            <td colspan="7"> NO EXISTEN REGISTROS EN EL SISTEMA. </td>
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

        //funcion controladora para eliminar usuarios
        public function eliminar_usuario_controlador(){
            $codigo=mainModel::decryption($_POST['codigo-del']);
            $adminPrivilegio=mainModel::decryption($_POST['privilegio-admin']);

            $codigo=mainModel::limpiar_cadena($codigo);
            $adminPrivilegio=mainModel::limpiar_cadena($adminPrivilegio);

            if($adminPrivilegio==1){
                $query1=mainModel::ejecutar_consulta_simple("SELECT id FROM admin WHERE CuentaCodigo='$codigo'");
                $datosAdmin=$query1->fetch();
                if($datosAdmin['id']!=1){
                    $DelUsua=usuarioModelo::eliminar_usuario_modelo($codigo);
                    mainModel::eliminar_bitacora($codigo);
                    if($DelUsua->rowCount()>=1){
                        $DelCuenta=mainModel::eliminar_cuenta($codigo);
                        if($DelCuenta->rowCount()>=1){
                            $alerta=[
                                "Alerta"=>"recargar",
                                "Titulo"=>"USUARIO Y CUENTA ELIMINADA",
                                "Texto"=>"Se ha ELIMINADO el USUARIO y la CUENTA del sistema.",
                                "Tipo"=>"success"
                            ];
                        }else{
                            $alerta=[
                                "Alerta"=>"simple",
                                "Titulo"=>"Ocurrio un Error Inexperado",
                                "Texto"=>"No podemos Eliminar esta cuenta de usuario en este momento del sistema.",
                                "Tipo"=>"error"
                            ];
                        }
                    }else{
                        $alerta=[
                            "Alerta"=>"simple",
                            "Titulo"=>"Ocurrio un Error Inexperado",
                            "Texto"=>"No podemos Eliminar este usuario en este momento del sistema.",
                            "Tipo"=>"error"
                        ];
                    }
                }else{
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrio un Error Inexperado",
                        "Texto"=>"No pódemos eliminar el Administrador Principal del Sistema.",
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

        //funcion controladora para obtener los datos de un usuario
        public function datos_usuario_controlador($tipo,$codigo){
            $codigo=mainModel::decryption($codigo);
            $tipo=mainModel::limpiar_cadena($tipo);
            
            return usuarioModelo::datos_usuario_modelo($tipo,$codigo);
        }

        //funcion controladora para actualizar datos del usuario
        public function actualizar_usuario_controlador(){
            $cuenta=mainModel::decryption($_POST['cuenta-up']);

            $dni=mainModel::limpiar_cadena($_POST['dni-up']);
            $nombre=mainModel::limpiar_cadena($_POST['nombre-up']);
            $apellido=mainModel::limpiar_cadena($_POST['apellido-up']);
            $telefono=mainModel::limpiar_cadena($_POST['telefono-up']);
            $direccion=mainModel::limpiar_cadena($_POST['direccion-up']);
            $tipo=mainModel::limpiar_cadena($_POST['tipo-up']);
            $estado=mainModel::limpiar_cadena($_POST['estado-up']);

            $query1=mainModel::ejecutar_consulta_simple("SELECT * FROM admin WHERE CuentaCodigo='$cuenta'");
            $DatosUsua=$query1->fetch();

            if($dni!=$DatosUsua['AdminDNI']){
                $consulta1=mainModel::ejecutar_consulta_simple("SELECT AdminDNI FROM admin WHERE AdminDNI='$dni'");
                if($consulta1->rowCount()>=1){
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrio un Error Inexperado",
                        "Texto"=>"El Numero de Documento que acaba de ingresar ya se encuentra Registrado en el Sistema, Por favor verificar su número de documento y realice la actualización nuevamente.",
                        "Tipo"=>"error"
                    ];
                    return mainModel::sweet_alert($alerta);
                    exit();
                }
            }

            $dataAd=[
                "DNI"=>$dni,
                "Nombre"=>$nombre,
                "Apellido"=>$apellido,
                "Telefono"=>$telefono,
                "Direccion"=>$direccion,
                "Tipo"=>$tipo,
                "Estado"=>$estado,
                "Codigo"=>$cuenta
            ];

            if(usuarioModelo::actualizar_usuario_modelo($dataAd)){
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
                    "Texto"=>"No hemos podido realizar la actualización de tus datos, por favor intentelo nuevamente.",
                    "Tipo"=>"error"
                ];                
            }
            return mainModel::sweet_alert($alerta);


        }

    }
