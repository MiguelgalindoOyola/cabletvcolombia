function cargadivconsulta(id, url, data) {
    $("#" + id).show();
    $.ajax({
        type: "POST",
        url: url,
        data: data,
        success: function (html) {
            if (html == 'true') {
                $("#" + id).html(html);
            } else {
                $("#" + id).html(html);
            }
        },
        beforeSend: function () {
            $("#" + id).html("<p><div class='text-center'><img src='http://localhost/citasapp/public/common/img/ajax-loader.gif'></p>");
        },
        timeout: 10000,
    });
}

$(document).on('click', '#agregarFila', function () {
        original = $("#tabla tbody tr.fila-base");
        fila = original.clone();
        $(':input', fila).each(function () {
            var type = this.type;
            var tag = this.tagName.toLowerCase();
//limpiamos los valores de los campos…
            if (type == 'text' || type == 'password' || tag == 'textarea')
                this.value = '';
// excepto de los checkboxes y radios, le quitamos el checked
// pero su valor no debe ser cambiado
            else if (type == 'checkbox' || type == 'radio')
                this.checked = false;
// los selects le ponesmos el indice a -
            else if (tag == 'select')
                this.selectedIndex = 0;
        });

        fila.removeClass('fila-base');
        fila.show();
        fila.appendTo("#tabla tbody");
    });



    // Evento que selecciona la fila y la elimina 
    $(document).on("click", ".eliminarFila", function () {
        var parent = $(this).parents().get(0);
        $(parent).remove();
    });
