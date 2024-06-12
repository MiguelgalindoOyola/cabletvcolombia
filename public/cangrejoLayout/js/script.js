var RUTA_URL = "http://localhost/CABLETVCOLOMBIA/";
$(document).ready(function () {

    $(document).on("click", "#btnEditarCliente", function () {
        $('#modalunico5').modal('show');
        cargadivconsulta('contenidomodal5', 'Formulariousuario/' + $(this).val(), '');
    });


//carga modal clientes

    $(document).on("click", "#btnBuscar", function () {
        $('#modalunico').modal('show');
        cargadivconsulta('contenidomodal1', 'FormularioCliente/', '');

    });

    $(document).on("click", "#btnBusca", function () {
        var cod = document.getElementById("cmbelemento").value;
        if (cod == '0000') {
            swal('Selecionar Opcion Valida');

        } else {

            cargadivconsulta('divcarga', 'Formulariousuario/' + cod);
        }
    });


//eliminar barrio
    $('#modalEliminarSedes').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var recipent = button.data('id')
        var nom = button.data('nom')
        var modal = $(this);
        modal.find('h4').text('Esta seguro que desea eliminar esta sede: ' + nom + '?');
        modal.find('#enviar').attr('href', 'EliminarBarrio/' + recipent);
    });


//    eliminar
//     servicio
    $('#modalEliminarServicio').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var recipent = button.data('id')
        var nom = button.data('nom')
        var modal = $(this);
        modal.find('h4').text('Esta seguro que desea eliminar esteservicio: ' + nom + '?');
        modal.find('#enviar').attr('href', 'EliminarServicios/' + recipent);
    });
//    editar barrio
    $(document).on('click', '#btnEditarBarrio', function () {
        cargadivconsulta('CargaformBarrios', 'FormularioBarrio/' + $(this).val(), '');
    });
//    editar servicio
    $(document).on("click", "#btnEditarServicio", function () {
        $('#modalgeneral').modal('show');
        cargadivconsulta('contenidomodal', 'FormularioServicios/' + $(this).val(), '');

    });
//    novedades servicios
    $(document).on("click", "#btnNovedadesServicios", function () {
        $('#modalgeneral').modal('show');
        cargadivconsulta('contenidomodal', 'FormularioNovedades/' + $(this).val(), '');

    });
    $(document).ready(function () {
        $('#myBtn').click(function () {
            $(".selectpicker > option:eq(1)").data("subtext", "Look I'm changed");
            $(".selectpicker").selectpicker('refresh');
        });
    });
//    proveedores
    $(document).on('click', '#btnAgregarProveedores', function () {
        cargadivconsulta('vista', 'formularioproveedores/', '');
    });
    $(document).on('click', '#btnEditarproveedores', function () {
        cargadivconsulta('vista', 'formularioproveedores/' + $(this).val(), '');
    });
