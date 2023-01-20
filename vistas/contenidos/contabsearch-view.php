<?php 
    if($_SESSION['tipo_simic']!="Administrador" && $_SESSION['tipo_simic']!="Financiero"){
        echo $lc->forzar_cierre_sesion_controlador();
    }
?>
<div class="container-fluid">
    <div class="page-header">
        <h1 class="text-titles"><i class="zmdi zmdi-account zmdi-hc-fw"></i> USUARIOS DE CONTABILIDAD </h1>
    </div>
    <p class="lead">Puede realizar la busqueda de un usuario de contabilidad por el nombre, apellido o numero de documento.</p>
</div>

<!-- Panel links -->
<div class="container-fluid">
    <ul class="breadcrumb breadcrumb-tabs">
        <li>
            <a href="<?php echo SERVERURL; ?>contab/" class="btn btn-info">
                <i class="zmdi zmdi-plus"></i> &nbsp; NUEVO USUARIO
            </a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>contablist/" class="btn btn-success">
                <i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE USUARIOS
            </a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>contabsearch/" class="btn btn-primary">
                <i class="zmdi zmdi-search"></i> &nbsp; BUSCAR USUARIOS
            </a>
        </li>
    </ul>
</div>
<?php if(!isset($_SESSION['busqueda_contab']) && empty($_SESSION['busqueda_contab'])){ ?>
    <!-- Panel de busqueda -->
    <div class="container-fluid">
        <form class="well FormularioAjax" action="<?php echo SERVERURL; ?>ajax/buscadorAjax.php" method="POST" data-form="default" autocomplete="off" enctype="multipart/form-data">
            <div class="row">
                <div class="col-xs-12 col-md-8 col-md-offset-2">
                    <div class="form-group label-floating">
                        <span class="control-label">¿A quién estas buscando?</span>
                        <input class="form-control" type="text" name="busqueda_inicial_contab" required="">
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
            <p class="lead text-center">Su última búsqueda  fue <strong>“<?php echo $_SESSION['busqueda_contab']; ?>”</strong></p>
            <div class="row">
                <input type="hidden" name="eliminar_busqueda_contab" value="destruir">
                <div class="col-xs-12">
                    <p class="text-center">
                        <button type="submit" class="btn btn-danger btn-raised btn-sm"><i class="zmdi zmdi-delete"></i> &nbsp; Eliminar búsqueda</button>
                    </p>
                </div>
            </div>
            <div class="RespuestaAjax"></div>
        </form>
    </div>

    <!-- Panel listado de busqueda de usuarios de contabilidad -->
    <div class="container-fluid">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="zmdi zmdi-search"></i> &nbsp; BUSCAR USUARIOS CONTABILIDAD</h3>
            </div>
            <div class="panel-body">
                <?php
                    require_once "./controladores/contabControlador.php";
                    $insContab= new contabControlador();

                    $pagina = explode("/", $_GET['views']);
                    echo $insContab->paginador_contab_controlador($pagina[1],5,$_SESSION['privilegio_simic'],$_SESSION['busqueda_contab']); 
                ?>
            </div>
        </div>
    </div>
<?php } ?>