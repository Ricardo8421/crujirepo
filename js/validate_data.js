let form = document.getElementById('form');
var completado = 0;
var hipervinculo = 'FormularioDatosEnvio.php';
form.addEventListener('submit', function (event) {
event.preventDefault(); // Evita el envío del formulario por defecto
 // Llamar a la función para hacer la consulta
console.log("enyrasa");
 
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
			const successMessage = document.createElement('div');
			successMessage.classList.add('alert', 'alert-success');
			successMessage.textContent = 'Datos enviados exitosamente';
			form.appendChild(successMessage);
			window.location.href = hipervinculo;
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
		} else if (input.validity.typeMismatch || input.validity.rangeUnderflow || input.validity.rangeOverflow) {
			errorMessage.textContent = 'Ingresa un valor válido entre 1 y 22.';
		}
	});
});


// Obtener todas las etiquetas select y los campos de entrada
var selects = document.querySelectorAll("#actividad")
let inputs_numbers = document.querySelectorAll('input[type="number"]');

// Recorrer cada etiqueta select
selects.forEach((select, index) => {
	// Agregar un evento change a cada etiqueta select
	select.addEventListener('change', () => {
		// Obtener el valor seleccionado
		const selectedValue = select.value;

		// Verificar si se ha seleccionado una actividad
		if (selectedValue !== '') {
			// Hacer que el campo de entrada correspondiente sea obligatorio
			inputs_numbers[index].required = true;

			// Deshabilitar la opción seleccionada en las demás etiquetas select
			if (index > 2)
				selects.forEach((otherSelect) => {
					if (otherSelect !== select) {
						const option = otherSelect.querySelector(`option[value="${selectedValue}"]`);
						if (option) {
							option.disabled = true;
						}
					}
				});
		}
	});
});
