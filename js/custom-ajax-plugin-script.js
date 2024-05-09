jQuery(document).ready(function($) {
    $('#store-name-form').submit(function(e) {
        e.preventDefault();
        var storeName = $('#store-name').val();
        $.ajax({
            type: 'POST',
            url: custom_ajax_plugin_ajax_object.ajax_url,
            data: {
                action: 'custom_ajax_plugin_update_store_name',
                store_name: storeName
            },
            success: function(response) {
                $('#store-name-result').html(response);
            }
        });
    });
});