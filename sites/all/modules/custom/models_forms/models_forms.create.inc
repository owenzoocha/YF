<?php

/**
 * @file
 * Provides form functionality to create events.
 */

function models_forms_instagram_auth() {
  global $user;
  global $base_url;

  $res = drupal_get_query_parameters();
  if (isset($res['nid']) && isset($res['code'])) {
    if (is_numeric($res['nid'])) {
      $nw = entity_metadata_wrapper('node', $res['nid']);
      if ($user->uid == $nw->author->getIdentifier()) {

        $url = "https://api.instagram.com/oauth/access_token";
        $access_token_parameters = array(
          'client_id' => '9d703bd716be499ebac861d0c74d4c7b',
          'client_secret' => '09535536698540c48e4cf5d3d6d2cb11',
          'grant_type' => 'authorization_code',
          'redirect_uri' => $base_url . '/instagram_auth?nid=' . $res['nid'],
          'code' => $res['code']
        );
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, TRUE);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $access_token_parameters);
        // To return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);   // to stop cURL from verifying the peer's certificate.
        $result = curl_exec($curl);   // to perform the curl session
        curl_close($curl);   // to close the curl session

        $curl_res = drupal_json_decode($result);

        $nw->field_instagram_access_token->set($curl_res['access_token']);
        $nw->save();
        drupal_goto('listing/instagram/' . $res['nid'] . '/edit');
      }
      else {
        drupal_access_denied();
      }
    }
    else {
      drupal_access_denied();
    }
  }
  else {
    drupal_access_denied();
  }

  return '';

}

function models_forms_instagram_add() {
  global $user;
  global $base_url;

  $uw = entity_metadata_wrapper('user', $user->uid);
  module_load_include('inc', 'node', 'node.pages');

//  variable_del('listing_add_' . $uw->getIdentifier());
//  variable_del('event_add_' . $uw->getIdentifier());

  if (is_numeric(arg(2))) {
    $node_form = node_load(arg(2));
  }
  else {
    $node_form = new stdClass;
    $node_form->type = 'yoga';
    $node_form->language = LANGUAGE_NONE;
    $node_form->author = $uw->getIdentifier();
  }


//  $node_form = node_load(202);
  $yoga_form = drupal_get_form('yoga_node_form', $node_form);
  $client_id = '9d703bd716be499ebac861d0c74d4c7b';
  $redirect_url = $base_url . '/instagram_auth?nid=' . arg(2);
  $auth_link = 'https://api.instagram.com/oauth/authorize/?client_id=' . $client_id . '&redirect_uri=' . $redirect_url . '&response_type=code';

  if (is_numeric(arg(2))) {
    $nw = entity_metadata_wrapper('node', arg(2));
    if ($nw->field_instagram_access_token->value()) {
      $yoga_form['get_started'] = array(
        '#markup' => '<p class="greenify">' . t('Hi !name, your Instagram Feed is all set - to enable, select the checkbox below.  Any issues, give us a shout! ', array(
            '!name' => $uw->field_first_name->value(),
            '!link' => l('authorise my account now', $auth_link)
          )) . '</p>',
      );
    }
    else {
      $yoga_form['get_started'] = array(
        '#markup' => '<p class="greenify">' . t('Hi !name, to display your Instagram feed you will need to authorise YogaFind - to continue, first click: <strong>!link</strong> and follow the instructions. Any issues, please let us know', array(
            '!name' => $uw->field_first_name->value(),
            '!link' => l('authorise my account now', $auth_link)
          )) . '</p>',
      );
    }
  }

  $yoga_form['#theme'] = array('overwrite_instagram_form');
  $yoga_form['title']['#attributes']['placeholder'] = t('The title of your listing');

  $yoga_form['actions']['submit']['#value'] = t('Submit');
  unset($yoga_form['actions']['preview']);

//  unset($yoga_form['field_yoga_cover_picture']);
  unset($yoga_form['field_yoga_introduction']);
  unset($yoga_form['field_yoga_event_type']);
  unset($yoga_form['field_yoga_event_price']);
  unset($yoga_form['field_yoga_event_price_include']);
  unset($yoga_form['field_yoga_itinerary']);
  unset($yoga_form['field_yf_text_bg']);

  unset($yoga_form['field_yoga_lt_town']);
  unset($yoga_form['field_yoga_lt_country']);
  unset($yoga_form['field_yoga_lt_county']);
  unset($yoga_form['field_yoga_classes']);
  unset($yoga_form['field_yoga_teachers']);
  unset($yoga_form['field_yoga_event_list']);

  unset($yoga_form['title']);
  unset($yoga_form['field_yoga_latlng']);
  unset($yoga_form['field_yoga_location']);
  unset($yoga_form['field_my_fb']);
  unset($yoga_form['field_my_twitter']);
  unset($yoga_form['field_my_instagram']);
  unset($yoga_form['field_yoga_event_list']);

  unset($yoga_form['field_location_taxonomy']);
  unset($yoga_form['field_yoga_style']);
  unset($yoga_form['body']);
//  unset($yoga_form['field_yoga_cover_picture']);
//  unset($yoga_form['field_yoga_logo']);

  unset($yoga_form['field_yoga_event_dates']);
  unset($yoga_form['field_yoga_link']);
  unset($yoga_form['field_yoga_mail']);
  unset($yoga_form['field_yoga_type']);
  unset($yoga_form['field_yoga_number']);
  unset($yoga_form['field_yf_gallery']);
  return $yoga_form;
}

