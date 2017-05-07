<?php
/**
 * @file tweaks.search_pages.inc
 */

/**
 * Do search stuff.
 *
 * @param $term
 * @return string
 */
function yoga_search_results($term) {
  $term = ucwords(str_replace('-', ' ', $term));
  $search_place = taxonomy_get_term_by_name($term);

  if (!empty($search_place)) {
    $search_parents = taxonomy_get_parents_all(reset($search_place)->tid);
    $params = drupal_get_query_parameters();

    if (sizeof($search_parents) == 3) {
      $town = $search_parents[0]->tid;
      $county = $search_parents[1]->tid;
      $country = $search_parents[2]->tid;
    }
    elseif (sizeof($search_parents) == 2) {
      $town = 'all';
      $county = $search_parents[0]->tid;
      $country = $search_parents[1]->tid;
    }
    else {
      $town = 'all';
      $county = 'all';
      $country = $search_parents[0]->tid;
    }

    // Grab the lat long - OR, if not found, set it..
    if (!empty(reset($search_place)->field_yoga_taxonomy_geofield[LANGUAGE_NONE])) {
      $lat = reset($search_place)->field_yoga_taxonomy_geofield[LANGUAGE_NONE][0]['lat'];
      $lng = reset($search_place)->field_yoga_taxonomy_geofield[LANGUAGE_NONE][0]['lon'];
    }
    else {
      $add_arr = array();
      foreach ($search_parents as $index => $search_parent) {
        if ($search_parent->name != 'International') {
          $add_arr[] = $search_parent->name;
        }
        else {
          $international = TRUE;
        }
      }
      if (!isset($international)) {
        $add_arr[] = 'UK';
      }
      $add = implode(', ', $add_arr);
      $geo_array = tweaks_grab_geocode($add);
      if (!empty($geo_array['lat'])) {
        $tw = entity_metadata_wrapper('taxonomy_term', reset($search_place)->tid);
        $tw->field_yoga_taxonomy_geofield->set($geo_array);
        $tw->save();
      }
      $lat = $geo_array['lat'];
      $lng = $geo_array['lon'];
    }

    // Distance
    // $lat = 51.656991;
    // $lng = -3.805476;
    $dist = !empty($params['within']) ? $params['within'] : 100;
    $area = array($lat, $lng, $dist);

    if (arg(0) == 'events') {

      $metatag_description = array(
        '#type' => 'html_tag',
        '#tag' => 'meta',
        '#attributes' => array(
          'name' => 'description',
          'content' => 'Description for meta-tags',
        )
      );
      drupal_add_html_head($metatag_description, 'description');

      $type = t('Find Yoga Events in') . ' ';
      $classes_hdr = '<div class="options-hdr clearfix">
      <div class="options op-time">Time</div>
      <div class="options op-style">Style</div>
      <div class="options op-duration">Duration</div>
      <div class="options op-teacher">Teacher</div>
    </div>';

      if (strpos(current_path(), '/during/') !== FALSE) {
        $date = arg(4);
      }
      else {
        $date = date('Y-m');
      }

      if (arg(5)) {
        $event_type = ucwords(str_replace('-', ' ', arg(5)));
      }
      else {
        $event_type = 'All Events';
      }

      if (arg(6)) {
        $style_term = ucwords(str_replace('-', ' ', arg(6)));
        $style = taxonomy_get_term_by_name($style_term);
        $style = reset($style)->tid;
      }
      else {
        $style = 'all';
      }
//      $srch_string = 'Event' . '/' . $country . '/' . $county . '/' . $town . '/' . implode(',', $area) . '/' . $date . '/' . $event_type . '/' . $style;
      $res = views_embed_view('yoga_searcher', 'block', 'Event', $country, $county, $town, implode(',', $area), $date, $event_type, $style);
    }
    elseif (arg(0) == 'yoga') {
      $type = t('Find Yoga Listings in') . ' ';
      $classes_hdr = '<div class="options-hdr clearfix">
      <div class="options op-time">Time</div>
      <div class="options op-style">Style</div>
      <div class="options op-duration">Duration</div>
      <div class="options op-teacher">Teacher</div>
    </div>';

      if (arg(3)) {
        $style_term = ucwords(str_replace('-', ' ', arg(3)));
        $style = taxonomy_get_term_by_name($style_term);
        $style = reset($style)->tid;
      }
      else {
        $style = 'all';
      }
      //    dpm('Studio, Instructor' . '/' . $country . '/' . $county . '/' . $town . '/' . implode(',', $area) . '/' . $style);

      $res = views_embed_view('yoga_searcher', 'block_1', 'Studio,Instructor', $country, $county, $town, implode(',', $area), $style);

    }
    elseif (arg(0) == 'classes') {

      if (!empty($params['after'])) {
        $after = timefield_time_to_integer(date('g:ia', strtotime($params['after'])));
      }
      else {
        $time_now = date('H', strtotime('now'));
        if (TRUE === TRUE) { // time given?
          if ($time_now < 6) {
            $after = 'all';
            $the_time = FALSE;
          }
          elseif ($time_now >= 6 && $time_now < 9) {
            $after = 21600; // 6am onwards
          }
          elseif ($time_now >= 9 && $time_now < 12) {
            $after = 32400; // 9am onwards
          }
          elseif ($time_now >= 12 && $time_now < 15) {
            $after = 43200; // 12pm onwards
          }
          elseif ($time_now >= 15 && $time_now < 18) {
            $after = 54000; // 15pm onwards
          }
          elseif ($time_now >= 18 && $time_now < 21) {
            $after = 64800; // 18pm onwards
          }
          elseif ($time_now >= 21) {
            $after = 75600; // 21pm onwards
          }
        }
      }

      if (arg(4)) {
        $day_lookup = strtolower(arg(4));
      }
      else {
        $day_lookup = strtolower(date('l', strtotime('now')));
      }

      if (arg(5)) {
        $style_term = ucwords(str_replace('-', ' ', arg(5)));
        $style = taxonomy_get_term_by_name($style_term);
        $style = reset($style)->tid;
      }
      else {
        $style = 'all';
      }

      drupal_add_js(drupal_get_path('module', 'models_nav') . '/js/yoga_classes.js');
      $type = t('Find Yoga Classes in') . ' ';
      $res = views_embed_view('yoga_searcher_classes', 'block', $day_lookup, $after, implode(',', $area), $country, $county, $town, $style);
    }
    drupal_set_title($type . $term);
    return $res;
  }
  else {
    drupal_set_title('Sorry - no results, please try another search!');
    watchdog('YF SEARCH', 'no results for ' . $term, array('%function' => __FUNCTION__,),WATCHDOG_ERROR);
    return '';
  }

}