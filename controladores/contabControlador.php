<?php
    if($peticionAjax){
        require_once "../modelos/contabModelo.php";
    }else{
        require_once "./modelos/contabModelo.php";
    }

    class contabControlador extends contabModelo{
    	//Funcion controladora para agregar un usuario de contabilidad
    	public function agregar_contab_controlador(){
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
            $privilegio=4;

            if($genero=="Masculino"){
            	$foto="Male2Avatar.png";
            }else{
            	$foto="Female2Avatar.png";
            }

            if($password1!=$password2){
            	$alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un Error Inexperado",
                    "Texto"=>"Las CONTRASEÑAS ingresadas no coinciden, por favor intentelo nuevamente.",
                    "Tipo"=>"error"
                ];
            }else{
            	$consulta1=mainModel::ejecutar_consulta_simple("SELECT ContabDNI FROM contab WHERE ContabDNI='$dni'");
            	if($consulta1->rowCount()>=1){
            		$alerta=[
	                    "Alerta"=>"simple",
	                    "Titulo"=>"Ocurrio un Error Inexperado",
	                    "Texto"=>"El Numero de Documento que acaba de ingresar ya se encuentra registrado en el sistema.",
	                    "Tipo"=>"error"
	                ];
            	}else{
            		if($email!=""){
            			$consulta2=mainModel::ejecutar_consulta_simple("SELECT CuentaEmail FROM cuenta WHERE CuentaEmail='$email'");
            			$ec=$consulta2->rowCount();
            		}else{
            			$ec=0;
            		}

            		if($ec>=1){
            			$alerta=[
		                    "Alerta"=>"simple",
		                    "Titulo"=>"Ocurrio un Error Inexperado",
		                    "Texto"=>"El EMAIL que acaba de ingresar ya se encuentra registrado en el sistema.",
		                    "Tipo"=>"error"
		                ];
            		}else{
            			$consulta3=mainModel::ejecutar_consulta_simple("SELECT CuentaUsuario FROM cuenta WHERE CuentaUsuario='$usuario'");

            			if($consulta3->rowCount()>=1){
            				$alerta=[
		                    "Alerta"=>"simple",
		                    "Titulo"=>"Ocurrio un Error Inexperado",
		                    "Texto"=>"El USUARIO que acaba de ingresar ya se encuentra registrado en el sistema.",
		                    "Tipo"=>"error"
		                ];
            			}else{
            				$consulta4=mainModel::ejecutar_consulta_simple("SELECT id FROM cuenta");
                            $numero=($consulta4->rowCount())+1;
                            
                            $codigo=mainModel::generar_codigo_aleatorio("FC",7,$numero);

                            $clave=mainModel::encryption($password1);

                            $dataAC=[
                            	"Codigo"=>$codigo,
                            	"Privilegio"=>$privilegio,
                            	"Usuario"=>$usuario,
                            	"Clave"=>$clave,
                            	"Email"=>$email,
                            	"Estado"=>"Activo",
                            	"Tipo"=>"Financiero",
                            	"Genero"=>$genero,
                            	"Foto"=>$foto
                            ];

							$guardarCuenta=mainModel::agregar_cuenta($dataAC);

							if($guardarCuenta->rowCount()>=1){
								$dataCont=[
									"DNI"=>$dni,
									"Nombre"=>$nombre,
									"Apellido"=>$apellido,
									"Telefono"=>$telefono,
									"Direccion"=>$direccion,
									"Tipo"=>"Financiero",
									"Estado"=>"Activo",
									"Codigo"=>$codigo
								];
								
								$guardarContab=contabModelo::agregar_contab_modelo($dataCont);

								if($guardarContab->rowCount()>=1){
									$alerta=[
										"Alerta"=>"limpiar",
										"Titulo"=>"Usuario Registrado",
										"Texto"=>"El Usuario Financiero se registro con Exito en el Sistema.",
										"Tipo"=>"success"
									];
								}else{
									mainModel::eliminar_cuenta($codigo);
									$alerta=[
										"Alerta"=>"simple",
										"Titulo"=>"Ocurrio un Error Inexperado",
										"Texto"=>"No hemos podido registrar el Usuario Financiero, por favor intente nuevamente.",
										"Tipo"=>"error"
									];
								}
							}else{
								$alerta=[
									"Alerta"=>"simple",
									"Titulo"=>"Ocurrio un Error Inexperado",
									"Texto"=>"No hemos podido registrar la CUENTA en el sistema, por favor intente nuevamente.",
									"Tipo"=>"error"
								];
							}
            			}
            		}
            	}
            }
            return mainModel::sweet_alert($alerta);
    	}

		//funcion controladora para administrar el paginador de los usuarios de contabilidad y tabla de busqueda (lista de usuarios)
        public function paginador_contab_controlador($pagina,$registros,$privilegio,$busqueda){
            
            $pagina=mainModel::limpiar_cadena($pagina);
            $registros=mainModel::limpiar_cadena($registros);
            $privilegio=mainModel::limpiar_cadena($privilegio);
            $busqueda=mainModel::limpiar_cadena($busqueda);
            $tabla="";

            $pagina= (isset($pagina) && $pagina>0) ? (int) $pagina : 1;
            $inicio= ($pagina>0) ? (($pagina*$registros)-$registros) : 0;

            if(isset($busqueda) && $busqueda!=""){
                $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM contab WHERE (ContabNombre LIKE '%$busqueda%' OR ContabApellido LIKE '%$busqueda%' OR ContabDNI LIKE '%$busqueda%' OR ContabTelefono LIKE '%$busqueda%' OR ContabEstado LIKE '%$busqueda%') ORDER BY ContabNombre ASC LIMIT $inicio,$registros";
                $paginaurl="contabsearch";
            }else{
                $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM contab ORDER BY ContabNombre ASC LIMIT $inicio,$registros";
                $paginaurl="contablist";
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
                            <td>'.$rows['ContabDNI'].'</td>
                            <td>'.$rows['ContabNombre'].'</td>
                            <td>'.$rows['ContabApellido'].'</td>
                            <td>'.$rows['ContabTelefono'].'</td>
                            <td>'.$rows['ContabTipo'].'</td>
                            <td>'.$rows['ContabEstado'].'</td>';
                            if($privilegio<=3){
                                $tabla.='
                                    <td>
                                        <a href="'.SERVERURL.'myaccount/contab/'.mainModel::encryption($rows['CuentaCodigo']).'/" class="btn btn-success btn-raised btn-xs">
                                            <i class="zmdi zmdi-refresh"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="'.SERVERURL.'mydata/contab/'.mainModel::encryption($rows['CuentaCodigo']).'/" class="btn btn-success btn-raised btn-xs">
                                            <i class="zmdi zmdi-refresh"></i>
                                        </a>
                                    </td>
                                ';
                            }
                            if($privilegio==1){
                                $tabla.='
                                    <td>
                                        <form action="'.SERVERURL.'ajax/contabAjax.php" method="POST" class="FormularioAjax" data-form="delete" entype="multipart/form-data" autocomplete="off">
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
                            <td colspan="10">
                                <a href="'.SERVERURL.$paginaurl.'/" class="btn btn-sm btn-info btn-raised">
                                    Haga Click Aqui para Recargar el Listado
                                </a>
                            </td>
                        </tr>
                    ';
                }else{
                    $tabla.='
                        <tr>
                            <td colspan="10"> NO EXISTEN REGISTROS EN EL SISTEMA. </td>
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

        //funcion controladora para obtener los datos de un usuario de contabilidad
        public function datos_contab_controlador($tipo,$codigo){
            $codigo=mainModel::decryption($codigo);
            $tipo=mainModel::limpiar_cadena($tipo);
            
            return contabModelo::datos_contab_modelo($tipo,$codigo);
        }

        //Funcion controladora para eliminar un usuario de contabilidad
    	public function eliminar_contab_controlador(){
            $codigo=mainModel::decryption($_POST['codigo-del']);
            $privilegio=mainModel::decryption($_POST['privilegio-admin']);

            if($privilegio==1){
                $DelContab=contabModelo::eliminar_contab_modelo($codigo);
                mainModel::eliminar_bitacora($codigo);

                if($DelContab->rowCount()>=1){

                    $DelCuenta=mainModel::eliminar_cuenta($codigo);

                    if($DelCuenta->rowCount()>=1){
                        $alerta=[
                            "Alerta"=>"recargar",
                            "Titulo"=>"Usuario Eliminado",
                            "Texto"=>"El Usuario de contabilidad fue eliminado con éxito.",
                            "Tipo"=>"success"
                        ];
                    }else{
                        $alerta=[
                            "Alerta"=>"simple",
                            "Titulo"=>"Ocurrio un Error Inexperado",
                            "Texto"=>"No podemos eliminar la cuenta de usuario de contabilidad en este momento.",
                            "Tipo"=>"error"
                        ];
                    }
                }else{
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrio un Error Inexperado",
                        "Texto"=>"No podemos eliminar este usuario de contabilidad en este momento.",
                        "Tipo"=>"error"
                    ];
                }

            }else{
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un Error Inexperado",
                    "Texto"=>"No posees los permisos necesarios para realizar esta operación.",
                    "Tipo"=>"error"
                ];
            }
            return mainModel::sweet_alert($alerta);
		}

        //funcion controladora para actualizar datos del usuario de contabilidad
        public function actualizar_contab_controlador(){
            $cuenta=mainModel::decryption($_POST['cuenta-up']);

            $dni=mainModel::limpiar_cadena($_POST['dni-up']);
            $nombre=mainModel::limpiar_cadena($_POST['nombre-up']);
            $apellido=mainModel::limpiar_cadena($_POST['apellido-up']);
            $telefono=mainModel::limpiar_cadena($_POST['telefono-up']);
            $direccion=mainModel::limpiar_cadena($_POST['direccion-up']);
            $tipo=mainModel::limpiar_cadena($_POST['tipo-up']);
            $estado=mainModel::limpiar_cadena($_POST['estado-up']);

            $query1=mainModel::ejecutar_consulta_simple("SELECT * FROM contab WHERE CuentaCodigo='$cuenta'");
            $DatosContab=$query1->fetch();

            if($dni!=$DatosContab['ContabDNI']){
                $consulta1=mainModel::ejecutar_consulta_simple("SELECT ContabDNI FROM contab WHERE ContabDNI='$dni'");
                if($consulta1->rowCount()>=1){
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrio un Error Inexperado",
                        "Texto"=>"El  Numero de Documento que acaba de ingresar ya se encuentra Registrado en el Sistema, Por favor verificar su número de documento y realice la actualización nuevamente.",
                        "Tipo"=>"error"
                    ];
                    return mainModel::sweet_alert($alerta);
                    exit();
                }  
            }

            $dataContab=[
                "DNI"=>$dni,
                "Nombre"=>$nombre,
                "Apellido"=>$apellido,
                "Telefono"=>$telefono,
                "Direccion"=>$direccion,
                "Tipo"=>$tipo,
                "Estado"=>$estado,
                "Codigo"=>$cuenta
            ];

            if(contabModelo::actualizar_contab_modelo($dataContab)){
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