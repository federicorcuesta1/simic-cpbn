<?php 
    if($_SESSION['tipo_simic']!="Administrador"){
        echo $lc->redireccionar_usuario_controlador($_SESSION['tipo_simic']);
    }
?>
<div class="container-fluid">
    <div class="page-header">
        <h1 class="text-titles"><i class="zmdi zmdi-account zmdi-hc-fw"></i> USUARIOS ADMINISTRATIVOS</h1>
    </div>
    <p class="lead">Puede realizar la busqueda de un usuario administrativo por el nombre, apellido o numero de documento.</p>
</div>

<!-- Panel links -->
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

    if(!isset($_SESSION['busqueda_usua']) && empty($_SESSION['busqueda_usua'])){
?>
        <!-- Panel de busqueda -->
        <div class="container-fluid">
            <form class="well FormularioAjax" action="<?php echo SERVERURL; ?>ajax/buscadorAjax.php" method="POST" data-form="default" autocomplete="off" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-xs-12 col-md-8 col-md-offset-2">
                        <div class="form-group label-floating">
                            <span class="control-label">¿A quién estas buscando?</span>
                            <input class="form-control" type="text" name="busqueda_inicial_usua" required="">
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <p class="text-center">
                            <button type="submit" class="btn btn-primary btn-raised btn-sm"><i class="zmdi zmdi-search"></i> &nbsp; Buscar</button>
                        </p>
                    </div>
                </div>
                <div class="RespuestaAjax"></div>
            </form>
        </div>
<?php }else{ ?>

        <!-- Panel última busqueda -->
        <div class="container-fluid">
            <form class="well FormularioAjax" action="<?php echo SERVERURL; ?>ajax/buscadorAjax.php" method="POST" data-form="default" autocomplete="off" enctype="multipart/form-data">
                <p class="lead text-center">Su última búsqueda  fue <strong>“<?php echo $_SESSION['busqueda_usua']; ?>”</strong></p>
                <div class="row">
                    <input class="form-control" type="hidden" name="eliminar_busqueda_usua" value="1">
                    <div class="col-xs-12">
                        <p class="text-center">
                            <button type="submit" class="btn btn-danger btn-raised btn-sm"><i class="zmdi zmdi-delete"></i> &nbsp; Eliminar búsqueda</button>
                        </p>
                    </div>
                </div>
                <div class="RespuestaAjax"></div>
            </form>
        </div>

        <!-- Panel listado de busqueda de administradores -->
        <div class="container-fluid">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="zmdi zmdi-search"></i> &nbsp; BUSCAR ADMINISTRADOR</h3>
                </div>
                <div class="panel-body">
                    <?php
                        require_once "./controladores/usuarioControlador.php";
                        $insUsua= new usuarioControlador(); 
                        
                        $pagina = explode("/", $_GET['views']);
                        echo $insUsua->paginador_usuario_controlador($pagina[1],5,$_SESSION['privilegio_simic'],$_SESSION['codigo_cuenta_simic'],$_SESSION['busqueda_usua']); 
                    ?>
                </div>
            </div>
        </div>
<?php } ?>