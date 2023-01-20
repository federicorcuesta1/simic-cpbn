<?php 
    if($_SESSION['tipo_simic']!="Administrador"){
        echo $lc->redireccionar_usuario_controlador($_SESSION['tipo_simic']);
    }
?>

<div class="container-fluid">
    <div class="page-header">
        <h1 class="text-titles"><i class="zmdi zmdi-account zmdi-hc-fw"></i> LISTA DE MIEMBROS IGLESIA </h1>
    </div>
    <p class="lead">Este es el listado de las personas registradas en el sistema como miembros activos.</p>
</div>

<div class="container-fluid">
    <ul class="breadcrumb breadcrumb-tabs">
    <li>
            <a href="<?php echo SERVERURL; ?>membernew/" class="btn btn-info">
                <i class="zmdi zmdi-plus"></i> &nbsp; NUEVO MIEMBRO
            </a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>memberlist/" class="btn btn-success">
                <i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE MIEMBROS
            </a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>membersearch/" class="btn btn-primary">
                <i class="zmdi zmdi-search"></i> &nbsp; BUSQUEDA DE MIEMBROS
            </a>
        </li>
        <li>
            <a href="<?php echo SERVERURL; ?>reportes/" class="btn btn-info">
                <i class="zmdi zmdi-folder-outline"></i> &nbsp; REPORTES
            </a>
        </li>
    </ul>
</div>

<?php 
    require_once "./controladores/miembrosControlador.php";
    $insMiem= new miembrosControlador();
?>
<!-- Panel listado de administradores -->
<div class="container-fluid">
    <div class="panel panel-success">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="zmdi zmdi-format-list-bulleted"></i> &nbsp; LISTA DE MIEMBROS</h3>
        </div>
        <div class="panel-body">
            <?php 
                $pagina = explode("/", $_GET['views']);
                echo $insMiem->paginador_miembro_controlador($pagina[1],10,$_SESSION['privilegio_simic'],"");
            ?>  
        </div>
    </div>
</div>