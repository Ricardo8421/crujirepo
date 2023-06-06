<?php
require('../../libraries/fpdf185/fpdf.php');

function createPdfProfesor($jsonData){

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

    $jsonData = json_decode($jsonData);
    $nombreCompleto = $jsonData->nombreCompleto;
    $numeroEmpleado = $jsonData->numeroEmpleado;
    $departamento = $jsonData->departamento;
    $materias = $jsonData->materias;
    $actividades = $jsonData->actividades;

    $pdf = new PDF('P', 'mm', 'Letter');
    $pdf->AliasNbPages();
    $pdf->AddPage();

    // Definir fuentes
    $pdf->SetFont('Arial', '', 12);

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
    $pdf->Cell(0, 0, '', 'T');

    // Encabezado de Materias seleccionadas
    $pdf->Ln(10);
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
        $nombre = $materia->nombre;
        $longitudNombre = strlen($nombre);
        $longitudAcademia = strlen($materia->academia);

        if ($longitudNombre > $maxLongitudNombre) {
            $maxLongitudNombre = $longitudNombre;
        }

        if ($longitudAcademia > $maxLongitudAcademia) {
            $maxLongitudAcademia = $longitudAcademia;
        }
    }

    $numeroMateria = 1; // Variable para almacenar el número de materia

    // Variables para definir la posición y el tamaño de las celdas
    // Iterar sobre las materias y mostrar los datos actualizados en la tabla
    
    $celdaMaterias = $maxLongitudNombre * 2.5;
    $celdaAcademia = $maxLongitudAcademia * 2.5;
    
    $cellWidth = array(15, $celdaMaterias, $celdaAcademia); // Definir el ancho de las celdas

    $x = ($pdf->GetPageWidth() - array_sum($cellWidth)) / 2;

    $pdf->SetX($x);
    // Encabezados de la tabla
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetFillColor(27, 99, 149);
    $pdf->SetTextColor(255, 255, 255);

    $pdf->Cell($cellWidth[0], 10, 'No.', 1, 0, 'C', true);
    $pdf->Cell($cellWidth[1], 10, 'Nombre', 1, 0, 'C', true);
    $pdf->Cell($cellWidth[2], 10, 'Academia', 1, 1, 'C', true);

    $pdf->SetFont('Arial', '', 12);
    $pdf->SetFillColor(255, 255, 255);
    $pdf->SetTextColor(0, 0, 0);

    foreach ($materias as $materia) {
        $pdf->SetX($x);

        // Mostrar el número de materia
        $pdf->SetFont('Arial', '', 10); // Restablecer fuente y tamaño normal
        $pdf->Cell($cellWidth[0], 10, $numeroMateria, 1, 0, 'C', true);

        // Mostrar el nombre de la materia en varias líneas
        $pdf->Cell($cellWidth[1], 10, $materia->nombre, 1, 0, 'C', true);

        // Mostrar el nombre de la academia
        $pdf->Cell($cellWidth[2], 10, $materia->academia, 1, 1, 'C', true);

        $numeroMateria++; // Incrementar el número de materia en cada iteración
    }

    $pdf->Ln(10); // Espacio adicional después de la tabla

    // Encabezado de Materias seleccionadas
    $pdf->Ln(10);
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, 'Materias seleccionadas', 0, 1, 'C');
    // Tabla de Actividades seleccionadas
    $pdf->SetFont('Arial', '', 12);
    $pdf->SetFillColor(255, 255, 255);
    $pdf->SetTextColor(0, 0, 0);

    $maxLongitudNombre = 0;

    foreach ($actividades as $actividad) {
        $nombre = $actividad->nombre;
        $longitudNombre = strlen($nombre);
        if ($longitudNombre > $maxLongitudNombre) {
            $maxLongitudNombre = $longitudNombre;
        }
    }

    $numeroActividad = 1; // Variable para almacenar el número de materia

    $celdaActividades = $maxLongitudNombre * 2.0;
    
    $cellWidth = array(15, $celdaActividades, 20); // Definir el ancho de las celdas

    $x = ($pdf->GetPageWidth() - array_sum($cellWidth)) / 2;

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
        $pdf->Cell($cellWidth[1], 10, $actividad->nombre, 1, 0, 'C', true);

        // Mostrar el nombre de la academia
        $pdf->Cell($cellWidth[2], 10, $actividad->horas, 1, 1, 'C', true);

        $numeroActividad++; // Incrementar el número de materia en cada iteración
    }

    // Salida del PDF
    $pdf->Output('datosIngresados.pdf', 'D'); // Descargar el PDF con el nombre "archivo.pdf"
}

?>
