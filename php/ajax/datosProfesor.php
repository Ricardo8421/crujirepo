<?php
include "../utils/conexion.php";

header('Content-type: application/json; charset=UTF-8');

session_start();    

$usuario = $_SESSION["usuario"];

$query = sprintf(
    "SELECT 
		u.id AS IdUsuario, 
		p.id AS Matricula, 
		p.nombreCompleto AS NombreCompleto,
		d.clave AS ClaveDepartamento,
		d.nombre AS Departamento,
		p.accesoCongelado AS AccesoCongelado
    FROM profesor p, usuario u, departamento d
    WHERE p.idUsuario = u.id AND p.departamento = d.clave AND
        u.login = '%s'
    ORDER BY NombreCompleto",
    $mysql->real_escape_string($usuario)
);

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