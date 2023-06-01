<?php
include "../utils/conexion.php";

header('Content-type: application/json; charset=UTF-8');

$query =
    "SELECT m.clave, m.nombre AS materia, a.nombre AS academia, m.semestre, m.plan, m.carrera 
    FROM materia m, academia a 
    WHERE a.id = m.academia";

$result = $mysql->query($query);

if($result->num_rows > 0){
    $json = "[";

    while ($row = $result->fetch_assoc()) {
        $currentSubject = [];

        $currentSubject["Materia"] = $row["materia"];
        $currentSubject["Academia"] = $row["academia"];
        $currentSubject["Semestre"] = $row["semestre"];
        $currentSubject["Plan"] = $row["plan"];

        switch ($row["carrera"]) {
            case 'A':
                $currentSubject["Carrera"] = "Lic. Ciencia de Datos";
                break;
            case 'B':
                $currentSubject["Carrera"] = "Ing. Inteligencia Artificial";
                break;
            case 'C':
                $currentSubject["Carrera"] = "Ing. Sistemas Computacionales";
                break;
            default:
                $currentSubject["Carrera"] = "Ing. Comedia";
                break;
        }

        $json = $json.json_encode($currentSubject, JSON_UNESCAPED_UNICODE).",";
    }

    $json = substr($json, 0, -1);
    $json = $json . "]";
}

echo $json;
?>