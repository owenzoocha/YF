<?php

/**
 * @file
 * The primary PHP file for this theme.
 */

// -37.859354, 144.971573 == 11/349.. blabla

// function yogafind_search_api_solr_search_results_alter(&$results, $query, $response) {
//   dpm($results);
//   dpm($response);
// }

/**
 * Implements hook_preprocess_node().
 */
function yogafind_preprocess_node(&$variables) {
  global $user;
  if ($variables['view_mode'] == 'teaser') {
    $variables['theme_hook_suggestions'][] = 'node__' . $variables['node']->type . '__teaser';
    $variables['theme_hook_suggestions'][] = 'node__' . $variables['node']->nid . '__teaser';
  }

  if ($variables['view_mode'] == 'token') {
    $variables['theme_hook_suggestions'][] = 'node__' . $variables['node']->type . '__token';
    $variables['theme_hook_suggestions'][] = 'node__' . $variables['node']->nid . '__token';
    if (isset($variables['field_yoga_type'])) {
      if ($variables['field_yoga_type'][0]['value'] != 'event') {
        $variables['theme_hook_suggestions'][] = 'node__' . $variables['node']->type . '__listing__token';
      }
    }
  }

  if ($variables['type'] == 'article') {
    if ($variables['view_mode'] != 'teaser') {
      $nw = entity_metadata_wrapper('node', $variables['nid']);
      if ($nw->status->value() == 0) {
        $variables['publish_msg'] = '<p class="greenify">' . t('This post is currently in preview mode - click !here when you are ready to publish.', array(
            '!here' => l('<strong>' . t('here') . '</strong>', 'node/' . arg(1), array(
              'html' => TRUE,
              'query' => array('publish' => 1)
            ))
          )) . '</p>';
      }
      else {
        if (!$nw->promote->value()) {
          $variables['publish_msg'] = '<p class="greenify">' . t('This post is being reviewed, please check back soon!') . '</p>';
        }
      }
    }
    else {
      $nw = entity_metadata_wrapper('node', $variables['nid']);

      try {
        $variables['title'] = l($variables['title'], 'node/' . $nw->getIdentifier());
        $variables['post_date'] = date('d M Y H:i', $nw->created->value());
        $variables['author_name'] = $nw->author->label();

        $alter = array(
          'max_length' => 150,
          'ellipsis' => TRUE,
          'word_boundary' => TRUE,
          'html' => TRUE,
        );
        $variables['description'] = $nw->body->value() ? views_trim_text($alter, drupal_html_to_text($nw->body->value()['value'], array(
          'p',
          'a'
        ))) : FALSE;

        $uri = $nw->field_post_image->value() ? $nw->field_post_image->value()['uri'] : grab_default_profile_image($nw->author->getIdentifier());

        $pic = '<div class="event-logo">' . l(theme('image_style', array(
            'style_name' => 'profile',
            'path' => $uri,
            'attributes' => array('class' => array('img-responsive'))
          )), 'node/' . $nw->getIdentifier(), array('html' => TRUE)) . '</div>';
        $variables['logo'] = $pic;

        $variables['listing_link'] = $nw->author->field_my_listings->value() ? '<p class="listing-link"><small>' . t('Listing:') . '</small> ' . l($nw->author->field_my_listings->value()[0]->title, 'node/' . $nw->author->field_my_listings->value()[0]->nid, array('attributes' => array('class' => array('a-link')))) . '</p>' : FALSE;

      } catch (EntityMetadataWrapperException $exc) {
        watchdog(
          'template - posts teaser',
          'EntityMetadataWrapper exception in %function() @trace',
          array(
            '%function' => __FUNCTION__,
            '@trace' => $exc->getTraceAsString()
          ),
          WATCHDOG_ERROR
        );
      }


    }
  }

  if ($variables['type'] == 'yoga') {

    if (!empty($variables['field_yoga_type'][0]['value'])) {
      $variables['yoga_type'] = $variables['field_yoga_type'][0]['value'];
    }

    if ($variables['view_mode'] == 'token') {

      $nw = entity_metadata_wrapper('node', $variables['nid']);
      $variables['title'] = l(decode_entities($variables['title']), 'node/' . $nw->getIdentifier());
      $alter = array(
        'max_length' => 150,
        'ellipsis' => TRUE,
        'word_boundary' => TRUE,
        'html' => TRUE,
      );
      $variables['description'] = $nw->body->value() ? views_trim_text($alter, $nw->body->value()['value']) : FALSE;

      $styles = '';
      if ($nw->field_yoga_style->value()) {
        $styles = '<ul class="list-unstyled teaser-styles">';
        foreach ($nw->field_yoga_style->getIterator() AS $k => $style) {
          $styles .= '<li><span>' . $style->label() . '</span></li>';
        }
        $styles .= '</ul>';
      }
      $variables['styles'] = $styles;

      $variables['location'] = implode(', ', grab_location_blurb($nw));

      if ($variables['field_yoga_type'][0]['value'] == 'event') {
        try {
          // Parent.
          $query = db_query('SELECT entity_id FROM field_data_field_yoga_event_list WHERE field_yoga_event_list_nid=:nid', array('nid' => $nw->getIdentifier()));
          $res = $query->fetchAll();
          $pw = entity_metadata_wrapper('node', $res[0]->entity_id);

          $variables['parent_title'] = l($pw->label(), 'node/' . $pw->getIdentifier());
          $variables['event_type'] = $nw->field_yoga_event_type->value() ? $nw->field_yoga_event_type->label() : FALSE;

          if ($nw->field_yoga_event_dates->value()) {
            if ($nw->field_yoga_event_dates->value()['value'] == $nw->field_yoga_event_dates->value()['value2']) {
              $variables['dates'] = date('dS M Y', strtotime($nw->field_yoga_event_dates->value()['value']));
            }
            else {
              $variables['dates'] = date('dS M Y', strtotime($nw->field_yoga_event_dates->value()['value'])) . '<i class="material-icons">&#xE8E4;</i><span class="date-to">' . date('dS M Y', strtotime($nw->field_yoga_event_dates->value()['value2'])) . '</span>';
            }

          }
          $uri = $nw->field_yoga_logo->value() ? $nw->field_yoga_logo->value()['uri'] : grab_default_profile_image($pw->author->getIdentifier());
          $pic = '<div class="event-logo">' . l(theme('image_style', array(
              'style_name' => 'profile',
              'path' => $uri,
              'attributes' => array('class' => array('img-responsive'))
            )), 'node/' . $nw->getIdentifier(), array('html' => TRUE)) . '</div>';
          $variables['logo'] = $pic;

          if ($nw->field_yoga_event_price->value()) {
            $price_class = strlen($nw->field_yoga_event_price->value()) > 10 ? 'block-this' : 'inline-this';
          }
          $variables['price'] = $nw->field_yoga_event_price->value() ? '<p class="event-price ' . $price_class . '">' . $nw->field_yoga_event_price->value() . '</p>' : FALSE;
        } catch (EntityMetadataWrapperException $exc) {
          watchdog(
            'MODULE_NAME',
            'EntityMetadataWrapper exception in %function() @trace',
            array(
              '%function' => __FUNCTION__,
              '@trace' => $exc->getTraceAsString()
            ),
            WATCHDOG_ERROR
          );
        }
      }
      else {
        $uri = $nw->field_yoga_logo->value()['uri'];
        $pic = '<div class="event-logo">' . l(theme('image_style', array(
            'style_name' => 'profile',
            'path' => $uri,
            'attributes' => array('class' => array('img-responsive'))
          )), 'node/' . $nw->getIdentifier(), array('html' => TRUE)) . '</div>';
        $variables['logo'] = $pic;

        $details = '<ul class="list-unstyled teaser-yoga-info">';
        $details .= $nw->field_yoga_classes->value() ? '<li>' . l('<i class="material-icons">schedule</i> ' . sizeof($nw->field_yoga_classes->value()) . ' ' . format_plural(sizeof($nw->field_yoga_classes->value()), t('Class'), t('Classes')), 'node/' . $nw->getIdentifier(), array('html' => TRUE)) . '</li>' : FALSE;

        $details .= $nw->field_yoga_teachers->value() ? '<li>' . l('<i class="material-icons">school</i> ' . sizeof($nw->field_yoga_teachers->value()) . ' ' . format_plural(sizeof($nw->field_yoga_teachers->value()), t('Teacher'), t('Teachers')), 'node/' . $nw->getIdentifier(), array('html' => TRUE)) . '</li>' : FALSE;

        $details .= $nw->field_yoga_event_list->value() ? '<li>' . l('<i class="material-icons">event_available</i> ' . sizeof($nw->field_yoga_event_list->value()) . ' ' . format_plural(sizeof($nw->field_yoga_event_list->value()), t('Event'), t('Events')), 'node/' . $nw->getIdentifier(), array('html' => TRUE)) . '</li>' : FALSE;

        $details .= $nw->author->field_my_posts->value() ? '<li>' . l('<i class="material-icons">rss_feed</i> ' . sizeof($nw->author->field_my_posts->value()) . ' ' . format_plural(sizeof($nw->author->field_my_posts->value()), t('Post'), t('Posts')), 'node/' . $nw->getIdentifier(), array('html' => TRUE)) . '</li>' : FALSE;
        $details .= '</ul>';
        $variables['details'] = $details;
        $variables['view_link'] = l('view listing <i class="material-icons">trending_flat</i>', 'node/' . $nw->getIdentifier(), array('html' => TRUE, 'attributes' => array('class' => array('a-link link-go'))));
      }
    }
  }

}

