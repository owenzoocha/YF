<?php // print $social; ?>
<header id="navbar" role="banner" class="<?php print $navbar_classes; ?>">
  <div class="container">
    <div class="navbar-header">
      <?php if ($logo): ?>
        <a class="logo navbar-btn pull-left" href="<?php print $front_page; ?>"
           title="<?php print t('Home'); ?>">
          <img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>"/>
        </a>
      <?php endif; ?>

      <?php if (!empty($site_name)): ?>
        <a class="name navbar-brand" href="<?php print $front_page; ?>"
           title="<?php print t('Home'); ?>"><?php print $site_name; ?></a>
      <?php endif; ?>

      <?php if (!empty($primary_nav) || !empty($secondary_nav) || !empty($home_nav) || !empty($page['navigation'])): ?>
        <button type="button" class="navbar-toggle" data-toggle="collapse"
                data-target=".navbar-collapse">
          <span class="sr-only"><?php print t('Toggle navigation'); ?></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
      <?php endif; ?>
    </div>

    <?php if (!empty($primary_nav) || !empty($secondary_nav) || !empty($home_nav) || !empty($page['navigation'])): ?>
      <div class="navbar-collapse collapse">
        <nav role="navigation">
          <?php if (!empty($primary_nav)): ?>
            <?php print render($primary_nav); ?>
          <?php endif; ?>
          <?php if (!empty($secondary_nav)): ?>
            <?php // print render($secondary_nav); ?>
          <?php endif; ?>
          <?php if (!empty($search_menu)): ?>
            <?php // print $search_menu; ?>
          <?php endif; ?>
          <?php //if (!empty($custom_nav)): ?>
          <?php print $custom_nav; ?>
          <?php //endif; ?>
          <?php if (!empty($home_nav)): ?>
            <?php print $home_nav; ?>
          <?php endif; ?>
          <?php if (!empty($page['navigation'])): ?>
            <?php print render($page['navigation']); ?>
          <?php endif; ?>
        </nav>
      </div>
    <?php endif; ?>
  </div>
</header>
<main id="main" role="main">
  <div id="hero">
    <div class="hero-content container">
      <div class="hero left animated fadeInUp">
        <h1>Find yoga listings, events and classes all over the UK.</h1>
        <h2>Looking to join? Get started <a href="/getting-started" class="a-link link-go">now <i
              class="material-icons">trending_flat</i></a></h2>
      </div>
      <div class="hero right">
        <?php
        //          $slick_block = block_load('webform', 'client-block-166');
        //          $block = _block_get_renderable_array(_block_render_blocks(array($slick_block)));
        //          print drupal_render($block);
        $slick_block = block_load('models_searcher', 'main_searcher');
        $block = _block_get_renderable_array(_block_render_blocks(array($slick_block)));
        print drupal_render($block);
        ?>
      </div>
    </div>
  </div>

  <?php print $messages; ?>

  <div id="yf-sign-up">
    <div class="container">
      Looking to list your yoga classes, event or studio? Join ### others and <a
        href="/getting-started" class="a-link link-go">get started now <i
          class="material-icons">trending_flat</i></a>
    </div>
  </div>

<!--  <div id="yf-sponsors">-->
<!--    <div class="container">-->
<!--      <span>YogaFind Sponsors</span>-->
<!--    </div>-->
<!--  </div>-->

  <div id="yf-events" class="container">
    <div class="row">
      <div class="col-sm-8">
        <h3 class="hd-purple">Upcoming Events</h3>
        <h4>On your mat, get set, yoga!</h4>
        <a href="/events" class="a-link link-go">View more events <i
            class="material-icons">trending_flat</i></a>
        <?php
        $slick_block = block_load('views', 'yoga_event_lists-block_2');
        $block = _block_get_renderable_array(_block_render_blocks(array($slick_block)));
        print drupal_render($block);
        ?>
      </div>
      <div class="col-sm-4">
        <h3 class="hd-purple">Latest Listings</h3>
        <h4>Our latest studios & instructors</h4>
        <a href="/yoga" class="a-link link-go">View more listings <i
            class="material-icons">trending_flat</i></a>
        <?php
        $slick_block = block_load('views', 'yoga_searcher-block_2');
        $block = _block_get_renderable_array(_block_render_blocks(array($slick_block)));
        print drupal_render($block);
        ?>
      </div>
    </div>
  </div>

  <!--  <div id="yf-subscribe">-->
  <!--    <div class="container">-->
  <!--      <h3 class="hd-purple">Keep up to date with YogaFind</h3>-->
  <!---->
  <!--      --><?php
  //      //      $slick_block = block_load('webform', 'client-block-132');
  //      //      $block = _block_get_renderable_array(_block_render_blocks(array($slick_block)));
  //      //      print drupal_render($block);
  //      ?>
  <!--    </div>-->
  <!--  </div>-->

  <div id="yf-events">
    <div class="container">
      <div class="container">

        <h3 class="hd-purple">YogaFind Posts</h3>
        <h4>Latest yoga posts</h4>
        <a href="/posts" class="a-link link-go">View more posts <i
            class="material-icons">trending_flat</i></a>
        <div class="row">

          <?php
          $slick_block = block_load('views', 'user_blog_posts-block_2');
          $block = _block_get_renderable_array(_block_render_blocks(array($slick_block)));
          print drupal_render($block);
          ?>
        </div>
      </div>
    </div>
  </div>

  <!--  <div id="yf-forums" class="container">-->
  <!--    <h3 class="text-center hd-purple">YogaFind Forums</h3>-->
  <!--    <h4>Join the Discussion</h4>-->
  <!--    --><?php
  ////    $slick_block = block_load('views', '2b3038a0dd4683e6f418c3bd54ec2f22');
  ////    $block = _block_get_renderable_array(_block_render_blocks(array($slick_block)));
  ////    print drupal_render($block);
  //    ?>
  <!--  </div>-->
</main>

<div class="main-container <?php print $container_class; ?>">
  <div class="row">
    <section<?php print $content_column_class; ?>>
      <?php if (!empty($page['highlighted'])): ?>
        <div
          class="highlighted jumbotron"><?php print render($page['highlighted']); ?></div>
      <?php endif; ?>
      <?php if (!empty($page['help'])): ?>
        <?php print render($page['help']); ?>
      <?php endif; ?>
      <?php if (!empty($action_links)): ?>
        <ul class="action-links"><?php print render($action_links); ?></ul>
      <?php endif; ?>
      <?php if (!empty($page['search_top'])): ?>
        <?php print render($page['search_top']); ?>
      <?php endif; ?>
      <?php print render($page['content']); ?>
      <?php if (isset($client_request_confirm_form)) : print $client_request_confirm_form; endif; ?>
    </section>
  </div>
</div>


<?php if (!empty($page['footer'])): ?>
  <div class="footer-surround">
    <?php if (!isset($no_footer)): ?>
      <footer class="footer container-fluid">
        <?php print render($page['footer']); ?>
      </footer>
    <?php endif; ?>
    <footer class="footer-cr container-fluid">
      <span
        class="cr"><?php print '&copy; ' . t(':date yogafind.co.uk all rights reserved.', array(':date' => date('Y', strtotime('now')))); ?></span>
    </footer>
  </div>
<?php endif; ?>

