<?php
include "../utils/conexion.php";

header('Content-type: application/json; charset=UTF-8');

$b = false;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = sprintf("SELECT academia.nombre AS NombreAcademia, materia.Nombre AS NombreMateria, profesor.nombreCompleto AS NombreProfesor, profesor.departamento AS Departamento, profesor.id AS Matricula FROM profesor 
                    JOIN materiaregistradas ON profesor.id = materiaregistradas.idProfesor
                    JOIN materia ON materiaregistradas.idMateria = materia.clave
                    JOIN academia ON materia.academia = academia.Id
                    JOIN departamento ON profesor.departamento  = departamento.clave
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
            $matricula = $row['Matricula'];
            
            if (!isset($result['NombreAcademia'])) {
                $result['NombreAcademia'] = $academia;
            }
            
            if (!isset($result['Materias'])) {
                $result['Materias'] = array();
            }
            
            if (!isset($result['Materias'][$materia])) {
                $result['Materias'][$materia] = array();
                $result['Materias'][$materia]['NombreMateria'] = $materia;
                $result['Materias'][$materia]['Profesores'] = array();
            }
            
            $result['Materias'][$materia]['Profesores'][] = array(
                'NombreCompleto' => $profesor,
                'Matricula' => $matricula,
                'Departamento' => $departamento
            );
        }
        
        $json = json_encode($result, JSON_UNESCAPED_UNICODE);
    }

}

if (!$b) {
    $result = array(
        'NombreAcademia' => '',
        'Materias' => array()
    );
    
    $json = json_encode($result, JSON_UNESCAPED_UNICODE);
}

echo $json;
?>
