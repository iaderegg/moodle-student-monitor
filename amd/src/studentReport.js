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
        'report_studentmonitor/buttons.print',
        'report_studentmonitor/sweetalert',
], function (
    $,
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
    buttonsPrint,
    Swal) {

    return {
        init: function () {
            $(document).ready(function () {
                $('#accordion-student-report').on('click', '.course-button', function () {
                    /* eslint no-console: ["error", { allow: ["log", "error"] }] */
                    const queryString = window.location.search;
                    const urlParams = new URLSearchParams(queryString);
                    var courseId = $(this).attr('id').split('-')[1];

                    var promiseGetGradesCourse = ajax.call([{
                        methodname: 'report_studentmonitor_get_student_course_grades',
                        args: {
                            courseId: courseId,
                            userId: urlParams.get('id')
                        }
                    }]);

                    promiseGetGradesCourse[0].done(function (response) {
                        if (!response.error) {
                            var grades = JSON.parse(response.grades);
                            console.log(grades);

                            var context = {
                                items: grades[0].items,
                            };

                            templates.render('report_studentmonitor/student_course_grades', context)
                                .then(function (html, js) {
                                    $('#card-body-' + courseId).html('');
                                    templates.appendNodeContents('#card-body-' + courseId, html, js);
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