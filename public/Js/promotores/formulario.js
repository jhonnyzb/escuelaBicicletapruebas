$(function()
{
    var URL = $('#main').data('url');
    var URL_MODULO = $('#main').data('url-modulo');

    function buscar(key)
    {
        $.get(
            URL+'/service/buscar/'+key,
            {},
            function(data)
            {
                if(data.length == 1)
                {
                    window.location.href = URL_MODULO+'/'+data[0]['Id_Persona']+'/editar';
                }
            },
            'json'
        );
    }

    function popular_ciudades(id)
    {
        $.ajax({
            url: URL+'/service/ciudad/'+id,
            data: {},
            dataType: 'json',
            success: function(data)
            {
                var html = '';
                if(data.length > 0)
                {
                    $.each(data, function(i, e)
                    {
                        html += '<option value="'+e['Nombre_Ciudad']+'">'+e['Nombre_Ciudad']+'</option>';
                    });
                }
                $('select[name="Nombre_Ciudad"]').html(html);
                $('select[name="Nombre_Ciudad"]').selectpicker('refresh');
                $('select[name="Nombre_Ciudad"]').selectpicker('val', $('select[name="Nombre_Ciudad"]').data('value'));

            }
        });
    };

    $('select[name="Id_Pais"]').on('changed.bs.select', function(e)
    {
        if($('select[name="Id_Pais"]').selectpicker('val'))
            popular_ciudades($('select[name="Id_Pais"]').selectpicker('val'));
    });

    if ($('select[name="Id_Pais"]').data('val') != '')
        popular_ciudades($('select[name="Id_Pais"]').selectpicker('val'));

    $('select[name="Id_Pais"]').trigger('change');
    $('input[name="Cedula"]').on('blur', function(e)
    {
        buscar($(this).val());
    });
});
