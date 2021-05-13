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

    function createTable(idNumberCourseCategory, courses) {

        $('#table-courses-' + idNumberCourseCategory).html('');

        $('#table-courses-' + idNumberCourseCategory).DataTable({
            "destroy": true,
            "columns": [{
                    "title": "Nombre",
                    "data": "fullname"
                },
                {
                    "title": "Estudiantes",
                    "data": "students"
                },
                {
                    "title": "Profesores",
                    "data": "professors"
                },
                {
                    "title": "Opciones",
                    "data": "options"
                }
            ],
            "data": courses,
            "dom": 'Bfrt',
            "language": {
                "url": "../assets/datatables/Spanish.json",
            },
            "order": [
                [0, "desc"]
            ],
            "columnDefs": [
            {
                "targets": [1, 2],
                "searchable": false,
                "className": "text-center"
            },
            {
                "targets": 3,
                "searchable": false,
                "className": "text-center"
            }],
            "initComplete": function () {

            }
        });
    }

    return {
        init: function () {
            $(document).ready(function () {

                $('#accordion').on('click', '.category-button', function () {
                    /* eslint no-console: ["error", { allow: ["log", "error"] }] */
                    var categoryCourseId = $(this).attr('id').split('-')[1];
                    var courseCategoryIdNumber = $(this).attr('data-target').split('-')[2];

                    var promiseCreateAcademicPeriod = ajax.call([{
                        methodname: 'report_studentmonitor_get_course_categories',
                        args: {
                            categoryCourseId: categoryCourseId,
                        }
                    }]);

                    promiseCreateAcademicPeriod[0].done(function (response) {
                        if (!response.error) {

                            var courseCategories = JSON.parse(response.course_categories);
                            var courses = JSON.parse(response.courses);

                            if (courseCategories.length > 0) {

                                if (courses.length > 0) {
                                    var context = {
                                        courseCategories: courseCategories,
                                        courseCategoryIdNumber: courseCategoryIdNumber,
                                        hasCourses: 1
                                    };
                                } else {
                                    var context = {
                                        courseCategories: courseCategories,
                                        courseCategoryIdNumber: courseCategoryIdNumber
                                    };
                                }
                            }else{
                                if (courses.length > 0) {
                                    var context = {
                                        courseCategoryIdNumber: courseCategoryIdNumber,
                                        hasCourses: 1
                                    };
                                }else{
                                    var context = {
                                        courseCategoryIdNumber: courseCategoryIdNumber
                                    };
                                }
                            }

                            templates.render('report_studentmonitor/child_categories', context)
                                .then(function (html, js) {
                                    $('#card-body-' + courseCategoryIdNumber).html('');
                                    templates.appendNodeContents('#card-body-' + courseCategoryIdNumber, html, js);

                                    if (courses.length > 0) {
                                        $('#id-' + courseCategoryIdNumber).on('click', function () {
                                            createTable(courseCategoryIdNumber, courses);
                                        });
                                    }

                                    if (courseCategories.length == 0) {
                                        createTable(courseCategoryIdNumber, courses);
                                    }

                                }).fail(function (ex) {
                                    console.log(ex);
                                });
                        }
                    });

                });
            });
        }
    };
});