fetch("le_json.json")
	.then((response) => response.json())
	.then((data) => {
		// Asignar el contenido del archivo JSON a una variable
		var datos = data;
		const materias = document.getElementById("materias");
		// Obtener la etiqueta select
		var select = document.getElementById("academia");
		var academias = [];
		// Recorrer los objetos JSON
		for (var i = 0; i < datos.length; i++) {
			// Verificar si la edad del objeto es mayor a 28
			// Crear la opción para el país del objeto
			var opcion = document.createElement("option");
			if (!academias.includes(datos[i].Academia)) {
				academias.push(datos[i].Academia);
				opcion.text = datos[i].Academia;
				opcion.value = datos[i].Academia;
				// Agregar la opción a la etiqueta select
				select.add(opcion);
			}
		}
		// Agregar el evento change a la etiqueta select
		select.addEventListener("change", function () {
			// Obtener la academia seleccionada
			var academiaSeleccionada = this.value;

			// Filtrar los objetos del JSON por la academia seleccionada
			var objetosFiltrados = datos.filter(function (objeto) {
				return objeto.Academia == academiaSeleccionada;
			});
			var selectsMaterias = document.querySelectorAll("#materia");
			for (var i = 0; i < selectsMaterias.length; i++) {
				selectsMaterias[i].parentNode.removeChild(selectsMaterias[i]);
			}

			// Crear la nueva etiqueta select
			var selectMaterias = document.createElement("select");
			selectMaterias.id = "materia";

			// Recorrer los objetos filtrados y agregar opciones al nuevo select
			objetosFiltrados.forEach(function (objeto) {
				// Verificar si la materia del objeto no está en el select de materias
				if (
					!selectMaterias.querySelector('option[value="' + objeto.Nombre + '"]')
				) {
					// Crear la opción para la materia del objeto
					var opcion = document.createElement("option");
					opcion.text = objeto.Nombre;
					opcion.value = objeto.Nombre;

					// Agregar la opción al nuevo select
					selectMaterias.add(opcion);
				}
			});

			// Agregar el nuevo select al documento
			materias.appendChild(selectMaterias);
		});
	})
	.catch((error) => console.error(error));
