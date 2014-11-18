/*!
 * Author: Emiliano Viada
 * Date: 2 Nov 2014
 !**/

$(function() {
    "use strict";

    // List tables (dataTables)
    $('#list-table').dataTable({
        "bPaginate": true,
        "bLengthChange": true,
        "bFilter": false,
        "bSort": true,
        "bInfo": true,
        "bAutoWidth": false,
        "aoColumnDefs": [
            { 'bSortable': false, 'aTargets': [ 0 ] }
        ]
    });

    // Add customized class to dataTables
    $('.dataTables_length select').addClass('form-control');

    // Table checkbox (iCheck)
    $('#list_batch_checkbox, #checkbox_all_elements').on('ifChanged', function () {
        $(this)
            .closest('table')
            .find('td.sonata-ba-list-field-batch input[type="checkbox"]')
            .iCheck($(this).is(':checked') ? 'check' : 'uncheck')
        ;
    });

    $('td.sonata-ba-list-field-batch input[type="checkbox"]')
        .on('ifChanged', function () {
            $(this)
                .closest('tr')
                .toggleClass('sonata-ba-list-row-selected', $(this).is(':checked'))
            ;
        })
        .trigger('ifChanged')
    ;

    // Multiple select
    $('select[multiple="multiple"]').multipleSelect();
});
