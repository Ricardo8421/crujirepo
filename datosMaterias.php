<?php
include "conexion.php";
header('Content-type: application/json; charset=UTF-8');

$p = sprintf("SELECT m.clave, m.nombre AS Materia, a.nombre AS Academia, m.semestre, m.plan, m.carrera FROM materia m, academia a WHERE a.id = m.academia",
$xd->real_escape_string($u),
$xd->real_escape_string($c));
$r = $xd->query($p);

if($r->num_rows > 0){
    $json = "[";
    while($f = $r->fetch_assoc()){
        $co = [];
        $co["Materia"]=$f["Materia"];
        $co["Academia"]=$f["Academia"];
        $co["Semestre"]=$f["semestre"];
        $co["Plan"]=$f["plan"];
        switch ($f["carrera"]) {
            case 'A':
                $co["Carrera"] = "Lic. Ciencia de Datos";
                break;
            case 'B':
                $co["Carrera"] = "Ing. Inteligencia Artificial";
                break;
            case 'C':
                $co["Carrera"] = "Ing. Sistemas Computacionales";
                break;
            default:
                $co["Carrera"] = "Ing. Comedia";
                break;
        }
        $json = $json.json_encode($co, JSON_UNESCAPED_UNICODE).",";
    }
    $json = substr($json,0,-1);
    $json = $json."]";
}

echo $json;
?>