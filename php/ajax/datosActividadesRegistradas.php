<?php
include "../utils/conexion.php";

header('Content-type: application/json; charset=UTF-8');

$b=false;

if(isset($_POST['usuario'])){
    $usuario = $_POST['usuario'];
    $query=sprintf("SELECT p.id AS Matricula, p.nombreCompleto AS NombreCompleto, d.nombre AS Departamento 
                FROM profesor p, departamento d 
                WHERE p.id='%s' AND p.departamento = d.clave;",
        $mysql->real_escape_string($usuario));
    $res = $mysql->query($query);
    if($res->num_rows > 0){
        $b=true;
        $f = $res->fetch_assoc();
        $r["NombreCompleto"]=$f["NombreCompleto"];
        $r["Matricula"]=$f["Matricula"];
        $r["Departamento"]=$f["Departamento"];
        $query = sprintf(
            "SELECT 
                m.nombre AS Materia,
                a.nombre AS Academia,
                m.clave AS Clave
            FROM materia m, academia a, materiaregistradas mr, profesor p
            WHERE
                p.id = mr.idProfesor AND
                mr.idMateria = m.clave AND
                m.academia = a.id AND
                p.id = '%s'",
            $mysql->real_escape_string($usuario)
        );
        
        $result = $mysql->query($query);
        $query = sprintf(
            "SELECT
                a.nombre AS Actividad,
                arg.cantidadHoras AS Horas
            FROM profesor p, actividadregistrada arg, actividad a
            WHERE
                p.id = arg.idProfesor AND
                arg.idActividad = a.id AND
                p.id = '%s'",
            $mysql->real_escape_string($usuario)
        );
        $resulta2 = $mysql->query($query);
    
        $r["Materias"] = [];
        $r["Actividades"] = [];
        if($result->num_rows > 0){
            
            while ($row = $result->fetch_assoc()) {
                $r["Materias"][count($r["Materias"])] = $row;
            }
            while ($row = $resulta2->fetch_assoc()) {
                $r["Actividades"][count($r["Actividades"])] = $row;
            }
        }
        $json = json_encode($r, JSON_UNESCAPED_UNICODE);
    }
}

if(!$b){
    $temp = [];
    $temp["error"] = "jaja nel";
    $json = json_encode($temp);
}

echo $json;

?>