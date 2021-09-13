$(function() {
    $('.datatable').DataTable({
    	"language": {
        	"url": 'public/Spanish.json'
    	},
    	responsive:true,
      dom: 'Blfrtip',
      lengthMenu: [[10, 25, 50, 100, 1000,-1], [10, 25, 50, 100, 1000, "All"]],
      buttons: [
        'csv',
        'excel',
        'print',
        {
        	extend: 'pdf',
          orientation: 'landscape',
          pageSize: 'LEGAL'
        }
      ]
    });
});
