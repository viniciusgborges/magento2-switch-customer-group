define([
    "jquery",
    "mage/translate",
], function ($) {
    "use strict";
    $(document).ready(function () {
        $('#vbdev_change_customer_group').on('click', function () {
            request()
        })

        function getMessage(type, message) {
            type.text($.mage.__(message)).hide().fadeIn();
            setTimeout(function () {
                type.fadeOut();
            }, 8000);
        }

        function request() {
            const customersId = $('#switch_customer_group_switch_customer_group_by_id_customers_id').val(),
                sourceGroup = $('#switch_customer_group_switch_customer_group_by_id_source_group_selected').val(),
                targetGroup = $('#switch_customer_group_switch_customer_group_by_id_target_group_selected').val()

            if (!customersId) {
                getMessage($('#switch-group-messages .message-error'), 'Please enter customer ID');
                return true;
            }

            const serviceUrl = window.ajaxUrl,
                payload = {
                    form_key: window.formKey,
                    'customersId': customersId,
                    'sourceGroup': sourceGroup,
                    'targetGroup': targetGroup
                }

            $.ajax({
                url: serviceUrl,
                data: payload,
                dataType: 'json',
                type: 'POST',
                showLoader: true,
            }).done(function (result) {
                    const message = result.customer_ids.length !== 0 ? 'Success, but these customer ids do not exist: ' + result.customer_ids
                        : result.response === 'Success' ? 'Success' : 'Failure';
                    const messageType = result.response === 'Success' ? $('#switch-group-messages .message-success') : $('#switch-group-messages .message-error');
                    getMessage(messageType, message);

                    if (result.response === 'Failure') console.error(result);
                }
            ).fail(function (jqXHR, textStatus, errorThrown) {
                getMessage($('#switch-group-messages .message-error'), 'Error: ' + errorThrown);
                console.error(jqXHR, textStatus, errorThrown);
            });
        }
    });
});
