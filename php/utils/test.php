<?php
require 'createPdf.php';


$jsonData = array(
    'nombreCompleto' => 'Jose Monroy',
    'numeroEmpleado' => '123456',
    'departamento' => 'Inteligencia Artificial'
);

//manda llamar a la funcion json_encode para convertir el array en un json
$json = json_encode($jsonData);

//manda llamar a la funcion createPdf qye se encuentra en createPdf.php y le pasa el json
createPdf($json);

?>