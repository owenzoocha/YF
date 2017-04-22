
<div class="event-teaser clearfix <?php print 'live-' . $status; ?>">
  <?php print $logo; ?>
  <div class="event-info">
    <?php if ($status == 0): print '<span class="to-edit">preview mode</span>'; endif; ?>
    <h3><?php print $title; ?></h3>
    <p class="event-intro">by <?php print $author_name . ' ' . $post_date; ?></p>
    <div class="event-desc"><?php print $description; ?></div>
    <?php // print $listing_link; ?>
  </div>
</div>
