<?php

/**
 * @file
 * Provides form functionality to create events.
 */

function models_forms_teacher_add() {
  global $user;
  $user = user_load($user->uid);

  $uw = entity_metadata_wrapper('user', $user->uid);

  $entity = entity_create('class', array('type' => 'teacher'));
  $yoga_form = drupal_get_form('eck__entity__form_add_class_teacher', $entity);
  $yoga_form['title']['#title'] = t('Full Name');
  $yoga_form['get_started'] = array(
    '#markup' => '<p class="greenify">' . t('Post a new Yoga Teacher for your listing below') . '</p>',
  );
  $yoga_form['#theme'] = array('overwrite_classes_form');

  $wysiwyg_js['wysiwyg']['configs']['tinymce']['formatfiltered_html'] = array(
    'menubar' => FALSE,
    'statusbar' => FALSE,
  );
  drupal_add_js($wysiwyg_js, 'setting');

  return $yoga_form;
}
//
//function models_forms_teachers_add_submit($form, &$form_state) {
//  global $user;
//  dpm($user);
//  $uw = entity_metadata_wrapper('user', $user->uid);
//
//  $nw = entity_metadata_wrapper('node', $uw->field_my_listings->value()[0]->nid);
//
//  dpm($form_state['values'], 'fs');
//  dpm('here!!www');
//}

