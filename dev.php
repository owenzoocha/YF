<?php
/**
 * Root directory of Drupal installation.
 */
define('DRUPAL_ROOT', getcwd());

require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);

function geo_time() {
  $placedid = 'ChIJZbYQN2Cqd0gR4hBmNUTOVY0';
//  $placedid = 'ChIJCT7gsUJDbkgRQX55jieEiuI';
  $places_request = drupal_http_request('https://maps.googleapis.com/maps/api/place/details/json?placeid=' . $placedid . '&key=AIzaSyAJotW5W9qrHFoKPAJPim6w4jWr6MWNEHA');
  if ($places_request) {
    $json = drupal_json_decode($places_request->data);
    dpm($json);
    $yoga_url['url'] = 'nope';
    if (!empty($json['result']['address_components'])) {
      foreach ($json['result']['address_components'] as $index => $address_component) {
        $term = taxonomy_get_term_by_name($address_component['long_name'], 'locations');
        dpm($term);
        if ($term) {
          $tw = entity_metadata_wrapper('taxonomy_term', reset($term)->tid);

          dpm($tw->value());

          if (!$tw->field_yoga_taxonomy_geofield->value()) {
            // Cache and save the latlong data to the term.
            $latlng = array(
              'lat' => $json['result']['geometry']['location']['lat'],
              'lng' => $json['result']['geometry']['location']['lng'],
            );
            $geo_array = array(
              'geom' => 'POINT (' . $latlng['lng'] . ' ' . $latlng['lat'] . ')',
              'geo_type' => 'point',
              'lat' => $latlng['lat'],
              'lon' => $latlng['lng'],
              'left' => $latlng['lng'],
              'top' => $latlng['lat'],
              'right' => $latlng['lng'],
              'bottom' => $latlng['lat'],
              // 'geohash' => ,
            );

            $tw->field_yoga_taxonomy_geofield->set($geo_array);
            $tw->save();

            $yoga_url['create'] = 1;
          }
          else {
            $yoga_url['create'] = 0;
          }
          $yoga_url['url'] = 'yoga/in/' . strtolower(str_replace(' ', '-', $address_component['long_name']));
          break;
        }
        else {
          $yoga_url['to_add'][] = $address_component['long_name'];
        }
      }

      if (isset($yoga_url['to_add'])) {
        watchdog('YF_places_to_add', implode(', ', $yoga_url['to_add']) . ' for: ' . $placedid);
      }
      dpm($yoga_url, 'to return');
    }
  }
}

//geo_time();


// town-0 county-1 country-2
function testerr() {
  $file = fopen('counties2.csv', 'r');
  $i = 0;
  while (($line = fgetcsv($file, 2000, ",")) !== FALSE) {
    //$line is an array of the csv elements
    if ($i != 0) {

      $town = taxonomy_get_term_by_name($line[0]);
      $parent = taxonomy_get_term_by_name($line[1]);

      if (empty($town)) {
        $town_term = new stdClass();
        $town_term->name = $line[0]; // The name of the term
        $town_term->vid = 4; // The ID of the parent vocabulary
        $town_term->parent = reset($parent)->tid; // This tells taxonomy that this is a top-level term
        taxonomy_term_save($town_term);
//        dpm_once(reset($parent)->tid);
      }
    }

//      // FOR COUNTIES >
//      $tax = taxonomy_get_term_by_name($line[1]);
//      if (!empty($tax)) {
//        dpm_once(reset($tax)->tid);
//      }
//      else {
//        if ($line[2] == 'Wales') {
//          $parent = 206;
//        }
//        if ($line[2] == 'England') {
//          $parent = 207;
//        }
//        if ($line[2] == 'Scotland') {
//          $parent = 208;
//        }
//        if ($line[2] == 'Northern Ireland') {
//          $parent = 209;
//        }
//        $county_term = new stdClass();
//        $county_term->name = $line[1]; // The name of the term
//        $county_term->vid = 4; // The ID of the parent vocabulary
//        $county_term->parent = $parent; // This tells taxonomy that this is a top-level term
//        taxonomy_term_save($county_term);
//      }
//    }
    $i++;
  }

//  England - 207
//  Wales - 206
//  Scot - 208
//  NI - 209
//  $county_term = new stdClass();
//  $county_term->name = 'Hertfordshire'; // The name of the term
//  $county_term->vid = 4; // The ID of the parent vocabulary
//  $county_term->parent = 207; // This tells taxonomy that this is a top-level term
//  taxonomy_term_save($county_term);

  return '';
}


menu_execute_active_handler();
// delete_out_of_date();
//owen_pp_refund();
//owen_pp_delayed();
