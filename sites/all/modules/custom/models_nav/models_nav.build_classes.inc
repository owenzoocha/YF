<?php
/**
 * Build up the yoga array from result of view query;
 * @return array
 */
function build_yoga_class_array($res) {
  $class_array = array();
  foreach ($res AS $key => $class) {
    $ew = entity_metadata_wrapper('class', $class->id);
    if ($ew->field_yc_dow->value()) {
      $styles = '';
      foreach ($ew->field_yoga_style->getIterator() AS $k => $style) {
        $styles .= $style->label() . ', ';
      }

      $nw = entity_metadata_wrapper('node', $ew->uid->field_my_listings->value()[0]->nid);
      $uri = $nw->field_yoga_logo->value() ? $nw->field_yoga_logo->value()['uri'] : grab_default_profile_image($nw->author->getIdentifier());
      $pic = '<div class="event-logo">' . l(theme('image_style', array(
          'style_name' => 'profile',
          'path' => $uri,
          'attributes' => array('class' => array('img-responsive'))
        )), 'node/' . $nw->getIdentifier(), array('html' => TRUE)) . '</div>';

      //32400 = 9oclock
      $class_array[$ew->field_yc_dow->value()][] = array(
        'eid' => $ew->getIdentifier(),
        'dow' => $ew->field_yc_dow->value(),
        'pic' => $pic,
        'times' => $ew->field_yc_start_time->value()['value_formatted'] . ' - ' . $ew->field_yc_start_time->value()['value2_formatted'],
        'desc' => $ew->field_yc_desc->value(),
        'style' => rtrim($styles, ', '),
        'teacher' => $ew->field_yc_teacher->value() ? $ew->field_yc_teacher->label() : '-',
        'duration' => timefield_time_to_duration($ew->field_yc_start_time->value()['value'], $ew->field_yc_start_time->value()['value2'], 'time'),
      );
    }
  }
  return $class_array;
}

/**
 * Build up the yoga classes data from the array.
 * @return array
 */
function build_yoga_class_data($class_array, $make_edits) {
  $class_data = '';
  foreach ($class_array as $key => $day) {
    $active_class = date('l', strtotime('now')) == $key ? 'active' : '';
    $class_data .= '<div class="day-wrapper ' . $active_class . '" data-day="' . $key . '">';
    $i = 1;
    foreach ($day as $k => $v) {
      $editable = $make_edits === TRUE ? '<span class="edit-link">' . l(t('edit'), 'classes/' . $v['eid'] . '/edit') . '</span>' : FALSE;
      $class_data .= '<div class="class-' . $i . ' yoga-class">';
      $class_data .= '<div class="options op-time">' . $editable . ' ' . $v['times'] . '</div>';
      $class_data .= '<div class="options op-style">' . $v['style'] . '</div>';
      $class_data .= '<div class="options op-duration">' . $v['duration'] . 'h</div>';
      $class_data .= '<div class="options op-teacher">' . $v['teacher'] . '</div>';
      $class_data .= '<div class="yoga-class-extra">';
      $class_data .= '<div class="yoga-class-img">' . $v['pic'] . '</div>';
      $class_data .= '<div class="yoga-class-desc">';
      $class_data .= '<div class="close-btn"><i class="material-icons">close</i></div>';
      $class_data .= '<h4>' . $v['style'] . '</h4>';
      $class_data .= '<p><strong>' . $v['times'] . '</strong> with <strong>' . $v['teacher'] . '</strong></p>';
      $class_data .= '<p>' . $v['desc'] . '</p>';
      $class_data .= '</div>';
      $class_data .= '</div>';
      $class_data .= '</div>';
      $i++;
    }
    $class_data .= '</div>';
  }

  return $class_data;
}

