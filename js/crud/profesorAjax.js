/**
 * Constantes para usar en profesores.php con modalForm.js
 */

const loadingRing = `<div class="text-center align-middle"><div class="lds-dual-ring"></div></div>`;
const alert = (msg) => `
	<div class="alert alert-danger alert-dismissible fade show" role="alert">
		<strong>Error: </strong> ${msg}
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	</div>`;

$(document).ready(async () => {
	let data = await $.ajax({ url: "php/ajax/datosProfesor" });
	let profe = data[0];

	data = await $.ajax({ url: "php/ajax/datosDepartamentos" });
	let optionsDepartamento = `<option value="" selected disabled>Seleccione su departamento</option>`;

	for (let i = 0; i < data.length; i++) {
		const departamento = data[i];
		optionsDepartamento += `<option value="${departamento.Clave}">${departamento.Departamento}</option>`;
	}

	$("#generatedContainer").html(generateCardHTML(profe));

	$('#inputMatricula').val(profe.Matricula);
	$('#inputNombre').val(profe.NombreCompleto);
	$('#inputDepartamento').html(optionsDepartamento);
	$(`option[value=${profe.ClaveDepartamento}]`).prop('selected', true);

	let teacherForm = $('#teacherForm');
	
	teacherForm.on('submit', async (e)=>{
		e.preventDefault();
		
		/* TODO: Debe jalar el php para poder descomentar eso, se ocupa validar
		let response = await $.ajax({
			url: "php/ajax/modificarProfesor_profesor",
			type: "POST",
			data: form.serialize()
		});
		*/
		
		response = {success: true, msg: 'Si jaló paps'};
		//response = {success: false, msg: 'Algo de no sé qué y no sé cuanto error ble'};
		
		if (response.success) {
			displayData(profe);
			$("#editTeacherModal").modal('hide');
		} else {
			$('#teacherAlert').html(alert(response.msg));
		}
		
	});

	let userForm = $('#userForm');
	
	userForm.on('submit', async (e)=>{
		e.preventDefault();
		
		/* TODO: Debe jalar el php para poder descomentar eso, se ocupa validar
		let response = await $.ajax({
			url: "php/ajax/modificarUsuario_profesor",
			type: "POST",
			data: form.serialize()
		});
		*/

		response = {success: true, msg: 'Si jaló paps'};
		//response = {success: false, msg: 'Algo de no sé qué y no sé cuanto error ble'};

		if (response.success) {
			displayData(profe);
			$("#editTeacherModal").modal('hide');
		} else {
			$('#teacherAlert').html(alert(response.msg));
		}

	});
});

const displayData = (profe) => {
	let keys = Object.keys(profe);

	for (let i = 0; i < keys.length; i++) {
		const key = keys[i];
		
		$(`[display=${key}]`).text(profe[key]);
	}
}

const generateCardHTML = (profe) => `
	<div class="text-center">
		<img src="assets/escudoPerfil.png" width="100" class="rounded-circle">
	</div>

	<div class="text-center mt-3">
		<div>
			<span class="bg-secondary p-1 px-5 rounded text-white">Profesor</span>
			<h5 class="mt-2 mb-0" display="NombreCompleto">${profe.NombreCompleto}</h5>
			<span display="Matricula">${profe.Matricula}</span>
		</div>

		<div class="card-body mt-2">
			<small class="text-muted">Datos personales:</small>
			<hr>
			<div class="row">
				<div class="col-sm-4">
					<p class="text-primary mb-0"><i class="fa-solid fa-id-card"></i> <b>Matricula</b></p>
				</div>
				<div class="col-sm-8">
					<p class="text-primary mb-0" display="Matricula">${profe.Matricula}</p>
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-sm-4">
					<p class="mb-0"><i class="fa-solid fa-star"></i> Nombre completo</p>
				</div>
				<div class="col-sm-8">
					<p class="text-muted mb-0" display="NombreCompleto">${profe.NombreCompleto}</p>
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-sm-4">
					<p class="mb-0"><i class="fa-solid fa-calendar-days"></i> Departamento</p>
				</div>
				<div class="col-sm-8">
					<p class="text-muted mb-0" display="Departamento">${profe.Departamento}</p>
				</div>
			</div>
			<hr>
		</div>

		<div class="buttons">
			<button class="btn btn-primary px-4" data-bs-toggle="modal" data-bs-target="#editTeacherModal">Editar datos personales</button>
		</div>

		<div class="card-body mt-2">
			<small class="text-muted">Cuenta:</small>
			<hr>
			<div class="row">
				<div class="col-sm-4">
					<p class="mb-0"><i class="fa-solid fa-user"></i> Usuario</p>
				</div>
				<div class="col-sm-8">
					<p class="text-muted mb-0" display="Usuario">${profe.Usuario}</p>
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-sm-4">
					<p class="mb-0"><i class="fa-solid fa-asterisk"></i> Contraseña</p>
				</div>
				<div class="col-sm-8">
					<p class="text-muted mb-0">**********</p>
				</div>
			</div>
			<hr>
		</div>

		<div class="buttons">
			<button class="btn btn-primary px-4" data-bs-toggle="modal" data-bs-target="#editUserModal">Editar datos de cuenta</button>
		</div>

		<div class="buttons mt-4">
			<button class="btn btn-warning px-4">Contestar Cuestionario</button>
		</div>
	</div>`;

let form = document.getElementById('teacherForm');
form.addEventListener('submit', async function(event){
	event.preventDefault();
	let response = await $.ajax({
		url: "php/ajax/modificarProfesor_personales.php",
		type: "POST",
		data: $("#teacherForm").serialize(),
		success: function (resultado) {
			const successMessage = document.createElement('div');
			try{
				if(resultado.success){
					location.reload();
				}else{
					successMessage.classList.add('alert', 'alert-danger');
				}
				successMessage.textContent = resultado.msg;
			}catch(e){
				successMessage.classList.add('alert', 'alert-danger');
				successMessage.textContent = "Algo salió mal";
			}
			document.getElementById("generatedContainer").appendChild(successMessage);
		}
	});
});

let formU = document.getElementById('userForm');
formU.addEventListener('submit', async function(event){
	event.preventDefault();
	let response = await $.ajax({
		url: "php/ajax/modificarProfesor_contrasena.php",
		type: "POST",
		data: $("#userForm").serialize(),
		success: function (resultado) {
			const successMessage = document.createElement('div');
			try{
				if(resultado.success){
					location.reload();
				}else{
					successMessage.classList.add('alert', 'alert-danger');
				}
				successMessage.textContent = resultado.msg;
			}catch(e){
				successMessage.classList.add('alert', 'alert-danger');
				successMessage.textContent = "Algo salió mal";
			}
			document.getElementById("generatedContainer").appendChild(successMessage);
		}
	});
});