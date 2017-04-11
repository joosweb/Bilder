$(document).ready(function() {
    $('#register-form').submit(function(e) {
        e.preventDefault();
        var nombres = $('#nombres').val();
        var apellidos = $('#apellidos').val();
        var email = $('#email').val();
        var passw = $('#password').val();
        var captcha = $("#g-recaptcha-response").val();
        if (!$('#profile-sign-in__remember').prop('checked')) {
            $('#msg-error-register').html('<div class="alert alert-dismissible alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Debe aceptar los terminos y politicas de privacidad.</div>');
            return false;
        }
        var data = 'nombres=' + nombres + '&apellidos=' + apellidos + '&email=' + email + '&password=' + passw + '&captcha=' + captcha;
        /* login submit */
        $.ajax({
            type: 'POST',
            url: 'includes/sign-up.php',
            data: data,
            beforeSend: function() {
                $("#register-button").html('<i class="fa fa-cloud-upload" aria-hidden="true"></i> Registrando <i class="fa fa-spinner fa-spin fa-lg fa-fw"></i>');
            },
            success: function(response) {
                if (response == 'ok') {
                    window.location.href = "index.php?s=profile&msg=welcome";
                } else if (response == 'emailexist') {
                    $('#msg-error-register').html('<div class="alert alert-dismissible alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>El email ya esta registrado.</strong>  por favor intente con otro.</div>');
                    $("#register-button").html('Registrarme');
                } else if (response == 'vacios') {
                    $('#msg-error-register').html('<div class="alert alert-dismissible alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Por favor rellene todos los campos.</div>');
                    $("#register-button").html('Registrarme');
                } else if (response == 'ErrorCode') {
                    $('#msg-error-register').html('<div class="alert alert-dismissible alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Debe comprobar que no es un robot.</div>');
                    $("#register-button").html('Registrarme');
                } 
                else {
                    $('#msg').html('<div class="alert alert-dismissible alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>  <strong>Error!</strong> Por favor ingrese nuevamente sus datos.</div>');
                    $("#Entrar").html('Entrar');
                }
            }
        });
        /* login submit */
    });

    $('#ValidarDocumento').submit(function(e) {
        e.preventDefault();

        var NumeroDocumento = $('#Ndocumento').val();
        var data = 'documento=' + NumeroDocumento;

        if(NumeroDocumento == '') {
            alert('Ingrese el Nº de documento');
            return false;
        }

        $.ajax({
            type: 'POST',
            url: 'includes/checkDocument.php',
            data: data,
            beforeSend: function() {
                $("#resultado").html('<center><img src="img/loading/loading.gif" width="100" alt="Cargando..."></center>');
            },
            success: function(response) {
                if (response == 'caducado') {
                    $('#resultado').html('<div class="alert alert-dismissible alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button> <i class="fa fa-exclamation-circle" aria-hidden="true"></i> Este documento ha expirado.</div>');
                } else if (response == 'Noexiste') {
                    $('#resultado').html('<div class="alert alert-dismissible alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button> <i class="fa fa-exclamation-circle" aria-hidden="true"></i> No se encontraron resultados.</div>');
                } else if (response == 'vacios') {
                    $('#resultado').html('<div class="alert alert-dismissible alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Por favor rellene todos los campos.</div>');
                } else {
                    $('#resultado').html(response);
                }
            }
        });

    });

    $('#formCpassword').submit(function(e) {
        e.preventDefault();

        var pass = $('#password').val();
        var Npass = $('#Npassword').val();
        var RPpass = $('#RNpassword').val();
        var captcha = $("#g-recaptcha-response").val();

        var data = 'oldpass=' + pass + '&newpass=' + Npass + '&rnewpass=' + RPpass + '&captcha=' + captcha;

        $.ajax({
            type: 'POST',
            url: 'includes/changePassword.php',
            data: data,
            beforeSend: function() {
                $("#CambiarContrasena").html('<i class="fa fa-cloud-upload" aria-hidden="true"></i> Verificando <i class="fa fa-spinner fa-spin fa-lg fa-fw"></i>');
            },
            success: function(response) {
                if (response == 'ok') {
                   $('#msg-changeP').html('<div class="alert alert-dismissible alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><i class="fa fa-check-square" aria-hidden="true"></i> <strong>Su contraseña ha sido actualizada.</strong>  ya puede entrar en bilder con su nueva contraseña.</div>');
                   $("#CambiarContrasena").html('Cambiar Contraseña');
                } else if (response == 'error') {
                    $('#msg-changeP').html('<div class="alert alert-dismissible alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Ocurrió un error durante la actualización, por favor intente nuevamente de lo contrario contacte con un administrador.</div>');
                    $("#CambiarContrasena").html('Cambiar Contraseña');
                } else if (response == 'equalToFalse') {
                    $('#msg-changeP').html('<div class="alert alert-dismissible alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Verifique la confirmación de la nueva contraseña, esta debe coincidir con la nueva contraseña. </div>');
                    $("#CambiarContrasena").html('Cambiar Contraseña');
                } else if (response == 'PassEmpty') {
                    $('#msg-changeP').html('<div class="alert alert-dismissible alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button><i class="fa fa-exclamation-circle" aria-hidden="true"></i> No pueden haber campos vacios en el formulario. </div>');
                    $("#CambiarContrasena").html('Cambiar Contraseña');
                } else if(response == 'Pfalse') {
                    $('#msg-changeP').html('<div class="alert alert-dismissible alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button><i class="fa fa-exclamation-circle" aria-hidden="true"></i> La contraseña actual ingresada es incorrecta. </div>');
                    $("#CambiarContrasena").html('Cambiar Contraseña');
                }
                else if(response == 'ErrorCode'){
                    $('#msg-changeP').html('<div class="alert alert-dismissible alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Verificación captcha incorrecto!. </div>');
                    $("#CambiarContrasena").html('Cambiar Contraseña');
                }
                else {
                    $('#msg-changeP').html(response);
                }
            }
        });
    });    
});