function models_forms_listing_add() {
  global $user;

  $uw = entity_metadata_wrapper('user', $user->uid);
  module_load_include('inc', 'node', 'node.pages');

  if (is_numeric(arg(1))) {
    $node_form = node_load(arg(1));
    if (arg(0) != 'event') {
      $yoga_form = drupal_get_form('yoga_node_form', $node_form);
    }
    else {
      $yoga_form = drupal_get_form('yoga_event_node_form', $node_form);
    }
  }
  else {
    if (arg(0) != 'event') {
      $node_form = (object) array(
        'uid' => $user->uid,
        'name' => (isset($user->name) ? $user->name : ''),
        'type' => 'yoga',
        'language' => LANGUAGE_NONE,
      );
      $yoga_form = drupal_get_form('yoga_node_form', $node_form);
    }
    else {
      $node_form = (object) array(
        'uid' => $user->uid,
        'name' => (isset($user->name) ? $user->name : ''),
        'type' => 'yoga_event',
        'language' => LANGUAGE_NONE,
      );
      $yoga_form = drupal_get_form('yoga_event_node_form', $node_form);
    }
  }


  if (is_numeric(arg(1))) {
    $nw = entity_metadata_wrapper('node', arg(1));
    if (arg(0) != 'event') {
      $yoga_form['get_started'] = array(
        '#markup' => '<p class="greenify">' . t('Updating your Yoga listing: <strong>!yoga</strong>', array(
            '!name' => $uw->field_first_name->value(),
            '!yoga' => $nw->label()
          )) . '</p>',
      );
    }
    else {
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
      $yoga_form['get_started'] = array(
        '#markup' => '<p class="greenify">' . t('Namaste !name :) to get your Yoga listing published, complete the below form, hit submit and start adding your classes, events, teachers, yoga posts and more!', array('!name' => $uw->field_first_name->value())) . '</p>',
      );
    }
    else {
      // Redirect and run checks against the users' plan..
      if ($uw->field_yf_subscription->value() == 'free') {
        drupal_set_message(t('<i class="material-icons">event_available</i> Oops you must upgrade your current !plan plan to add events - <strong>!link</strong> to upgrade now :)', array('!plan' => $uw->field_yf_subscription->value(), '!link' => l('click here', '/user/plan/settings'))));
        drupal_goto('user/' . $uw->getIdentifier());
      }

//      variable_set('event_add_' . $uw->getIdentifier(), 1);
      drupal_set_title('Create a Yoga Event');
      $yoga_form['get_started'] = array(
        '#markup' => '<p class="greenify">' . t('Hi !name, to get started, select your event type from the options below - e.g Teacher Training, Retreat etc..', array('!name' => $uw->field_first_name->value())) . '</p>',
      );
    }
  }

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
    'menubar' => TRUE,
    'statusbar' => TRUE,
    'toolbar' => 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
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

  if (arg(0) == 'event') {
    unset($yoga_form['field_yoga_introduction']);
    unset($yoga_form['field_yf_gallery']);
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
//
  unset($yoga_form['field_instagram_user_id']);
  unset($yoga_form['field_instagram_access_token']);

  return $yoga_form;
}


function models_forms_listing_add_submit(&$form, &$form_state) {
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
  return TRUE;
}
