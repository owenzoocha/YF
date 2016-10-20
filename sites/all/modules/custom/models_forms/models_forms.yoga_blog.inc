<?php

/**
 * @file
 * Provides form functionality to create events.
 */

function models_forms_blog_add() {
  global $user;
  $user = user_load($user->uid);

  $uw = entity_metadata_wrapper('user', $user->uid);
  module_load_include('inc', 'node', 'node.pages');

  if (is_numeric(arg(1))) {
    $node_form = node_load(arg(1));
  }
  else {
    $node_form = new stdClass;
    $node_form->type = 'article';
    $node_form->language = LANGUAGE_NONE;
    $node_form->author = $uw->getIdentifier();
  }

  $yoga_form = drupal_get_form('article_node_form', $node_form);

  if (is_numeric(arg(1))) {
    $nw = entity_metadata_wrapper('node', arg(1));
    if (arg(0) != 'event') {
      $yoga_form['get_started'] = array(
        '#markup' => '<p class="greenify">' . t('Updating your Yoga Post: <strong>!yoga</strong>', array(
            '!name' => $uw->field_first_name->value(),
            '!yoga' => $nw->label()
          )) . '</p>',
      );
    }
  }
  else {
    if (arg(0) != 'event') {
      variable_set('blog_add_' . $user->uid, 1);
      $yoga_form['get_started'] = array(
        '#markup' => '<p class="greenify">' . t('Namaste !name, have an interesting Yoga post, tip, lesson or anything you would like to share? Create your Yoga Find post below.', array('!name' => $uw->field_first_name->value())) . '</p>',
      );
    }
  }
  $yoga_form['#theme'] = array('overwrite_classes_form');

  return $yoga_form;
}