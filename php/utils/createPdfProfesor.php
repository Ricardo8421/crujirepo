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
    $materias = $jsonData['Materias'];
    $actividades = $jsonData['Actividades'];
    $masMaterias = $jsonData['MasMaterias'];

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

    if ($masMaterias == '1') {
        $pdf->SetTextColor(27, 99, 149);
        $pdf->SetFont('Arial', 'B', 12); // Establecer la fuente en Arial, estilo negritas, tamaño 12
        $pdf->Cell(50, 10, 'Con disposicion para impartir mas materias', 0, 0, 'L');
        $pdf->SetTextColor(0, 0, 0); // Restaurar el color de texto original (negro)
        $pdf->SetFont('Arial', '', 12); // Restaurar la fuente original (sin negritas)
        $pdf->Cell(0, 10, '', 0, 1, 'L');
    }
    

    // Línea horizontal
    $pdf->SetDrawColor(27, 99, 149); // Establecer color de línea en azul
    $pdf->SetLineWidth(1); // Establecer grosor de línea en 1.5
    $pdf->Cell(0, 0, '', 'T');

    // Encabezado de Materias seleccionadas
    $pdf->Ln(10);
    $pdf->SetLineWidth(0);
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, 'Materias seleccionadas', 0, 1, 'C');

    // Tabla de Materias seleccionadas

    $pdf->SetFont('Arial', '', 12);
    $pdf->SetFillColor(255, 255, 255);
    $pdf->SetTextColor(0, 0, 0);

    $maxLongitudNombre = 0;
    $maxLongitudAcademia = 0;

    // Iterar sobre las materias y encontrar la longitud máxima para el nombre y la academia
    foreach ($materias as $materia) {
        $longitudNombre = strlen($materia['Materia']);
        $longitudAcademia = strlen($materia['Academia']);

        if ($longitudNombre > $maxLongitudNombre) {
            $maxLongitudNombre = $longitudNombre;
        }

        if ($longitudAcademia > $maxLongitudAcademia) {
            $maxLongitudAcademia = $longitudAcademia;
        }
    }

    $celdaMaterias = $maxLongitudNombre * 2;
    $celdaAcademia = $maxLongitudAcademia * 2;
    $celdaMaterias = ($celdaMaterias > 100) ? 100 : $celdaMaterias;

    $cellWidth = array(25, $celdaMaterias, $celdaAcademia); // Definir el ancho de las celdas

    $x = ($pdf->GetPageWidth() - array_sum($cellWidth)) / 2;
    $x = ($x > 0) ? $x : 4;

    $pdf->SetX($x);
    // Encabezados de la tabla
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetFillColor(27, 99, 149);
    $pdf->SetTextColor(255, 255, 255);

    $pdf->Cell($cellWidth[0], 10, 'Clave', 1, 0, 'C', true);
    $pdf->Cell($cellWidth[1], 10, 'Nombre', 1, 0, 'C', true);
    $pdf->Cell($cellWidth[2], 10, 'Academia', 1, 1, 'C', true);

    $pdf->SetFont('Arial', '', 12);
    $pdf->SetFillColor(255, 255, 255);
    $pdf->SetTextColor(0, 0, 0);

    foreach ($materias as $materia) {
        $pdf->SetX($x);

        // Mostrar el número de materia
        $pdf->SetFont('Arial', '', 10); // Restablecer fuente y tamaño normal
        $pdf->Cell($cellWidth[0], 10, utf8_decode($materia['Clave']), 1, 0, 'C', true);
    
        // Mostrar el nombre de la materia en varias líneas
        $pdf->Cell($cellWidth[1], 10, utf8_decode($materia['Materia']), 1, 0, 'C', true);

        // Mostrar el nombre de la academia
        $pdf->Cell($cellWidth[2], 10, utf8_decode($materia['Academia']), 1, 1, 'C', true);


    }

    $pdf->Ln(10); // Espacio adicional después de la tabla

    // Encabezado de Materias seleccionadas
    $pdf->Ln(10);
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, 'Actividades seleccionadas', 0, 1, 'C');
    // Tabla de Actividades seleccionadas
    $pdf->SetFont('Arial', '', 12);
    $pdf->SetFillColor(255, 255, 255);
    $pdf->SetTextColor(0, 0, 0);

    $maxLongitudNombre = 0;

    foreach ($actividades as $actividad) {
        $nombre = $actividad['Actividad'];
        $longitudNombre = strlen($nombre);
        if ($longitudNombre > $maxLongitudNombre) {
            $maxLongitudNombre = $longitudNombre;
        }
    }

    $numeroActividad = 1; // Variable para almacenar el número de materia

    $celdaActividades = $maxLongitudNombre * 2.0;

    $celdaActividades = ($celdaActividades > 100) ? 100 : $celdaActividades;

    $cellWidth = array(15, $celdaActividades, 20); // Definir el ancho de las celdas
    

    $x = ($pdf->GetPageWidth() - array_sum($cellWidth)) / 2;
    $x = ($x > 0) ? $x : 4;


    $pdf->SetX($x);
    // Encabezados de la tabla
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetFillColor(27, 99, 149);
    $pdf->SetTextColor(255, 255, 255);

    $pdf->Cell($cellWidth[0], 10, 'No.', 1, 0, 'C', true);
    $pdf->Cell($cellWidth[1], 10, 'Actividad', 1, 0, 'C', true);
    $pdf->Cell($cellWidth[2], 10, 'Hrs', 1, 1, 'C', true);

    $pdf->SetFont('Arial', '', 12);
    $pdf->SetFillColor(255, 255, 255);
    $pdf->SetTextColor(0, 0, 0);

    foreach ($actividades as $actividad) {
        $pdf->SetX($x);

        // Mostrar el número de materia
        $pdf->SetFont('Arial', '', 10); // Restablecer fuente y tamaño normal
        $pdf->Cell($cellWidth[0], 10, $numeroActividad, 1, 0, 'C', true);

        // Mostrar el nombre de la materia en varias líneas
        $pdf->Cell($cellWidth[1], 10, utf8_decode($actividad['Actividad']), 1, 0, 'C', true);

        // Mostrar el nombre de la academia
        $pdf->Cell($cellWidth[2], 10, utf8_decode($actividad['Horas']), 1, 1, 'C', true);

        $numeroActividad++; // Incrementar el número de materia en cada iteración
    }

    // Salida del PDF
    $pdf->Output('comprobanteEncuesta.pdf', 'D'); // Descargar el PDF con el nombre "archivo.pdf"
    //$pdf->Output('datosIngresados.pdf', 'I'); // Mostrar el PDF en el navegador
?>
