<?php
include "php/utils/login.php";
session_start();
$redirect = checkSession(1);
echo($_SERVER["REQUEST_METHOD"]);
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["usuario"])) {
  $profesor = $_SESSION["usuario"];
  
  for ($i = 1; $i <= 5; $i++) {
    if (isset($_POST["actividad" . $i]) && isset($_POST["horas_actividad" . $i])&&isset($_POST["materia" . $i])) {
      $actividad = $_POST["actividad" . $i];
      $horas = $_POST["horas_actividad" . $i];

      if ($actividad !== null && $actividad !== "" && $actividad !== "default" &&
          $horas !== null && $horas !== "" && $horas !== "0") {
        
        $query = sprintf("INSERT INTO actividadregistrada (idProfesor, idActividad, cantidadHoras) VALUES (
          '%s', '%s', %d)",
          $mysql->real_escape_string($profesor),
          $mysql->real_escape_string($actividad),
          $mysql->real_escape_string($horas)
        );

        if ($mysql->query($query)) {
          $resultado = "Registro correcto";
        } else {
          $resultado = "Error en el registro";
        }
      }
      if($i<5)
{$materia=$_POST["materia" . $i];
echo($materia);}
if ($materia !== null && $materia !== "" && $materia !== "default"&&$i<5) {
    
    $query = sprintf("INSERT INTO materiaregistradas (idProfesor, idMateria) VALUES (
      '%s', '%s')",
      $mysql->real_escape_string($profesor),
      $mysql->real_escape_string($materia),
    );

    if ($mysql->query($query)) {
      $resultado = "Registro correcto";
    } else {
      $resultado = "Error en el registro";
    }
  }
    }
  }
}

# Redirigir a una página de confirmación
header('Location: registroConcluido.php');
exit();
?>
