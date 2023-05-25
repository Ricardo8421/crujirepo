<?php
include "conexion.php";
header('Content-type: application/json; charset=UTF-8');

$p = sprintf("SELECT u.id AS IdUsuario, u.login AS Matricula, p.nombreCompleto AS NombreCompleto, d.nombre AS Departamento FROM profesor p, usuario u, departamento d WHERE p.idUsuario = u.id AND p.departamento = d.clave ORDER BY NombreCompleto",
    $xd->real_escape_string($u),
    $xd->real_escape_string($c));
$r = $xd->query($p);

if($r->num_rows > 0){
    $json = "[";
    while($f = $r->fetch_assoc()){
        $json = $json.json_encode($f, JSON_UNESCAPED_UNICODE).",";
    }
    $json = substr($json,0,-1);
    $json = $json."]";
}

echo $json;
?>