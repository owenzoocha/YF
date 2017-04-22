<?php

/**
 * @file
 * Provides form functionality to create events.
 */

function models_forms_class_add() {
  global $user;
  $user = user_load($user->uid);
  $uw = entity_metadata_wrapper('user', $user->uid);

  // Redirect and run checks against the users' plan..
  if ($uw->field_yf_subscription->value() == 'free') {
    drupal_set_message(t('<i class="material-icons">schedule</i> Oops you must upgrade your current !plan plan to add classes - <strong>!link</strong> to upgrade now :)', array('!plan' => $uw->field_yf_subscription->value(), '!link' => l('click here', '/user/plan/settings'))));
    drupal_goto('user/' . $uw->getIdentifier());
  }

  $nw = entity_metadata_wrapper('node', $uw->field_my_listings->value()[0]->nid);

  if (is_numeric(arg(1))) {

    // Check to see if the author and only the author is editing.
    if ($user->uid != $nw->value()->uid) {
      drupal_goto('node/' . $nw->getIdentifier());
    } else {
      $params = drupal_get_query_parameters();
      if (!empty($params['delete'])) {
        entity_delete('class', arg(1));
        drupal_goto('node/' . $nw->getIdentifier());
      }
    }

    $entity_tmp = entity_load('class', array(arg(1)));
    $entity = reset($entity_tmp);
    $get_started = array(
      '#markup' => '<p class="greenify">' . t('Update your Yoga class below') . '</p>',
    );

  }
  else {
    $entity = entity_create('class', array('type' => 'yoga'));
    $get_started = array(
      '#markup' => '<p class="greenify">' . t('Post a new Yoga class for your listing below') . '</p>',
    );

    if ($nw->field_yoga_type->value() != 'instructor') {
      if (!$nw->field_yoga_teachers->value()) {
        $get_started = array(
          '#markup' => '<p class="greenify">' . t('Post a new Yoga class for your listing below.</br>Tip! To get started, you may want to <strong>!add</strong>.', array('!add' => l(t('add a teacher'), 'teacher/add'))) . '</p>',
        );
      }
    }
  }

  $yoga_form = drupal_get_form('eck__entity__form_add_class_yoga', $entity);

  $yoga_form['title']['#value'] = 'yoga_class_' . $uw->getIdentifier() . '_' . $uw->label();

  $yoga_form['get_started'] = $get_started;

  if (is_numeric(arg(1))) {
    $yoga_form['actions']['delete'] = array(
      '#markup' => l(t('Delete'), 'teacher/' . arg(1) . '/edit', array(
        'query' => array('delete' => 1),
        'attributes' => array('class' => array('btn btn-danger'))
      )),
      '#weight' => 10001,
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

