(function($) {
    $('.bb-tab').click(function() {
        var target = jQuery($(this).attr('data-target'));      
        $('.bb-wrap').hide();
        target.fadeIn(200);
        $('.nav-tab-active').removeClass('nav-tab-active');
        $(this).addClass('nav-tab-active');
    });
})(jQuery);