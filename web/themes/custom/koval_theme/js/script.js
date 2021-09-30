(function ($) {
  Drupal.behaviors.formErrorBehavior = {
    attach: function (context, settings) {
        $('img.cat-image').once().click(function (event) {
            $('body').css('overflow-y', 'hidden')
            $(this).clone().appendTo("body").addClass('cats-window additional_class');
            event.preventDefault();
            $('#window_site').fadeIn(0, function () {
              $('#overlay')
                .css('background', 'black')
                .css('display', 'block')
                .animate({opacity: 0.9}, 0);
            });
          });

        $('#overlay_close, #window_site, #overlay').click(function () {
          $('img.cat-image').removeClass('cats-window')
          $('.additional_class').css('display', 'none')
          $('body').css('overflow-y', 'auto')
          $('#overlay').animate({opacity: 0}, 0, function () {
            $(this).css('display', 'none');
            $('#window_site').fadeOut(0);
          });
        });
    }
  }
})(jQuery);
