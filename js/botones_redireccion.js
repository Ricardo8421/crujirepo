
    // Asignar el evento click al botón de profesores
    if(document.querySelector('#profesores'))
    document.querySelector('#profesores').addEventListener('click', function() {
        window.location.href = 'profesores.php';
    });

    // Asignar el evento click al botón de materias
    if(document.querySelector('#materias'))
    document.querySelector('#materias').addEventListener('click', function() {
        window.location.href = 'materias.php';
    });
    if(document.querySelector('#volver'))
    document.querySelector('#volver').addEventListener('click', function() {
        window.location.href = 'Seleccion_admin.php';
    });