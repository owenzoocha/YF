<div class="event-teaser clearfix">
  <?php print $logo; ?>
  <div class="event-dates">
    <p><?php print $dates; ?></p>
    <?php if (!empty($event_type)): ?>
      <p><span class="event-type"><?php print $event_type; ?></span></p>
    <?php endif; ?>
    <?php print $price; ?>
  </div>
  <div class="event-info">
    <h3><?php print $title; ?></h3>
    <p class="event-intro"><?php print $location; ?> - organised by <?php print $parent_title; ?></p>
    <div class="event-desc"><?php print $description; ?></div>
  </div>
</div>