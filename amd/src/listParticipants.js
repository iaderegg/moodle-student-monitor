/*eslint no-unused-vars: ["error", { "args": "none" }]*/
define(['jquery',
    'core/ajax',
    'core/templates',
    'report_studentmonitor/jszip',
    'report_studentmonitor/pdfmake',
    'report_studentmonitor/jquery.dataTables',
    'report_studentmonitor/dataTables.bootstrap4',
    'report_studentmonitor/autoFill.bootstrap4',
    'report_studentmonitor/dataTables.buttons',
    'report_studentmonitor/buttons.bootstrap4',
    'report_studentmonitor/buttons.colVis',
    'report_studentmonitor/buttons.html5',
    'report_studentmonitor/buttons.print'
    // 'report_studentmonitor/sweetalert',
], function ($,
    ajax,
    templates,
    jszip,
    pdfmake,
    dataTable,
    bootstrapDataTables,
    autoFill,
    buttonsDatatables,
    buttonsBootstrap,
    buttonscolVis,
    buttonsHtml5,
    buttonsPrint
    //Swal
) {

    return {
        init: function () {

            $(document).ready(function () {

                $('#table-course-students').DataTable({
                    "dom": 'Bfrtip',
                    "language": {
                        "url": "../assets/datatables/Spanish.json",
                    },
                    "order": [
                        [0, "asc"]
                    ],
                    "columnDefs": [
                    {
                        "targets": [0, 1, 2],
                        "className": "dt-body-center"
                    }],
                    "buttons": [
                        {
                            "extend": "copyHtml5",
                            "exportOptions": {
                                "columns": [0, 1, 2, 3]
                            }
                        },
                        {
                            "extend": "csv",
                            "exportOptions": {
                                "columns": [0, 1, 2, 3]
                            }
                        },
                        {
                            "extend": "print",
                            "exportOptions": {
                                "columns": [0, 1, 2, 3]
                            }
                        }
                    ],
                    "paging": true
                });

            });
        }
    };
});