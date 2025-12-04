$(document).ready(function() {
    
    //* cambia el formulario segun el rol seleccionado
    //* agarra el cambio del value del input radio
    $('input[name="rol"]').change(function() {
        //* this para agarra el input que esta seleccionado
        let rol = $(this).val();
        
        //* quitar clase active de todas las opciones
        //* quiere decuir que no se pone el boton verde
        $('.role-option').removeClass('active');
        //* se le agrega la clase active al boton seleccionado
        $(this).closest('.role-option').addClass('active');
        
        //* dependiendo del rol seleccionado, se ocultan o se muestran camposlos inputs
        if (rol === 'ADMIN') {
            $('#numeroFichaGroup').addClass('d-none');
            $('#numero_ficha').prop('required', false);
            $('#passwordGroup').removeClass('d-none');
            $('#password').prop('required', true);
            $('#linkRegistro').addClass('d-none');
        } else {
            $('#numeroFichaGroup').removeClass('d-none');
            $('#numero_ficha').prop('required', true);
            $('#passwordGroup').addClass('d-none');
            $('#password').prop('required', false);
            $('#linkRegistro').removeClass('d-none');
        }
    });

    // Enviar formulario
    $('#loginForm').submit(function(e) {
        e.preventDefault();
        
        //* agarra el valor del rol seleccionado
        let rol = $('input[name="rol"]:checked').val();
        let correo = $('#correo').val().trim();
        let numero_ficha = $('#numero_ficha').val().trim();
        let password = $('#password').val().trim();
        
        
        
        $.ajax({
            url: '../CONTROLLER/login.php',
            type: 'POST',
            data: {
                rol: rol,
                correo: correo,
                numero_ficha: numero_ficha,
                password: password
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Bienvenido!',
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {

                        //!´´´´´´
                        window.location.href = response.redirect;
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al procesar la solicitud'
                });
            }
        });
    });
});
