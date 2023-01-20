<script type="text/javascript" src="<?php echo SERVERURL; ?>vistas/js/jspdf.min.js"></script>
<script type="text/javascript" src="<?php echo SERVERURL; ?>vistas/js/html2canvas.esm.js"></script>
<script type="text/javascript" src="<?php echo SERVERURL; ?>vistas/js/html2canvas.js"></script>
<script type="text/javascript" src="<?php echo SERVERURL; ?>vistas/js/html2canvas.min.js"></script>
<script type="text/javascript" src="<?php echo SERVERURL; ?>vistas/js/script.js"></script>

<script type="text/javascript">
function genPDF(){
    var doc = new jsPDF('p','mm','letter');
    doc.setFont("times", "bold");
    doc.text("La Iglesia Cristiana Colombia Puerta de Bendición para las Naciones", 105, 60, null, null, "center");
    doc.setFont("times", "normal");
    doc.text("CERTIFICA QUE:", 105, 70, null, null, "center");
    doc.setFont("helvetica", "normal");
    doc.fromHTML($('#contenedor').get(0),20,60,{
        'width':180
    });
    doc.save('certificacion.pdf');
}
</script>

<div id="contenedor">
    <?php 
        include_once "./controladores/miembrosControlador.php";
        $inMiembro= new miembrosControlador();
        $datos=explode("/", $_GET['views']);
        
        $filesMiem=$inMiembro->datos_miembro_controlador("Unico",$datos[1]);
        if($filesMiem->rowCount()==1){
            $campos=$filesMiem->fetch();
            if($_SESSION['privilegio_simic']<1 || $_SESSION['privilegio_simic']>3){
                echo $lc->redireccionar_usuario_controlador($_SESSION['tipo_simic']);
            }            
    ?>
<br><br><br><br><br><br><br>
    <div class="container-fluid">
        <div class="certificado">
            <section>
                <p>El Señor (a) <strong> <?php echo $campos['MiemApellidos']; ?> <?php echo $campos['MiemNombres']; ?> </strong>, identificado con el documento de identidad No. <strong><?php echo $campos['MiemDNI']; ?></strong> se encuentra registrado en la base de datos de la iglesia desde el <strong><?php echo $campos['MiemFechaConversion']; ?></strong> y su estado actual es el de <strong><?php echo $campos['MiemEstado']; ?></strong> teniendo como fecha de retiro como miembro de la iglesia desde el <strong><?php echo $campos['MiemRetiroIglesia']; ?></strong>; tiempo durante el cual se ha mostrado como una persona confiable, creyente a la Palabra de Dios, cumplidor (a) con los principios biblicos, diezmador (a), ofrendador (a).</p><br>
            </section>

            <section>
                <p>Agradecemos la atención prestada.</p><br>
                <p>Para constancia se firma el presente certificado el <strong><?php echo date("d-m-Y");?></strong>, en la ciudad de Bogota.</p><br><br><br>
            </section>

            <section>
                <p class="firma">Carlos Arturo Avendaño Pardo</p>
                <p>C.C. No. 3015591 de Fómeque</p>
                <p>Pastor-Presidente-Fundador</p>
                <p>Cel. 3135845628</p>
            </section>

        </div>

    </div>

</div>

<p class="text-center" style="margin-top: 20px;">                    
    <a href="javascript:genPDF()" type="submit" class="btn btn-info btn-raised btn-sm"><i class="zmdi zmdi-print"></i> GENERAR PDF </a>
    <a href="<?php echo SERVERURL; ?>memberlist/" class="btn btn-info btn-raised btn-sm">
        <i class="zmdi zmdi-folder-outline"></i> &nbsp; REPORTES </a>
</p>
<br><br><br>

<?php }else{ ?>
    <div class="alert alert-dismissible alert-warning text-center">
        <button type="button" class="close" data-dismiss="alert">x</button>
        <i class="zmdi zmdi-alert-triangle zmdi-hc-5x"></i>
        <h2>¡Lo sentimos!</h2>
        <h3>No podemos Mostrar la información del Miembro en este momento.</h3>
    </div>
<?php } ?>
