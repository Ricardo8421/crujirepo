<?php
include "../utils/login.php";
session_start();
$redirect = checkSession(1);
$b=false;
$redireccionar=false;
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

  $query = "SELECT id, horasMinimas FROM actividad WHERE horasMinimas>0;";
  $resR = $mysql->query($query);
  $actR = [];
  $actR["id"] = [];
  $actR["horas"] = [];
  $actT = 0;
  while($f = $resR->fetch_assoc()){
    array_push($actR["id"], $f["id"]);
    array_push($actR["horas"], $f["horasMinimas"]);
    $actT++;
  }

  $queryA = "INSERT INTO actividadRegistrada (idProfesor, idActividad, cantidadHoras) VALUES ";
  $queryM = "INSERT INTO materiaregistradas (idProfesor, idMateria) VALUES ";
  
  for ($i = 1; $i <= 5; $i++) {
    $flag=1;

    if (isset($_POST["actividad" . $i]) && isset($_POST["horas_actividad" . $i])) {
      $actividad = $_POST["actividad" . $i];
      $horas = $_POST["horas_actividad" . $i];

      if ($actividad !== null && $actividad !== "" && $actividad !== "default" && $horas !== null && $horas !== "" && $horas !== "0") {
         if (is_numeric($actividad)&& (int)$actividad == $actividad && is_numeric($horas) && (int)$horas == $horas){
          if(in_array($actividad, $actR["id"])){
            if($horas<$actR["horas"][array_search($actividad, $actR["id"])]){
              break;
            }else{
              $actT--;
            }
          }
        $queryA = $queryA.sprintf("('%s', %d, %d),",
          $mysql->real_escape_string($profesor),
          $mysql->real_escape_string($actividad),
          $mysql->real_escape_string($horas)
        );
      }else {
        $redireccionar=true;
      }
    }
    }
    if(isset($_POST["materia" . $i]) && $flag==1){   
    $materiaV=$_POST["materia" . $i];
    $queryMV = sprintf("SELECT clave FROM materia WHERE clave=%s",
    $mysql->real_escape_string($materiaV)
        );
    $queryMV=substr($queryMV,0,-1);
      $materia=$_POST["materia" . $i];
      if ($materia !== null && $materia !== "" && $materia !== "default"&&$i<5&&$flag==!0&& is_numeric($materia)==false && (int)$materia !==$materia&& (float)$materia !== $materia && is_string($materia)) {
        $queryM = $queryM.sprintf("('%s', '%s'),",
          $mysql->real_escape_string($profesor),
          $mysql->real_escape_string($materia),
        );
      }
    }
    if(isset($_POST["materias_extra"])){
      $extra = $_POST["materias_extra"];
      $queryME = sprintf("UPDATE profesor SET materiasExtra=%d WHERE id=%s",
        $mysql->real_escape_string($extra),
        $mysql->real_escape_string($profesor));
    }
  }
  if($redireccionar){
    header("Location: ./" . getRedirect($redirect));
  }
  if($actT==0){
    $queryA=substr($queryA,0,-1);
    if ($mysql->query($queryA)) {
      $queryM=substr($queryM,0,-1);
      if ($mysql->query($queryM)) {
        $resultado = "Registro correcto";
        $b=true;
      } else {
        $query = sprintf("DELETE FROM actividadRegistrada WHERE idProfesor='%s'",
          $mysql->real_escape_string($profesor));
        $mysql->query($query);
        $resultado = "Error en el registro";
      }
    } else {
      $resultado = "Error en el registro";
    }
    $mysql->query($queryME);
    if($mysql->affected_rows == 0){
      $b=false;
      $resultado="Error en el registro";

      $query = sprintf("DELETE FROM actividadRegistrada WHERE idProfesor='%s'",
        $mysql->real_escape_string($profesor));
      $mysql->query($query);
      $query = sprintf("DELETE FROM materiaRegistradas WHERE idProfesor='%s'",
        $mysql->real_escape_string($profesor));
      $mysql->query($query);

    }
  }else{
    $resultado = "Actividad requeridas invalidas";
  }
}

$r["success"]=$b;
$r["resultado"]=$resultado;

echo json_encode($r);
?>