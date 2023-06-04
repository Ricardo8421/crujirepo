/**
 *
 * Este archivo se encarga de modificar los modals de las páginas CRUD con los datos
 * que están en el html, se hace a partir de los botones en cada fila con las clases
 * btn-read para filtrar, btn-update para actualizar, y btn-delete para la confirmación
 *
 * Se requiere importar junto con otro archivo javascript que contenga lo siguiente
 *
 * url : string
 * 		Url de donde se va a conseguir el json con los datos
 * topic : string
 * 		Cadena que representa la clase de objeto con la que se trata
 * columns : int
 * 		Cantidad de columnas que tiene la tabla
 * generateRowHTML (objeto) : string
 * 		Funcion que regresa el html de cada fila de la tabla.
 * 		El objeto es un elemento que se va a obtener del json
 *
 * Para la función se debe tomar en cuenta que cada celda que contenga datos debe contener
 * el atributo modal-form-target que contiene la id del input para que este script pueda
 * remplazar los datos en el formulario
 *
 */

const loadingRing = 
	`<tr><th colspan="${columns}" class="text-center align-middle">
		<div class="lds-dual-ring"></div>
	</th></tr>`

const retrieveData = async () => {
	return await $.ajax({ url: url });
}

$(document).ready(() => {
	render(retrieveData);
});

addClickListeners = () => {
	$(".btn-create").on("click", function () {
		createButton($(".btn-update").first().parent().parent());
	});
	$(".btn-read").on("click", function () {
		readButton($(".btn-update").first().parent().parent());
	});
	$(".btn-update").on("click", function () {
		updateButton($(this).parent().parent());
	});
	$(".btn-delete").on("click", function () {
		deleteButton($(this).parent().parent());
	});
};

/**
 *
 * Agrega las filas a la tabla
 *
 * @param getData Promesa que regresará la lista de datos
 *
 */
render = async (getData) => {
	// Colocar el símbolo de cargando
	$("#generatedContainer").html(loadingRing);

	// Obtener informacion
	let data = await getData();

	// Quitar el símbolo de cargando
	$("#generatedContainer").html("");

	// Para cada fila, generar html y agregarlo
	data.forEach((row) =>
		$("#generatedContainer").append(generateRowHTML(row))
	);

	// Agregar listeners a los botones de edicion
	addClickListeners();
}

/**
 *
 * Limpia los datos del formulario
 *
 * @param example Es una fila que sirve de ejemplo para obtener los nombres y las inputs.
 * 		Se recomienda usar la primera fila
 *
 */
createButton = (example) => {
	values = $(example).children("[modal-form-target]");

	$("#editDataLabel").text(`Agregando nuevo ${topic}`);
	$("#sumbitCrud").text(`Registrar ${topic}`);

	for (let i = 0; i < values.length; i++) {
		const val = $(values[i]);

		let target = val.attr("modal-form-target");
		let name = $(`#${target}`).attr("name");

		let label = $(`label[for=${target}]`);
		if (label.length > 0)
			label.text(name.charAt(0).toUpperCase() + name.slice(1));

		let text = $(`input#${target}[type=text]`);
		if (text.length > 0) text.val("");

		let select = $(`select#${target}`);
		if (select.length > 0) select.children().first().prop("selected", true);

		let checkbox = $(`input#${target}[type=checkbox]`);
		if (checkbox.length > 0) checkbox.show().prop("checked", true);
	}
};

/**
 *
 * Reformatea el formulario para parecer que filtra.
 * NO FUNCIONA CON CHECKBOXES
 *
 * @param example Es una fila que sirve de ejemplo para obtener los nombres y las inputs.
 * 		Se recomienda usar la primera fila
 *
 */
readButton = (example) => {
	values = $(example).children("[modal-form-target]");

	$("#editDataLabel").text("Filtrando por");
	$("#sumbitCrud").text("Filtrar");

	for (let i = 0; i < values.length; i++) {
		const val = $(values[i]);

		let target = val.attr("modal-form-target");
		let name = $(`#${target}`).attr("name");

		let label = $(`label[for=${target}]`);

		let text = $(`input#${target}[type=text]`);
		if (text.length > 0) {
			if (label.length > 0) label.text("Buscar por " + name);
			text.val("");
		}

		let select = $(`select#${target}`);
		if (select.length > 0) {
			if (label.length > 0) label.text("Filtrar por " + name);
			select.children().first().prop("selected", true);
		}

		let checkbox = $(`input#${target}[type=checkbox]`);
		if (checkbox.length > 0) {
			if (label.length > 0) label.text("");
			checkbox.hide();
		}
	}
};

/**
 *
 * Ingresa los datos de la fila en el formulario
 *
 * @param row La fila de donde obtiene los datos
 *
 */
updateButton = (row) => {
	values = $(row).children("[modal-form-target]");

	$("#editDataLabel").text(`Editando ${topic}`);
	$("#sumbitCrud").text("Guardar cambios");

	for (let i = 0; i < values.length; i++) {
		const val = $(values[i]);

		let target = val.attr("modal-form-target");
		let name = $(`#${target}`).attr("name");

		let label = $(`label[for=${target}]`);
		if (label.length > 0)
			label.text(name.charAt(0).toUpperCase() + name.slice(1));

		let text = $(`input#${target}[type=text]`);
		if (text.length > 0) text.val(val.text());

		let select = $(`select#${target}`);
		if (select.length > 0)
			select
				.children(`option:contains("${val.text()}")`)
				.prop("selected", true);

		let checkbox = $(`input#${target}[type=checkbox]`);
		if (checkbox.length > 0)
			checkbox.show().prop("checked", val.text() == "true");
	}
};

/**
 *
 * Ingresa la id de la fila en el formulario
 *
 * @param row La fila de donde obtiene la id. Debe estar en el primer hijo
 *
 */
deleteButton = (row) => {
	id = $(row).children().first().text();
	$("#deleteConfirmationInput").val(id);
};
