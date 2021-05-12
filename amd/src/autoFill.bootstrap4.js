/*! Bootstrap integration for DataTables' AutoFill
 * ©2015 SpryMedia Ltd - datatables.net/license
 */

(function (factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD
        define(['jquery', 'report_studentmonitor/dataTables.bootstrap4', 'report_studentmonitor/dataTables.autoFill'], function ($) {
            return factory($, window, document);
        });
    } else if (typeof exports === 'object') {
        // CommonJS
        module.exports = function (root, $) {
            if (!root) {
                root = window;
            }

            if (!$ || !$.fn.dataTable) {
                $ = require('report_studentmonitor/dataTables.bootstrap4')(root, $).$;
            }

            if (!$.fn.dataTable.AutoFill) {
                require('report_studentmonitor/dataTables.autoFill')(root, $);
            }

            return factory($, root, root.document);
        };
    } else {
        // Browser
        factory(jQuery, window, document);
    }
}(function ($, window, document, undefined) {
    'use strict';
    var DataTable = $.fn.dataTable;

    DataTable.AutoFill.classes.btn = 'btn btn-primary';

    return DataTable;
}));