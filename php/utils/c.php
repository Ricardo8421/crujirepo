<?php
include "conexion.php";

$response = array(); // Array de respuesta

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['valor'])) {
  
  $variable=$_POST['valor'];
  // Validar el valor antes de realizar la consulta
  if (!empty($variable) && is_numeric($variable)) {
    
    $query = sprintf("SELECT horasMinimas FROM actividad WHERE id = %d",
      $mysql->real_escape_string($variable)
    );
    $result = $mysql->query($query);

    if ($result) {
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $horasMinimas = $row["horasMinimas"];
          $response= $horasMinimas;
        }
      } else {
        $response["error"] = "No se encontraron resultados.";
      }
    } else {
      $response["error"] = "Error en la consulta: " . $mysql->error;
    }
  } else {
    $response["error"] = "El valor proporcionado no es válido.";
  }
} else {
  $response["error"] = "Método de solicitud no válido o parámetro 'valor' no proporcionado.";
}

echo json_encode($response);
?>