// Helper function for social link etc - if there's no http on a link, add it.
function add_http($url) {
  if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
    $url = "http://" . $url;
  }
  return $url;
}

/**
 * Implements hook_preprocess_page()
 */
function yogafind_preprocess_page(&$variables) {
  global $user;

  $uw = entity_metadata_wrapper('user', $user);
//
//  dpm(current_path());
//  dpm(drupal_get_path_alias());

  // Redirect non users from edit article page
  if (strpos(current_path(), 'post') !== FALSE && is_numeric(arg(1)) && arg(2) == 'edit') {
    $nw = entity_metadata_wrapper('node', arg(1));
    if ($nw->author->getIdentifier() != $uw->getIdentifier()) {
      drupal_goto('user');
    }
  }

  // Redirect wrong event edit pages to listings and vice versa
  if (strpos(current_path(), 'listing') !== FALSE && is_numeric(arg(1)) && arg(2) == 'edit' || strpos(current_path(), 'event') !== FALSE && is_numeric(arg(1)) && arg(2) == 'edit') {
    $nw = entity_metadata_wrapper('node', arg(1));
    if ($nw->field_yoga_type->value() != 'event') {
      if (strpos(current_path(), 'event') !== FALSE) {
        drupal_goto('listing/' . $nw->getIdentifier() . '/edit');
      }
    }
    else {
      if (strpos(current_path(), 'listing') !== FALSE) {
        drupal_goto('event/' . $nw->getIdentifier() . '/edit');
      }
    }
  }

  // Breadcrumbs for search pages.
  if (strpos(current_path(), 'events/in') !== FALSE || strpos(current_path(), 'classes/in') !== FALSE || strpos(current_path(), 'yoga/in') !== FALSE) {

    // Yoga View breadcrumbs
    $my_breadcrumbs_array[] = l('Home', '/');

    if (strpos(current_path(), 'events/in') !== FALSE) {
      $path = 'events/in/';
      $my_breadcrumbs_array[] = l('Events', 'events');
    }
    elseif (strpos(current_path(), 'classes/in') !== FALSE) {
      $path = 'classes/in/';
      $my_breadcrumbs_array[] = l('Classes', 'classes');
    }
    elseif (strpos(current_path(), 'yoga/in') !== FALSE) {
      $path = 'yoga/in/';
      $my_breadcrumbs_array[] = l('Yoga', 'yoga');
    }

    $term = ucwords(str_replace('-', ' ', arg(2)));
    $search_place = taxonomy_get_term_by_name($term);
    $search_parents = taxonomy_get_parents_all(reset($search_place)->tid);
    if (sizeof($search_parents) == 3) {
      $town = $search_parents[0]->name;
      $county = $search_parents[1]->name;
      $country = $search_parents[2]->name;
    }
    elseif (sizeof($search_parents) == 2) {
      $town = FALSE;
      $county = $search_parents[0]->name;
      $country = $search_parents[1]->name;
    }
    else {
      $town = FALSE;
      $county = FALSE;
      $country = $search_parents[0]->name;
    }

    if ($country) {
      $my_breadcrumbs_array[] = l($country, $path . strtolower(str_replace(' ', '-', $country)));
    }

    if ($county) {
      $my_breadcrumbs_array[] = l($county, $path . strtolower(str_replace(' ', '-', $county)));
    }

    if ($town) {
      $my_breadcrumbs_array[] = l($town, $path . strtolower(str_replace(' ', '-', $town)));
    }
    drupal_set_breadcrumb($my_breadcrumbs_array);
  }

  if (strpos(current_path(), 'class/') !== FALSE) {
    if (is_numeric(arg(2))) {
      if ($uw->field_my_listings->value()) {
        drupal_goto('node/' . $uw->field_my_listings->value()[0]->nid);
      }
      else {
        drupal_goto('user');
      }
    }
  }

  // Save the first name part.
  if (!$uw->field_first_name->value()) {
    if ($uw->field_my_name->value()) {
      $fname = explode(' ', $uw->field_my_name->value());
      $uw->field_first_name->set($fname[0]);
      $uw->save();
    }
  }

  // Save the whole my name part.
  if ($uw->field_first_name->value()) {
    $update_name = $uw->field_first_name->value();
    if ($uw->field_surname->value()) {
      $update_name .= ' ' . $uw->field_surname->value();
      $uw->field_my_name->set($update_name);
      $uw->save();
    }
  }

  $variables['home_nav'] = $user->uid == 0 ? theme('home_nav') : FALSE;

  if (drupal_is_front_page()) {
    drupal_add_css('https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.4.0/animate.min.css', array('type' => 'external'));
    unset($variables['page']['content']);
//    $variables['logo'] = drupal_get_path('theme', 'models') . '/' . 'white-logo.png';
    if (isset($_COOKIE['Drupal_visitor_not_verified_logoff'])) {
      if ($_COOKIE['Drupal_visitor_not_verified_logoff'] != 0) {
        // drupal_set_message(t('Oops - it looks like you haven\'t verified your account yet! Please check your email for the verification link - or request a new password'), 'status', FALSE);

        $logged_out_user = user_load($_COOKIE['Drupal_visitor_not_verified_logoff']);
        if (in_array('unauthenticated user', $logged_out_user->roles)) {
          drupal_set_message('Oops - it looks like you haven\'t verified your account yet! Please check your email for the verification link - or ' . l(t('resend validation e-mail'), 'revalidate-email/' . $_COOKIE['Drupal_visitor_not_verified_logoff']));
          // user_cookie_save(array('not_verified.logoff' => 0));
        }
        else {
          user_cookie_delete('not_verified.logoff');
        }
      }
    }
  }

  // Bounce non admin onto personal info instead of user/edit.
  if (!in_array('hbm_admin', $user->roles) || $user->uid != 1) {
//    unset($variables['tabs']);

    if (strrpos(current_path(), 'user/' . $user->uid . '/edit') !== FALSE) {
      drupal_goto('user/personal-information/settings');
    }
  }

  // $msg_count = privatemsg_unread_count($uw->value());
  // dpm( $msg_count );

  $variables['social'] = theme('social_nav');
  $variables['custom_nav'] = $user->uid != 0 ? theme('custom_nav') : FALSE;
  $variables['title_search_class'] = FALSE;

  $search_menu = theme('search_menu');
  $variables['search_menu'] = $search_menu;

  if (!$uw->field_my_tcs->value() && $user->uid != 0) {
    $tc_msg = t('Welcome to Hair & Beauty Models! To get started, please make sure you accept the') . ' ' . l('terms and conditions', 'terms') . ' ' . '<strong>' . l('here', 'user/personal-information/settings', array('fragment' => 'edit-field-my-tcs')) . '</strong>.';
    drupal_set_message($tc_msg, 'warning', FALSE);
  }

  if (strrpos(current_path(), 'search') !== FALSE) {
    $variables['no_footer'] = TRUE;
    unset($variables['tabs']);
  }

  if ((arg(0) == 'user' && is_numeric(arg(1)) && !arg(2) || strrpos(current_path(), '/settings') !== FALSE) && strpos(current_path(), 'user/reset') === FALSE) {
    $variables['content_column_class'] = ' class="col-sm-pull-3 col-sm-9"';
  }

  if ($user->uid == 0) {
    unset($variables['tabs']);
    if (current_path() == 'user') {
      drupal_goto('user/login');
    }
    if (current_path() == 'user/login') {
      drupal_set_title('Sign in');
    }
    if (current_path() == 'user/register') {
      drupal_set_title('Sign up');
    }
    if (current_path() == 'user/password') {
      drupal_set_title('Request new password');
    }
  }

  // Tweenmax
//  drupal_add_js('http://cdnjs.cloudflare.com/ajax/libs/gsap/1.18.4/TweenMax.min.js', array('type' => 'external'));

  // drupal_add_js('https://cdnjs.cloudflare.com/ajax/libs/skrollr/0.6.30/skrollr.min.js', array('type' => 'external'));
  // drupal_add_js('https://cdnjs.cloudflare.com/ajax/libs/jquery-noty/2.3.8/packaged/jquery.noty.packaged.min.js', array('type' => 'external'));

//  drupal_add_js('https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.12.0/moment.min.js', 'external');
  drupal_add_js('https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.5/ScrollMagic.min.js', 'external');
//  drupal_add_js('https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.5/plugins/debug.addIndicators.min.js', 'external');
//  drupal_add_js(libraries_get_path('raty-fa-0.1.1') . '/' . 'lib/jquery.raty-fa.js');

  // dpm(current_path());
  // dpm_once($_SERVER['REQUEST_URI']);

  // Set navbar to fixed.
  // navbar navbar-default navbar-fixed-top
  $variables['navbar_classes_array'][1] = 'container-fluid';
//  $variables['navbar_classes_array'][2] = 'navbar-fixed-top';

  if (strrpos(current_path(), 'search') !== FALSE && strrpos(current_path(), 'ts/') === FALSE && strrpos(current_path(), 'messages/') === FALSE ||
    strpos(current_path(), 'previous-jobs') !== FALSE ||
    strpos(current_path(), 'my-jobs') !== FALSE ||
    strpos(current_path(), 'watchlist') !== FALSE ||
    strpos(current_path(), 'job-requests') !== FALSE
  ) {
//    drupal_add_js('https://npmcdn.com/imagesloaded@4.1/imagesloaded.pkgd.min.js', 'external');
//    drupal_add_js('https://npmcdn.com/masonry-layout@4.0.0/dist/masonry.pkgd.min.js', 'external');
    drupal_add_js(drupal_get_path('theme', 'models') . '/' . 'js/hbm_user_jobs.js');
  }

  if (strrpos(current_path(), 'search') !== FALSE && strrpos(current_path(), 'ts/') === FALSE && strrpos(current_path(), 'messages/') === FALSE) {
    drupal_add_js(drupal_get_path('theme', 'models') . '/' . 'js/hbm_search.js');
    // drupal_add_js('https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.5/plugins/debug.addIndicators.min.js', 'external');
    $variables['container_class'] = 'container-fluid';
    $variables['title_search_class'] = 'event-page';
    $variables['content_column_class'] = ' class="col-sm-12 event-page"';
    $variables['hb_header_class'] = '';

    $slick_block = block_load('search_api_sorts', 'search-sorts');
    $block = _block_get_renderable_array(_block_render_blocks(array($slick_block)));
    $variables['filter_blocks'] = drupal_render($block);
  }


  // Alllll stuffs for the author pic and top nav stuff.
  if ((strpos(current_path(), 'node') !== FALSE) ||
    (strpos(current_path(), 'studio/') !== FALSE && strpos(current_path(), '/teachers') !== FALSE) ||
    (strpos(current_path(), 'studio/') !== FALSE && strpos(current_path(), '/posts') !== FALSE) ||
    (strpos(current_path(), '/timetable') !== FALSE) ||
    (strpos(current_path(), 'studio/') !== FALSE && strpos(current_path(), '/events') !== FALSE)
  ) {
    $nw = tweaks_get_alias_wrapper();

    if ($nw->getBundle() == 'yoga' || $nw->getBundle() == 'article') {
      $variables['content_column_class'] = ' class="col-sm-pull-3 col-sm-9"';
    }
    if ($nw->getBundle() == 'yoga') {

      // Yoga View breadcrumbs
      $my_breadcrumbs_array[] = l('Home', '/');
      $my_breadcrumbs_array[] = l('Everywhere', 'yoga');
//      $my_breadcrumbs_array[] = l('UK', 'in');

      $url = 'yoga/in';
      if ($nw->field_yoga_lt_country->value()) {
        $my_breadcrumbs_array[] = l($nw->field_yoga_lt_country->label(), $url . '/' . strtolower(str_replace(' ', '-', $nw->field_yoga_lt_country->label())));
      }
      if ($nw->field_yoga_lt_county->value()) {
        $my_breadcrumbs_array[] = l($nw->field_yoga_lt_county->label(), $url . '/' . strtolower(str_replace(' ', '-', $nw->field_yoga_lt_county->label())));
      }
      if ($nw->field_yoga_lt_town->value()) {
        $my_breadcrumbs_array[] = l($nw->field_yoga_lt_town->label(), $url . '/' . strtolower(str_replace(' ', '-', $nw->field_yoga_lt_town->label())));
      }

      drupal_set_breadcrumb($my_breadcrumbs_array);

      $variables['cover_pic'] = $nw->field_yoga_cover_picture->value() ? 'style="background:url(' . image_style_url('coverpic', $nw->field_yoga_cover_picture->value()['uri']) . ')"' : FALSE;

      drupal_add_js(libraries_get_path('slick') . '/' . 'slick/slick.min.js');
      drupal_add_css(libraries_get_path('slick') . '/' . 'slick/slick.css');
      drupal_add_css(libraries_get_path('slick') . '/' . 'slick/slick-theme.css');
      drupal_add_js(drupal_get_path('module', 'models_nav') . '/js/models_nav.js');


      $variables['hb_header_class'] = 'header-title';
      if ($nw->field_yoga_logo->value()) {
        $pic = '<div class="my-image">' . theme('image_style', array(
            'style_name' => 'profile',
            'path' => $nw->field_yoga_logo->value()['uri'],
            'attributes' => array('class' => array(''))
          )) . '</div>';
      }
      else {
        $pic = '<div class="my-image">' . theme('image_style', array(
            'style_name' => 'profile',
            'path' => 'public://pictures/picture-default.png',
            'attributes' => array('class' => array(''))
          )) . '</div>';
      }
      $variables['the_pic'] = l($pic, 'user/' . $nw->author->getIdentifier(), array(
        'html' => TRUE,
        'attributes' => array('class' => array('author-pic'))
      ));

      $contact_teacher = l('<i class="fa fa-envelope"></i>' . ' ' . t('Contact Teacher'), '#', array(
        'html' => TRUE,
        'attributes' => array(
          'data-toggle' => array('modal'),
          'data-target' => array('#job-publish-form-popup'),
          'class' => array('btn btn-default')
        )
      ));

      $contact_number = l('<i class="fa fa-phone"></i> ' . $nw->field_yoga_number->value(), 'tel:' . $nw->field_yoga_number->value(), array(
        'html' => TRUE,
        'attributes' => array(
//          'data-toggle' => array('modal'),
//          'data-target' => array('#job-publish-form-popup'),
          'class' => array('btn btn-purple')
        )
      ));

      $links = array();
      if ($link = $nw->field_my_twitter->value()) {

        $links[] = l('<span class="tw">Twitter</span>', add_http($link['url']), array('html' => TRUE));
      }
      if ($link = $nw->field_my_fb->value()) {
        $links[] = l('<span class="fb">Facebook</span>', add_http($link['url']), array('html' => TRUE));
      }
      if ($link = $nw->field_my_instagram->value()) {
        $links[] = l('<span class="insta">Instagram</span>', add_http($link['url']), array('html' => TRUE));
      }

      $vars = array(
        'items' => $links,
        'type' => 'ul',
        'title' => 'Social Links',
        'attributes' => array(
          'class' => 'list-inline list-unstyled yoga-social',
        ),
      );
      $social_links = theme_item_list($vars);

      $job_details = '<div class="yoga-intro">';
      $job_details .= $nw->field_yoga_introduction->value() ? '<span>' . truncate_utf8($nw->field_yoga_introduction->value(), 150, $wordsafe = FALSE, $add_ellipsis = TRUE, $min_wordsafe_length = 1) . '</span></br>' : '';
      $job_details .= $nw->field_yoga_mail->value() ? '<span>' . $contact_teacher . '</span>' : '';
      $job_details .= $nw->field_yoga_number->value() ? '<span>' . $contact_number . '</span>' : '';
      $job_details .= $social_links;
      $job_details .= '</div>';

      $variables['job_details'] = $job_details;

      // Client request accept / remove
      $client_request_form = drupal_get_form('models_forms_confirm_clients_form');
      $modal_options = array(
        'attributes' => array(
          'id' => 'job-publish-form-popup',
          'class' => array('job-publish-form-popup-modal')
        ),
        'heading' => t('Confirm Clients'),
        'body' => drupal_render($client_request_form),
      );
      $variables['client_request_confirm_form'] = theme('bootstrap_modal', $modal_options);

      if ($nw->field_yoga_type->value() == 'event') {
        $variables['show_bg'] = FALSE;
        $variables['the_pic'] = FALSE;

        $job_details = '<p class="event-intro">';
        $job_details .= '<span class="event-type">' . $nw->field_yoga_event_type->value() . '</span> <span class="text-muted">in </span>';

        $located = grab_location_blurb($nw);

        $job_details .= '<span class="event-where">' . implode(', ', $located) . '</span> <span class="text-muted">organised by </span>';
        $job_details .= l($nw->author->field_my_listings[0]->label(), 'node/' . $nw->author->field_my_listings[0]->getIdentifier());
        $job_details .= '</p>';

        $variables['job_details'] = $job_details;
        $variables['my_nav'] = $nw->author->getIdentifier() == $uw->getIdentifier() ? theme('my_nav') : FALSE;
      }
      else {
        $variables['show_bg'] = TRUE;
        $variables['my_nav'] = theme('my_nav');
      }
    }

    if ($nw->getBundle() == 'article') {
      $variables['my_nav'] = $nw->author->getIdentifier() == $uw->getIdentifier() ? theme('my_nav') : FALSE;
      $params = drupal_get_query_parameters();
      if (!empty($params['publish'])) {
        if ($params['publish'] == 1) {
          $nw->status->set($params['publish']);
          $nw->save();
          drupal_goto('node/' . arg(1));
        }
      }
    }
  }

  // Ignore below if user/reset is in the path.
  if (strpos(current_path(), 'user/reset') === FALSE) {

    // Build up the users home page top bar..
    if (arg(0) == 'user' && is_numeric(arg(1)) && !arg(2) ||
      strpos(current_path(), 'previous-jobs') !== FALSE ||
      strpos(current_path(), 'user/') !== FALSE && strpos(current_path(), '/feedback') !== FALSE ||
      strpos(current_path(), 'user/') !== FALSE && strpos(current_path(), '/photos') !== FALSE ||
      strpos(current_path(), 'my-jobs') !== FALSE ||
      strpos(current_path(), 'watchlist') !== FALSE ||
      strpos(current_path(), 'job-requests') !== FALSE ||
      (arg(0) == 'user' && !is_numeric(arg(1)) && arg(2))
    ) {

      // Bump anons to the login page when looking at users..
      if ($user->uid == 0) {
        drupal_goto('user/login');
      }

      if (in_array('unauthenticated user', $user->roles)) {
        require_once(drupal_get_path('module', 'user') . '/user.pages.inc');
        user_logout();
        // drupal_set_message(t('Oops - it looks like you haven\'t verified your account yet! Please check your email for the verification link - or request a new password'), 'status', FALSE);
        // drupal_goto('search');
      }

      // Delete the 'just registered' set_variable.
      if (variable_get('just_registered_' . $user->uid)) {
        variable_del('just_registered_' . $user->uid);
      }

      if (is_numeric(arg(1))) {
        if ($user->uid == arg(1)) {
          $greeting = t('Welcome back'); // If cookie set?
          $greeting = t('Namaste') . ', ';
          drupal_set_title($greeting . $uw->field_first_name->value());
          $pic = tweaks_get_profile_picture($uw->value());
          $the_pic = tweaks_get_profile_url($pic, $uw->getIdentifier());
//          $stars = $uw->field_my_overall_rating->value() ? $uw->field_my_overall_rating->value() : 0;
          $job_details = tweaks_get_profile_intro($uw);
          $author_feedback_amount = tweaks_get_feedback_amount($uw);
        }
        else {
          $person = entity_metadata_wrapper('user', arg(1));
          drupal_set_title($person->field_my_name->value());
          $pic = tweaks_get_profile_picture($person->value());
          $the_pic = tweaks_get_profile_url($pic, $person->getIdentifier());
          $stars = $person->field_my_overall_rating->value() ? $person->field_my_overall_rating->value() : 0;
          $job_details = tweaks_get_profile_intro($person);
          $author_feedback_amount = tweaks_get_feedback_amount($person);
        }
      }
      else {
        $pic = tweaks_get_profile_picture($uw->value());
        $the_pic = tweaks_get_profile_url($pic, $uw->getIdentifier());
        $stars = $uw->field_my_overall_rating->value() ? $uw->field_my_overall_rating->value() : 0;
        $job_details = tweaks_get_profile_intro($uw);
        $author_feedback_amount = tweaks_get_feedback_amount($uw);
      }

      $variables['hb_header_class'] = 'header-title pull-left';
      $variables['the_pic'] = $the_pic;
//      $variables['author_rating'] = '<div class="hb-rating raty raty-readonly" data-rating="' . $stars . '"></div>';
      $variables['author_feedback_amount'] = $author_feedback_amount;
      $variables['job_details'] = $job_details;

      // Initiate custom job navigation if logged in user = author.
      if (arg(1) == $uw->getIdentifier() ||
        strpos(current_path(), 'previous-jobs') !== FALSE ||
        strpos(current_path(), 'my-jobs') !== FALSE ||
        strpos(current_path(), 'user/') !== FALSE && strpos(current_path(), '/photos') !== FALSE ||
        strpos(current_path(), 'job-requests') !== FALSE ||
        strpos(current_path(), 'watchlist') !== FALSE ||
        (arg(0) == 'user' && !is_numeric(arg(1)) && arg(2))
      ) {
        $variables['my_nav'] = theme('my_nav', array('user_nav' => $uw->getIdentifier()));
      }
      else {
        $variables['my_nav'] = theme('my_nav', array(
          'user_nav' => $uw->getIdentifier(),
          'someone_else' => TRUE
        ));
      }
    }
  }

  if (strpos(current_path(), 'job/') !== FALSE && strpos(current_path(), '/photos') !== FALSE || strpos(current_path(), 'user/photos') !== FALSE) {
    drupal_add_css(libraries_get_path('dropzone') . '/' . 'dist/min/basic.min.css');
    drupal_add_css(libraries_get_path('dropzone') . '/' . 'dist/min/dropzone.min.css');
    drupal_add_js(libraries_get_path('dropzone') . '/' . 'dist/min/dropzone.min.js');
  }


  // ALL SEARCHER RESULTS PAGE STUFFS >>> create the tertiary menu for classes/in days.
  if (strpos(current_path(), 'classes/in/') !== FALSE) {
    $variables['my_nav'] = theme('my_nav', array('classes_searcher' => TRUE));
  }
  if (strpos(current_path(), 'classes/in/') !== FALSE || strpos(current_path(), 'events/in/') !== FALSE || strpos(current_path(), 'yoga/in/') !== FALSE) {
    $variables['content_column_class'] = ' class="col-sm-pull-3 col-sm-9"';
  }

}

