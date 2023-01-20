<?php
    if($peticionAjax){
        require_once "../core/mainModel.php";
    }else{
        require_once "./core/mainModel.php";
    }

    class miembrosModelo extends mainModel{
        //funcion modelo que registra un nuevo miembro  
        protected function agregar_miembro_modelo($datos){
            $query=mainModel::conectar()->prepare("INSERT INTO miembros(MiemDNI,MiemNombres,MiemApellidos,MiemTelefono,MiemEmail,MiemDireccion,MiemCiudad,MiemFechaNacimiento,MiemLugarNacimiento, MiemEdad, MiemEtnia,MiemEstadoCivil,MiemNombreConyuge,MiemNumeroHijos,MiemFechaMatrimonio,MiemNacionalidad,MiemSexo,MiemTipoSangre,MiemOcupacion,MiemTitulo,MiemInstitucion,MiemFechaGrado,MiemFechaConversion,MiemFechaBautismo,MiemLugarBautismo,MiemPastorBautizo,MiemRetiroIglesia,MiemEstado) VALUES(:DNI,:Nombres,:Apellidos,:Telefono,:Email,:Direccion,:Ciudad,:FechaNacimiento,:LugarNacimiento,:Edad,:Etnia,:EstadoCivil,:NombreConyuge,:NumeroHijos,:FechaMatrimonio,:Nacionalidad,:Sexo,:TipoSangre,:Ocupacion,:Titulo,:Institucion,:FechaGrado,:FechaConversion,:FechaBautismo,:LugarBautismo,:PastorBautizo,:RetiroIglesia,:Estado)");

            $query->bindParam(":DNI",$datos['DNI']);
            $query->bindParam(":Nombres",$datos['Nombres']);
            $query->bindParam(":Apellidos",$datos['Apellidos']);
            $query->bindParam(":Telefono",$datos['Telefono']);
            $query->bindParam(":Email",$datos['Email']);
            $query->bindParam(":Direccion",$datos['Direccion']);
            $query->bindParam(":Ciudad",$datos['Ciudad']);
            $query->bindParam(":FechaNacimiento",$datos['FechaNacimiento']);
            $query->bindParam(":LugarNacimiento",$datos['LugarNacimiento']);
            $query->bindParam(":Edad",$datos['Edad']);
            $query->bindParam(":Etnia",$datos['Etnia']);
            $query->bindParam(":EstadoCivil",$datos['EstadoCivil']);
            $query->bindParam(":NombreConyuge",$datos['NombreConyuge']);
            $query->bindParam(":NumeroHijos",$datos['NumeroHijos']);
            $query->bindParam(":FechaMatrimonio",$datos['FechaMatrimonio']);
            $query->bindParam(":Nacionalidad",$datos['Nacionalidad']);
            $query->bindParam(":Sexo",$datos['Sexo']);
            $query->bindParam(":TipoSangre",$datos['TipoSangre']);
            $query->bindParam(":Ocupacion",$datos['Ocupacion']);
            $query->bindParam(":Titulo",$datos['Titulo']);
            $query->bindParam(":Institucion",$datos['Institucion']);
            $query->bindParam(":FechaGrado",$datos['FechaGrado']);
            $query->bindParam(":FechaConversion",$datos['FechaConversion']);
            $query->bindParam(":FechaBautismo",$datos['FechaBautismo']);
            $query->bindParam(":LugarBautismo",$datos['LugarBautismo']);
            $query->bindParam(":PastorBautizo",$datos['PastorBautizo']);
            $query->bindParam(":RetiroIglesia",$datos['RetiroIglesia']);
            $query->bindParam(":Estado",$datos['Estado']);            
            $query->execute();
            return $query;
        }

        //funcion modelo para registro de datos del miembro
        protected function datos_miembro_modelo($tipo,$codigo){
            if($tipo=="Unico"){
                $query=mainModel::conectar()->prepare("SELECT * FROM miembros WHERE MiemDNI=:Codigo");
                $query->bindParam(":Codigo",$codigo);
            }elseif($tipo=="Conteo"){
                $query=mainModel::conectar()->prepare("SELECT id FROM miembros");
            }elseif($tipo=="Select"){
                $query=mainModel::conectar()->prepare("SELECT MiemDNI,MiemNombres FROM miembros ORDER BY MiemNombres ASC");
            }
            $query->execute();
            return $query;
        }

        //Funcion modelo para eliminar un miembro
    	protected function eliminar_miembro_modelo($dni){
			$query=mainModel::conectar()->prepare("DELETE FROM miembros WHERE MiemDNI=:DNI");
			$query->bindParam(":DNI",$dni);
			$query->execute();
			return $query;
		}

        protected function actualizar_miembro_modelo($datos){
            $query=mainModel::conectar()->prepare("UPDATE miembros SET MiemDNI=:DNI, MiemNombres=:Nombres, MiemApellidos=:Apellidos, MiemTelefono=:Telefono, MiemEmail=:Email, MiemDireccion=:Direccion, MiemCiudad=:Ciudad, MiemFechaNacimiento=:FechaN, MiemLugarNacimiento=:LugarN, MiemEdad=:Edad, MiemEtnia=:Etnia, MiemEstadoCivil=:EstadoC, MiemNombreConyuge=:NombreC, MiemNumeroHijos=:NumeroH, MiemFechaMatrimonio=:FechaM, MiemNacionalidad=:Nacionalidad, MiemSexo=:Sexo, MiemTipoSangre=:TipoS, MiemOcupacion=:Ocupacion, MiemTitulo=:Titulo, MiemInstitucion=:Institucion, MiemFechaGrado=:FechaG, MiemFechaConversion=:FechaC, MiemFechaBautismo=:FechaB, MiemLugarBautismo=:LugarB, MiemPastorBautizo=:PastorB, MiemRetiroIglesia=:RetiroI, MiemEstado=:Estado");

            $query->bindParam(":DNI",$datos['DNI']);
            $query->bindParam(":Nombres",$datos['Nombres']);
            $query->bindParam(":Apellidos",$datos['Apellidos']);
            $query->bindParam(":Telefono",$datos['Telefono']);
            $query->bindParam("Email",$datos['Email']);
            $query->bindParam(":Direccion",$datos['Direccion']);
            $query->bindParam(":Ciudad",$datos['Ciudad']);
            $query->bindParam(":FechaN",$datos['FechaN']);
            $query->bindParam(":LugarN",$datos['LugarN']);
            $query->bindParam(":Edad",$datos['Edad']);
            $query->bindParam(":Etnia",$datos['Etnia']);
            $query->bindParam(":EstadoC",$datos['EstadoC']);
            $query->bindParam(":NombreC",$datos['NombreC']);
            $query->bindParam(":NumeroH",$datos['NumeroH']);
            $query->bindParam(":FechaM",$datos['FechaM']);
            $query->bindParam(":Nacionalidad",$datos['Nacionalidad']);
            $query->bindParam(":Sexo",$datos['Sexo']);
            $query->bindParam(":TipoS",$datos['TipoS']);
            $query->bindParam(":Ocupacion",$datos['Ocupacion']);
            $query->bindParam(":Titulo",$datos['Titulo']);
            $query->bindParam(":Institucion",$datos['Institucion']);
            $query->bindParam(":FechaG",$datos['FechaG']);
            $query->bindParam(":FechaC",$datos['FechaC']);
            $query->bindParam(":FechaB",$datos['FechaB']);
            $query->bindParam(":LugarB",$datos['LugarB']);
            $query->bindParam(":PastorB",$datos['PastorB']);
            $query->bindParam(":RetiroI",$datos['RetiroI']);
            $query->bindParam(":Estado",$datos['Estado']);
            $query->execute();
            return $query;
        }

    }