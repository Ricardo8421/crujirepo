/**
 * Constantes para usar en materias.php con modalForm.js
 */

const createUrl = "php/ajax/insertarMateria.php";
const readUrl = "php/ajax/datosMaterias.php";
const updateUrl = "php/ajax/modificarMateria.php";
const deleteUrl = "php/ajax/eliminarMateria.php";

const loadingRing = `
	<tr><th colspan="8" class="text-center align-middle">
		<div class="lds-dual-ring"></div>
	</th></tr>`;

const generateRowHTML = (materia) =>
	`<tr>
		<td class="d-none" modal-form-target="clave">${materia.Clave}</td>
		<td class="text-center align-middle" modal-form-target="nombre">${materia.Materia}</td>
		<td class="text-center align-middle" modal-form-target="academia">${materia.Academia}</td>
		<td class="text-center align-middle" modal-form-target="semestre">${materia.Semestre}</td>
		<td class="text-center align-middle" modal-form-target="plan">${materia.Plan}</td>
		<td class="text-center align-middle" modal-form-target="carrera">${materia.Carrera}</td>
		<td class="text-center align-middle">
			<button type="button" class="btn btn-primary btn-sm px-3 btn-update"
				data-bs-toggle="modal" data-bs-target="#crudModal">
				<i class="fas fa-pencil"></i>
			</button>
		</td>
		<td class="text-center align-middle">
			<button type="button" class="btn btn-danger btn-sm px-3 btn-delete"
				data-bs-toggle="modal" data-bs-target="#crudModal">
				<i class="fas fa-trash"></i>
			</button>
		</td>
	</tr>`;

const crudFields = () => [
	{
		type: "text",
		label: "Clave",
		id: "inputClave",
		name: "clave",
		placeholder: "Clave única de la materia",
	},
	{
		type: "text",
		label: "Nombre",
		id: "inputNombre",
		name: "nombre",
		placeholder: "Nombre de la materia",
	},
	{
		type: "select",
		label: "Academia",
		id: "inputAcademia",
		name: "academia",
		placeholder: "Seleccione la academia",
		getOptions: async () => {
			let academias = await $.ajax({
				url: "php/ajax/datosAcademias.php",
			});

			let res = [];
			for (let i = 0; i < academias.length; i++) {
				const academia = academias[i];
				res[i] = { value: academia.Id, text: academia.Academia };
			}

			return res;
		},
	},
	{
		type: "number",
		min: 1,
		max: 8,
		label: "Semestre",
		id: "inputSemestre",
		name: "semestre",
		placeholder: "1ro a 8vo semestre",
	},
	{
		type: "number",
		min: 2009,
		max: 2099,
		label: "Plan",
		id: "inputPlan",
		name: "plan",
		placeholder: "Año del plan académico",
	},
	{
		type: "select",
		label: "Carrera",
		id: "inputCarrera",
		name: "carrera",
		placeholder: "Seleccione la carrera",
		getOptions: async () => {
			return [
				{ value: "C", text: "Ing. Sistemas Computacionales" },
				{ value: "B", text: "Ing. Inteligencia Artificial" },
				{ value: "A", text: "Lic. Ciencia de Datos" },
			];
		},
	},
];

const updateFields = () => {
	let fields = crudFields();
	fields.shift();
	fields.unshift({
		type: "disabled",
		label: "Clave",
		id: "inputClave",
		name: "clave",
		placeholder: "Clave única de la materia",
	});
	return fields;
};

const readFields = () => {
	let fields = crudFields();
	for (let i = 0; i < fields.length; i++) {
		const field = fields[i];
		field.label = "Buscar por " + field.label.toLowerCase();
	}
	return fields;
}

const createConfig = {
	label: "Registrando materia",
	buttonText: "Registrar",
	fields: crudFields(),
};
const readConfig = {
	label: "Filtrando",
	buttonText: "Filtrar",
	fields: readFields(),
};
const updateConfig = {
	label: "Actualizando los datos",
	buttonText: "Guardar cambios",
	fields: updateFields()
};
const deleteConfig = {
	label: "¿Está seguro de querer borrar este registro?",
	buttonText: "Borrar",
	fields: [
		{ type: "hidden", name: "clave" },
		{
			type: "disabled",
			label: "Materia a borrar",
			name: "nombre",
		},
	],
};
