<?php
    if($peticionAjax){
        require_once "../core/mainModel.php";
    }else{
        require_once "./core/mainModel.php";
    }

    class cuentaControlador extends mainModel{
        public function datos_cuenta_controlador($codigo,$tipo){
            $codigo=mainModel::decryption($codigo);
            $tipo=mainModel::limpiar_cadena($tipo);

            if($tipo=="admin"){
                $tipo="Administrador";
            }else{
                $tipo="Financiero";
            }

            return mainModel::datos_cuenta($codigo,$tipo);
        }

        public function actualizar_cuenta_controlador(){
            $CuentaCodigo=mainModel::decryption($_POST['CodigoCuenta-up']);
            $CuentaTipo=mainModel::decryption($_POST['tipoCuenta-up']);

            $query1=mainModel::ejecutar_consulta_simple("SELECT * FROM cuenta WHERE CuentaCodigo='$CuentaCodigo'");
            $DatosCuenta=$query1->fetch();

            $user=mainModel::limpiar_cadena($_POST['user-log']);
            $password=mainModel::limpiar_cadena($_POST['password-log']);
            $password=mainModel::encryption($password);

            if($user!="" && $password!=""){
                if(isset($_POST['privilegio-up'])){
                    $login=mainModel::ejecutar_consulta_simple("SELECT id FROM cuenta WHERE CuentaUsuario='$user' AND CuentaClave='$password'");
                }else{
                    $login=mainModel::ejecutar_consulta_simple("SELECT id FROM cuenta WHERE CuentaUsuario='$user' AND CuentaClave='$password' AND CuentaCodigo='$CuentaCodigo'");
                }

                if($login->rowCount()==0){
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrio un error Inesperado",
                        "Texto"=>"El nombre de Usuario y Contraseña que acaba de ingresar no coinciden con los datos de su cuenta.",
                        "Tipo"=>"error"
                    ];
                    return mainModel::sweet_alert($alerta);
                    exit();
                }
            }else{
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error Inesperado",
                    "Texto"=>"Para hacer la actualización de los datos de la cuenta debe ingresar el nombre de usuario y clave, por favor ingrese los datos e intentelo nuevamente.",
                    "Tipo"=>"error"
                ];
                return mainModel::sweet_alert($alerta);
                exit();
            }

            //VERIFICAR USUARIO
            $CuentaUsuario=mainModel::limpiar_cadena($_POST['usuario-up']);
            if($CuentaUsuario!=$DatosCuenta['CuentaUsuario']){
                $query2=mainModel::ejecutar_consulta_simple("SELECT CuentaUsuario FROM cuenta WHERE CuentaUsuario='$CuentaUsuario'");
                if($query2->rowCount()>=1){
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrio un error Inesperado",
                        "Texto"=>"El nuevo nombre de Usuario que acaba de ingresar ya se encuentra registrado en el sistema.",
                        "Tipo"=>"error"
                    ];
                    return mainModel::sweet_alert($alerta);
                    exit();
                }
            }

            //VERIFICAR EMAIL
            $CuentaEmail=mainModel::limpiar_cadena($_POST['email-up']);
            if($CuentaEmail!=$DatosCuenta['CuentaEmail']){
                $query3=mainModel::ejecutar_consulta_simple("SELECT CuentaEmail FROM cuenta WHERE CuentaEmail='$CuentaEmail'");
                if($query3->rowCount()>=1){
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrio un error Inesperado",
                        "Texto"=>"El nuevo Email de Usuario que acaba de ingresar ya se encuentra registrado en el sistema.",
                        "Tipo"=>"error"
                    ];
                    return mainModel::sweet_alert($alerta);
                    exit();
                }
            }

            $CuentaGenero=mainModel::limpiar_cadena($_POST['optionsGenero-up']);
            if(isset($_POST['optionsEstado-up'])){
                $CuentaEstado=mainModel::limpiar_cadena($_POST['optionsEstado-up']);
            }else{
                $CuentaEstado=$DatosCuenta['CuentaEstado'];
            }

            if($CuentaTipo=="admin"){
                if(isset($_POST['optionsPrivilegio-up'])){
                    $CuentaPrivilegio=mainModel::decryption($_POST['optionsPrivilegio-up']);
                }else{
                    $CuentaPrivilegio=$DatosCuenta['CuentaPrivilegio'];
                }

                $Usua=mainModel::limpiar_cadena($_POST['tipo-up']);
                if($Usua!=""){
                    $TipoUsuario=$Usua;
                }else{
                    $TipoUsuario=$DatosCuenta['CuentaTipo'];                
                }

                if($CuentaGenero=="Masculino"){
                    $CuentaFoto="Male3Avatar.png";
                }else{
                    $CuentaFoto="Female3Avatar.png";
                }
            }else{
                $CuentaPrivilegio=$DatosCuenta['CuentaPrivilegio'];
                if($CuentaGenero=="Masculino"){
                    $CuentaFoto="Male2Avatar.png";
                }else{
                    $CuentaFoto="Female2Avatar.png";
                }
            }

            //VERIFICAR EL CAMBIO DE CLAVE
            $passwordN1=mainModel::limpiar_cadena($_POST['newPassword1-up']);
            $passwordN2=mainModel::limpiar_cadena($_POST['newPassword2-up']);
            if($passwordN1!="" || $passwordN2!=""){
                if($passwordN1==$passwordN2){
                    $CuentaClave=mainModel::encryption($passwordN1);
                }else{
                    $alerta=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrio un Error Inesperado",
                        "Texto"=>"Las Nuevas Contraseñas no coinciden por favor vuelva a intentarlo nuevamente.",
                        "Tipo"=>"error"
                    ];
                    return mainModel::sweet_alert($alerta);
                    exit();
                }
            }else{
                $CuentaClave=$DatosCuenta['CuentaClave'];
            }
            
            //ENVIANDO DATOS AL MODELO
            $datosUpdate=[
                "CuentaPrivilegio"=>$CuentaPrivilegio,
                "CuentaCodigo"=>$CuentaCodigo,
                "CuentaUsuario"=>$CuentaUsuario,
                "CuentaClave"=>$CuentaClave,
                "CuentaEmail"=>$CuentaEmail,
                "CuentaEstado"=>$CuentaEstado,
                "CuentaTipo"=>$TipoUsuario,
                "CuentaGenero"=>$CuentaGenero,
                "CuentaFoto"=>$CuentaFoto            
            ];

            if(mainModel::actualizar_cuenta($datosUpdate)){
                if(!isset($_POST['privilegio-up'])){
                    session_start(['name'=>'SIMIC']);
                    $_SESSION['usuario_simic']=$CuentaUsuario;
                    $_SESSION['foto_simic']=$CuentaFoto;
                }
                $alerta=[
                    "Alerta"=>"recargar",
                    "Titulo"=>"Actualizacion de Datos",
                    "Texto"=>"Los datos de la Cuenta han sido actualizados exitosamente.",
                    "Tipo"=>"success"
                ];
            }else{
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrio un Error Inesperado",
                    "Texto"=>"Lo Sentimos no hemos podido hacer la actualización de los datos de la cuenta, por favor intentelo nuevamente.",
                    "Tipo"=>"error"
                ];
            }
            return mainModel::sweet_alert($alerta);



        }
}