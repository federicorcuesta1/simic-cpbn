<?php
    $peticionAjax=true;
    require_once "../core/configGeneral.php";
    if(isset($_POST['dni-reg']) || isset($_POST['codigo-del']) || isset($_POST['cuenta-up'])){
        	require_once "../controladores/contabControlador.php";
        	$InsContab= new contabControlador();
        	if(isset($_POST['dni-reg']) && isset($_POST['nombre-reg']) && isset($_POST['apellido-reg'])){
        		echo $InsContab->agregar_contab_controlador();
        	}

            if(isset($_POST['codigo-del']) && isset($_POST['privilegio-admin'])){
                echo $InsContab->eliminar_contab_controlador();
            }

            if(isset($_POST['cuenta-up']) && isset($_POST['dni-up']) && isset($_POST['tipo-up'])){
                echo $InsContab->actualizar_contab_controlador();
            }
        
    }else{
        session_start(['name'=>'SIMIC']);
        session_destroy();
        echo '<script> window.location.href="'.SERVERURL.'login/" </script>';
    }