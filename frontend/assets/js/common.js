$(document).ready(function(e) {
    CKEDITOR.replace('message', {
        language: 'en',
        uiColor: '#ffffff',
        resize_enabled: 'false',
        removePlugins: 'elementspath',
        height: 100,
        width: '100%'
    });
    
    $(":file").filestyle({input: false});

    $(".inps").click(function(e) {
        if ($(this).prop("checked") == true) {
            $("." + $(this).data("target")).prop("checked", true);
        } else {
            $("." + $(this).data("target")).prop("checked", false);
        }
    });
});