//    $('#modalEliminarMedicos').on('show.bs.modal', function (event) {
//        var button = $(event.relatedTarget)
//        var recipent = button.data('id')
//        var nom = button.data('nom')
//        var modal = $(this);
//        modal.find('h4').text('Esta seguro que desea eliminar este Proveedor: ' + nom + '?');
//        modal.find('#enviar').attr('href', 'bajaproveedor/' + recipent);
//    });
//    clientes
    $(document).on('click', '#btnAgregarClientes', function () {
        cargadivconsulta('vista', 'formularioclientes/', '');
    });
    $(document).on('click', '#btnEditarclientes', function () {
        cargadivconsulta('vista', 'formularioclientes/' + $(this).val(), '');
    });
    $('#modalClientes').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var recipent = button.data('id')
        var nom = button.data('nom')
        var modal = $(this);
        modal.find('h4').text('Esta seguro que desea eliminar este Cliente: ' + nom + '?');
        modal.find('#enviar').attr('href', 'bajacliente/' + recipent);
    });
    $(document).on('click', '#btnVerCertificados', function () {
        $('#ModalCertificados').modal('show');
        var data = {
            'id': $(this).val()
        };
        cargadivconsulta('contenidoModalCerti', 'vercertificados', data);
    });
    $(document).on('click', '#btnHistoriaClinica', function () {
        var data = {
            'id': $(this).val()
        };
        cargadivconsulta('vistaCitas', 'verhistoriaclinica', data);
    });
    $(document).on('click', '#btnAtender', function () {
        var data = {
            'id': $(this).val()
        };
        cargadivconsulta('vistaCitas', 'ingresardatospaciente/', data);
    });
    $(document).on('click', '#btnArchivos', function () {
        cargadivconsulta('vistaArchivos', 'vistaarchivos', '');
        $(this).text('Cancelar');
        $(this).attr('id', 'btnCancelar');
    });
    $(document).on('click', '#btnCancelar', function () {
        $('#vistaArchivos').empty();
        $(this).text('Subir certificados');
        $(this).attr('id', 'btnArchivos');
    });
    $(document).on('click', '#btnOtros', function () {
        $('#otrosArchivos').append('<div class="form-group">\n\
<div class="form-row">\n\
<div class="col-md-6">\n\
<label>Seleccione archivo</label></div>\n\
<div class="col-md-6">\n\
<input type="file" name="txtCertificado[]"></div></div></div>');
    });
    $(document).on('click', '#btnGenerarReporte', function () {
        var fi = $('#txtFechaI').val();
        var ff = $('#txtFechaF').val();
        var data = {
            'fechai': fi,
            'fechaf': ff
        };
        if (fi.length > 0 && ff.length > 0) {
            cargadivconsulta('cargarCitas', 'generarreporte/', data);
        } else {
            new PNotify({
                title: 'Mensaje alerta',
                text: 'Seleccione fechas',
                type: 'danger'
            });
        }
    });
    $(document).on('click', '#btnEnviar', function () {
        var password = $('#txtPassword').val();
        var data = {
            'password': $('#txtPassword').val()
        };
        if (password.length > 0) {
            cargadivconsulta('formularioEditar', 'formularioeditar', data);
        } else {
            alert('Digite contraseña');
        }
    });
    $(document).on('click', '#btnVerProgramar', function () {
        var data = {
            'id': $(this).val()
        };
        $('#CitasModal').modal('show');
        cargadivconsulta('contenidoModal', RUTA_URL + 'usuario/verestadocita', data);
    });
    $(document).on('click', '#btnAgregarRoles', function () {
        cargadivconsulta('vista', 'formularioroles/', '');
    });
    $(document).on('click', '#btnEditarRoles', function () {
        var data = {
            'id': $(this).val()
        };
        cargadivconsulta('vista', 'formularioroles/', data);
    });
    $(document).on('click', '#btnBuscarDatos', function () {
        $('#btnEstado').val('I');
        var data = $('#formdatos').serialize();
        cargadivconsulta('vista', 'buscarcitas/', data);
    });
    $(document).on('click', '#btnCancelarCita', function () {
        var id = $('#codCita').val();
        var data = {
            'txtCodigo': id
        };
        $.ajax({
            type: 'POST',
            url: 'cancelarcita',
            data: data,
            dataType: 'json',
            success: function (data) {
                if (data.response == 'Error') {
                    new PNotify({
                        title: 'Mensaje confirmacion!',
                        text: data.mensaje,
                        type: 'error'
                    });
                } else {
                    $('#ProgramarModal').modal('hide');
                    $('#vista').load(RUTA_URL + 'administracion/cargarcitas');
                    new PNotify({
                        title: 'Mensaje confirmacion!',
                        text: data.mensaje,
                        type: 'success'
                    });
                }
            }
        });
    });

    $(document).on('click', '#btnEditarEspe', function () {
        cargadivconsulta('vista', 'formularioespe/' + $(this).val(), '');
    });
    $(document).on('click', '#btnAgregarEspe', function () {
        cargadivconsulta('vista', 'formularioespe/', '');
    });

    $(document).on('click', '#btnEditarSedes', function () {
        cargadivconsulta('vista', 'formulariosedes/' + $(this).val(), '');
    });
    $(document).on('click', '#btnAgregarSedes', function () {
        cargadivconsulta('vista', 'formulariosedes/', '');
    });
    $(document).on('click', '#btnCerrarModal', function () {
        $('#btnEstado').val('A');
    });
    $(document).on('click', '#btnGuardar', function () {
        var data = $('#formProgramar').serialize();
        $('#lblMensaje').empty();
        $.ajax({
            type: 'POST',
            url: 'programarCita',
            data: data,
            dataType: 'json',
            success: function (data) {
                if (data.response == 'Error') {
                    $('#lblMensaje').append('<div class="alert alert-danger" role="alert">' + data.mensaje + '</div>');
                } else {
                    $('#ProgramarModal').modal('hide');
                    $('#vista').load(RUTA_URL + 'administracion/cargarcitas');
                    new PNotify({
                        title: 'Mensaje confirmacion!',
                        text: data.mensaje,
                        type: 'success'
                    });
                }
            }
        });
    });
    $(document).on('change', '#selEspecialidad', function () {
        cargadivconsulta('CargarMedico', 'cargamedicos/' + $(this).val(), '');
    });
    $(document).on('click', '#btnProgramar', function () {
        $('#btnEstado').val('I');
        $('#ProgramarModal').modal('show');
        cargadivconsulta('contenidoModal', 'programarcitas/' + $(this).val(), '');
    });
    setTimeout(function () {
        $("#mensaje").fadeOut(1500);
    }, 3000);
    window.onclick = function (event) {
        var modal = document.getElementById('ProgramarModal');
        if (event.target == modal) {
            $('#btnEstado').val('A');
        }
    }
});
//function cargarcitas() {
//    var bandera = $('#btnEstado').val();
//    if (bandera == 'A') {
//        $('#vista').load(RUTA_URL + 'administracion/cargarcitas');
//    }
//}
//setInterval("cargarcitas()", 6000);
//jQuery(window).load(function () {
//
//    $(".loader-img").fadeOut();
//    $(".loader").fadeOut("slow");
//});
//        