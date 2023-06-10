
$(document).ready(function() {
	// Manejar el cambio en el select
	
	$("select[name='actividad1']").change(function() {
		// Obtener el valor seleccionado
		var seleccionado = $(this).val();
		let resultado=peticion(seleccionado);
		
		
		// Hacer una solicitud AJAX a tu script PHP
		async function peticion(seleccionado) {
			let response= await $.ajax({
			url: "php/utils/c.php",
			method: "POST",
			data: { valor: seleccionado },
			success: function(resultado) {
				let rsp=JSON.parse(resultado);
				// Actualizar el valor del input con el resultado de la consulta
				$("input[name='horas_actividad1']").attr("min", rsp);
			
			
			}
		});
		if (response.error) {
			$("#login_message").html(`<p class="text-danger">${response.error}</p>`);
		} else {
		}
	}
	});
});
let form = document.getElementById('form');
var completado = 0;
var hipervinculo = 'FormularioDatosEnvio.php';
form.addEventListener('submit', function (event) {
event.preventDefault(); // Evita el envío del formulario por defecto
 // Llamar a la función para hacer la consulta
 
	let horas_actividad1 = parseInt(document.getElementById('horas_actividad1').value);
	let horas_actividad2 = parseInt(document.getElementById('horas_actividad2').value);
	let horas_actividad3 = parseInt(document.getElementById('horas_actividad3').value);
	let horas_actividad4 = parseInt(document.getElementById('horas_actividad4').value);
	let horas_actividad5 = parseInt(document.getElementById('horas_actividad5').value);
	if (isNaN(horas_actividad3)) { horas_actividad3 = 0; }
	if (isNaN(horas_actividad4)) { horas_actividad4 = 0; }
	if (isNaN(horas_actividad5)) {
		horas_actividad5 = 0;
		
	}

	var suma = horas_actividad1 + horas_actividad2 + horas_actividad3 + horas_actividad4 + horas_actividad5;

	if (suma > 22) {

		document.getElementById('horas_actividad1-error').textContent = '';
		document.getElementById('horas_actividad4-error').textContent = '';
		document.getElementById('horas_actividad3-error').textContent = '';
		document.getElementById('horas_actividad4-error').textContent = '';
		document.getElementById('horas_actividad5-error').textContent = 'La suma de los valores debe ser menor a 22';

	} else {
		document.getElementById('horas_actividad1-error').textContent = '';
		document.getElementById('horas_actividad2-error').textContent = '';
		document.getElementById('horas_actividad3-error').textContent = '';
		document.getElementById('horas_actividad4-error').textContent = '';
		document.getElementById('horas_actividad5-error').textContent = '';

		// Procesar los datos si la suma es válida

		if (completado == 0) {
			completado = completado + 1;
			// Por ejemplo, puedes mostrar un mensaje de éxito
			$(document).ready(function() {
				// Manejar el cambio en el select
				
				
					
					// Hacer una solicitud AJAX a tu script PHP
					async function registro(seleccionado) {
						let response= await $.ajax({
						url: "FormularioDatosEnvio.php",
						method: "POST",
						data: { valor: $("#form").serialize() 
					},
						success: function(resultado) {					
							window.location.href = hipervinculo;
						}
					});
					if (response.error) {
						$("#login_message").html(`<p class="text-danger">${response.error}</p>`);
					} else {
					}
				}
				registro();
			});
			const successMessage = document.createElement('div');
			successMessage.classList.add('alert', 'alert-success');
			successMessage.textContent = 'Datos enviados exitosamente';
			form.appendChild(successMessage);	
			
		}
	}
});

// Agregar un listener de blur a los inputs para mostrar los mensajes de error debajo de cada input
const inputs = document.querySelectorAll('input[type="number"]');
inputs.forEach((input) => {
	input.addEventListener('blur', () => {
		const inputId = input.getAttribute('id');
		const errorId = inputId + '-error';
		const errorMessage = document.getElementById(errorId);
		errorMessage.textContent = '';

		if (input.validity.valueMissing) {
			errorMessage.textContent = 'Este campo es obligatorio.';
		} else 
		if (input.validity.typeMismatch || input.validity.rangeUnderflow || input.validity.rangeOverflow) {
			var minValue = input.getAttribute('min');
			var maxValue = input.getAttribute('max');
			errorMessage.textContent = 'Ingresa un valor válido entre ' + minValue + ' y ' + maxValue + '.';}
	});
});


// Obtener todas las etiquetas select y los campos de entrada

let inputs_numbers = document.querySelectorAll('input[type="number"]');
var selects = document.querySelectorAll("#actividad")
var selects = document.querySelectorAll("#actividad");
var selectedValues = [];

// Recorrer cada etiqueta select
selects.forEach((select, index) => {
  // Agregar un evento change a cada etiqueta select
  select.addEventListener('change', () => {
    // Restablecer el valor seleccionado anteriormente
    if (selectedValues[index]) {
      const prevOption = select.querySelector(`option[value="${selectedValues[index]}"]`);
      if (prevOption) {
        prevOption.disabled = false;
      }
    }

    // Obtener el valor seleccionado actual
    const selectedValue = select.value;
    selectedValues[index] = selectedValue;

    // Verificar si se ha seleccionado una actividad
    if (selectedValue !== '') {
      // Hacer que el campo de entrada correspondiente sea obligatorio
      inputs_numbers[index].required = true;

      // Deshabilitar la opción seleccionada en las demás etiquetas select
      selects.forEach((otherSelect, otherIndex) => {
        if (otherIndex !== index) {
          const option = otherSelect.querySelector(`option[value="${selectedValue}"]`);
          if (option) {
            option.disabled = true;
          }
        }
      });
    } else {
      // Si no se seleccionó ninguna actividad, eliminar la marca de obligatorio y restaurar las opciones deshabilitadas
      inputs_numbers[index].required = false;
      selectedValues[index] = null;

      selects.forEach((otherSelect) => {
        const disabledOption = otherSelect.querySelector('option:disabled');
        if (disabledOption) {
          disabledOption.disabled = false;
        }
      });
    }
  });
});