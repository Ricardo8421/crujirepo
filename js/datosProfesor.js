function obtenerDatos() {
    console.log("Obteniendo datos...");
    // Realizar una petición AJAX al archivo.php para obtener el JSON
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState === 4 && this.status === 200) {
        var json = this.responseText;
  
        // Redireccionar a createPdf.php con el JSON como parámetro
        window.location = '/crujirepo/php/utils/createPdfProfesor.php?json=' + encodeURIComponent(json);
      }
    };
    xhttp.open("GET", "test.php", true);
    xhttp.send();
  }
  
  // Manejar el evento click del botón
  var boton = document.getElementById('generar-pdf');
  boton.addEventListener('click', obtenerDatos);
  