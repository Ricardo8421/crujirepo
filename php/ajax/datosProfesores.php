<?php
include "../utils/conexion.php";

header('Content-type: application/json; charset=UTF-8');

$query =
    "SELECT 
		u.id AS IdUsuario, 
		p.id AS Matricula, 
		p.nombreCompleto AS NombreCompleto,
		d.clave AS ClaveDepartamento,
		d.nombre AS Departamento,
		p.accesoCongelado AS AccesoCongelado,
        COUNT(arg.idActividad) > 1 AS HaContestado
    FROM (profesor p LEFT OUTER JOIN actividadregistrada arg ON p.id=arg.idProfesor), usuario u, departamento d
    WHERE p.idUsuario = u.id AND p.departamento = d.clave
    GROUP BY Matricula
    ORDER BY NombreCompleto";

$result = $mysql->query($query);

if ($result->num_rows > 0) {
    $json = "[";
    
    while ($row = $result->fetch_assoc()) {
        $json = $json.json_encode($row, JSON_UNESCAPED_UNICODE).",";
    }

    $json = substr($json, 0, -1);
    $json = $json."]";
}

echo $json;
?>