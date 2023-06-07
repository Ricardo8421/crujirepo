<?php
include "../utils/conexion.php";

header('Content-type: application/json; charset=UTF-8');

if(isset($_POST['usuario'])){
    $usuario = $_POST['usuario'];
    $query = sprintf("SELECT m.nombre AS Materia, a.nombre AS Academia FROM materia m, academia a, materiaregistradas mr, profesor p WHERE p.id='%s' AND p.id=mr.idProfesor AND mr.idMateria=m.clave AND m.academia=a.id;",
        $mysql->real_escape_string($usuario)
    );
    
    $result = $mysql->query($query);
    $query = sprintf("SELECT a.nombre AS Actividad, arg.cantidadHoras AS Horas FROM profesor p, actividadregistrada arg, actividad a WHERE p.id=arg.idProfesor AND arg.idActividad=a.id AND p.id='%s';",
        $mysql->real_escape_string($usuario)
    );
    $resulta2 = $mysql->query($query);

    if($result->num_rows > 0){
        $r["Materias"] = [];
        $r["Actividades"] = [];
        
        while ($row = $result->fetch_assoc()) {
            $r["Materias"][count($r["Materias"])] = $row;
        }
        while ($row = $resulta2->fetch_assoc()) {
            $r["Actividades"][count($r["Actividades"])] = $row;
        }
        $json = json_encode($r, JSON_UNESCAPED_UNICODE);
    }
}else{
    $temp = [];
    $temp["error"] = "jaja nel";
    $json = json_encode($temp);
}

echo $json;

?>