/**
 * Created by owenwilliams on 15/08/2016.
 */
(function ($) {

  var models_searcher = {

    init: function (context) {
      models_searcher.placesClicker();
      models_searcher.placesTimeOut = false;
      models_searcher.apiTimeOut = false;

      // move form inside ul on the nav dd.
      $('.navbar-nav #models-searcher-form').insertAfter('.navbar-nav .first.leaf .dropdown-menu .dropdown-header-area');

      var placeLookup = {
        autocomplete: new google.maps.places.AutocompleteService(),
        places: new google.maps.places.PlacesService(document.createElement("div"))
      };
      $('.dropdown-menu-yogafind.dropdown-menu-searcher .no-results').hide();
      $('#search-lookup').on('keyup', function (event) {
        clearTimeout(models_searcher.placesTimeOut);
        clearTimeout(models_searcher.apiTimeOut);
        $this = $(this);
        $('.dropdown-menu-yogafind.dropdown-menu-searcher li.res').remove();

        var query = $this.val();
        models_searcher.placesTimeOut = setTimeout(function () {
          if (query.length > 0) {

            // https://maps.googleapis.com/maps/api/place/details/json?placeid=ChIJ2TsKiYFebkgRTqYZD28_iE4&key=AIzaSyAJotW5W9qrHFoKPAJPim6w4jWr6MWNEHA

            placeLookup.autocomplete.getPlacePredictions({
              input: query,
              componentRestrictions: {country: 'uk'},
              types: ['(regions)']
            }, function (results) {
              // $('li.res').remove();
              // console.log(results);
              if (results) {
                $('<li class="res goog"><img title="Google" alt="Google" src="/sites/all/themes/yogafind/images/powered_by_google_on_white.png"/></li>').insertAfter($('.dropdown-menu-yogafind.dropdown-menu-searcher .dropdown-header.dropdown-header-area'));
                var resultString = '';
                $.each(results, function (i, areas) {
                  // console.log(areas);
                  resultString += '<li class="res res-places"><a href="#" data-placeid="' + areas['place_id'] + '">' + areas['description'] + '</a></li>';
                });

                $(resultString).insertAfter($('.dropdown-menu-yogafind.dropdown-menu-searcher .dropdown-header.dropdown-header-area'));
              }
              else {
                // $('li.res-place').remove();
                $('<li class="res no-res">Nothing here :(!</li>').insertAfter($('.dropdown-menu-yogafind.dropdown-menu-searcher .dropdown-header.dropdown-header-area'));
              }
              // if (thisRequest != lastRequest) {
              //   return;
              // }
            });
          }
        }, 400);

        models_searcher.apiTimeOut = setTimeout(function () {
          // $('li.res-ajax').remove();

          if (query.length > 0) {
            // Now from the Drupal side o' things..
            $.get('/api/yf_dynamic_search/' + query + '.json', function (data, status) {
                if (!data) {
                  return;
                }
                else {
                  if (data['listing']) {
                    var listingString = '';
                    $.each(data['listing'], function (listingTitle, listing) {
                      listingString += '<li class="res res-ajax"><a href="/' + listing['url'] + '">' + listingTitle + '</a></li>';
                    });
                    $(listingString).insertAfter($('.dropdown-menu-yogafind.dropdown-menu-searcher .dropdown-header.dropdown-header-listings'));
                  }
                  if (data['event']) {
                    var eventString = '';
                    $.each(data['event'], function (eventTitle, event) {
                      eventString += '<li class="res res-ajax"><a href="/' + event['url'] + '">' + eventTitle + '</a></li>';
                    });
                    $(eventString).insertAfter($('.dropdown-menu-yogafind.dropdown-menu-searcher .dropdown-header.dropdown-header-events'));
                  }
                }
              }
            );
          }
        }, 400);
      });
    },

    placesClicker: function () {
      $(document).on('click', 'li.res-places a', function () {
        var placeId = $(this).data('placeid');
        // console.log(placeId);
        if (placeId) {
          $.get('/api/yf_places_lookup/' + placeId + '.json', function (data, status) {
            // console.log(data);
            if (data['url'] != 'nope') {
              window.location.href = '/' + data['url'];
            }
          });
        }
        return false;
      });
    },

    searcher: function (geo) {
      var srch = 'http://models.dev/search?field_hb_geofield_latlon_op=10&field_hb_geofield_latlon=' + geo['suburb'] + '&search=&field_hb_geofield_latlon_lat=' + geo['latitude'] + '&field_hb_geofield_latlon_lng=' + geo['longitude'] + '&sort=field_hb_geofield%3Alatlon&order=asc';
      window.location.href = srch;
    }
  };

  Drupal.behaviors.models_searcher = {
    attach: function (context) {
      $('body', context).once(function () {
        models_searcher.init();
      });
    }
  };

})
(jQuery);
