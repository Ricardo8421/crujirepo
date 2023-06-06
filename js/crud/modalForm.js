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
 * Y se necesitan los objetos createConfig, readConfig, updateConfig, y deleteConfig
 * que son objetos que marcan la configuración de los campos del 
 *
 */

const loadingRing = `<tr><th colspan="${columns}" class="text-center align-middle">
		<div class="lds-dual-ring"></div>
	</th></tr>`;

const retrieveData = async () => {
	return await $.ajax({ url: url });
};

$(document).ready(() => {
	read(retrieveData);
});

addClickListeners = () => {
	$(".btn-create").on("click", function () {
		renderForm(createConfig);
		//		createButton($(".btn-update").first().parent().parent());
	});
	$(".btn-read").on("click", function () {
		renderForm(readConfig);
		//readButton($(".btn-update").first().parent().parent());
	});
	$(".btn-update").on("click", async function () {
		await renderForm(updateConfig);
		renderFormData($(this).parent().parent());
	});
	$(".btn-delete").on("click", async function () {
		await renderForm(deleteConfig);
		renderFormData($(this).parent().parent());
		//deleteButton($(this).parent().parent());
	});
};

/**
 *
 * Agrega las filas a la tabla
 *
 * @param getData Promesa que regresará la lista de datos
 *
 */
read = async (getData) => {
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
};

renderTextField = async (config) => {
	let div = "";
	let disabled = "";
	let type = "text";

	switch (config.type) {
		case "hidden":
			type = "hidden";
			break;
		case "disabled":
			disabled = "disabled";
		default:
			div = `<div class="mb-3">
						<label for="${config.id}" class="form-label">${config.label}</label>`;
	}

	return `
		${div}
			<input type="${type}" id="${config.id}" class="form-control" placeholder="${config.placeholder}" name="${config.name}" ${disabled}>
		</div>`;
};

renderNumberField = async (config) => {
	return `
		<div class="mb-3">
			<label for="${config.id}" class="form-label">${config.label}</label>
			<input type="number" min="${config.min}" max="${config.max}" id="${config.id}" class="form-control" placeholder="${config.placeholder}" name="${config.name}">
		</div>`;
};

renderSelectField = async (config) => {
	let options = await config.getOptions();
	let optionsHtml = "";

	for (let i = 0; i < options.length; i++) {
		const option = options[i];
		optionsHtml += `
		<option value="${option.value}">${option.text}</option>`;
	}

	return `
	<div class="mb-3">
		<div class="form-group">
			<label for="${config.id}" class="form-label">${config.label}</label>
			<div id="dropdown${config.id}" class="input-group">
				<select id="${config.id}" class="form-control chosen-select" style="width:350px;" name="${config.name}">
					<option value="" selected disabled>${config.placeholder}</option>
					${optionsHtml}
				</select>
			</div>
		</div>
	</div>`;
};

renderCheckboxField = async (config) => {
	return `
	<div class="mb-3 form-check">
		<label for="${config.id}" class="form-check-label" >${config.label}</label>
		<input type="checkbox" id="${config.id}" class="form-check-input" name="${config.name}">
	</div>`
}

renderForm = async (config) => {
	$("#crudModalLabel").text(config.label);
	$("#crudSubmitButton").text(config.buttonText);

	$("#generatedForm").html(loadingRing);

	let html = "";

	renders = {
		text: renderTextField,
		hidden: renderTextField,
		disabled: renderTextField,
		select: renderSelectField,
		number: renderNumberField,
		checkbox: renderCheckboxField
	};

	for (let i = 0; i < config.fields.length; i++) {
		const field = config.fields[i];
		render = renders[field.type];
		html += await render(field);
	}

	$("#generatedForm").html(html);
};

renderFormData = async (row) => {
	values = $(row).children("[modal-form-target]");

	for (let i = 0; i < values.length; i++) {
		const val = $(values[i]);

		let name = val.attr("modal-form-target");

		let text = $(`
			input[name=${name}][type=text],
			input[name=${name}][type=hidden],
			input[name=${name}][type=number]
		`);
		if (text.length > 0) text.val(val.text());

		let select = $(`select[name=${name}]`);
		if (select.length > 0)
			select
				.children(`option:contains("${val.text()}")`)
				.prop("selected", true);

		let checkbox = $(`input[name=${name}][type=checkbox]`);
		if (checkbox.length > 0)
			checkbox.show().prop("checked", val.text() == "true");
	}
};

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
