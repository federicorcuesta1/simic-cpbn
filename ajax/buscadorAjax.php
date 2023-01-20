<?php
    session_start(['name'=>'SIMIC']);
    $peticionAjax=true;
    require_once "../core/configGeneral.php";
    if(isset($_POST)){

        //MODULO MIEMBROS
        if(isset($_POST['busqueda_inicial_miem'])){
            $_SESSION['busqueda_miem']=$_POST['busqueda_inicial_miem'];
        }

        if(isset($_POST['eliminar_busqueda_miem'])){
            unset($_SESSION['busqueda_miem']);
            $url="membersearch";
        }

        if(isset($url)){
            echo '<script> window.location.href="'.SERVERURL.$url.'/" </script>';
        }else{
            echo '<script> location.reload(); </script>';
        }
        
        
        //MODULO ADMINISTRADOR
        if(isset($_POST['busqueda_inicial_usua']) ){
            $_SESSION['busqueda_usua']=$_POST['busqueda_inicial_usua'];
        }

        if(isset($_POST['eliminar_busqueda_usua'])){
            unset($_SESSION['busqueda_usua']);
            $url="usuasearch";
        }


        //MODULO CONTABILIDAD
        if(isset($_POST['busqueda_inicial_contab'])){
            $_SESSION['busqueda_contab']=$_POST['busqueda_inicial_contab'];            
        }

        if(isset($_POST['eliminar_busqueda_contab'])){
            unset ($_SESSION['busqueda_contab']);
            $url="contabsearch";
        }
        if(isset($url)){
            echo '<script> window.location.href="'.SERVERURL.$url.'/" </script>';
        }else{
            echo '<script> location.reload(); </script>';
        }
        
    }else{
        session_destroy();
        echo '<script> window.location.href="'.SERVERURL.'login/" </script>';
    }