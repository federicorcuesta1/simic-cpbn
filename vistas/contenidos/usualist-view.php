<?php 
    if($_SESSION['tipo_simic']!="Administrador"){
        echo $lc->redireccionar_usuario_controlador($_SESSION['tipo_simic']);
    }
?>
<div class="container-fluid">
    <div class="page-header">
        <h1 class="text-titles"><i class="zmdi zmdi-account zmdi-hc-fw"></i> USUARIOS ADMINISTRATIVOS </h1>
    </div>
    <p class="lead">Este es el listado de las personas registradas en el sistema como usuarios.</p>
</div>

<div class="container-fluid">
    <ul class="breadcrumb breadcrumb-tabs">
        <li>
            <a href="<?php echo SERVERURL; ?>usua/" class="btn btn-info">
                <i class="zmdi zmdi-plus"></i> &nbsp; NUEVO USUARIO
            </a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>usualist/" class="btn btn-success">
                <i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE USUARIOS
            </a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>usuasearch/" class="btn btn-primary">
                <i class="zmdi zmdi-search"></i> &nbsp; BUSCAR USUARIOS
            </a>
        </li>
    </ul>
</div>

<?php 
    require_once "./controladores/usuarioControlador.php";
    $insUsua= new usuarioControlador();
?>
<!-- Panel listado de administradores -->
<div class="container-fluid">
    <div class="panel panel-success">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; USUARIOS ADMINISTRATIVOS</h3>
        </div>
        <div class="panel-body">
            <?php 
                $pagina = explode("/", $_GET['views']);
                echo $insUsua->paginador_usuario_controlador($pagina[1],5,$_SESSION['privilegio_simic'],$_SESSION['codigo_cuenta_simic'],""); 
            ?>  
        </div>
    </div>
</div>