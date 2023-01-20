<?php
if($peticionAjax){
    require_once "../modelos/loginModelo.php";
}else{
    require_once "./modelos/loginModelo.php";
}

class loginControlador extends loginModelo{

    //funcion controladora de inicio de sesion
    public function iniciar_sesion_controlador(){
        $usuario=mainModel::limpiar_cadena($_POST['usuario']);
        $clave=mainModel::limpiar_cadena($_POST['clave']);

        $clave=mainModel::encryption($clave);

        $datosLogin=[
            "Usuario"=>$usuario,
            "Clave"=>$clave
        ];

        $datosCuenta=loginModelo::iniciar_sesion_modelo($datosLogin);

        if($datosCuenta->rowCount()==1){
            $row=$datosCuenta->fetch();

            //obtenemos los datos de la fecha, hora y año actual que se inicia sesion
            $fechaActual=date("Y-m-d");
            $yearActual=date("Y");
            $horaActual=date("h:i:s a");

            $consulta1=mainModel::ejecutar_consulta_simple("SELECT id FROM bitacora");

            $numero=($consulta1->rowCount())+1;

            $codigoB=mainModel::generar_codigo_aleatorio("CB",7,$numero);

            $datosBitacora=[
                "Codigo"=>$codigoB,
                "Fecha"=>$fechaActual,
                "HoraInicio"=>$horaActual,
                "HoraFinal"=>"Sin Registro",
                "Tipo"=>$row['CuentaTipo'],
                "Year"=>$yearActual,
                "Cuenta"=>$row['CuentaCodigo']
            ];

            $insertarBitacora=mainModel::guardar_bitacora($datosBitacora);
            if($insertarBitacora->rowCount()>=1){

                if($row['CuentaTipo']=="Administrador"){
                    $query1=mainModel::ejecutar_consulta_simple("SELECT * FROM admin WHERE CuentaCodigo='".$row['CuentaCodigo']."'");
                }else{
                    $query1=mainModel::ejecutar_consulta_simple("SELECT * FROM contab WHERE CuentaCodigo='".$row['CuentaCodigo']."'");
                }

                if($query1->rowCount()==1){
                    session_start(['name'=>'SIMIC']);//Este es el nombre de inicio de sesion se puede cambiar pero hay que modificarla en todos el codigo.
                    $UserData=$query1->fetch();

                    if($row['CuentaTipo']=="Administrador"){
                        $_SESSION['nombre_simic']=$UserData['AdminNombre'];
                        $_SESSION['apellido_simic']=$UserData['AdminApellido'];
                        $_SESSION['dni_simic']=$UserData['AdminDNI'];
                        $_SESSION['telefono_simic']=$UserData['AdminTelefono'];
                        $_SESSION['direccion_simic']=$UserData['AdminDireccion'];
                    }else{
                        $_SESSION['nombre_simic']=$UserData['ContabNombre'];
                        $_SESSION['apellido_simic']=$UserData['ContabApellido'];
                        $_SESSION['dni_simic']=$UserData['ContabDNI'];
                        $_SESSION['telefono_simic']=$UserData['ContabTelefono'];
                        $_SESSION['direccion_simic']=$UserData['ContabDireccion'];
                    }

                    $_SESSION['usuario_simic']=$row['CuentaUsuario'];
                    $_SESSION['tipo_simic']=$row['CuentaTipo'];
                    $_SESSION['privilegio_simic']=$row['CuentaPrivilegio'];
                    $_SESSION['foto_simic']=$row['CuentaFoto'];
                    $_SESSION['token_simic']=md5(uniqid(mt_rand(),true));
                    $_SESSION['codigo_cuenta_simic']=$row['CuentaCodigo'];
                    $_SESSION['codigo_bitacora_simic']=$codigoB;
    
                    //redireccionamos al usuario segun el tipo de usuario y los permisos que tenga
                    if($row['CuentaPrivilegio']==1){
                        $url=SERVERURL."home/";
                    }elseif($row['CuentaPrivilegio']==2 || $row['CuentaPrivilegio']==3){
                        $url=SERVERURL."membernew/";
                    }else{
                        $url=SERVERURL."finanzas/";
                    }
    
                    return $urlLocation='<script> window.location="'.$url.'" </script>';
                }else{
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrio un Error Inexperado",
                        "Texto"=>"No hemos podido iniciar la sesión por problemas técnicos, por favor intente nuevamente",
                        "Tipo"=>"error"
                    ];
                    return mainModel::sweet_alert($alerta);
                }

            }else{
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un Error Inexperado",
                    "Texto"=>"No hemos podido iniciar la sesión por problemas técnicos, por favor intente nuevamente",
                    "Tipo"=>"error"
                ];
                return mainModel::sweet_alert($alerta);
            }
        }else{
            $alerta=[
                "Alerta"=>"simple",
                "Titulo"=>"Ocurrio un Error Inexperado",
                "Texto"=>"El Nombre de Usuario y Contraseña no son correctos o su cuenta puede estar inactiva, por favor intentelo nuevamente.",
                "Tipo"=>"error"
            ];
            return mainModel::sweet_alert($alerta);
        }
    }

    //funcion controladora para cerrar la sesion
    public function cerrar_sesion_controlador(){
        session_start(['name'=>'SIMIC']);
        $token=mainModel::decryption($_GET['Token']);
        $hora=date("h:i:s a");
        $datos=[
            "Usuario"=>$_SESSION['usuario_simic'],
            "Token_S"=>$_SESSION['token_simic'],
            "Token"=>$token,
            "Codigo"=>$_SESSION['codigo_bitacora_simic'],
            "Hora"=>$hora
        ];
        return loginModelo::cerrar_sesion_modelo($datos);
    }    

    //funcion controladora para cerrar la sesion o no permitir el acceso a nuestro sistema
    public function forzar_cierre_sesion_controlador(){
        session_unset();
        session_destroy();
        $redirect='<script> window.location.href="'.SERVERURL.'login/" </script>';
        return $redirect;
    }

    public function redireccionar_usuario_controlador($tipo){
        if($tipo=="Administrador"){
            $redirect='<script> window.location.href="'.SERVERURL.'home/" </script>';
        }elseif($tipo=="Financiero"){
            $redirect='<script> window.location.href="'.SERVERURL.'finanzas/" </script>';
        }else{
            $redirect='<script> window.location.href="'.SERVERURL.'membernew/" </script>';
        }
        return $redirect;
    }

}
