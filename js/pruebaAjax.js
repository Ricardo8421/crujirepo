async function ask() {
    let test = await $.ajax('formulario.php');
    console.log(test);
}

ask();
