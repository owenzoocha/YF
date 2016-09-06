(function ($) {

  var hbcomplete = {
    nanobar : false,

    init: function(context) {

      $('#edit-field-my-address-und-0-thoroughfare').attr('placeholder', 'Address 1');
      // $('#edit-location-locality').attr('placeholder', 'City/Suburb');
      // $('#edit-location-administrative-area').attr('placeholder', 'Address 1');
      // $('#edit-location-postal-code').attr('placeholder', 'Postcode');

      $('#geocomplete').geocomplete({
        map: ".map_canvas",
        details: ".details",
        types: ["geocode", "establishment"],
        // location: ['lat', 'lng'],
        detailsAttribute: "data-geo",
        componentRestrictions: {
          country: "uk"
        }
      })
      .bind("geocode:result", function(event, result){
        console.log(event);
        console.log(result);

        var add1 = '';
        var add2 = '';
        var state = '';
        var pc = '';
        var sublocality = '';
        var county = '';

        $.each(result['address_components'], function(i, v) {
          // console.log(v);
          $.each(v['types'], function(j, type) {
            if (type == 'subpremise') {
              add1 = v['long_name'] + ' ';
              return;
            }
            if (type == 'street_number') {
              add1 += v['long_name'] + ' ';
              return;
            }
            if (type == 'route') {
              add1 += v['long_name'];
              return;
            }
            if (type == 'sublocality') {
              sublocality += v['long_name'];
              return;
            }
            if (type == 'locality') {
              add2 += v['short_name'];
              return;
            }
            if (type == 'administrative_area_level_1') { // country - Wales etc
              state += v['short_name'];
              return;
            }
            if (type == 'administrative_area_level_2') { // county
              county += v['short_name'];
              return;
            }
            if (type == 'postal_code') {
              pc += v['long_name'];
              return;
            }
          });

        });

        // console.log(add1);
        // console.log(add2);
        // console.log(state);
        // console.log(pc);
        // console.log(sublocality);

        $('#edit-location-thoroughfare, #edit-field-yoga-location-und-0-thoroughfare, #edit-field-my-address-und-0-thoroughfare').val(add1);
        // $('#edit-location-premise').val(add2);
        $('#edit-location-locality, #edit-field-yoga-location-und-0-locality, #edit-field-my-address-und-0-locality').val(add2);
        // $('#edit-location-administrative-area, #edit-field-yoga-location-und-0-administrative-area, #edit-field-my-address-und-0-administrative-area').val(state);

        $('#edit-location-administrative-area, #edit-field-yoga-location-und-0-administrative-area, #edit-field-my-address-und-0-administrative-area').val(county);
        $('#edit-location-postal-code, #edit-field-yoga-location-und-0-postal-code, #edit-field-my-address-und-0-postal-code').val(pc);

        $('#hide_county').val(county);
        $('#hide_country').val(state);

        $('#edit-field-yoga-latlng-und-0-geom-lat').val(result['geometry']['viewport']['f']['f']);
        $('#edit-field-yoga-latlng-und-0-geom-lon').val(result['geometry']['viewport']['b']['f']);

      });

    }
  }

  Drupal.behaviors.hbcomplete = {
    attach: function(context) {
      $('body', context).once(function () {
        hbcomplete.init();
      });
    }
  };

})(jQuery);
