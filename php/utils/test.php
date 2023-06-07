<?php
require 'createPdf.php';

$jsonData = array(
    'NombreCompleto' => 'Jose Monroy',
    'Matricula' => '123456',
    'Departamento' => 'Inteligencia Artificial',
    'Materias' => array(
        'materia1' => array(
            'Materia' => 'Materia 1',
            'Academia' => 'Academia 1',
        ),
        'materia2' => array(
            'Materia' => 'Materia 2',
            'Academia' => 'Academia 2',
        ),
        'materia3' => array(
            'Materia' => 'Materia 3',
            'Academia' => 'Academia 3',
        )
    ),

    'Actividades' => array(
        'actividad1' => array(
            'Actividad' => 'Actividad 1',
            'Horas' => '10',
        ),
        'actividad2' => array(
            'Actividad' => 'Si la vaca vive entonces no esta muerta',
            'Horas' => '20',
        ),
        'actividad3' => array(
            'Actividad' => 'Actividad 3',
            'Horas' => '30',
        )
        )
);

//manda llamar a la funcion json_encode para convertir el array en un json
$json = json_encode($jsonData);

//manda llamar a la funcion createPdf qye se encuentra en createPdf.php y le pasa el json
createPdfProfesor($json);

?>