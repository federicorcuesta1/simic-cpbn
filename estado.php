<?php
    require('./lib/fpdf182/fpdf.php');

    class PDF extends FPDF{
        // Cabecera de página
        function Header(){
            $html="Iglesia Cristiana";
            $html1='Colombia Puerta de Bendición para las Naciones';
            $html2="Nit. 800123456-1";
            // Logo
            $this->Image('./vistas/assets/img/logo5x5.png',10,8,33);
            // Arial bold 15
            $this->SetFont('Arial','B',12);
            // Movernos a la derecha
            $this->Cell(220);
            // Título
            $this->Cell(70,10, utf8_decode($html),0,0,'L');
            $this->SetFont('Helvetica','B',15);
            // Movernos a la derecha
            $this->Cell(10);
            // Título
            $this->Cell(-215,30, utf8_decode($html1),0,0,'C');
            $this->SetFont('Arial','I',12);
            // Movernos a la derecha
            $this->Cell(135);
            // Título
            $this->Cell(70,50, utf8_decode($html2),0,0,'L');        
            // Salto de línea
            $this->Ln(40);

            $this->SetFont('Helvetica','B',12);
            $this->Cell(50,10,utf8_decode('NOMBRES'),1,0,'C',0);
            $this->Cell(40,10,utf8_decode('APELLIDOS'),1,0,'C',0);
            $this->Cell(40,10,utf8_decode('DOCUMENTO'),1,0,'C',0);
            $this->Cell(20,10,utf8_decode('ESTADO'),1,1,'C',0);        
        }

        // Pie de página
        function Footer(){
            // Posición: a 1,5 cm del final
            $this->SetY(-15);
            // Arial italic 8
            $this->SetFont('Arial','I',8);
            // Número de página
            $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
        }
    }

    require "./cn.php";
    $consulta="SELECT * FROM miembros WHERE MiemEstado='Activo'";
    $resultado=$mysqli->query($consulta);


    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage('L', 'Letter');
    $pdf->SetFont('Arial','',10);

        while($row=$resultado->fetch_assoc()){
            $pdf->Cell(50,10,utf8_decode($row['MiemNombres']),1,0,'C',0);
            $pdf->Cell(40,10,utf8_decode($row['MiemApellidos']),1,0,'C',0);
            $pdf->Cell(40,10,utf8_decode($row['MiemDNI']),1,0,'C',0);
            $pdf->Cell(20,10,utf8_decode($row['MiemEstado']),1,1,'C',0);
        }
    $pdf->Output('I','Reporte.pdf',false); //reemplazar la I por D
?>