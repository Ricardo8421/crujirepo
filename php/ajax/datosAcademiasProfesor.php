<?php
include "../utils/conexion.php";

header('Content-type: application/json; charset=UTF-8');

$b = false;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = sprintf("SELECT academia.nombre AS NombreAcademia, materia.Nombre AS NombreMateria, profesor.nombreCompleto AS NombreProfesor, departamento.nombre AS Departamento FROM profesor 
                    JOIN materiaregistradas ON profesor.id = materiaregistradas.idProfesor
                    JOIN materia ON materiaregistradas.idMateria = materia.clave
                    JOIN academia ON materia.academia = academia.Id
                    JOIN departamento ON profesor.departamento = departamento.clave
                    WHERE academia.id='%s';",
        $mysql->real_escape_string($id));
    $res = $mysql->query($query);
    if ($res->num_rows > 0) {
        $b = true;
        $result = array();
        
        while ($row = $res->fetch_assoc()) {
            $academia = $row['NombreAcademia'];
            $materia = $row['NombreMateria'];
            $profesor = $row['NombreProfesor'];
            $departamento = $row['Departamento'];
            
            if (!isset($result['Academia'])) {
                $result['Academia'] = $academia;
            }
            
            if (!isset($result['Materias'])) {
                $result['Materias'] = array();
            }
            
            if (!isset($result['Materias']['Materia'])) {
                $result['Materias']['Materia'] = array();
            }
            
            if (!isset($result['Materias']['Materia']['Profesores'])) {
                $result['Materias']['Materia']['Profesores'] = array();
            }
            
            $result['Materias']['Materia'][] = array(
                'Nombre' => $materia,
                'Profesores' => array(
                    'Profesores' => array(
                        array(
                            'NombreCompleto' => $profesor,
                            'Departamento' => $departamento
                        )
                    )
                )
            );
        }
        
        $json = json_encode($result, JSON_UNESCAPED_UNICODE);
    }
}

if (!$b) {
    $result = array(
        'Academia' => '',
        'Materias' => array()
    );
    
    $json = json_encode($result, JSON_UNESCAPED_UNICODE);
}

echo $json;
?>
