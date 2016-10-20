<?php
/**
 * Template preprocess for Yoga Classes widget block.
 */
function template_preprocess_yoga_area_lp(&$vars) {
  global $user;

//  $countries = taxonomy_get_tree(4, $parent = 0, $max_depth = 1, $load_entities = FALSE);
  drupal_add_js(drupal_get_path('module', 'models_nav') . '/js/yoga_area_lp.js');

  if (drupal_get_path_alias() == 'events') {
    $countries['International'] = array(
      'tid' => 1976,
      'url' => 'in/international',
    );
  }
  $countries['England'] = array(
    'tid' => 207,
    'url' => 'in/england',
  );
  $countries['Scotland'] = array(
    'tid' => 208,
    'url' => 'in/scotland',
  );
  $countries['Wales'] = array(
    'tid' => 206,
    'url' => 'in/wales',
  );
  $countries['Northern Ireland'] = array(
    'tid' => 209,
    'url' => 'in/northern-ireland',
  );
  $countries['Republic Of Ireland'] = array(
    'tid' => 210,
    'url' => 'in/repubic-of-ireland',
  );
//  ksort($countries);

  $counties = array();
  foreach ($countries as $index => $country) {
    $counties[$index] = taxonomy_get_tree(4, $country['tid'], $max_depth = 1, $load_entities = FALSE);
  }

  $places = array();
  foreach ($counties as $i => $county_parent) {
    foreach ($county_parent as $j => $county) {
      $places[$i][$county->name] = taxonomy_get_tree(4, $county->tid, $max_depth = 1, $load_entities = FALSE);
    }
  }

//  dpm($countries);
//  dpm($counties);
//  dpm($places);

  try {
    
    $england = '<h2><i class="material-icons">add</i> England</h2>';
    $wales = '<h2><i class="material-icons">add</i> Wales</h2>';
    $scotland = '<h2><i class="material-icons">add</i> Scotland</h2>';
    $ni = '<h2><i class="material-icons">add</i> Northern Ireland</h2>';

    $srch = drupal_get_path_alias() . '/';
//    if ($srch = 'in/') {
//      $srch = 'yoga/';
//    }

    if (drupal_get_path_alias() == 'events') {
      $international = '<h2><i class="material-icons">add</i> International Events</h2>';
      // AREAS OF ENGLAND.
      $international .= '<div class="area-showhide">';
      $international .= '<ul class="list-unstyled">';

      foreach ($places['International'] as $county => $county_of_int) {
        $international .= '<li>';
        $international .= '<h3>' . l($county, $srch . 'in/' . str_replace(' ', '-', strtolower($county))) . '</h3>';
        $international .= '<ul class="list-unstyled">';
        foreach ($county_of_int as $county_index => $town) {
          $international .= '<li>' . l($town->name, $srch . 'in/' . str_replace(' ', '-', strtolower($town->name))) . '</li>';
        }
        $international .= '</ul>';
        $international .= '</li>';
      }
      $international .= '</ul>';
      $international .= '</div>';
      $vars['international'] = $international;
    }
    else {
      $vars['international'] = FALSE;
    }
    
    
    // AREAS OF ENGLAND.
    $england .= '<div class="area-showhide">';
    $england .= '<ul class="list-unstyled">';

    foreach ($places['England'] as $county => $county_of_eng) {
      $england .= '<li>';
      $england .= '<h3>' . l($county, $srch . 'in/' . str_replace(' ', '-', strtolower($county))) . '</h3>';
      $england .= '<ul class="list-unstyled">';
      foreach ($county_of_eng as $county_index => $town) {
        $england .= '<li>' . l($town->name, $srch . 'in/' . str_replace(' ', '-', strtolower($town->name))) . '</li>';
      }
      $england .= '</ul>';
      $england .= '</li>';
    }
    $england .= '</ul>';
    $england .= '</div>';
    $vars['england'] = $england;

    // AREAS OF WALES.
    $wales .= '<div class="area-showhide">';
    $wales .= '<ul class="list-unstyled">';
    foreach ($places['Wales'] as $county => $county_of_eng) {
      $wales .= '<li>';
      $wales .= '<h3>' . l($county, $srch . 'in/' . str_replace(' ', '-', strtolower($county))) . '</h3>';
      $wales .= '<ul class="list-unstyled">';
      foreach ($county_of_eng as $county_index => $town) {
        $wales .= '<li>' . l($town->name . ' - ' . $town->tid, $srch . 'in/' . str_replace(' ', '-', strtolower($town->name))) . '</li>';
      }
      $wales .= '</ul>';
      $wales .= '</li>';
    }
    $wales .= '</ul>';
    $wales .= '</div>';

    $vars['wales'] = $wales;

    // AREAS OF SCOTLAND.
    $scotland .= '<div class="area-showhide">';
    $scotland .= '<ul class="list-unstyled">';
    foreach ($places['Scotland'] as $county => $county_of_eng) {
      $scotland .= '<li>';
      $scotland .= '<h3>' . l($county, $srch . 'in/' . str_replace(' ', '-', strtolower($county))) . '</h3>';
      $scotland .= '<ul class="list-unstyled">';
      foreach ($county_of_eng as $county_index => $town) {
        $scotland .= '<li>' . l($town->name, $srch . 'in/' . str_replace(' ', '-', strtolower($town->name))) . '</li>';
      }
      $scotland .= '</ul>';
      $scotland .= '</li>';
    }
    $scotland .= '</ul>';
    $scotland .= '</div>';
    $vars['scotland'] = $scotland;

    // AREAS OF NI.
    $ni .= '<div class="area-showhide">';
    $ni .= '<ul class="list-unstyled">';
    foreach ($places['Northern Ireland'] as $county => $county_of_eng) {
      $ni .= '<li>';
      $ni .= '<h3>' . l($county, $srch . 'in/' . str_replace(' ', '-', strtolower($county))) . '</h3>';
      $ni .= '<ul class="list-unstyled">';
      foreach ($county_of_eng as $county_index => $town) {
        $ni .= '<li>' . l($town->name, $srch . 'in/' . str_replace(' ', '-', strtolower($town->name))) . '</li>';
      }
      $ni .= '</ul>';
      $ni .= '</li>';
    }
    $ni .= '</ul>';
    $ni .= '</div>';
    $vars['ni'] = $ni;


//    if (!is_numeric(arg(1))) {
//      $nid = explode('/', drupal_get_normal_path('studio/' . arg(1)));
//      $nid = $nid[1];
//    }
//    else {
//      $nid = arg(1);
//    }
//    $nw = entity_metadata_wrapper('node', $nid);
//
//    $class_array = array();
//    $make_edits = $user->uid == $nw->author->getIdentifier() ? TRUE : FALSE;


  } catch (EntityMetadataWrapperException $exc) {
    watchdog(
      'template_preprocess_yoga_area_lp block',
      'EntityMetadataWrapper exception in %function() @trace',
      array('%function' => __FUNCTION__, '@trace' => $exc->getTraceAsString()),
      WATCHDOG_ERROR
    );
  }
}
