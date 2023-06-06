/**
 * Constantes para usar en profesores.php con modalForm.js
 */

const url = "php/ajax/datosProfesores.php";
const loadingRing = `
	<tr><th colspan="8" class="text-center align-middle">
		<div class="lds-dual-ring"></div>
	</th></tr>`;

const generateRowHTML = (profe) =>
	`
	<tr class="info-container">
		<td class="d-none" modal-form-target="idUsuario">${profe.IdUsuario}</td>
		<td class="d-none" modal-form-target="accesoCongelado">${profe.AccesoCongelado == 1}</td>
		<td class="text-center align-middle" modal-form-target="matricula">${profe.Matricula}</td>
		<td class="text-center align-middle" modal-form-target="nombre">${profe.NombreCompleto}</td>
		<td class="text-center align-middle" modal-form-target="departamento">${profe.Departamento}</td>
		<td class="text-center align-middle">
			<button type="button" class="btn btn-${profe.AccesoCongelado == 1 ? 'danger' : 'success'} disabled btn-sm px-3 btn-access">
				<i class="fas fa-${profe.AccesoCongelado == 1 ? 'x' : 'check'}"></i>
			</button>
		</td>
		${generatePDFButtons(profe.HaContestado==1)}
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
	</tr>
	`;


generatePDFButtons = (haContestado) => {
	if (haContestado) {
		return `
		<td class="text-center align-middle">
			<button type="button" class="btn btn-warning btn-sm px-3 btn-pdf">
				<i class="fa-regular fa-file-pdf"></i>
			</button>
		</td>
		<td class="text-center align-middle">
			<button type="button" class="btn btn-danger btn-sm px-3 btn-reset-form">
				<i class="fa-solid fa-arrow-rotate-left"></i>
			</button>
		</td> `;
	}

	return `
	<td class="text-center align-middle" colspan="2">
		Este usuario no ha respondido el cuestionario
	</td> `;
};

const crudFields = () => [
	{
		type: "hidden",
		id: "inputIdUsuario",
		name: "idUsuario"
	},
	{
		type: "hidden",
		id: "inputAcceso",
		name: "accesoCongelado"
	},
	{
		type: "disabled",
		label: "Matricula",
		id: "inputMatricula",
		name: "matricula",
		placeholder: "Matricula del profesor",
	},
	{
		type: "text",
		label: "Nombre",
		id: "inputNombre",
		name: "nombre",
		placeholder: "Nombre completo del profesor",
	},
	{
		type: "select",
		label: "Departamento",
		id: "inputDepartamento",
		name: "departamento",
		placeholder: "Seleccione el departamento",
		getOptions: async () => {
			let departamentos = await $.ajax({
				url: "php/ajax/datosDepartamentos.php",
			});

			let res = [];
			for (let i = 0; i < departamentos.length; i++) {
				const departamento = departamentos[i];
				res[i] = { value: departamento.Id, text: departamento.Departamento };
			}

			return res;
		},
	}
];

createFields = () => {
	let fields = crudFields().splice(2);
	fields[0].type='text';
	return fields;
};

updateFields = () => {
	let fields = crudFields();
	fields[fields.length] = {
		type: "checkbox",
		label: "Congelar el acceso",
		id: "inputAccesoCongelado",
		name: "accesoCongelado"
	}
	return fields;
}

const createConfig = {
	label: "Registrando profesor",
	buttonText: "Registrar",
	fields: createFields()
};
const readConfig = {
	label: "Filtrando",
	buttonText: "Filtrar",
	fields: createFields()
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
		{ type: "hidden", name: "matricula" },
		{
			type: "disabled",
			label: "Profesor a borrar",
			name: "nombre"
		},
	]
};
