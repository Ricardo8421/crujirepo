function obtenerDatos() {
    // Realizar una petición AJAX al archivo.php para obtener el JSON
    var xhttp = new XMLHttpRequest();
    var usuario;
    xhttp.onreadystatechange = function() {
      if (this.readyState === 4 && this.status === 200) {
        var json = this.responseText;
        // Convertir el JSON a un objeto
        var objeto = JSON.parse(json);
        objeto = objeto[0];
        usuario = objeto.Usuario;
        
        xhttp.onreadystatechange = function() {
          if (this.readyState === 4 && this.status === 200) {
            var json = this.responseText;
            // Redireccionar a createPdf.php con el JSON como parámetro
            console.log(json);
            window.location = '/crujirepo/php/utils/createPdfProfesor.php?json=' + encodeURIComponent(json);
          }
        };
        xhttp.open("POST", "php/ajax/datosActividadesRegistradas.php", true);
      
        // Establecer el encabezado Content-Type para enviar los datos en formato URL-encoded
        xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      
        // Enviar el parámetro usuario en la petición POST
        xhttp.send("usuario=" + usuario);
      }
    };
    xhttp.open("GET", "php/ajax/datosProfesor.php", true);
    xhttp.send();
  }
  
  // Manejar el evento click del botón
  var boton = document.getElementById('generar-pdf');
  boton.addEventListener('click', obtenerDatos);
  