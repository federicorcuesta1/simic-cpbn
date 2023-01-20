<?php 
    if($_SESSION['tipo_simic']!="Administrador"){
        echo $lc->redireccionar_usuario_controlador($_SESSION['tipo_simic']);
    }
?>
<div class="container-fluid">
    <div class="page-header">
        <h1 class="text-titles">Ingresos <small> al Sistema</small></h1>
    </div>
</div>

<div class="full-box text-center" style="padding: 30px 10px;">
    <?php 
        require "./controladores/usuarioControlador.php";
        $IUsua= new usuarioControlador();
        $CUsua=$IUsua->datos_usuario_controlador("Conteo",0);
    ?>
    <article class="full-box tile">
        <div class="full-box tile-title text-center text-titles text-uppercase">
            Usuarios Administradores
        </div>
        <div class="full-box tile-icon text-center">
            <i class="zmdi zmdi-account"></i>
        </div>
        <div class="full-box tile-number text-titles">
            <p class="full-box"><?php echo $CUsua->rowCount(); ?></p>
            <small>Registrados</small>
        </div>
    </article>
    
    <?php 
        require "./controladores/contabControlador.php";
        $IContab= new contabControlador();
        $CContab=$IContab->datos_contab_controlador("Conteo",0);
    ?>
    <article class="full-box tile">
        <div class="full-box tile-title text-center text-titles text-uppercase">
            Usuarios Financieros
        </div>
        <div class="full-box tile-icon text-center">
            <i class="zmdi zmdi-account"></i>
        </div>
        <div class="full-box tile-number text-titles">
            <p class="full-box"><?php echo $CContab->rowCount(); ?></p>
            <small>Registrados</small>
        </div>
    </article>
</div>

<div class="container-fluid">
    <div class="page-header">
        <h1 class="text-titles">Tiempo <small>en el Sistema</small></h1>
    </div>
    <section id="cd-timeline" class="cd-container">
        <?php 
            require_once "./controladores/bitacoraControlador.php";
            $IBitacora= new bitacoraControlador();

            echo $IBitacora->listado_bitacora_controlador(5);

        ?>
    </section>
</div>