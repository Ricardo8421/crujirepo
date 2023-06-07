/**
 * Constantes para usar en profesores.php con modalForm.js
 */

// ups
const loadingRing = `<div class="text-center align-middle"><div class="lds-dual-ring"></div></div>`;

const generateRowHTML = (profe) => `
    <div class="d-none" id="dataHolder">
        <input type="hidden" value="${profe.NombreCompleto}" modal-form-target="name">
        <input type="hidden" value="${profe.departamento}" modal-form-target="name">
        <input type="hidden" value="${profe.usuario}" modal-form-target="name">
        <input type="hidden" value="${profe.NombreCompleto}" modal-form-target="name">
    </div>

    <div class="text-center">
        <img src="assets/blueLogoEscom.png" width="100" class="rounded-circle">
    </div>

    <div class="text-center mt-3">
        <span class="bg-secondary p-1 px-4 rounded text-white">Profesor</span>
        <h5 class="mt-2 mb-0">${profe.NombreCompleto}</h5>
        <span>${profe.Matricula}</span>

        <form class="mt-3">
            <p class="fonts">Datos personales:</p>
            <fieldset class="px-4 mt-1" id="generatedForm">

            </fieldset>
        </form>

        <div class="buttons">
            <button class="btn btn-warning px-4">Contestar Cuestionario</button>
            <button class="btn btn-primary px-4 ms-3">Contact</button>
        </div>
    </div>`;

const crudFields = () => [
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

const readConfig = {
	buttonText: "Editar datos",
	fields: crudFields()
};
const updateConfig = {
	buttonText: "Guardar cambios",
	fields: crudFields()
};

$(document).ready(() => {
	let temp = addClickListeners;
    addClickListeners = () => {
        temp();
        renderForm(readConfig);
        renderFormData()
    }
});