/**
 * Implements hook_preprocess_html().
 */
function yogafind_preprocess_html(&$variables) {
  if ((strpos(current_path(), 'node') !== FALSE) ||
    (strpos(current_path(), 'job/') !== FALSE && strpos(current_path(), '/clients') !== FALSE)
  ) {
    $variables['classes_array'][] = 'event-mode';
  }
}

/**
 * Implements hook_preprocess_region().
 */
function yogafind_preprocess_region(&$variables) {
  // dpm($variables);
  if ($variables['region'] == 'content') {
    // if (arg(0) == 'user') {
    //   $variables['classes_array'][] = 'row';
    // }
  }
}

/**
 * Implements hook_preprocess_entity.
 */
function yogafind_preprocess_entity(&$variables) {
  if ($variables['entity_type'] == 'class') {
    $ew = entity_metadata_wrapper('class', $variables['elements']['#entity']->id);
    $nw = entity_metadata_wrapper('node', $ew->uid->field_my_listings->value()[0]->nid);

    // DO SOME CACHE STUFF? here..

    $uri = $nw->field_yoga_logo->value() ? $nw->field_yoga_logo->value()['uri'] : $nw->author->value()->picture->uri;
    $pic = '<div class="event-logo">' . l(theme('image_style', array(
        'style_name' => 'profile',
        'path' => $uri,
        'attributes' => array('class' => array('img-responsive'))
      )), 'node/' . $nw->getIdentifier(), array('html' => TRUE)) . '</div>';

    $styles = '';
    if ($ew->getBundle() != 'teacher' && $ew->field_yoga_style->value()) {
      foreach ($ew->field_yoga_style->getIterator() AS $k => $style) {
        $styles .= $style->label() . ', ';
      }

    $class_array = array(
      'eid' => $ew->getIdentifier(),
      'dow' => $ew->field_yc_dow->value(),
      'times' => $ew->field_yc_start_time->value()['value_formatted'] . ' - ' . $ew->field_yc_start_time->value()['value2_formatted'],
      'desc' => $ew->field_yc_desc->value(),
      'pic' => $pic,
      'style' => rtrim($styles, ', '),
      'teacher' => $ew->field_yc_teacher->value() ? $ew->field_yc_teacher->label() : '-',
      'duration' => timefield_time_to_duration($ew->field_yc_start_time->value()['value'], $ew->field_yc_start_time->value()['value2'], 'time'),
      'listing' => l($nw->label(), 'node/' . $nw->getIdentifier(), array('attributes' => array('class' => array('a-link')))),
    );

    $class_data = '<div class="day-wrapper">';
//    $editable = $make_edits === TRUE ? '<span class="edit-link">' . l(t('edit'), 'classes/' . $v['eid'] . '/edit') . '</span>' : FALSE;
    $editable = FALSE;
    $class_data .= '<div class="class-' . $ew->getIdentifier() . ' yoga-class">';
    $class_data .= '<div class="options op-time">' . $editable . ' ' . $class_array['times'] . '</div>';
    $class_data .= '<div class="options op-style">' . $class_array['style'] . '</div>';
    $class_data .= '<div class="options op-duration">' . $class_array['duration'] . 'h</div>';
    $class_data .= '<div class="options op-teacher">' . $class_array['teacher'] . '</div>';
    $class_data .= '<div class="options op-listing">' . $class_array['listing'] . '</div>';
    $class_data .= '<div class="yoga-class-extra">';
    $class_data .= '<div class="yoga-class-img">' . $class_array['pic'] . '</div>';
    $class_data .= '<div class="yoga-class-desc">';
    $class_data .= '<div class="close-btn"><i class="material-icons">close</i></div>';
    $class_data .= '<h4>' . $class_array['style'] . '</h4>';
    $class_data .= '<p><strong>' . $class_array['times'] . '</strong> with <strong>' . $class_array['teacher'] . '</strong></p>';
    $class_data .= '<p>' . $class_array['desc'] . '</p>';
    $class_data .= '</div>';
    $class_data .= '</div>';
    $class_data .= '</div>';
    $class_data .= '</div>';
    $variables['class_data'] = $class_data;
    }
  }

  if ($variables['elements']['#bundle'] == 'teacher') {
    global $user;
    $url_name = explode('/', $variables['url']);
    $nw = tweaks_get_alias_wrapper();
    $path = drupal_get_path_alias('node/' . $nw->getIdentifier());
    if ($variables['view_mode'] == 'teaser') {
//      $variables['individual'] = TRUE;
    }
    if ($variables['view_mode'] == 'token') {
      $variables['view_more'] = l(t('view'), $path . '/teachers/' . $url_name[3], array('attributes' => array('class' => array('btn btn-purple btn-block btn-xs'))));
      $variables['edit_link'] = $user->uid == $nw->author->getIdentifier() ? l(t('edit'), 'teacher/' . $variables['elements']['#entity']->id . '/edit', array('attributes' => array('class' => array('a-link')))) : FALSE;
    }
  }
}

