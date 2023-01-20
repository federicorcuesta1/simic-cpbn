<?php
    $peticionAjax=true;
    require_once "../core/configGeneral.php";
    if(isset($_POST['dni-reg']) || isset($_POST['codigo-del']) || isset($_POST['codigo'])){
        require_once "../controladores/miembrosControlador.php";
        $InsMiembro= new miembrosControlador();

        if(isset($_POST['dni-reg']) && isset($_POST['nombre-reg'])){
            echo $InsMiembro->agregar_miembro_controlador();
        }

        if(isset($_POST['codigo-del']) && isset($_POST['privilegio-admin'])){
            echo $InsMiembro->eliminar_miembro_controlador();
        }

        if(isset($_POST['codigo']) && isset($_POST['dni-up']) && isset($_POST['nombre-up'])){
            echo $InsMiembro->actualizar_miembro_controlador();
        }
        
    }else{
        session_start(['name'=>'SIMIC']);
        session_destroy();
        echo '<script> window.location.href="'.SERVERURL.'login/" </script>';
    }