<?php
require('../../libraries/fpdf185/fpdf.php');

$json = $_GET['json'];

// Decodificar el JSON
$data = json_decode($json, true);

    class PDF extends FPDF {
        function Header() {
            // Establecer fondo
            $this->SetFillColor(27, 99, 149);
            $this->Rect(0, 0, $this->GetPageWidth(), 50, 'F');
    
            // Texto en color blanco
            $this->SetTextColor(255, 255, 255);
    
            $this->SetFont('Arial', 'B', 20);
            $this->Cell(0, 20, 'Datos personales', 0, 1, 'C');

            $requestUri = $_SERVER['REQUEST_URI'];
            $imagenIpn = '/assets/Ipn.png';
            $imagenEscom = '/assets/Escom.png';

            $pattern = '#^\/([^\/]+)#';
            preg_match($pattern, $requestUri, $matches);
            $result = $matches[1];
            $imgIpn = 'http://localhost/' . $result . $imagenIpn;
            $imgEscom = 'http://localhost/' . $result . $imagenEscom;
            
            // Logo IPN
            $this->Image($imgIpn, 10, 10, 40, 0, 'PNG');
            // Logo ESCOM
            $this->Image($imgEscom, $this->GetPageWidth() - 50, 10, 40, 0, 'PNG');
        }
    
        function Footer() {
            // Establecer fondo del footer
            $this->SetFillColor(27, 99, 149);
            $this->Rect(0, $this->GetPageHeight() - 20, $this->GetPageWidth(), 20, 'F');
    
            // Texto en color blanco
            $this->SetTextColor(255, 255, 255);
    
            $this->SetY(-15);
            $this->SetFont('Arial', 'I', 10 );
            $this->Cell(0, 10, '"La tecnica al servicio de la patria"', 0, 0, 'C');
        }
    }

    $jsonData = json_decode($json,true);
    $nombreCompleto = $jsonData['NombreCompleto'];
    $nombreCompleto = utf8_decode($nombreCompleto);
    $numeroEmpleado = $jsonData['Matricula'];
    $departamento = $jsonData['Departamento'];
    $departamento = utf8_decode($departamento);

    $pdf = new PDF('P', 'mm', 'Letter');
    $pdf->AliasNbPages();
    $pdf->AddPage();

    // Definir fuentes
    $pdf->SetFont('Arial', '', 12, 'UTF-8');

    // Tabla de información personal
    $paddingTop = 20; // Espacio superior deseado

    $pdf->Cell(0, 0, '', 0, 1); // Espacio en blanco para separar del header

    $pdf->SetY($pdf->GetY() + $paddingTop); // Ajustar la posición vertical
    $pdf->Cell(50, 10, 'Nombre Completo:', 0, 0, 'L');
    $pdf->Cell(0, 10, $nombreCompleto, 0, 1, 'L');

    $pdf->Cell(50, 10, 'Numero de empleado:', 0, 0, 'L');
    $pdf->Cell(0, 10, $numeroEmpleado, 0, 1, 'L');

    $pdf->Cell(50, 10, 'Departamento:', 0, 0, 'L');
    $pdf->Cell(0, 10, $departamento, 0, 1, 'L');

    // Línea horizontal
    $pdf->SetDrawColor(27, 99, 149); // Establecer color de línea en azul
    $pdf->SetLineWidth(1); // Establecer grosor de línea en 1.5
    $pdf->Cell(0, 0, '', 'T');

    // Salida del PDF
    $pdf->Output('datosIngresados.pdf', 'D'); // Descargar el PDF con el nombre "archivo.pdf"
    //$pdf->Output('datosIngresados.pdf', 'I'); // Mostrar el PDF en el navegador
?>
