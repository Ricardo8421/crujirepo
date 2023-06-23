fetch("php/ajax/datosMaterias")
	.then(response => response.json())
	.then(data => {
		var datos = data;
		// Obtener la etiqueta select

		$(document).ready(function() {
			// Manejar el cambio en el select
				// Hacer una solicitud AJAX a tu script PHP
				async function peticion(seleccionado) {
					let response= await $.ajax({
					url: "php/utils/academia_usuario.php",
					method: "POST",
					data: {},
					success: function(resultado) {
						let rsp=((resultado));

						
function dividirString(inputString) {
	// Ignorar los primeros 4 caracteres
	inputString = inputString.slice(4);
	
	// Dividir el string en partes usando el delimitador "
	var partes = inputString.split('"');
	
	// Filtrar las partes vacías
	partes = partes.filter(function(parte) {
	  return parte !== "";
	});
	
	// Retornar el resultado como un array de strings
	return partes;
  }
  
						  
						  // Ejemplo de uso:
//						 const inputString = 'DCIC"Ciencias de la Computaci\u00f3n""Ciencia de Datos""Inteligencia Artificial"';
						  const resultArray = dividirString(rsp);
								// Agregar el evento change a la etiqueta select
		
			// Obtener la academia seleccionada
			var objetosFiltrados =[];
			for(let o=0;o<(resultArray.length);o++){

			var academiaSeleccionada =String (resultArray[o]);
			//console.log(rsp);
			console.log(academiaSeleccionada);

			// Filtrar los objetos del JSON por la academia seleccionada
			objetosFiltrados.push( datos.filter(function (objeto) {
				return objeto.Academia == academiaSeleccionada;
			}))
					}
			var selectsMaterias_q = document.querySelectorAll("#materia");
			let breakMaterias = document.querySelectorAll("#break");
			let labelMaterias = document.querySelectorAll("#materia_label");

			for (var i = 1; i < (labelMaterias.length + 1); i++) {
				let previous_divs = document.querySelectorAll("#materias_div" + i);


				previous_divs[0].parentNode.removeChild(previous_divs[0]);
			}

			for (let i = 1; i < 5; i++) {
				selectsMaterias_q = document.querySelectorAll("#materia");

				var materia_div = document.createElement("div");
				materia_div.id = "materias_div" + i;
				materia_div.name = "materias_div";
				materia_div.className = "container container-formulario";
				if (i == 1) { materia_div.style.display = "block" }
				else materia_div.style.display = "none"
				materia_div.innerHTML = `
        <br id="break">
        <label for="materia" id="materia_label">Materia ${i}</label>
        <br id="break">
                `;
				let nombre="materia" + i;
				// Crear la nueva etiqueta select
				var selectMaterias = document.createElement("select");

				selectMaterias.className = "form-control-dark dropdown-menu dropdown-menu-dark d-block position-static mx-0 border-0 shadow w-220px ";
				selectMaterias.ariaLabel = "Default select example";
				selectMaterias.style = "background-color: var(--background-color); color: var( --contrast-dark-color);";
				selectMaterias.id = "materia";
				selectMaterias.name =(nombre);
				if (i == 1) {selectMaterias.required = true;}
				var def=document.createElement("option");
				def.value="";
				def.text="Seleccionar materia";
				selectMaterias.add(def);
				// Recorrer los objetos filtrados y agregar opciones al nuevo select
				objetosFiltrados.forEach(function (objeto) {
					// Verificar si la materia del objeto no está en el select de materias
					if (!selectMaterias.querySelector('option[value="' + objeto.Clave + '"]')) {
						// Crear la opción para la materia del objeto
						var opcion = document.createElement("option");
						opcion.text = objeto.Materia+" - "+(objeto.Carrera=="Lic. Ciencia de Datos" ? "LCD" : (objeto.Carrera=="Ing. Inteligencia Artificial" ? "IIA" : "ISC"));
						opcion.value = objeto.Clave;

						// Agregar la opción al nuevo select
						selectMaterias.add(opcion);
					}
				});
				// Agregar el nuevo select al documento
				materia_div.appendChild(selectMaterias);
				//materia_div.appendChild(materias_extra_label_DOM);
				//materia_div.appendChild(materias_extra_checkbox_DOM);
				carta.appendChild(materia_div);

				//carta.appendChild(littlescript);
			}

		
					}
				});
				if (response.error) {
					$("#login_message").html(`<p class="text-danger">${response.error}</p>`);
				} else {
				}
			}
			peticion();
		});
		$(document).ready(() => {
			var materias_pp = document.getElementById("materias_pp");
			var materias_ll = document.getElementById("materias_ll");
			var materias_pp_label = document.getElementById("materias_pp_label");
			var materias_ll_label = document.getElementById("materias_ll_label");
			var selectnumber = 2;
			var restanumber = 0;
			// Si la casilla de verificación está marcada
				materias_pp.style.display = "block";
				materias_pp_label.style.display = "block";
				materias_ll.style.display = "block";
				materias_ll_label.style.display = "block";

				if (document.querySelectorAll("#materias_pp").length != 0) {

					materias_pp.addEventListener('click', function () {
						console.log(selectnumber);
						// Variable para llevar la cuenta de la cantidad
						let previous_divs = document.getElementById("materias_div" + selectnumber)
						
							previous_divs.style.display = "block";
							if (selectnumber < 4) { selectnumber = selectnumber + 1; }
							else { selectnumber = 2; restanumber = 4; }
							
						
					});
					materias_ll.addEventListener('click', function () {
						if (restanumber == 4) { selectnumber = 4; restanumber = 0; }
						console.log(selectnumber);
						// Variable para llevar la cuenta de la cantidad
						let previous_divs = document.getElementById("materias_div" + selectnumber)
						if (previous_divs.style.display == "none" && selectnumber > 2) selectnumber = selectnumber - 1;
						previous_divs = document.getElementById("materias_div" + selectnumber)
						

							previous_divs.style.display = "none";
							if (selectnumber > 2) {
								selectnumber = selectnumber - 1;
							}
							else selectnumber = 2;
							
						
						console.log(selectnumber);
					});
				}
			
			
			selectnumber = 2;
		}	
		);
		
	})
	.catch(error => console.error(error));