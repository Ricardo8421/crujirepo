<?php
require_once '../../libraries/dompdf/autoload.inc.php';

use Dompdf\Dompdf;
use Dompdf\Options;

function createPdf($json){

    $options = new Options();
    $options->set('isRemoteEnabled', TRUE);
    $options->set('defaultFont', 'Courier');
    $options->set('isHtml5ParserEnabled', TRUE);
    $options->set('isPhpEnabled', TRUE);
    $options->set('isJavascriptEnabled', TRUE);
    $options->set('isFontSubsettingEnabled', TRUE);


    //Crea un objeto de la clase Dompdf
    $dompdf = new Dompdf($options);
    //Crea una variable con el contenido del archivo plantillaPdf.php
    $html = file_get_contents('plantillaPdf.php');
    //Decodifica el json y lo convierte en un array
    $data = json_decode($json, true);

    //Obtiene los valores del array
    $nombreCompleto = $data['nombreCompleto'];
    $numeroEmpleado = $data['numeroEmpleado'];
    $departamento = $data['departamento'];

    //Reemplaza los valores de la plantilla con los valores del array
    $html = str_replace("{{ \$nombreCompleto }}", $nombreCompleto, $html);
    $html = str_replace("{{ \$numeroEmpleado }}", $numeroEmpleado, $html);
    $html = str_replace("{{ \$departamento }}", $departamento, $html);

    $materias = $data['materias'];

    $cantidadMaterias = count($materias);

    for ($i = 0 ; $i < $cantidadMaterias ; $i++){
        $materia = $materias['materia'.($i+1)];
        $nimbre = $materia['nombre'];
        $academia = $materia['academia'];
        $html = str_replace("{{ \$materia".($i+1)." }}", ($i+1), $html);
        $html = str_replace("{{ \$nombreM".($i+1)." }}", $nimbre, $html);
        $html = str_replace("{{ \$academiaM".($i+1)." }}", $academia, $html);
    }
    if ($cantidadMaterias < 4){
        for ($i = $cantidadMaterias ; $i < 4 ; $i++){
            $html = str_replace("{{ \$materia".($i+1)." }}", "", $html);
            $html = str_replace("{{ \$nombreM".($i+1)." }}", "", $html);
            $html = str_replace("{{ \$academiaM".($i+1)." }}", "", $html);
        }
    }

    $actividades = $data['actividades'];

    $cantidadActividades = count($actividades);

    for ($i = 0 ; $i < $cantidadActividades ; $i++){
        $actividad = $actividades['actividad'.($i+1)];
        $nombre = $actividad['nombre'];
        $horas = $actividad['horas'];
        $html = str_replace("{{ \$actividad".($i+1)." }}", ($i+1), $html);
        $html = str_replace("{{ \$nombreA".($i+1)." }}", $nombre, $html);
        $html = str_replace("{{ \$horasA".($i+1)." }}", $horas, $html);
    }
    if ($cantidadActividades < 5){
        for ($i = $cantidadActividades ; $i < 5 ; $i++){
            $html = str_replace("{{ \$actividad".($i+1)." }}", "", $html);
            $html = str_replace("{{ \$nombreA".($i+1)." }}", "", $html);
            $html = str_replace("{{ \$horasA".($i+1)." }}", "", $html);
        }
    }


    //Carga el contenido de la variable html al objeto dompdf
    $dompdf->loadHtml($html);
    //Renderiza el pdf
    $dompdf->render();

    $nombreArchivo = 'datosIngresados.pdf';
    $dompdf->stream($nombreArchivo, ['Attachment' => true]);
    
}
?>