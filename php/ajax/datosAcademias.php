<?php
include "../utils/conexion.php";

header('Content-type: application/json; charset=UTF-8');

$query = 
	"SELECT
		a.id AS Id,
		d.clave AS ClaveDepartamento,
		d.nombre AS Departamento,
		a.nombre AS Academia
	FROM academia a, departamento d
	WHERE a.departamento = d.clave
	ORDER BY Academia";

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