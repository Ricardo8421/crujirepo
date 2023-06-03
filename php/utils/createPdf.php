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

    //Carga el contenido de la variable html al objeto dompdf
    $dompdf->loadHtml($html);
    //Renderiza el pdf
    $dompdf->render();

    $nombreArchivo = 'datosIngresados.pdf';
    $dompdf->stream($nombreArchivo, ['Attachment' => true]);
    //Manda llamar a la funcion downloadPdf
    
}
?>