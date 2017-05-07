<h2><i class="fa fa-instagram"></i> Instagram</h2>
<?php if (!isset($instagram_get_started)): ?>
<div class="instafeed-wrapper">
  <div id="instafeed"></div>
</div>
<?php else: ?>
  <div class="nothing-here-yet">
    <?php print $instagram_get_started; ?>
  </div>
<?php endif; ?>