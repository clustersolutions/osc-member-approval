/*
 * jQuery File Upload Plugin JS Example 8.9.1
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Hacked for OSC Member Approval, Cluster Solutions 2015
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

/* global $, window */

$(function () {
    'use strict';

    // Initialize the jQuery File Upload widget:
    $('#fileupload').fileupload({
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: 'ext/member_approval/'
    });

    // Enable iframe cross-domain access via redirect option:
    $('#fileupload').fileupload(
        'option',
        'redirect',
        window.location.href.replace(
            /\/[^\/]*$/,
            '/cors/result.html?%s'
        )
    );

    // Load existing files:
    $('#fileupload').addClass('fileupload-processing');
    $.ajax({
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: $('#fileupload').fileupload('option', 'url'),
        dataType: 'json',
        context: $('#fileupload')[0]
    }).always(function () {
        $(this).removeClass('fileupload-processing');
    }).done(function (result) {
        $(this).fileupload('option', 'done')
            .call(this, $.Event('done'), {result: result});
    });

    // Form modal functions
    $('#myModal').on('hidden.bs.modal', function () {
        $('#inputEmail').val('');
        $('#inputEmail').popover('hide');
    })
    $('#myModal').on('shown.bs.modal', function () {
        $('#inputEmail').focus();
    })

    $('#inputEmail').popover({'trigger':'manual', 'content': 'Email required', 'placement': 'bottom'});

    // Validate form input
    $('#fileupload').bind('fileuploadsubmit', function (e, data) {    
        var input = $('#inputEmail');
        if (!input.val()) {
            data.context.find('button').prop('disabled', false);
            input.popover('show');
            input.focus();
            return false;
        }
        input.popover('hide');
        $("#myModal").modal('hide');
    });
});
