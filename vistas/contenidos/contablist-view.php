<?php 
    if($_SESSION['tipo_simic']!="Administrador" && $_SESSION['tipo_simic']!="Financiero"){
        echo $lc->forzar_cierre_sesion_controlador();
    }
?>
<div class="container-fluid">
    <div class="page-header">
        <h1 class="text-titles"><i class="zmdi zmdi-account zmdi-hc-fw"></i> USUARIOS DE CONTABILIDAD </h1>
    </div>
    <p class="lead">Este es el listado de las personas registradas en el sistema como usuarios de contabilidad.</p>
</div>

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

<?php 
    require_once "./controladores/contabControlador.php";
    $insContab= new contabControlador();
?>
<!-- Panel listado de administradores -->
<div class="container-fluid">
    <div class="panel panel-success">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE USUARIOS DE CONTABILIDAD</h3>
        </div>
        <div class="panel-body">
            <?php 
                $pagina = explode("/", $_GET['views']);
                echo $insContab->paginador_contab_controlador($pagina[1],5,$_SESSION['privilegio_simic'],""); 
            ?>  
        </div>
    </div>
</div>