$(function()
{
	var input = 'input[name="usuarios"]';
	var table = '#table_objects';
    var form = '#participante';
    var modal = '#modal-agregar';
    var pk_object = "Id_Usuario";

    var fields = [
        'Nombre_Usuario',
        'Nombre_Tipo_Documento_Usuario',
        'Documento_Usuario',
        'Genero_Usuario',
        'Edad_Usuario',
        'CB_Usuario',
        'Hora_Inicio_Usuario',
        'Hora_Fin_Usuario',
        'Documento_Acudiente',
        'Nombre_Acudiente',
        'Email_Acudiente',
        'Telefono_Acudiente',
        'Destreza_Inicial_Usuario',
        'Avance_Logrado_Usuario',
        'Observaciones_Usuario'
    ];

	var objects = {};
	var table_objects = $(table).DataTable();
    var old_objects = $.parseJSON($(input).val() || null) || {};

    function generateUUID()
    {
        var d = new Date().getTime();
        var uuid = 'xxxxx'.replace(/[xy]/g, function(c) {
            var r = (d + Math.random()*16)%16 | 0;
            d = Math.floor(d/16);
            return (c=='x' ? r : (r&0x3|0x8)).toString(16);
        });

        return uuid;
    }

    // popular objeto
    function populateObject(object)
	{	$to_end = {};

		//se procesan textos y selectores primero.
        $.each(object, function(key, value)
        {
        	if($(form+' *[name="'+key+'"]').is('select')) {
                $(form+' *[name="'+key+'"]').selectpicker('val', value);
            } else if($(form+' *[name="'+key+'"]').is('p')) {
                $(form+' *[name="'+key+'"]').text(value);
            } else if($(form+' *[name="'+key+'"]').is('img')) {
                $(form+' *[name="'+key+'"]').attr('src', $(form+' *[name="'+key+'"]').data('url')+'/'+value);
            } else if($(form+' *[name="'+key+'"]').is('input[type="file"]')) {
                $(form+' *[name="'+key+'"]').val('');
            } else {
				$(form+' *[name="'+key+'"]').val(value);
			}
		});
		
		//se procesan radios y checkbox al final por trigger de eventos.
		$.each(object, function(key, value)
        {
			if($(form+' *[name="'+key+'"]').is(':radio'))
			{
                $(form+' *[name="'+key+'"][value="'+value+'"]').trigger('click');
			} else if($(form+' *[name="'+key+'"]').is(':checkbox')) {
				if ($(form+' *[name="'+key+'"]').attr('value') == value)
					$(form+' *[name="'+key+'"][value="'+value+'"]').trigger('click');
			}
        });
    }

    function eliminarObject(current)
    {
        var $odl_tr = $(table+' tr[id="'+current[pk_object]+'"]');
        if ($odl_tr.length)
        {
            table_objects.row($odl_tr).remove().draw();
            return true;
        }

        return false;
    }

    //procesar tabla
    function procesarObject(current)
    {
        var columns = '';
        objects[current[pk_object]] = current;
        eliminarObject(current);

        $.each(fields, function(i, e)
        {
            columns += '<td>'+current[e]+'</td>';
        });

        var $tr = $('<tr id="'+current[pk_object]+'"></tr>').html(
                    columns+
                    '<td>'+
                        '<div class="dropdown">'+
                            '<button class="btn btn-sm btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">'+
                                '<span class="caret"></span>'+
                            '</button>'+
                            '<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">'+
                                '<li><a data-role="editar" href="#">Editar</a></li>'+
                                '<li><a data-role="eliminar" href="#">Eliminar</a></li>'+
                            '</ul>'+
                        '</div>'+
                    '</td>') ;

        table_objects.row.add($tr).draw(false);
    }

    $('#table_objects').delegate('a[data-role="eliminar"]', 'click', function(e)
    {
        var id = $(this).closest('tr').prop('id');
        var object = objects[id];

        if(eliminarObject(object))
        {
            delete objects[id];
        }

        e.preventDefault();
    });

    $('#table_objects').delegate('a[data-role="editar"]', 'click', function(e)
    {
		$(form)[0].reset();
        var id = $(this).closest('tr').prop('id');
        var object = objects[id];
        populateObject(object);
        $(form).validator('validate');
        $(modal).modal('show');
        e.preventDefault();
    });

    $('#agregar').on('click', function(e)
    {
        $(form)[0].reset();
        $(form).find('select').selectpicker('val', '');
        $(form).find('input[type="hidden"]').val('');

        $(modal).modal('show');
    });

    $('#principal').on('submit', function(e)
    {
    	$(input).val(JSON.stringify(objects));
		$('#principal').find('button[type="submit"]').prop('disabled', true);
	});

    $(form).validator().on('submit', function(e)
    {
        if (e.isDefaultPrevented())
        {

        } else {
            var data = $(this).serializeArray();
            var object = {};

            $.each(data, function(i, e)
            {
                object[e.name] = e.value;
            });

            if(object[pk_object] === '')
            {
                object[pk_object] = generateUUID();
            }

            procesarObject(object);
            $(modal).modal('hide');
        }

        e.preventDefault();
    });

    if(!$.isEmptyObject(old_objects))
    {
        $.each(old_objects, function(i, object)
        {
            procesarObject(object);
        });
    }
});
