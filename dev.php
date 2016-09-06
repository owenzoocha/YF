<?php
/**
 * Root directory of Drupal installation.
 */
define('DRUPAL_ROOT', getcwd());

require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);

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

//testerr();

menu_execute_active_handler();
// delete_out_of_date();
//owen_pp_refund();
//owen_pp_delayed();
