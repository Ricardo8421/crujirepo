<?php
require_once '../../libraries/dompdf/autoload.inc.php';
echo "Ya jala";

use Dompdf\Dompdf;

$json = obtenerJson();
$data = json_decode($json, true);

//obteneer el html de plantillaPdf.php
ob_start();
include "plantillaPdf.php";
$html = ob_get_clean();



$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->render();

$nombreArchivo = 'datosIngresados.pdf';
$dompdf->stream($nombreArchivo, ['Attachment' => true]);

function obtenerJson()
{
    return '{"nombre": "John Doe", "edad": 30}';
}
?>