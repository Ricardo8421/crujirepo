<?php
require 'createPdf.php';

$jsonData = array(
    'nombreCompleto' => 'Jose Monroy',
    'numeroEmpleado' => '123456',
    'departamento' => 'Inteligencia Artificial',
    'materias' => array(
        'materia1' => array(
            'nombre' => 'Materia 1',
            'academia' => 'Academia 1',
        ),
        'materia2' => array(
            'nombre' => 'Materia 2',
            'academia' => 'Academia 2',
        ),
        'materia3' => array(
            'nombre' => 'Materia 3',
            'academia' => 'Academia 3',
        )
    ),

    'actividades' => array(
        'actividad1' => array(
            'nombre' => 'Actividad 1',
            'horas' => '10',
        ),
        'actividad2' => array(
            'nombre' => 'Actividad 2',
            'horas' => '20',
        ),
        'actividad3' => array(
            'nombre' => 'Actividad 3',
            'horas' => '30',
        )
        )
);

//manda llamar a la funcion json_encode para convertir el array en un json
$json = json_encode($jsonData);

//manda llamar a la funcion createPdf qye se encuentra en createPdf.php y le pasa el json
createPdfProfesor($json);

?>