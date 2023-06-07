<?php
include "php/utils/login.php";
session_start();
$redirect = checkSession(1);

for ($i = 1; $i <= 5; $i++) {
  $b=true;

  $actividad = $_POST['actividad' . $i];
  $horas = $_POST['horas_actividad' . $i];
  $profesor=$_SESSION['usuario'];

  if ($actividad !== null && $actividad !== '' && $actividad !== 'default' &&
      $horas !== null && $horas !== '' && $horas !== '0') {
    
    $query = sprintf("INSERT INTO actividadregistrada (idProfesor, idActividad, cantidadHoras) VALUES (
      '%d', '%d', %d,
      )",$mysql->real_escape_string($profesor),
        $mysql->real_escape_string($actividad),
        $mysql->real_escape_string($horas));

    #$query = mysqli_query($mysql, $insertar);
    if($mysql->query($query)){
        $r["resultado"] = "Registro correcto";
    }else{
        $b = false;
    }
    if (!$query) {
      echo("datos erroneos");
    }
  }
}

header('Location:registroConcluido');
exit();
?>