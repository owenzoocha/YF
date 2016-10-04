<?php
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
