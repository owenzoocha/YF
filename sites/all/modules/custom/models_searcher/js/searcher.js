/**
 * Created by owenwilliams on 15/08/2016.
 */
(function ($) {

  var models_searcher = {

    init: function (context) {

      var placeLookup = {
        autocomplete: new google.maps.places.AutocompleteService(),
        places: new google.maps.places.PlacesService(document.createElement("div"))
      };

      console.log(placeLookup);
      $('.dropdown-menu-yogafind .no-results').hide();

      $('#search-lookup').on('keyup', function (event) {
        $this = $(this);
        $('li.res').remove();

        var query = $this.val();
        setTimeout(function () {
          if (query.length > 0) {

            // https://maps.googleapis.com/maps/api/place/details/json?placeid=ChIJ2TsKiYFebkgRTqYZD28_iE4&key=AIzaSyAJotW5W9qrHFoKPAJPim6w4jWr6MWNEHA

            placeLookup.autocomplete.getPlacePredictions({
              input: query,
              componentRestrictions: {country: 'uk'},
              types: ['(regions)']
            }, function (results) {
              $('li.res').remove();
              // console.log(results);
              if (results) {
                $('<li class="res goog">Powered by <img title="Google" alt="Google" src="sites/all/themes/yogafind/images/Google_2015_logo.svg"/></li>').insertAfter($('.dropdown-menu-yogafind .dropdown-header.dropdown-header-area'));
                var resultString = '';
                $.each(results, function (i, areas) {
                  // console.log(areas);
                  resultString += '<li class="res"><a href="#" data-placeid="' + areas['place_id'] + '">' + areas['description'] + '</a></li>';
                });

                $(resultString).insertAfter($('.dropdown-menu-yogafind .dropdown-header.dropdown-header-area'));
              }
              else {
                $('li.res-place').remove();
                $('<li class="res no-res">Nothing here :(!</li>').insertAfter($('.dropdown-menu-yogafind .dropdown-header.dropdown-header-area'));
              }
              // if (thisRequest != lastRequest) {
              //   return;
              // }
            });

            // // Now from the Drupal side o' things..
            $.get('/api/yf_dynamic_search/' + query + '.json', function(data, status) {
              if (!data) {
                return;
              }
              else {
                if (data['listing']) {
                  var listingString = '';
                  $.each(data['listing'], function(listingTitle, listing) {
                    console.log(listing);
                    listingString += '<li class="res"><a href="#">' + listingTitle + '</a></li>';
                  });
                  $(listingString).insertAfter($('.dropdown-menu-yogafind .dropdown-header.dropdown-header-listings'));
                }
              }

            });
          }
        }, 200);
      });


    },

    searcher: function (geo) {
      var srch = 'http://models.dev/search?field_hb_geofield_latlon_op=10&field_hb_geofield_latlon=' + geo['suburb'] + '&search=&field_hb_geofield_latlon_lat=' + geo['latitude'] + '&field_hb_geofield_latlon_lng=' + geo['longitude'] + '&sort=field_hb_geofield%3Alatlon&order=asc';
      window.location.href = srch;
    }

  }

  Drupal.behaviors.models_searcher = {
    attach: function (context) {
      $('body', context).once(function () {
        models_searcher.init();
      });
    }
  };

})(jQuery);
