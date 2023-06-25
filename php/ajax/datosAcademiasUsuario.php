<?php
include "../utils/conexion.php";

header('Content-type: application/json; charset=UTF-8');
session_start();    

$usuario = $_SESSION["usuario"];
$query = sprintf(
    "SELECT
		p.nombreCompleto,
		GROUP_CONCAT(a.nombre SEPARATOR ',') AS academias
	FROM
		Profesor p 
		INNER JOIN Departamento d
		ON p.departamento = d.clave
		INNER JOIN Academia a
		ON a.departamento = d.clave
	WHERE p.id = '%s'
	GROUP BY p.nombreCompleto;",
    $mysql->real_escape_string($usuario)
);

$result = $mysql->query($query);

if($result->num_rows > 0){
    $json = "[";
    while ($row = $result->fetch_assoc()) {
        $json = $json.json_encode($row, JSON_UNESCAPED_UNICODE).",";
    }
    $json = substr($json, 0, -1);
    $json = $json . "]";
}

echo $json;

?>