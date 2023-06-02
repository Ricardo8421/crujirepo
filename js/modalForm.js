addClickListeners = () => {
	$('.btn-edit').on('click', function(){
        editData($(this).parent().parent());
    });
    $('.btn-delete').on('click', function(){
        deleteData($(this).parent().parent());
    });
}

editData = (row) => {
    values = $(row).children("[modal-form-target]");

    for (let i = 0; i < values.length; i++) {
        const val = $(values[i]);

        target = '#' + val.attr('modal-form-target');

        input = $(`input${target}`);
        if (input) input.val(val.text());

        select = $(`select${target}`);
        if (select) select.children(`option:contains("${val.text()}")`).prop("selected", true);
    }
}

deleteData = (row) => {
    id = $(row).children().first().text();
    console.log(id);
    $("#deleteConfirmationInput").val(id);
}

