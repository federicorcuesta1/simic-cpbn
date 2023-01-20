<?php
    $peticionAjax=true;
    require_once "../core/configGeneral.php";
    if(isset($_POST['dni-reg']) || isset($_POST['codigo-del']) || isset($_POST['cuenta-up'])){
        require_once "../controladores/usuarioControlador.php";
        $insUsu= new usuarioControlador();

        if(isset($_POST['dni-reg']) && isset($_POST['nombre-reg']) && isset($_POST['apellido-reg']) && isset($_POST['usuario-reg'])){
            echo $insUsu->agregar_usuario_controlador();
        }

        if(isset($_POST['codigo-del']) && isset($_POST['privilegio-admin'])){
            echo $insUsu->eliminar_usuario_controlador();
        }

        if(isset($_POST['cuenta-up']) && isset($_POST['dni-up']) && isset($_POST['estado-up'])){
            echo $insUsu->actualizar_usuario_controlador();
        }
        
    }else{
        session_start(['name'=>'SIMIC']);
        session_destroy();
        echo '<script> window.location.href="'.SERVERURL.'login/" </script>';
    }