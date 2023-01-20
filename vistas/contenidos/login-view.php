<div class="full-box login-container cover">
    <form action="" method="POST" autocomplete="off" class="logInForm">
        <p class="text-center text-muted"><i class="zmdi zmdi-account-circle zmdi-hc-5x"></i></p>
        <p class="text-center text-muted text-uppercase">Inicia sesión con tu cuenta</p>
        <div class="form-group label-floating">
            <!--<label required="" class="control-label" for="UserName">Usuario</label>-->
            <input class="form-control control-label" id="UserName" name="usuario" type="text" style="color:#fff;" placeholder="Usuario">
            <p class="help-block">Escribe tú nombre de usuario</p>
        </div>
        <div class="form-group label-floating">
            <!--<label class="control-label" for="UserPass">Contraseña</label>-->
            <input required="" class="form-control control-label" id="UserPass" name="clave" type="password" style="color:#fff;" placeholder="Contraseña">
            <p class="help-block">Escribe tú contraseña</p>
        </div>
        <div class="form-group text-center">
            <input type="submit" value="Iniciar sesión" class="btn btn-info" style="color: #FFF;">
        </div>
    </form>

    <footer class="footer-img">                       
        <h3>Todos los Derechos Reservados<br><?php echo CREADOR; ?></h3>
        <i class = "zmdi zmdi-outlook zmdi-hc-lg mdc-text-light-blue">
            <a href="mailto:frctecnologiaeinformatica@gmail.com"> frctecnologiaeinformatica@gmail.com</a>
        </i><br>
        <i class = "zmdi zmdi-whatsapp zmdi-hc-lg mdc-text-green-700"></i> 310 884 88 08<br>
    </footer>

</div>

<?php 
    if(isset($_POST['usuario']) && isset($_POST['clave'])){
        require_once "./controladores/loginControlador.php";
        $login= new loginControlador();
        echo $login->iniciar_sesion_controlador();
    }
?>