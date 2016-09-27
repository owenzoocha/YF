<div class="organiser-details">
  <div class="organiser-logo">
    <?php print $logo; ?>
  </div>
  <div class="organiser-info">
    <h3><?php print $post_type; ?></h3>
    <p><?php print $parent_title; ?></p>
    <p><?php print $location; ?></p>
  </div>
</div>

<?php if (!empty($details)): ?>
<div class="organiser-list">
  <?php print $details; ?>
</div>
<?php endif; ?>
<?php print $organiser; ?>