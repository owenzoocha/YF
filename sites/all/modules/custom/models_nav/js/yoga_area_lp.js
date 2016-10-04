/**
 * Created by owenwilliams on 28/09/2016.
 */
(function ($) {

  var yoga_area = {
    init: function (context) {
      $('.area-dd h2').on('click', function () {
        $(this).parent().toggleClass('active');
        $this = $(this);
        if ($(this).parent().hasClass('active')) {
          setTimeout(function () {
            $this.find('.material-icons').html('remove');
          }, 100);
        }
        else {
          setTimeout(function () {
            $this.find('.material-icons').html('add');
          }, 100);
        }
        // return false;
      });
    }
  };

  Drupal.behaviors.yoga_classes = {
    attach: function (context) {
      $('body', context).once(function () {
        yoga_area.init();
      });
    }
  };

})(jQuery);
