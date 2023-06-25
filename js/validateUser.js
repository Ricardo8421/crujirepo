$.ajax({
    url: './php/ajax/datosProfesor.php',
    type: 'GET',
    dataType: 'json',
    success: function(response) {
      if (response[0].HaContestado == 1){
        window.location.href = "./";
      }
    },
    error: function(xhr, status, error) {
    }
  });
  