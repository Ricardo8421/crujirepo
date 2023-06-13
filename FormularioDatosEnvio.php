<?php
include "php/utils/login.php";
session_start();
$redirect = checkSession(1);
$b=false;
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["usuario"])) {
  $profesor = "";
  $usuario = $_SESSION["usuario"];

  $query = sprintf("SELECT p.id FROM profesor p, usuario u WHERE u.`login`='%s' AND u.id=p.idUsuario",
  $mysql->real_escape_string($usuario));
  $res = $mysql->query($query);
  if($res->num_rows > 0){
    $f = $res->fetch_assoc();
    $profesor = $f["id"];
  }

  $queryA = "INSERT INTO actividadRegistrada (idProfesor, idActividad, cantidadHoras) VALUES ";
  $queryM = "INSERT INTO materiaregistradas (idProfesor, idMateria) VALUES ";
  for ($i = 1; $i <= 5; $i++) {
    if (isset($_POST["actividad" . $i]) && isset($_POST["horas_actividad" . $i])) {
      $actividad = $_POST["actividad" . $i];
      $horas = $_POST["horas_actividad" . $i];

      if ($actividad !== null && $actividad !== "" && $actividad !== "default" && $horas !== null && $horas !== "" && $horas !== "0") {
        $queryA = $queryA.sprintf("('%s', %d, %d),",
          $mysql->real_escape_string($profesor),
          $mysql->real_escape_string($actividad),
          $mysql->real_escape_string($horas)
        );
      }
    }
    if(isset($_POST["materia" . $i])){
      $materia=$_POST["materia" . $i];
      if ($materia !== null && $materia !== "" && $materia !== "default"&&$i<5) {
        $queryM = $queryM.sprintf("('%s', '%s'),",
          $mysql->real_escape_string($profesor),
          $mysql->real_escape_string($materia),
        );
      }
    } 
  }
  $queryA=substr($queryA,0,-1);
  if ($mysql->query($queryA)) {
    $queryM=substr($queryM,0,-1);
    if ($mysql->query($queryM)) {
      $resultado = "Registro correcto";
      $b=true;
    } else {
      $query = sprintf("DELETE FROM actividadRegistrada WHERE idProfesor='%s'",
        $mysql->real_escape_string($profesor));
      $resultado = "Error en el registro";
    }
  } else {
    $resultado = "Error en el registro";
  }
}

$r["success"]=$b;
$r["resultado"]=$resultado;

echo json_encode($r);
?>
