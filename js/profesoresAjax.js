$(document).ready(async () => {
	$("#generatedContainer").html("");

	profesores = await $.ajax({ url: "php/ajax/datosProfesores.php" });

	profesores.forEach((profe) =>
		$("#generatedContainer").append(generateTeacherHTML(profe))
	);

	addClickListeners();
});

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

generateTeacherHTML = (profe) =>
	`
	<tr class="info-container">
		<td class="d-none" modal-form-target="inputIdUsuarioProfesor">${profe.IdUsuario}</td>
		<td class="d-none" modal-form-target="inputAccesoCongeladoProfesor">${profe.AccesoCongelado}</td>
		<td class="text-center align-middle" modal-form-target="inputMatriculaProfesor">${profe.Matricula}</td>
		<td class="text-center align-middle" modal-form-target="inputNombreProfesor">${profe.NombreCompleto}</td>
		<td class="text-center align-middle" modal-form-target="inputDepartamentoProfesor">${profe.Departamento}</td>
		<td class="text-center align-middle">
			<button type="button" class="btn btn-${profe.AccesoCongelado == 1 ? 'danger' : 'success'} disabled btn-sm px-3 btn-access">
				<i class="fas fa-${profe.AccesoCongelado == 1 ? 'x' : 'check'}"></i>
			</button>
		</td>
		${generatePDFButtons(profe.HaContestado)}
		<td class="text-center align-middle">
			<button type="button" class="btn btn-primary btn-sm px-3 btn-edit"
				data-bs-toggle="modal" data-bs-target="#editDataModal">
				<i class="fas fa-pencil"></i>
			</button>
		</td>
		<td class="text-center align-middle">
			<button type="button" class="btn btn-danger btn-sm px-3 btn-delete"
				data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal">
				<i class="fas fa-trash"></i>
			</button>
		</td>
	</tr>
	`;
