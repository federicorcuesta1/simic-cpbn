<?php
    if($peticionAjax){
        require_once "../core/mainModel.php";
    }else{
        require_once "./core/mainModel.php";
    }

    class contabModelo extends mainModel{
    	//Funcion modelo para agregar un usuario de contabilidad
    	protected function agregar_contab_modelo($datos){
    		$sql=mainModel::conectar()->prepare("INSERT INTO contab(ContabDNI,ContabNombre,ContabApellido,ContabTelefono,ContabDireccion,ContabTipo,ContabEstado,CuentaCodigo) VALUES(:DNI,:Nombre,:Apellido,:Telefono,:Direccion,:Tipo,:Estado,:Codigo)");
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

		//funcion modelo para datos de los usuarios de contabilidad
        protected function datos_contab_modelo($tipo,$codigo){
            if($tipo=="Unico"){
                $query=mainModel::conectar()->prepare("SELECT * FROM contab WHERE CuentaCodigo=:Codigo");
                $query->bindParam(":Codigo", $codigo);
            }elseif($tipo=="Conteo"){
                $query=mainModel::conectar()->prepare("SELECT id FROM contab");                
            }
            $query->execute();
            return $query;
        }
		
		//Funcion modelo para eliminar un usuario de contabilidad
    	protected function eliminar_contab_modelo($codigo){
			$query=mainModel::conectar()->prepare("DELETE FROM contab WHERE CuentaCodigo=:Codigo");
			$query->bindParam(":Codigo",$codigo);
			$query->execute();
			return $query;
		}
		
		//funcion modelo para actualizar datos del usuario de contabilidad
        protected function actualizar_contab_modelo($datos){
            $query=mainModel::conectar()->prepare("UPDATE contab SET ContabDNI=:DNI, ContabNombre=:Nombre, ContabApellido=:Apellido, ContabTelefono=:Telefono, ContabDireccion=:Direccion, ContabTipo=:Tipo, ContabEstado=:Estado WHERE CuentaCodigo=:Codigo");
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