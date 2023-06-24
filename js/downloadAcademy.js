async function generateFormFields(fields) {
	var formContent = "";
	for (var i = 0; i < fields.length; i++) {
		var field = fields[i];

		if (field.type === "select") {
			var selectOptions = "";
			if (typeof field.getOptions === "function") {
				var options = await field.getOptions();
				for (var j = 0; j < options.length; j++) {
					selectOptions +=
						'<option value="' + options[j].value + '">' + options[j].text + "</option>";
				}
			}

			formContent +=
				'<div class="mb-3">' +
				'<label for="' +
				field.id +
				'" class="form-label">' +
				field.label +
				"</label>" +
				'<select class="form-select" id="' +
				field.id +
				'" name="' +
				field.name +
				'" placeholder="' +
				field.placeholder +
				'">' +
				selectOptions +
				"</select>" +
				"</div>";
		}
	}

	return formContent;
}

$(document).ready(function () {
	$(".btn-download").on("click", async function () { // Convertir la función en asincrónica
		var academiaSelect = {
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
		};
		var formFields = [academiaSelect];

		var formContent = await generateFormFields(formFields); // Esperar a que se generen los campos del formulario

		$("#generatedForm").html(formContent);

		$("#crudModalLabel").text("Zona de descargas");
		$("#crudSubmitButton").text("Descargar");

		$("#crudForm").off("submit").on("submit", function (event) {
			event.preventDefault();
            var academia = $("#inputAcademia").val();
            var url = "php/ajax/datosAcademiasProfesor.php?id=" + academia;
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    let json = this.responseText;
					var xhr = new XMLHttpRequest();
					xhr.open("POST", './php/utils/createPdfAcademia.php', true);
					xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					xhr.onreadystatechange = function() {
						if (xhr.readyState == 4 && xhr.status == 200) {
							let response = JSON.parse(xhr.responseText);
							if (response.error) {
									Swal.fire({
										icon: 'info',
										title: 'Aviso',
										text: 'Aún no hay datos para mostrar',
										showConfirmButton: false,
										timer: 2000
									});                          
									return ; 
							} else {
								var pdfLocation = response.pdf_location;
								var downloadUrl = './php/utils/downloadPdf.php?file=' + encodeURIComponent(pdfLocation);
								window.location.href = downloadUrl;
							}
						}
					}
					xhr.send("json=" + encodeURIComponent(json));
                }
            }
            xhttp.open("GET", url, true);
            xhttp.send();
            
		});

		$("#crudModal").modal("show");
	});
});