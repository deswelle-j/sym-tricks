$('#add-image').click(function(){
    const index = +$('#widgets-counter').val();

    const tmpl = $('#trick_images').data('prototype').replace(/__name__/g, index);

    $('#trick_images').append(tmpl);

    $('#widgets-counter').val(index + 1);

    handleDelete()
});

function handleDelete() {
    $('button[data-action="delete"').click(function(){
        const target = this.dataset.target
        $(target).remove();
    })
}

function updateWidgetsConter() {
    const count = +$('#trick_images div.form-group').length;

    $('#widgets-counter').val(count);
}
updateWidgetsConter()
handleDelete()