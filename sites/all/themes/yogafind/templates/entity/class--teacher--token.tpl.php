<div class="teacher-info">
  <?php print drupal_render($content['field_teach_pic']); ?>
  <h3><?php print $title; ?></h3>
  <div class="teacher-view-more">
    <?php print $view_more; ?>
  </div>
</div>
<?php if (!empty($edit_link)): print $edit_link; endif; ?>