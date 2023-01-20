<section class="full-box cover dashboard-sideBar">
    <div class="full-box dashboard-sideBar-bg btn-menu-dashboard"></div>
    <div class="full-box dashboard-sideBar-ct">

        <!--SideBar Title -->
        <div class="full-box text-uppercase text-center text-titles dashboard-sideBar-title">
            <?php echo COMPANY; ?> <i class="zmdi zmdi-close btn-menu-dashboard visible-xs"></i>
        </div>

        <!-- SideBar User info -->
        <div class="full-box dashboard-sideBar-UserInfo">

            <figure class="full-box">
                <img src="<?php echo SERVERURL; ?>vistas/assets/avatars/<?php echo $_SESSION['foto_simic']; ?>" alt="UserIcon">
                <figcaption class="text-center text-titles"><?php echo $_SESSION['nombre_simic']; ?></figcaption>
            </figure>

            <?php 
                if($_SESSION['tipo_simic']=="Administrador"){
                    $tipo="admin";
                }else{
                    $tipo="contab";
                }
            ?>
            <ul class="full-box list-unstyled text-center">

                <li>
                    <a href="<?php echo SERVERURL; ?>mydata/<?php echo $tipo."/".$lc->encryption($_SESSION['codigo_cuenta_simic']); ?>/" title="Mis datos">
                        <i class="zmdi zmdi-account-circle"></i>
                    </a>
                </li>

                <li>
                    <a href="<?php echo SERVERURL; ?>myaccount/<?php echo $tipo."/".$lc->encryption($_SESSION['codigo_cuenta_simic']); ?>/" title="Mi cuenta">
                        <i class="zmdi zmdi-settings"></i>
                    </a>
                </li>

                <li>
                    <a href="<?php echo $lc->encryption($_SESSION['token_simic']); ?>" title="Salir del sistema" class="btn-exit-system">
                        <i class="zmdi zmdi-power"></i>
                    </a>
                </li>

            </ul>

        </div>

        <!-- SideBar Menu -->
        <ul class="list-unstyled full-box dashboard-sideBar-Menu">

            <!--MODULOS PARA EL ADMINISTRADOR GENERAL DEL SISTEMA-->
            <?php if($_SESSION['privilegio_simic']==1): ?>
            <!--LINK PARA INGRESO AL TABLERO PRINCIPAL-->
            <li>
                <a href="<?php echo SERVERURL; ?>home/">
                    <i class="zmdi zmdi-view-dashboard zmdi-hc-fw"></i> Dashboard
                </a>
            </li>                
            <!--LINK´S PARA INGRESO AL MODULO ADMINISTRATIVO-->
            <li>
                <a href="#!" class="btn-sideBar-SubMenu">
                    <i class="zmdi zmdi-case zmdi-hc-fw"></i> Administrativo <i class="zmdi zmdi-caret-down pull-right"></i>
                </a>
                <ul class="list-unstyled full-box">
                    <li>
                        <a href="<?php echo SERVERURL; ?>membernew/"><i class="zmdi zmdi-account-add"></i> Miembros</a>
                    </li>                                      
                </ul>
            </li>
            <!--LINK´S PARA INGRESO AL MODULO CONTABILIDAD-->
            <li>
                <a href="#!" class="btn-sideBar-SubMenu">
                    <i class="zmdi zmdi-balance-wallet"> </i> Contabilidad<i class="zmdi zmdi-caret-down pull-right"></i>
                </a>
                <ul class="list-unstyled full-box">
                    <li>
                        <a href="<?php echo SERVERURL; ?>finanzas/"><i class = "zmdi zmdi-money"> </i> Finanzas</a>
                    </li>
                </ul>
            </li>
            <!--LINK´S PARA INGRESO AL MODULO CREACIÓN DE USUARIOS TANTO DE ADMINISTRATIVO COMO DE CONTABILIDAD-->
            <li>
                <a href="#!" class="btn-sideBar-SubMenu">
                    <i class="zmdi zmdi-accounts-add"></i> Usuarios <i class="zmdi zmdi-caret-down pull-right"></i>
                </a>
                <ul class="list-unstyled full-box">
                    <li>
                        <a href="<?php echo SERVERURL; ?>usua/"><i class = "zmdi zmdi-accounts"></i> Administrativos</a>
                    </li>
                    <li>
                        <a href="<?php echo SERVERURL; ?>contab/"><i class = "zmdi zmdi-accounts-alt"></i> Contabilidad</a>
                    </li>
                </ul>
            </li>

            <!--MODULOS PARA EL ADMINISTRADOR SECRETARIO DEL SISTEMA-->
            <?PHP elseif($_SESSION['privilegio_simic']==2 || $_SESSION['privilegio_simic']==3):?>
            <!--LINK´S PARA INGRESO AL MODULO ADMINISTRATIVO-->
            <li>
                <a href="#!" class="btn-sideBar-SubMenu">
                    <i class="zmdi zmdi-case zmdi-hc-fw"></i> Administrativo <i class="zmdi zmdi-caret-down pull-right"></i>
                </a>
                <ul class="list-unstyled full-box">
                    <li>
                        <a href="<?php echo SERVERURL; ?>membernew/"><i class="zmdi zmdi-account-add"></i> Miembros </a>
                    </li>                                       
                </ul>
            </li>
            <!--LINK´S PARA INGRESO AL MODULO CREACIÓN DE USUARIOS TANTO DE ADMINISTRATIVO COMO DE CONTABILIDAD-->
            <li>
                <a href="#!" class="btn-sideBar-SubMenu">
                    <i class="zmdi zmdi-accounts-add"></i> Usuarios <i class="zmdi zmdi-caret-down pull-right"></i>
                </a>
                <ul class="list-unstyled full-box">
                    <li>
                        <a href="<?php echo SERVERURL; ?>usua/"><i class = "zmdi zmdi-accounts"></i> Administrativos</a>
                    </li>
                </ul>
            </li>>

            <!--MODULOS PARA EL MODULO FINANCIERO DEL SISTEMA-->
            <?php elseif($_SESSION['privilegio_simic']==4): ?>                
            <!--LINK´S PARA INGRESO AL MODULO CONTABILIDAD-->
            <li>
                <a href="#!" class="btn-sideBar-SubMenu">
                    <i class="zmdi zmdi-balance-wallet"> </i> Contabilidad<i class="zmdi zmdi-caret-down pull-right"></i>
                </a>
                <ul class="list-unstyled full-box">
                    <li>
                        <a href="<?php echo SERVERURL; ?>finanzas/"><i class = "zmdi zmdi-money"> </i> Finanzas</a>
                    </li>
                </ul>
            </li>
            <!--LINK´S PARA INGRESO AL MODULO CREACIÓN DE USUARIOS DE CONTABILIDAD UNICAMENTE-->
            <li>
                <a href="#!" class="btn-sideBar-SubMenu">
                    <i class="zmdi zmdi-accounts-add"></i> Usuarios <i class="zmdi zmdi-caret-down pull-right"></i>
                </a>
                <ul class="list-unstyled full-box">                    
                    <li>
                        <a href="<?php echo SERVERURL; ?>contab/"><i class = "zmdi zmdi-accounts-alt"></i> Contabilidad</a>
                    </li>
                </ul>
            </li>            
            <?php endif; ?>
            
            
        </ul>
    </div>
</section>