<?php
    if($peticionAjax){
        require_once "../core/mainModel.php";
    }else{
        require_once "./core/mainModel.php";
    }

    class usuarioModelo extends mainModel{
        //funcion modelo para agregar usuarios
        protected function agregar_usuario_modelo($datos){
            $sql=mainModel::conectar()->prepare("INSERT INTO admin(AdminDNI,AdminNombre,AdminApellido,AdminTelefono,AdminDireccion,AdminTipo,AdminEstado,CuentaCodigo) VALUES(:DNI,:Nombre,:Apellido,:Telefono,:Direccion,:Tipo,:Estado,:Codigo)");
            $sql->bindParam(":DNI",$datos['DNI']);
            $sql->bindParam(":Nombre",$datos['Nombre']);
            $sql->bindParam(":Apellido",$datos['Apellido']);
            $sql->bindParam(":Telefono",$datos['Telefono']);
            $sql->bindParam(":Direccion",$datos['Direccion']);
            $sql->bindParam(":Tipo",$datos['Tipo']);
            $sql->bindParam(":Estado",$datos['Estado']);
            $sql->bindParam(":Codigo",$datos['Codigo']);
            $sql->execute();
            return $sql;
        }

        //funcion modelo para eliminar usuarios
        protected function eliminar_usuario_modelo($codigo){
            $query=mainModel::conectar()->prepare("DELETE FROM admin WHERE CuentaCodigo=:Codigo");
            $query->bindParam(":Codigo",$codigo);
            $query->execute();
            return $query;
        }

        //funcion modelo para datos de los usuarios
        protected function datos_usuario_modelo($tipo,$codigo){
            if($tipo=="Unico"){
                $query=mainModel::conectar()->prepare("SELECT * FROM admin WHERE CuentaCodigo=:Codigo");
                $query->bindParam(":Codigo", $codigo);
            }elseif($tipo=="Conteo"){
                $query=mainModel::conectar()->prepare("SELECT id FROM admin WHERE id!='1'");                
            }
            $query->execute();
            return $query;
        }

        //funcion modelo para actualizar datos del usuario
        protected function actualizar_usuario_modelo($datos){
            $query=mainModel::conectar()->prepare("UPDATE admin SET AdminDNI=:DNI, AdminNombre=:Nombre, AdminApellido=:Apellido, AdminTelefono=:Telefono, AdminDireccion=:Direccion, AdminTipo=:Tipo, AdminEstado=:Estado WHERE CuentaCodigo=:Codigo");
            $query->bindParam(":DNI",$datos['DNI']);
            $query->bindParam(":Nombre",$datos['Nombre']);
            $query->bindParam(":Apellido",$datos['Apellido']);
            $query->bindParam(":Telefono",$datos['Telefono']);
            $query->bindParam(":Direccion",$datos['Direccion']);
            $query->bindParam(":Tipo",$datos['Tipo']);
            $query->bindParam(":Estado",$datos['Estado']);
            $query->bindParam(":Codigo",$datos['Codigo']);
            $query->execute();
            return $query;
        }

    }