function build_yoga_timetable_data($class_array, $make_edits) {
  $class_data = '';
  $class_data .= '<div class="day-wrapper timetable-wrapper">';

  foreach ($class_array as $k => $v) {
    $i = 1;
    $editable = $make_edits === TRUE ? '<span class="edit-link">' . l(t('edit'), 'classes/' . $v['eid'] . '/edit') . '</span>' : FALSE;
    $class_data .= '<div class="class-' . $i . ' yoga-class">';
    $class_data .= '<div class="options op-time">' . $editable . ' ' . $v['times'] . '</div>';
    $class_data .= '<div class="options op-style">' . $v['style'] . '</div>';
    $class_data .= '<div class="options op-duration">' . $v['duration'] . 'h</div>';
    $class_data .= '<div class="options op-teacher">' . $v['teacher'] . '</div>';
    $class_data .= '<div class="yoga-class-extra">';
    $class_data .= '<div class="yoga-class-img">' . $v['pic'] . '</div>';
    $class_data .= '<div class="yoga-class-desc">';
    $class_data .= '<div class="close-btn"><i class="material-icons">close</i></div>';
    $class_data .= '<h4>' . $v['style'] . '</h4>';
    $class_data .= '<p><strong>' . $v['times'] . '</strong> with <strong>' . $v['teacher'] . '</strong></p>';
    $class_data .= '<p>' . $v['desc'] . '</p>';
    $class_data .= '</div>';
    $class_data .= '</div>';
    $class_data .= '</div>';
    $i++;
  }

  $class_data .= '</div>';

  return $class_data;
}

/**
 * Build up the yoga classes data from the array.
 * @return array
 */
function build_yoga_class_widget_header($class_array) {
  // Create the classes header.
  $hdr = !empty($class_array['Monday']) ? 'yes' : 'no';
  $active_class = date('l', strtotime('now')) == 'Monday' ? 'active' : '';
  $class_header = '<div class="day ' . $hdr . '-classes"><a data-day="Monday" class="' . $active_class . '" href="#"><span class="hidden-lg">Mon</span><span class="visible-lg-inline">Monday</span></a></div>';

  $hdr = !empty($class_array['Tuesday']) ? 'yes' : 'no';
  $active_class = date('l', strtotime('now')) == 'Tuesday' ? 'active' : '';
  $class_header .= '<div class="day ' . $hdr . '-classes"><a data-day="Tuesday" class="' . $active_class . '" href="#"><span class="hidden-lg">Tue</span><span class="visible-lg-inline">Tuesday</span></a></div>';
  $hdr = !empty($class_array['Wednesday']) ? 'yes' : 'no';
  $active_class = date('l', strtotime('now')) == 'Wednesday' ? 'active' : '';
  $class_header .= '<div class="day ' . $hdr . '-classes"><a data-day="Wednesday" class="' . $active_class . '" href="#"><span class="hidden-lg">Wed</span><span class="visible-lg-inline">Wednesday</span></a></div>';

  $hdr = !empty($class_array['Thursday']) ? 'yes' : 'no';
  $active_class = date('l', strtotime('now')) == 'Thursday' ? 'active' : '';
  $class_header .= '<div class="day ' . $hdr . '-classes"><a data-day="Thursday" class="' . $active_class . '" href="#"><span class="hidden-lg">Thur</span><span class="visible-lg-inline">Thursday</span></a></div>';

  $hdr = !empty($class_array['Friday']) ? 'yes' : 'no';
  $active_class = date('l', strtotime('now')) == 'Friday' ? 'active' : '';
  $class_header .= '<div class="day ' . $hdr . '-classes"><a data-day="Friday" class="' . $active_class . '" href="#"><span class="hidden-lg">Fri</span><span class="visible-lg-inline">Friday</span></a></div>';

  $hdr = !empty($class_array['Saturday']) ? 'yes' : 'no';
  $active_class = date('l', strtotime('now')) == 'Saturday' ? 'active' : '';
  $class_header .= '<div class="day ' . $hdr . '-classes"><a data-day="Saturday" class="' . $active_class . '" href="#"><span class="hidden-lg">Sat</span><span class="visible-lg-inline">Saturday</span></a></div>';

  $hdr = !empty($class_array['Sunday']) ? 'yes' : 'no';
  $active_class = date('l', strtotime('now')) == 'Sunday' ? 'active' : '';
  $class_header .= '<div class="day ' . $hdr . '-classes"><a data-day="Sunday" class="' . $active_class . '" href="#"><span class="hidden-lg">Sun</span><span class="visible-lg-inline">Sunday</span></a></div>';

  return $class_header;
}