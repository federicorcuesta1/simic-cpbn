<?php
    if($peticionAjax){
        require_once "../core/configAPP.php";
    }else{
        require_once "./core/configAPP.php";
    }
    class mainModel{

        //funcion modelo para conectar con la base de datos
        protected function conectar(){
            $enlace= new PDO(SGBD,USER,PASS);
            return $enlace;
        }

        //funcion modelo para ejecutar consultas simples
        protected function ejecutar_consulta_simple($consulta){
            $respuesta=self::conectar()->prepare($consulta); //Este es un error que no impide el funcionamiento del sistema; y en la documentacion de php dice que en el futuro se arreglara este error.
            $respuesta->execute();
            return $respuesta;
        }

        //funcion modelo para agregar cuentas de usuario
        protected function agregar_cuenta($datos){
            $sql=self::conectar()->prepare("INSERT INTO cuenta(CuentaCodigo,CuentaPrivilegio,CuentaUsuario,CuentaClave,CuentaEmail,CuentaEstado,CuentaTipo,CuentaGenero,CuentaFoto) VALUES(:Codigo,:Privilegio,:Usuario,:Clave,:Email,:Estado,:Tipo,:Genero,:Foto)");
            $sql->bindParam(":Codigo",$datos['Codigo']);
            $sql->bindParam(":Privilegio",$datos['Privilegio']);
            $sql->bindParam(":Usuario",$datos['Usuario']);
            $sql->bindParam(":Clave",$datos['Clave']);
            $sql->bindParam(":Email",$datos['Email']);
            $sql->bindParam(":Estado",$datos['Estado']);
            $sql->bindParam(":Tipo",$datos['Tipo']);
            $sql->bindParam(":Genero",$datos['Genero']);
            $sql->bindParam(":Foto",$datos['Foto']);
            $sql->execute();
            return $sql;
        }

        //funcion modelo para eliminar cuentas de usuario
        protected function eliminar_cuenta($codigo){
            $sql=self::conectar()->prepare("DELETE FROM cuenta WHERE CuentaCodigo=:Codigo");
            $sql->bindParam(":Codigo", $codigo);
            $sql->execute();
            return $sql;
        }

        //funcion modelo para seleccion de datos cuentas de usuario
        protected function datos_cuenta($codigo,$tipo){
            $query=self::conectar()->prepare("SELECT * FROM cuenta WHERE CuentaCodigo=:Codigo AND CuentaTipo=:Tipo");
            $query->bindParam(":Codigo",$codigo);
            $query->bindParam(":Tipo",$tipo);
            $query->execute();
            return $query;
        }

        //funcion modelo para actualizar cuentas de usuario
        protected function actualizar_cuenta($datos){
            $query=self::conectar()->prepare("UPDATE cuenta SET CuentaPrivilegio=:Privilegio,CuentaUsuario=:Usuario,CuentaClave=:Clave,CuentaEmail=:Email,CuentaEstado=:Estado,CuentaTipo=:Tipo,CuentaGenero=:Genero,CuentaFoto=:Foto WHERE CuentaCodigo=:Codigo");
            $query->bindParam(":Privilegio", $datos['CuentaPrivilegio']);
            $query->bindParam(":Usuario", $datos['CuentaUsuario']);
            $query->bindParam(":Clave", $datos['CuentaClave']);
            $query->bindParam(":Email", $datos['CuentaEmail']);
            $query->bindParam(":Estado", $datos['CuentaEstado']);
            $query->bindParam(":Tipo", $datos['CuentaTipo']);
            $query->bindParam(":Genero", $datos['CuentaGenero']);
            $query->bindParam(":Foto", $datos['CuentaFoto']);
            $query->bindParam(":Codigo", $datos['CuentaCodigo']);
            $query->execute();
            return $query;
        }

        //funcion modelo para insertar registro del usuario en el sistema o en la bitacora del sistema
        protected function guardar_bitacora($datos){
            $sql=self::conectar()->prepare("INSERT INTO bitacora(BitacoraCodigo,BitacoraFecha,BitacoraHoraInicio,BitacoraHoraFinal,BitacoraTipo,BitacoraYear,CuentaCodigo) VALUES(:Codigo,:Fecha,:HoraInicio,:HoraFinal,:Tipo,:Year,:Cuenta)");
            $sql->bindParam(":Codigo", $datos['Codigo']);
            $sql->bindParam(":Fecha", $datos['Fecha']);
            $sql->bindParam(":HoraInicio", $datos['HoraInicio']);
            $sql->bindParam(":HoraFinal", $datos['HoraFinal']);
            $sql->bindParam(":Tipo", $datos['Tipo']);
            $sql->bindParam(":Year", $datos['Year']);
            $sql->bindParam(":Cuenta", $datos['Cuenta']);
            $sql->execute();
            return $sql;
        }

        //funcion modelo para actualizar registro del usuario en el sistema o en la bitacora del sistema
        protected function actualizar_bitacora($codigo,$hora){
            $sql=self::conectar()->prepare("UPDATE bitacora SET BitacoraHoraFinal=:Hora WHERE BitacoraCodigo=:Codigo");
            $sql->bindParam(":Hora", $hora);
            $sql->bindParam(":Codigo", $codigo);
            $sql->execute();
            return $sql;
        }

        //funcion modelo para eliminar registro del usuario en el sistema o en la bitacora del sistema
        protected function eliminar_bitacora($codigo){
            $sql=self::conectar()->prepare("DELETE FROM bitacora WHERE CuentaCodigo=:Codigo");
            $sql->bindParam(":Codigo", $codigo);
            $sql->execute();
            return $sql;
        }

        //funcion modelo para encriptar contraseñas
        public function encryption($string){
            $output=FALSE;
            $key=hash('sha256', SECRET_KEY);
            $iv=substr(hash('sha256', SECRET_IV), 0, 16);
            $output=openssl_encrypt($string, METHOD, $key, 0, $iv);
            $output=base64_encode($output);
            return $output;
        }

        //funcion modelo para desencriptar contraseñas
        protected function decryption($string){
            $key=hash('sha256', SECRET_KEY);
            $iv=substr(hash('sha256', SECRET_IV), 0, 16);
            $output=openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
            return $output;
        }

        //funcion modelo para generar codigos aleatorios
        protected function generar_codigo_aleatorio($letra, $longitud, $num){
            for($i=1; $i<=$longitud; $i++){
                $numero = rand(0,9);
                $letra.= $numero;
            }            
            return $letra."-".$num;
        }

        //funcion modelo para limpiar cadenas de texto
        protected function limpiar_cadena($cadena){
            $cadena=trim($cadena);
            $cadena=stripslashes($cadena);
            $cadena=str_ireplace("<script>", "", $cadena);
            $cadena=str_ireplace("</script>", "", $cadena);
            $cadena=str_ireplace("<script src", "", $cadena);
            $cadena=str_ireplace("<script type=", "", $cadena);
            $cadena=str_ireplace("SELECT * FROM", "", $cadena);
            $cadena=str_ireplace("DELETE FROM", "", $cadena);
            $cadena=str_ireplace("INSERT INTO", "", $cadena);
            $cadena=str_ireplace("--", "", $cadena);
            $cadena=str_ireplace("^", "", $cadena);
            $cadena=str_ireplace("[", "", $cadena);
            $cadena=str_ireplace("]", "", $cadena);
            $cadena=str_ireplace("==", "", $cadena);
            $cadena=str_ireplace(";", "", $cadena);
            return $cadena;
        }

        //funcion modelo para mostrar mensajes de alertas al sistema
        protected function sweet_alert($datos){
            if($datos['Alerta']=="simple"){
                $alerta="
                    <script>
                        swal(
                        '".$datos['Titulo']."',
                        '".$datos['Texto']."',
                        '".$datos['Tipo']."'
                        );
                    </script>
                ";
            }elseif($datos['Alerta']=="recargar"){
                $alerta="
                    <script>
                        swal({
                            title: '".$datos['Titulo']."',
                            text: '".$datos['Texto']."',
                            type: '".$datos['Tipo']."',
                            confirmButtonText: 'Aceptar'
                            }).then(function(){
                                location.reload();
                            });
                    </script>
                ";
            }elseif($datos['Alerta']=="limpiar"){
                 $alerta="
                    <script>
                        swal({
                            title: '".$datos['Titulo']."',
                            text: '".$datos['Texto']."',
                            type: '".$datos['Tipo']."',
                            confirmButtonText: 'Aceptar'
                            }).then(function(){
                                $('.FormularioAjax')[0].reset();
                            });
                    </script>
                ";
            }
            return $alerta;            
        }

    }