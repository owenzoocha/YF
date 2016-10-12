<?php

/**
 * Fix the classes searcher - to manipulate the query and allow for start time tweaks.
 */
function models_searcher_views_query_alter(&$view, &$query) {
  if ($view->name == 'yoga_searcher_classes') {
    foreach ($query->where[0]['conditions'] as $index => $condition) {
      if (strpos($condition['field'], 'field_data_field_yc_start_time.') !== FALSE) {
        $query->where[0]['conditions'][$index]['field'] = 'field_data_field_yc_start_time.field_yc_start_time_value';
        $query->where[0]['conditions'][$index]['value'] = $condition['value'][':field_data_field_yc_start_time_field_yc_start_time_value'];
        $query->where[0]['conditions'][$index]['operator'] = '>=';
        break;
      }
    }
  }

  if ($view->name == 'yoga_searcher') {
//    DATE_FORMAT(field_data_field_yoga_event_dates.field_yoga_event_dates_value, '%Y-%m') >= :field_data_field_yoga_event_dates_field_yoga_event_dates_value
    foreach ($query->where[0]['conditions'] as $index => $condition) {
      if (strpos($condition['field'], 'DATE_FORMAT(field_data_field_yoga_event_dates') !== FALSE) {
        $query->where[0]['conditions'][$index]['field'] = 'DATE_FORMAT(field_data_field_yoga_event_dates.field_yoga_event_dates_value, \'%Y-%m\') >= :field_data_field_yoga_event_dates_field_yoga_event_dates_value';
        unset($query->where[0]['conditions'][$index]['value'][':field_data_field_yoga_event_dates_field_yoga_event_dates_value1']);
        break;
      }
    }
  }
}