function yogafind_preprocess_views_view_fields(&$vars) {
  if ($vars['view']->name == 'jobs_rhs') {
    if ($vars['view']->current_display == 'block') {
//      $nw = entity_metadata_wrapper('node', arg(1));
//      $vars['fields']['field_hb_price']->content = $nw->field_hb_price->value() == 0 ? '<p><i class="fa fa-dollar"></i> FREE</p>' : '<p><i class="fa fa-dollar"></i> ' . $nw->field_hb_price->value() . '</p>';
    }
  }
}

function yogafind_preprocess_views_view(&$vars) {
  // if ($vars['name'] == 'related_jobs_by_terms') {
  //   $vars['view']->human_name = 'waaa';
  // }


  if ($vars['name'] == 'jobs_rhs') {
    if ($vars['display_id'] == 'block') {
      global $user;
      $uw = entity_metadata_wrapper('user', $user->uid);
      $nw = tweaks_get_alias_wrapper();
      $job_publish = l('<i class="fa fa-envelope"></i>' . ' ' . t('Contact Teacher'), '#', array(
        'html' => TRUE,
        'attributes' => array(
          'data-toggle' => array('modal'),
          'data-target' => array('#job-publish-form-popup'),
          'class' => array('btn btn-success btn-block')
        )
      ));

      $vars['job_publish_button'] = '<div class="hb-rhs-job-button">' . $job_publish . '</div>';
    }
    if ($vars['display_id'] == 'block_4') {
//      dpm($vars);
//      global $user;
//      $uw = entity_metadata_wrapper('user', $user->uid);
//      $nw = tweaks_get_alias_wrapper();
//      $job_publish = l('<i class="fa fa-envelope"></i>' . ' ' . t('Contact Teacher'), '#', array(
//        'html' => TRUE,
//        'attributes' => array(
//          'data-toggle' => array('modal'),
//          'data-target' => array('#job-publish-form-popup'),
//          'class' => array('btn btn-success btn-block')
//        )
//      ));
//      $vars['job_publish_button'] = '<div class="hb-rhs-job-button">' . $job_publish . '</div>';
    }
  }
}

