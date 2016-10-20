<?php

/**
 * @file
 * Provides form functionality to create events.
 */

function models_forms_listing_add() {
  global $user;

  $uw = entity_metadata_wrapper('user', $user->uid);
  module_load_include('inc', 'node', 'node.pages');

  variable_del('listing_add_' . $uw->getIdentifier());
  variable_del('event_add_' . $uw->getIdentifier());

  if (is_numeric(arg(1))) {
    $node_form = node_load(arg(1));
  }
  else {
    $node_form = new stdClass;
    $node_form->type = 'yoga';
    $node_form->language = LANGUAGE_NONE;
    $node_form->author = $uw->getIdentifier();
  }


//  $node_form = node_load(202);
  $yoga_form = drupal_get_form('yoga_node_form', $node_form);

//  YF google - AIzaSyBFrus52HY5XQTU5xBfVmEh0LvxpUGTVcY

  if (is_numeric(arg(1))) {
    $nw = entity_metadata_wrapper('node', arg(1));
    if (arg(0) != 'event') {
      variable_set('listing_add_' . $uw->getIdentifier(), 1);

      $yoga_form['get_started'] = array(
        '#markup' => '<p class="greenify">' . t('Updating your Yoga listing: <strong>!yoga</strong>', array(
            '!name' => $uw->field_first_name->value(),
            '!yoga' => $nw->label()
          )) . '</p>',
      );
    }
    else {
      variable_set('event_add_' . $uw->getIdentifier(), 1);

      drupal_set_title('Update your Yoga Event');
      $yoga_form['get_started'] = array(
        '#markup' => '<p class="greenify">' . t('Updating your Yoga listing: <strong>!yoga</strong>', array(
            '!name' => $uw->field_first_name->value(),
            '!yoga' => $nw->label()
          )) . '</p>',
      );
    }
  }
  else {
    if (arg(0) != 'event') {
      variable_set('listing_add_' . $uw->getIdentifier(), 1);
      $yoga_form['get_started'] = array(
        '#markup' => '<p class="greenify">' . t('Namaste !name :) to get your Yoga listing published, complete the below form, hit submit and start adding your classes, events, teachers, yoga posts and more!', array('!name' => $uw->field_first_name->value())) . '</p>',
      );
    }
    else {
      variable_set('event_add_' . $uw->getIdentifier(), 1);
      drupal_set_title('Create a Yoga Event');
      $yoga_form['get_started'] = array(
        '#markup' => '<p class="greenify">' . t('Hi !name, to get started, select your event type from the options below - e.g Teacher Training, Retreat etc..', array('!name' => $uw->field_first_name->value())) . '</p>',
      );
    }
  }

  dpm(variable_get('listing_add_' . $uw->getIdentifier()));
  dpm(variable_get('event_add_' . $uw->getIdentifier()));

  if (arg(0) != 'event') {
    $yoga_form['#theme'] = array('overwrite_listing_form');
    $yoga_form['title']['#attributes']['placeholder'] = t('The title of your listing');
  }
  else {
    $yoga_form['#theme'] = array('overwrite_event_form');
    $yoga_form['title']['#attributes']['placeholder'] = t('The title of your yoga event');
    $yoga_form['field_yoga_link']['und'][0]['#description'] = t('Your booking URL / website will be displayed next to your event listing.');
  }

  $wysiwyg_js['wysiwyg']['configs']['tinymce']['formatfiltered_html'] = array(
    'menubar' => FALSE,
    'statusbar' => FALSE,
  );
  drupal_add_js($wysiwyg_js, 'setting');

  if (arg(0) != 'event') {
    $yoga_form['#attached']['js'] = array(
//      'http://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyBFrus52HY5XQTU5xBfVmEh0LvxpUGTVcY' => array(
//        'type' => 'external',
//      ),
      libraries_get_path('geocomplete') . '/' . 'jquery.geocomplete.min.js',
      drupal_get_path('module', 'models_forms') . '/js/models_forms_google_complete.js',
    );

    $yoga_form['geocomplete'] = array(
      '#type' => 'textfield',
      // '#title' => 'Enter an address',
      '#description' => t('If your address is unrecognised, try the manual option below.'),
      '#attributes' => array(
        'id' => array('geocomplete'),
      ),
      '#suffix' => '<div class="map_canvas"></div><!--<p><a href="#" class="geocomplete-manual">' . t('+ add manual location') . '</a></p>-->',
    );
  }

  $yoga_form['actions']['submit']['#value'] = t('Submit');
  unset($yoga_form['actions']['preview']);

  if ($uw->field_my_listings->value()) {
    $nw = entity_metadata_wrapper('node', $uw->field_my_listings->value()[0]->nid);
    $yoga_form['field_yoga_number'][LANGUAGE_NONE][0]['value']['#value'] = $nw->field_yoga_number->value();
  }

//  $yoga_form['field_yoga_mail'][LANGUAGE_NONE][0]['value']['#value'] = $uw->mail->value();
  $yoga_form['field_yoga_mail'][LANGUAGE_NONE][0]['value']['#value'] = $uw->mail->value();

  $yoga_form['hide_country'] = array(
    '#type' => 'hidden',
    '#attributes' => array(
      'id' => array('hide_country'),
    ),
  );
  $yoga_form['hide_county'] = array(
    '#type' => 'hidden',
    '#attributes' => array(
      'id' => array('hide_county'),
    ),
  );

//  $yoga_form['field_yoga_link']['und'][0]['#value']['#attributes']['placeholder'] = t('example.co.uk2');
//  $yoga_form['field_yoga_link']['und'][0]['value']['#attributes']['placeholder'] = t('example.co.uk2');
//  $yoga_form['field_yoga_link'][LANGUAGE_NONE]['#attributes']['placeholder'] = t('example.co.uk3');
//  $yoga_form['field_yoga_link'][LANGUAGE_NONE][0]['#attributes']['placeholder'] = t('example.co.uk3');
//  $yoga_form['field_yoga_link']['#attributes']['placeholder'] = t('example.co.uk3');
//  $yoga_form['']

  if (arg(0) == 'event') {
    $yoga_form['field_yoga_type']['und']['#value'] = 'event';
    unset($yoga_form['field_yoga_cover_picture']);
    unset($yoga_form['field_yoga_introduction']); 

  }
  else {
    unset($yoga_form['field_yoga_event_type']);
    unset($yoga_form['field_yoga_event_price']);
    unset($yoga_form['field_yoga_event_price_include']);
    unset($yoga_form['field_yoga_itinerary']);
  }

  unset($yoga_form['field_yoga_lt_town']);
  unset($yoga_form['field_yoga_lt_country']);
  unset($yoga_form['field_yoga_lt_county']);
  unset($yoga_form['field_yoga_classes']);
  unset($yoga_form['field_yoga_teachers']);
  unset($yoga_form['field_yoga_event_list']);

  return $yoga_form;
}

//function models_forms_event_add_submit($form, &$form_state) {
//  dpm($form_state,'here fs');
//}

function models_forms_listing_add_submit($form, &$form_state) {
  $nw = entity_metadata_wrapper('node', $form_state['values']['nid']);
  if ($nw->field_yoga_location->value()) {
    if ($nw->field_yoga_location->value()['locality']) {
      $town = $nw->field_yoga_location->value()['locality'];
    }
    else {
      if ($nw->field_yoga_location->value()['administrative_area']) {
        $town = $nw->field_yoga_location->value()['administrative_area'];
      }
    }

    $town = taxonomy_get_term_by_name($town);
    if (!empty($town)) {
      $locations_tax = taxonomy_get_parents_all(reset($town)->tid);
      foreach ($locations_tax as $key => $val) {
        if ($key == 0) {
          $nw->field_yoga_lt_town->set($val->tid);
        }
        if ($key == 1) {
          $nw->field_yoga_lt_county->set($val->tid);
        }
        if ($key == 2) {
          $nw->field_yoga_lt_country->set($val->tid);
        }
        $nw->field_location_taxonomy->offsetSet($key, $val->tid);
      }
      $nw->save();
    }
  }
}
