<?php
//require 'createPdfProfesor.php';
require 'createPdfAcademia.php';

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

$jsonData2 = array(
    'Academia' => 'Ciencias Computacionales',
    'Materias' => array(
        'materia1' => array(
            'Materia' => 'Programacion Basica',
            'Profesores' => array(
                'profesor1' => array(
                    'NombreCompleto' => 'Jose Luis Monroy',
                    'Matricula' => '123456',
                    'Departamento' => 'Inteligencia Artificial',
                ),
                'profesor2' => array(
                    'NombreCompleto' => 'Maria Perez',
                    'Matricula' => '654321',
                    'Departamento' => 'Inteligencia Artificial',
                ),
                'profesor3' => array(
                    'NombreCompleto' => 'Juan Lopez',
                    'Matricula' => '456789',
                    'Departamento' => 'Computacion Grafica',
                )
            )
        ),
        'materia2' => array(
            'Materia' => 'Programacion Orientada a Objetos y Patrones de Diseno',
            'Profesores' => array(
                'profesor1' => array(
                    'NombreCompleto' => 'Jose Monroy',
                    'Matricula' => '123456',
                    'Departamento' => 'Sistemas Distribuidos',
                ),
                'profesor3' => array(
                    'NombreCompleto' => 'Juan Lopez',
                    'Matricula' => '456789',
                    'Departamento' => 'Computacion Grafica',
                )
            )
        ),
        'materia3' => array(
            'Materia' => 'Estructura de Datos',
            'Profesores' => array(
                'profesor1' => array(
                    'NombreCompleto' => 'Jose Monroy',
                    'Matricula' => '123456',
                    'Departamento' => 'Sistemas Distribuidos',
                ),
                'profesor2' => array(
                    'NombreCompleto' => 'Maria Perez',
                    'Matricula' => '654321',
                    'Departamento' => 'Inteligencia Artificial',
                ),
                'profesor3' => array(
                    'NombreCompleto' => 'Juan Lopez',
                    'Matricula' => '456789',
                    'Departamento' => 'Computacion Grafica',
                ),
                'profesor4' => array(
                    'NombreCompleto' => 'Pedro Sanchez',
                    'Matricula' => '987654',
                    'Departamento' => 'Sistemas Distribuidos',
                ),
                'profesor5' => array(
                    'NombreCompleto' => 'Maria Lopez',
                    'Matricula' => '456123',
                    'Departamento' => 'Inteligencia Artificial',
                ),
                'profesor6' => array(
                    'NombreCompleto' => 'Juan Perez',
                    'Matricula' => '789456',
                    'Departamento' => 'Computacion Grafica',
                ),
                'profesor7' => array(
                    'NombreCompleto' => 'Pedro Lopez',
                    'Matricula' => '321654',
                    'Departamento' => 'Sistemas Distribuidos',
                ),
            )
            ),
        'materia4' => array(
            'Materia' => 'Inteligencia Artificial',
            'Profesores' => array (
                'profesor1' => array(
                    'NombreCompleto' => 'Jose Monroy',
                    'Matricula' => '123456',
                    'Departamento' => 'Sistemas Distribuidos',
                ),
                'profesor2' => array(
                    'NombreCompleto' => 'Maria Perez',
                    'Matricula' => '654321',
                    'Departamento' => 'Inteligencia Artificial',
                ),
                'profesor3' => array(
                    'NombreCompleto' => 'Juan Lopez',
                    'Matricula' => '456789',
                    'Departamento' => 'Computacion Grafica',
                ),
                'profesor4' => array(
                    'NombreCompleto' => 'Pedro Sanchez',
                    'Matricula' => '987654',
                    'Departamento' => 'Sistemas Distribuidos',
                ),
                'profesor5' => array(
                    'NombreCompleto' => 'Maria Lopez',
                    'Matricula' => '456123',
                    'Departamento' => 'Inteligencia Artificial',
                ),
                'profesor6' => array(
                    'NombreCompleto' => 'Juan Perez',
                    'Matricula' => '789456',
                    'Departamento' => 'Computacion Grafica',
                ),
                'profesor7' => array(
                    'NombreCompleto' => 'Pedro Lopez',
                    'Matricula' => '321654',
                    'Departamento' => 'Sistemas Distribuidos',
                ),
            )
            ),
        'materia5' => array(
            'Materia' => 'Computacion Grafica',
            'Profesores' => array(
                'profesor1' => array(
                    'NombreCompleto' => 'Jose Monroy',
                    'Matricula' => '123456',
                    'Departamento' => 'Sistemas Distribuidos',
                ),
                'profesor2' => array(
                    'NombreCompleto' => 'Maria Perez',
                    'Matricula' => '654321',
                    'Departamento' => 'Inteligencia Artificial',
                ),
                'profesor3' => array(
                    'NombreCompleto' => 'Juan Lopez',
                    'Matricula' => '456789',
                    'Departamento' => 'Computacion Grafica',
                ),
                'profesor4' => array(
                    'NombreCompleto' => 'Pedro Sanchez',
                    'Matricula' => '987654',
                    'Departamento' => 'Sistemas Distribuidos',
                ),
                'profesor5' => array(
                    'NombreCompleto' => 'Maria Lopez',
                    'Matricula' => '456123',
                    'Departamento' => 'Inteligencia Artificial',
                ),
                'profesor6' => array(
                    'NombreCompleto' => 'Juan Perez',
                    'Matricula' => '789456',
                    'Departamento' => 'Computacion Grafica',
                ),
                'profesor7' => array(
                    'NombreCompleto' => 'Pedro Lopez',
                    'Matricula' => '321654',
                    'Departamento' => 'Sistemas Distribuidos',
                ),
            )
            ),

    )
);

//manda llamar a la funcion json_encode para convertir el array en un json
//$json = json_encode($jsonData);
$json = json_encode($jsonData2);

//manda llamar a la funcion createPdf qye se encuentra en createPdf.php y le pasa el json
//reatePdfProfesor($json);
createPdfAcademia($json);

?>