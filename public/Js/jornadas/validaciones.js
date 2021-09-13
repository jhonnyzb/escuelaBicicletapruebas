$(function()
{
    function validarTallerDeMecanica()
    {
        if($('select[name="Tipo"]').val() === 'Taller de mecánica' || $('select[name="Tipo"]').val() === 'Ciclo expedición')
        {
            $('select[name="Destreza_Inicial_Usuario"]').prop('required', false).val('');
            $('select[name="Avance_Logrado_Usuario"]').prop('required', false).val('');
        } else {
            $('select[name="Destreza_Inicial_Usuario"]').prop('required', true).val('');
            $('select[name="Avance_Logrado_Usuario"]').prop('required', true).val('');
        }
	}
	
    $('input[name="Acudiente_Es_Usuario"]').on('click', function(e)
    {
        if($(this).is(':checked'))
        {
            $('input[name="Documento_Acudiente"]').val($('input[name="Documento_Usuario"]').val());
            $('input[name="Nombre_Acudiente"]').val($('input[name="Nombre_Usuario"]').val());
        } else {
            $('input[name="Documento_Acudiente"]').val('');
            $('input[name="Nombre_Acudiente"]').val('');
        }
    });

    $('input[name="Nombre_Usuario"]').on('keyup', function(e)
    {
        if($('input[name="Acudiente_Es_Usuario"]').is(':checked'))
        {
            $('input[name="Nombre_Acudiente"]').val($(this).val());
        }
    });

    $('input[name="Documento_Usuario"]').on('keyup', function(e)
    {
        if($('input[name="Acudiente_Es_Usuario"]').is(':checked'))
        {
            $('input[name="Documento_Acudiente"]').val($(this).val());
        }
    });

    $('select[name="Id_Parque"]').on('change', function (e) {
        var localidad = $('select[name="Id_Parque"] option:selected').data('localidad');
        $('select[name="Id_Localidad"]').selectpicker('val', localidad);
    });

    $('select[name="Tipo"]').on('change', function (e) {
        validarTallerDeMecanica();
    });

    $('input[name="Edad_Usuario"]').on('change', function(e)
    {
        var edad = parseInt($(this).val());
        var cb = '';

        if (edad < 6) {cb = 'P.I';}
        else if (edad < 12) {cb = "I";}
        else if (edad < 18) {cb = "ADO";}
        else if (edad < 60) {cb = "ADU";}
        else if (edad >= 60) { cb = "VE"; }

        $('select[name="CB_Usuario"]').val(cb).trigger('change');
    });

    $('input[name="Documento_Usuario"]').on('blur', function(e)
    {
        var key = $(this).val();

        if (key)
        {
           $.post(
               $(this).data('url'),
               {
                   'key': key
               },
               'json'
           ).done(function(user) {
               if(!$.isEmptyObject(user))
               {
                   if (user.jornadas)
                   {
                        alert('Esta persona ya culminó proceso de enseñanza en la escuela de la bicicleta');
                   }

                   $('input[name="Nombre_Usuario"]').val(user.Nombre_Usuario).trigger('change');
                   $('input[name="Nombre_Acudiente"]').val(user.Nombre_Acudiente).trigger('change');
                   $('input[name="Email_Acudiente"]').val(user.Email_Acudiente).trigger('change');
                   $('input[name="Telefono_Acudiente"]').val(user.Telefono_Acudiente).trigger('change');
                   $('input[name="Acudiente_Es_Usuario"]').prop('checked', user.Acudiente_Es_Usuario === '1' ? 'true' : 'false');
                   $('input[name="Edad_Usuario"]').val(user.Edad_Usuario).trigger('change');
                   $('input[name="Genero_Usuario"][value="'+user.Genero_Usuario+'"]').trigger('click');

                   if($('select[name="Tipo"]').val() !== 'Taller de mecánica')
                   {
                       $('select[name="Nombre_Tipo_Documento_Usuario"]').val(user.Nombre_Tipo_Documento_Usuario).trigger('change');
                       $('select[name="Destreza_Inicial_Usuario"]').val(user.Avance_Logrado_Usuario).trigger('change');
                   }
               }
           });
        }
    });

    validarTallerDeMecanica();
});
