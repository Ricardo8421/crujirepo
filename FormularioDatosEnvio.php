<?php
include "php/utils/login.php";
session_start();
$redirect = checkSession(1);

for ($i = 1; $i <= 5; $i++) {
  $actividad = $_POST['actividad' . $i];
  $horas = $_POST['horas_actividad' . $i];
  $profesor=$_SESSION['usuario'];

  if ($actividad !== null && $actividad !== '' && $actividad !== 'default' &&
      $horas !== null && $horas !== '' && $horas !== '0') {
    
    $insertar = "INSERT INTO actividadregistrada (idProfesor, idActividad, cantidadHoras) VALUES (
      '$profesor',
      '$actividad',
      '$horas'
      )";

    $query = mysqli_query($mysql, $insertar);

    if (!$query) {
      echo("datos erroneos");
    }
  }
}

header('Location:registroConcluido');
exit();
?>