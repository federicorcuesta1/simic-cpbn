<?php 
    if($_SESSION['tipo_simic']!="Administrador"){
        echo $lc->redireccionar_usuario_controlador($_SESSION['tipo_simic']);
    }
?>
<div class="container-fluid">
    <div class="page-header">
        <h1 class="text-titles"><i class="zmdi zmdi-account zmdi-hc-fw"></i> BUSQUEDA MIEMBROS IGLESIA</h1>
    </div>
    <p class="lead">Puede realizar la busqueda de un miembro de la iglesia por el nombre, apellido o numero de documento.</p>
</div>

<?php   

    if(!isset($_SESSION['busqueda_miem']) && empty($_SESSION['busqueda_miem'])){
?>
        <!-- Panel de busqueda -->
        <div class="container-fluid">
            <form class="well FormularioAjax" action="<?php echo SERVERURL; ?>ajax/buscadorAjax.php" method="POST" data-form="default" autocomplete="off" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-xs-12 col-md-8 col-md-offset-2">
                        <div class="form-group label-floating">
                            <span class="control-label">¿A quién estas buscando?</span>
                            <input class="form-control" type="text" name="busqueda_inicial_miem" required="">
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
                <p class="lead text-center">Su última búsqueda  fue <strong>“<?php echo $_SESSION['busqueda_miem']; ?>”</strong></p>
                <div class="row">
                    <input type="hidden" name="eliminar_busqueda_miem" value="destruir">
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
                    <h3 class="panel-title"><i class="zmdi zmdi-search"></i> &nbsp; BUSCAR MIEMBRO IGLESIA</h3>
                </div>
                <div class="panel-body">
                    <?php
                        require_once "./controladores/miembrosControlador.php";
                        $insMiem= new miembrosControlador(); 
                        
                        $pagina = explode("/", $_GET['views']);
                        echo $insMiem->paginador_miembro_controlador($pagina[1],5,$_SESSION['privilegio_simic'],$_SESSION['busqueda_miem']); 
                    ?>
                </div>
            </div>
        </div>
<?php } ?>