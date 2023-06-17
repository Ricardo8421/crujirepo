<?php
require('../../libraries/fpdf185/fpdf.php');

if(isset($_GET['json'])){
    $json = $_GET['json'];

    $jsonData = json_decode($json, true);

    class PDF extends FPDF {
        function Header() {
            // Establecer fondo
            $this->SetFillColor(27, 99, 149);
            $this->Rect(0, 0, $this->GetPageWidth(), 50, 'F');
    
            // Texto en color blanco
            $this->SetTextColor(255, 255, 255);
    
            $this->SetFont('Arial', 'B', 20);
            $this->Cell(0, -10, 'Materias por academia', 0, 1, 'C');

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
            $this->Cell(0, 15, 'Pagina ' . $this->PageNo() . ' de {nb}', 0, 0, 'C');
        }
        function SetStartingPosition() {
            $this->SetY(60);
        }
        function AddPage($orientation='', $size='', $rotation=0) {
            parent::AddPage($orientation, $size, $rotation);
            if (!is_null(60)) {
                $this->SetY(60);
            }
        }
    }
    $nombre = utf8_decode($jsonData['NombreAcademia']);
    $materias = $jsonData['Materias'];

    $pdf = new PDF('P', 'mm', 'Letter');
    $pdf->SetMargins(10, 30, 10); // Establecer los márgenes (izquierdo, superior, derecho)
    $pdf->SetAutoPageBreak(true, 20); // Habilitar el salto automático de página con un margen inferior de 20
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetStartingPosition();

    // Definir fuentes
    $pdf->SetFont('Arial', '', 12);

    $pdf->Cell(0, 0, '', 0, 1); // Espacio en blanco para separar del header

    $pdf->Cell(50, 10, 'Academia:', 0, 0, 'L');
    $pdf->Cell(0, 10, $nombre, 0, 1, 'L');
    // Línea horizontal
    $pdf->SetDrawColor(27, 99, 149); // Establecer color de línea en azul
    $pdf->SetLineWidth(1); // Establecer grosor de línea en 1.5
    $pdf->Cell(0, 0, '', 'T');

    foreach ($materias as $materia) {
        // Encabezado de Materias seleccionadas
        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, utf8_decode($materia['NombreMateria']) , 0, 1, 'C');
        $pdf->SetLineWidth(0);

        $maxLongitudNombre = 0;
        $maxLongitudProfesores = 0;
    
        // Iterar sobre las materias y encontrar la longitud máxima para el nombre y la academia
        $profesores = $materia['Profesores'];
    
        foreach ($profesores as $profesor) {
            $longitudNombre = strlen($profesor['NombreCompleto']);
            $longitudProfesores = strlen($profesor['Departamento']);
            if ($longitudNombre > $maxLongitudNombre) {
                $maxLongitudNombre = $longitudNombre;
            }
            if ($longitudProfesores > $maxLongitudProfesores) {
                $maxLongitudProfesores = $longitudProfesores;
            }
        }
        
        $celdaNombres = $maxLongitudNombre * 2.5;
        $celdaAcademia = $maxLongitudProfesores * 2.5;

        $celdaNombres = ($celdaNombres < 50) ? 45 : $celdaNombres;
        $celdaAcademia = ($celdaAcademia < 50) ? 45 : $celdaAcademia;

        $cellWidth = array(25, $celdaNombres, $celdaAcademia); // Definir el ancho de las celdas
    
        $x = ($pdf->GetPageWidth() - array_sum($cellWidth)) / 2;
    
    
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetTextColor(0, 0, 0);
        // Tabla de Materias seleccionadas

        $pdf->SetX($x);
        // Encabezados de la tabla
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetFillColor(27, 99, 149);
        $pdf->SetTextColor(255, 255, 255);
    
        $pdf->Cell($cellWidth[0], 10, 'Matricula', 1, 0, 'C', true);
        $pdf->Cell($cellWidth[1], 10, 'Nombre Completo', 1, 0, 'C', true);
        $pdf->Cell($cellWidth[2], 10, 'Departamento', 1, 1, 'C', true);

        
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetTextColor(0, 0, 0);
        

        foreach ($profesores as $profesor) {
            $pdf->SetX($x);
            $pdf->Cell($cellWidth[0], 10, utf8_decode($profesor['Matricula']), 1, 0, 'C');
            $pdf->Cell($cellWidth[1], 10, utf8_decode($profesor['NombreCompleto']) , 1, 0, 'C');
            $pdf->Cell($cellWidth[2], 10, utf8_decode($profesor['Departamento']), 1, 1, 'C');
        }

    }

    $pdf->Ln(10); // Espacio adicional después de la tabla

    $NombrePDF = 'ResumenAcademia' . $nombre . '.pdf';

    $pdf->Output('D', $NombrePDF);
}
else {
    echo 'No se recibieron datos';
}
?>