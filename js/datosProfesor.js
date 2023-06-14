function obtenerDatos() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
      var objeto = JSON.parse(this.responseText)[0];
      var usuario = objeto.Usuario;

      var xhttp2 = new XMLHttpRequest();
      xhttp2.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
          var json = this.responseText;
          var url = '/crujirepo/php/utils/createPdfProfesor.php?json=' + encodeURIComponent(json);
          window.location.href = url;
        }
      };

      xhttp2.open("POST", "php/ajax/datosActividadesRegistradas.php", true);
      xhttp2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhttp2.send("usuario=" + encodeURIComponent(usuario));
    }
  };

  xhttp.open("GET", "php/ajax/datosProfesor.php", true);
  xhttp.send();
}

var boton = document.getElementById('generar-pdf');
boton.addEventListener('click', obtenerDatos);
