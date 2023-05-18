
// Obtener la casilla de verificación y el div que contiene las etiquetas select
const materias_extra = document.getElementById('materias_extra');
const materias = document.getElementById('materias');

// Agregar un evento change a la casilla de verificación
materias_extra.addEventListener('change', function() {
  // Si la casilla de verificación está marcada
  if (this.checked) {
    // Pedir al usuario cuántas etiquetas select desea mostrar
    var cantidad=8;
    while(cantidad>3)
     {cantidad = Math.abs(prompt('¿Cuántas etiquetas select desea mostrar?'));}
    
    // Convertir la cantidad a un número entero
    const n = parseInt(cantidad);
    
    // Comprobar que la cantidad sea un número válido
    if (!isNaN(n) && n > 0) {
      // Eliminar las etiquetas select existentes
      while (materias.children.length > 1) {
        materias.removeChild(materias.lastChild);
      }
      
      // Agregar n nuevas etiquetas select
      for (let i = 0; i < n; i++) {
        const select = document.createElement('select');
        select.name = 'materia' + (i + 1);
        select.className="form-control-dark dropdown-menu dropdown-menu-dark d-block position-static mx-0 border-0 shadow w-220px "; 
        select.ariaLabel ="Default select example"  
        select.style="background-color: var(--background-color); color: var( --contrast-dark-color);";
        select.id = 'materia' + (i + 1);
        select.innerHTML = `
          <option value="">Seleccione una opción</option>
          <option value="física">materia física</option>
          <option value="mental">materia mental</option>
          <option value="visual">materia visual</option>
          <option value="auditiva">materia auditiva</option>
          <option value="intelectual">Discapacidad intelectual</option>
        `;
        materias.appendChild(select);
      }
      
      // Mostrar el div de etiquetas select
      materias.style.display = 'block';
    }
  } else {
    // Ocultar el div de etiquetas select y eliminar las etiquetas select existentes
    materias.style.display = 'none';
    while (materias.children.length > 1) {
      materias.removeChild(materias.lastChild);
    }
  }
});
