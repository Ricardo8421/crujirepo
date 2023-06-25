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
 * loadingRing : string
 * 		Html que inserta el símbolo de cargando mientras recibe los datos
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

// Funcionalidad general

const retrieveData = async () => {
	return await $.ajax({ url: readUrl });
};
let data = [];

$(document).ready(async () => {
	data = await read(retrieveData);
});

submitForm = (url) => {
	let form = $("#crudForm");

	form.off();
	
	form.on('submit', async (event) => {
		event.preventDefault();
		let response = await $.ajax({
			url: url,
			type: "POST",
			data: form.serialize(),
			success: function (resultado) {
				const successMessage = document.createElement('div');
				try{
					if(resultado.success){
						location.reload();
					}else{
						successMessage.classList.add('alert', 'alert-danger');
					}
					successMessage.textContent = resultado.resultado;
				}catch(e){
					successMessage.classList.add('alert', 'alert-danger');
					successMessage.textContent = "Algo salió mal";
				}
				document.getElementById("errorsongos").appendChild(successMessage);
			}
		});

		console.log(response);

		if (response.success) {
			$('#crudModal').modal('hide')
			read(retrieveData);
		} else {
			renderMsg(response.msg);
		}
	});
}
let filterdata = (data) => {
	let form = $("#crudForm");

	form.off();

	form.on("submit", async (event) => {
		event.preventDefault();
		let filteredData = filtrar(data, await form.serializeArray());
		read(async () => filteredData);
	});
};

addClickListeners = () => {
	$(".btn-create").on("click", async function () {
		renderForm(createConfig);
		submitForm(createUrl);
	});
	$(".btn-read").on("click", async function () {
		renderForm(readConfig);
		filterdata(data);
		
	});
	$(".btn-update").on("click", async function () {
		await renderForm(updateConfig);
		renderFormData($(this).parent().parent());
		submitForm(updateUrl);
	});
	$(".btn-delete").on("click", async function () {
		await renderForm(deleteConfig);
		renderFormData($(this).parent().parent());
		submitForm(deleteUrl);
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
	return data;
};

// Renderers

renderTextField = async (config) => {
	let div = "";
	let disabled = "";
	let type = "text";
	let required = config.required === false? '' : 'required';

	switch (config.type) {
		case "hidden":
			type = "hidden";
			break;
		case "disabled":
			disabled = "readonly";
		default:
			div = `<div class="mb-3">
						<label for="${config.id}" class="form-label">${config.label}</label>`;
	}

	return `
		${div}
			<input ${required} type="${type}" id="${config.id}" class="form-control" placeholder="${config.placeholder}" name="${config.name}" ${disabled}>
		</div>`;
};

renderNumberField = async (config) => {
	let required = config.required === false? '' : 'required';
	return `
		<div class="mb-3">
			<label for="${config.id}" class="form-label">${config.label}</label>
			<input ${required} type="number" min="${config.min}" max="${config.max}" id="${config.id}" class="form-control" placeholder="${config.placeholder}" name="${config.name}">
		</div>`;
};

renderSelectField = async (config) => {
	let options = await config.getOptions();
	let optionsHtml = "";
	let required = config.required === false? '' : 'required';

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
				<select ${required} id="${config.id}" class="form-control chosen-select" style="width:350px;" name="${config.name}">
					<option value="" selected ${required?"disabled":""}>${config.placeholder}</option>
					${optionsHtml}
				</select>
			</div>
		</div>
	</div>`;
};

renderCheckboxField = async (config) => {
	console.log(config);
	let required = config.required === false? '' : 'required';
	return `
	<div class="mb-3 form-check">
		<label for="${config.id}" class="form-check-label" >${config.label}</label>
		<input ${required} type="checkbox" id="${config.id}" class="form-check-input" name="${config.name}">
	</div>`;
};

renderMsg = async (msg) => {
	$('#crudMsg').text(msg);
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
		checkbox: renderCheckboxField,
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
