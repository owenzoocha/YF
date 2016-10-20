<?php
/**
 * @param $srch
 * @return mixed
 *
 * Retrieve places lookup data.
 */
function _yf_places_lookup($places_id) {
  $places_request = drupal_http_request('https://maps.googleapis.com/maps/api/place/details/json?placeid=' . $places_id . '&key=AIzaSyAJotW5W9qrHFoKPAJPim6w4jWr6MWNEHA');
  if ($places_request) {
    $json = drupal_json_decode($places_request->data);
    $yoga_url['url'] = 'nope';
    if (!empty($json['result']['address_components'])) {
      foreach ($json['result']['address_components'] as $index => $address_component) {
        $term = taxonomy_get_term_by_name($address_component['long_name'], 'locations');
        if ($term) {
          $tw = entity_metadata_wrapper('taxonomy_term', reset($term)->tid);

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
          $yoga_url['tid'] = $tw->getIdentifier();
          $yoga_url['url'] = 'yoga/in/' . strtolower(str_replace(' ', '-', $address_component['long_name']));
          break;
        }
        else {
          $yoga_url['to_add'][] = $address_component['long_name'];
        }
      }

      if (isset($yoga_url['to_add'])) {
        watchdog('YF_places_to_add', implode(', ', $yoga_url['to_add']) . ' for: ' . $places_id);
      }
      return $yoga_url;
    }
  }
  else {
    return 'err';
  }
}

/**
 * @param $srch
 * @return mixed
 *
 * Retrieve dynamic search for the search input.
 */
function _yf_dynamic_search($srch) {
  $search_string = $srch;
  $sql = db_query('select nid, title, type from {node} where (type = :article OR type = :yoga) AND title like :search ', array(
    ':search' => '%' . $search_string . '%',
    ':article' => 'article',
    ':yoga' => 'yoga'
  ));
  $result = $sql->fetchAll();
  $dynamic_results = array();
  foreach ($result as $index => $item) {
    $current_type = 'listing';
    // Caching here.
    $deets = models_cache_get_dynamic_search_cache($item->nid);
//    $deets = FALSE;

    if ($deets) {
      $deets = drupal_json_decode($deets);
    }
    else {
      $nw = entity_metadata_wrapper('node', $item->nid);

      if ($nw->getBundle() == 'yoga') {
        if ($nw->field_yoga_type->value()) {
          if ($nw->field_yoga_type->value() == 'event') {
            $current_type = 'event';
            $desc = 'event!';
          }
          elseif ($nw->field_yoga_type->value() == 'instructor') {
            $desc = 'instructor!';
          }
          else {
            $desc = 'studio!';
          }
          $deets = array(
            'nid' => $item->nid,
            'desc' => $desc,
            'type' => $current_type,
            'url' => drupal_get_path_alias('node/' . $item->nid),
          );
          models_cache_build_dynamic_search_cache(drupal_json_encode($deets), $item->nid);
        }
        else {
          $deets = FALSE;
        }
      }
      else {
        $current_type = 'post';
        $deets = array(
          'nid' => $item->nid,
          'desc' => 'blog',
          'type' => $current_type,
          'url' => drupal_get_path_alias('node/' . $item->nid),
        );
        models_cache_build_dynamic_search_cache(drupal_json_encode($deets), $item->nid);
      }
    }
    if ($deets) {
      $dynamic_results[$deets['type']][$item->title] = $deets;
    }
  }
  return $dynamic_results;
}
