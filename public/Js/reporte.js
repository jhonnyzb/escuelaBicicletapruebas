
/**
 * Created by daniel on 26/07/17.
 */
$(function() {
    $('.datatable').DataTable({
      "language": {
        "url": 'public/Spanish.json'
      },
      responsive:true,
      paging: true,
      dom: 'Blfrtip',
      lengthMenu: [[10, 25, 50, 100, 1000, -1], [10, 25, 50, 100, 1000, "All"]],
      buttons: [
          'csv',
          'excel',
          'print',
          {extend: 'pdf',
              orientation: 'landscape',
              pageSize: 'LEGAL'}

      ],
    });

    $('form[name=form_busqueda_reporte]').submit(function(e)
    {
        e.preventDefault();
        var formObj = $(this);
        var formURL = formObj.attr("action");
        var formData = new FormData(this);

        if ( $.fn.DataTable.isDataTable('.datatable') ) {
            $('.datatable').DataTable().destroy();
        }

        $('#tblRemittanceList tbody').empty();

            table = $('.datatable');
            table.DataTable({
                "language": {
                    "url": 'public/Spanish.json'
                },
                dom: 'Blfrtip',
                lengthMenu: [[10, 25, 50, 100, 1000, -1], [10, 25, 50, 100, 1000, "All"]],
                paging: true,
                buttons: [
                  'csv',
                  'excel',
                  'print',
                  {
                      extend: 'pdf',
                      orientation: 'landscape',
                      pageSize: 'LEGAL'
                  }
                ],
                responsive:true,
                processing: true,
                serverSide: true,
                ajax:{
                    url: formURL,
                    type: 'POST',
                    data:  $(this).serializeArray()
                },
                columns: [
                    { data: 'id', name:'id'},
                    { data: 'Localidad', name:'Localidad'},
                    { data: 'Lugar', name:'Lugar'},
                    { data: 'Fecha', name:'Fecha'},
                    { data: 'Clima', name:'Clima'},
                    { data: 'Encargado', name:'Encargado'},
                    { data: 'Tipo', name:'Tipo'},
                    { data: 'Observaciones', name:'Observaciones'},
                    { data: 'Cedula', name:'Cedula'},
                    { data: 'Primer_Apellido', name:'Primer_Apellido'},
                    { data: 'Segundo_Apellido', name:'Segundo_Apellido'},
                    { data: 'Primer_Nombre', name:'Primer_Nombre'},
                    { data: 'Segundo_Nombre', name:'Segundo_Nombre'},
                    { data: 'Nombre_Acudiente', name:'Nombre_Acudiente'},
                    { data: 'Email_Acudiente', name:'Email_Acudiente'},
                    { data: 'Telefono_Acudiente', name:'Telefono_Acudiente'},
                    { data: 'Nombre_Usuario', name:'Nombre_Usuario'},
                    { data: 'Nombre_Tipo_Documento_Usuario', name:'Nombre_Tipo_Documento_Usuario'},
                    { data: 'Documento_Usuario', name:'Documento_Usuario'},
                    { data: 'Genero_Usuario', name:'Genero_Usuario'},
                    { data: 'Edad_Usuario', name:'Edad_Usuario'},
                    { data: 'CB_Usuario', name:'CB_Usuario'},
                    { data: 'Hora_Inicio_Usuario', name:'Hora_Inicio_Usuario'},
                    { data: 'Hora_Fin_Usuario', name:'Hora_Fin_Usuario'},
                    { data: 'Destreza_Inicial_Usuario', name:'Destreza_Inicial_Usuario'},
                    { data: 'Avance_Logrado_Usuario', name:'Avance_Logrado_Usuario'},
                    { data: 'Observaciones_Usuario', name:'Observaciones_Usuario'},
                    { data: 'Registro', name:'Registro'}

                ]


            });



    });


});
