<?php
/**
 * @file
 * yoga_content_types.features.inc
 */

/**
 * Implements hook_node_info().
 */
function yoga_content_types_node_info() {
  $items = array(
    'yoga_event' => array(
      'name' => t('Yoga Event'),
      'base' => 'node_content',
      'description' => t('Yoga Event'),
      'has_title' => '1',
      'title_label' => t('Title'),
      'help' => '',
    ),
  );
  drupal_alter('node_info', $items);
  return $items;
}
