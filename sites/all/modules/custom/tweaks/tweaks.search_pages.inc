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
function tweaks_yoga_search_results($term) {
  $term = ucwords(str_replace('-', ' ', $term));
  $search_place = taxonomy_get_term_by_name($term);
  $search_parents = taxonomy_get_parents_all(reset($search_place)->tid);

//  dpm(arg(3));
//  dpm(arg(4));

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

  $lat = 51.656991;
  $lng = -3.805476;
  $dist = 2;

  $area = array($lat, $lng, $dist);

//  dpm(implode(',', $area));
//  dpm($town);
//  dpm($county);
//  dpm($country);

  if (arg(0) == 'events') {
    $type = t('Find Yoga Events in') . ' ';
  }
  elseif (arg(0) == 'classes') {
    $type = t('Find Yoga Classes in') . ' ';
  }
//
//  $res = views_get_view_result('yoga_searcher', 'block_1', 'Event');
//  dpm($res);

//  $searcher = 'Event+206+all1959';
  $res = views_embed_view('yoga_searcher', 'block', 'Event', $country, $county, $town, implode(',', $area));
//  dpm($res);
  drupal_set_title($type . $term);
  return $res;
}