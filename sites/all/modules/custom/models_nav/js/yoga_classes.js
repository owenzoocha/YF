(function ($) {

  var yoga_classes = {
    init: function (context) {
      $('.days-hdr a').on('click', function () {
        // if ($(this).parent().hasClass('yes-classes')) {
          var day = $(this).data('day');
          $('.day a').removeClass('active');
          $(this).addClass('active');
          $('.day-wrapper').removeClass('active');
          $('.day-wrapper[data-day="' + day + '"]').addClass('active');
        // }
        return false;
      });

      $('.yoga-class').on('click', function () {
        $(this).toggleClass('active');
      });
    }
  };

  Drupal.behaviors.yoga_classes = {
    attach: function (context) {
      $('body', context).once(function () {
        yoga_classes.init();
      });
    }
  };

})(jQuery);
