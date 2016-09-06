<?php

/**
 * @file
 * Provides form functionality to create events.
 */

function models_forms_class_add() {
  global $user;
  $user = user_load($user->uid);

  $uw = entity_metadata_wrapper('user', $user->uid);
  $nw = entity_metadata_wrapper('node', $uw->field_my_listings->value()[0]->nid);

  $entity = entity_create('class', array('type' => 'yoga'));
  $yoga_form = drupal_get_form('eck__entity__form_add_class_yoga', $entity);

  $yoga_form['title']['#value'] = 'yoga_class_' . $uw->getIdentifier() . '_' . $uw->label();

  if (!$nw->field_yoga_teachers->value()) {
    $yoga_form['get_started'] = array(
      '#markup' => '<p class="greenify">' . t('Post a new Yoga class for your listing below.</br>Tip! To get started, you may want to <strong>!add</strong>.', array('!add' => l(t('add a teacher'), 'teacher/add'))) . '</p>',
    );
  }
  else {
    $yoga_form['get_started'] = array(
      '#markup' => '<p class="greenify">' . t('Post a new Yoga class for your listing below') . '</p>',
    );
  }
  $yoga_form['#theme'] = array('overwrite_classes_form');

  return $yoga_form;
}

function models_forms_class_add_submit($form, &$form_state) {
  global $user;
  dpm($user);
  $uw = entity_metadata_wrapper('user', $user->uid);

  $nw = entity_metadata_wrapper('node', $uw->field_my_listings->value()[0]->nid);

  dpm($form_state['values'], 'fs');
  dpm('here!!www');
}

