<?php
    class vistasModelo{
        protected function obtener_vistas_modelo($vistas){
            $listaBlanca=["contab","contablist","contabsearch", "finanzas", "home", "memberlist", "membernew","memberinfo", "membersearch", "myaccount", "mydata", "search", "usua", "usualist", "usuasearch", "membresia", "certificado", "pdf", "reportes"];
            if(in_array($vistas, $listaBlanca)){
                if(is_file("./vistas/contenidos/".$vistas."-view.php")){
                    $contenido="./vistas/contenidos/".$vistas."-view.php";
                }else{
                    $contenido="login";
                }
            }elseif($vistas=="login"){
                $contenido="login";
            }elseif($vistas=="index"){
                $contenido="login";
            }else{
                $contenido="404";
            }
            return $contenido;
        }
    }
    