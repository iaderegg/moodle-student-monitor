define(['jquery',
        'report_studentmonitor/jszip',
        'report_studentmonitor/pdfmake',
        'report_studentmonitor/jquery.dataTables',
        'report_studentmonitor/dataTables.bootstrap4',
        'report_studentmonitor/autoFill.bootstrap4',
        'report_studentmonitor/dataTables.buttons',
        'report_studentmonitor/buttons.bootstrap4',
        'report_studentmonitor/buttons.colVis',
        'report_studentmonitor/buttons.html5',
        'report_studentmonitor/buttons.print',
        'report_studentmonitor/sweetalert',
], function ($, 
    jszip,
    pdfmake,
    dataTable,
    bootstrapDataTables,
    autoFill,
    buttonsDatatables,
    buttonsBootstrap,
    buttonscolVis,
    buttonsHtml5,
    buttonsPrint,
    Swal) {

    return {
        init: function () {
            $(document).ready(function () {

                $('#table-monitorstudent').DataTable( {
                    "order": [[ 3, "desc" ]]
                });
            });
        }
    }
});