$(document).ready(async () => {
	$("#generatedContainer").html("");

	materias = await $.ajax({ url: "php/ajax/datosMaterias.php" });

	materias.forEach(materia =>
		$("#generatedContainer").append(generateSubjectHTML(materia))
	);

	addClickListeners();
});

generateSubjectHTML = materia =>
	`<tr>
		<td class="d-none" modal-form-target="inputClaveMateria">${materia.Clave}</td>
		<td class="text-center align-middle" modal-form-target="inputNombreMateria">${materia.Materia}</td>
		<td class="text-center align-middle" modal-form-target="inputAcademiaMateria">${materia.Academia}</td>
		<td class="text-center align-middle" modal-form-target="inputSemestreMateria">${materia.Semestre}</td>
		<td class="text-center align-middle" modal-form-target="inputPlanMateria">${materia.Plan}</td>
		<td class="text-center align-middle" modal-form-target="inputCarreraMateria">${materia.Carrera}</td>
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
	</tr>`;
