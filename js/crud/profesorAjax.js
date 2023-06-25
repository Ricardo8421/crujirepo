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

	insertButton();

	let teacherForm = $('#teacherForm');
	
	teacherForm.on('submit', async (e)=>{
		e.preventDefault();

		let datos = teacherForm.serializeArray();

		let response = await $.ajax({
			url: "php/ajax/modificarProfesor_personales.php",
			type: "POST",
			data: $.param(datos)
		});

		
		if (response.success) {
			profe.Matricula = datos[0].value;
			profe.NombreCompleto = datos[1].value;
			datos = await $.ajax({ url: "php/ajax/datosProfesor" });
			profe.Departamento = datos[0].Departamento;
			displayData(profe);
			$("#editTeacherModal").modal('hide');
		} else {
			console.log("Tardes las buenas");
			$('#teacherAlert').html(alert(response.msg));
		}
		
	});

	let userForm = $('#userForm');
	
	userForm.on('submit', async (e)=>{
		e.preventDefault();

		let datos = $("#userForm").serializeArray();

		if(datos[1].value==datos[2].value){
			let response = await $.ajax({
				url: "php/ajax/modificarProfesor_contrasena.php",
				type: "POST",
				data: $.param(datos)
			});
			if (response.success) {
				window.location.replace("logout.php");
			} else {
				$('#userAlert').html(alert(response.msg));
			}
		}else{
			$('#userAlert').html(alert("La confirmación de contraseña no coincide con la nueva contraseña"));
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

const insertButton = () => {
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState === 4 && this.status === 200) {
			var objeto = JSON.parse(this.responseText)[0];
			usuario = objeto['Matricula'];
			if (objeto['HaContestado'] == '1'){
				var button = '<button class="btn btn-warning px-4" id = "generar-pdf">Generar PDF</button>';
				$('#PdfOption').append(button);
				document.getElementById("generar-pdf").addEventListener("click", function(){
					var xhttp = new XMLHttpRequest();
					xhttp.onreadystatechange = function() {
						if (this.readyState === 4 && this.status === 200) {
						var objeto = JSON.parse(this.responseText)[0];
						var usuario = objeto['Matricula'];

						var xhttp2 = new XMLHttpRequest();
						xhttp2.onreadystatechange = function() {
							if (this.readyState === 4 && this.status === 200) {
							var json = this.responseText;
							var url = './php/utils/createPdfProfesor.php?json=' + encodeURIComponent(json);
							window.location.href = url;
							}
						};

						xhttp2.open("POST", "php/ajax/datosActividadesRegistradas.php", true);
						xhttp2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
						xhttp2.send("usuario=" + encodeURIComponent(usuario));
						}
					};

					xhttp.open("GET", "php/ajax/datosProfesor.php", true);
					xhttp.send();
				});
			}
			else{
				var button = '<button class="btn btn-warning px-4" id = "Contestar-Encuesta">Contestar Encuesta</button>';
				$('#PdfOption').append(button);
				document.getElementById("Contestar-Encuesta").addEventListener("click", function(){
					window.location.href = './formulario';
				});
			}
		}
	};
	xhttp.open("GET", "php/ajax/datosProfesor.php", true);
	xhttp.send();
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
					<p class="text-muted mb-0" display="NombreUsuario">${profe.NombreUsuario}</p>
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

		<div class="buttons mt-4" id="PdfOption">
		</div>
	</div>`;
