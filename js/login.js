$(document).ready(()=>{
    $("#login_form").on('submit', (e)=>{
		e.preventDefault();
		login();
	});
})

async function login() {
    let response = await $.ajax({
        url: 'php/ajax/login.php',
        type: 'POST',
        data: $("#login_form").serialize()
    });

    if (response.error) {
        $("#login_message").html(`<p class="text-danger">${response.error}</p>`);
    } else {
        $(location).attr('href', response.redirectTo);
    }
}