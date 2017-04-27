<div class="row">
  <h2>Your Information</h2>
  <div class="col-sm-2">
    <label class="control-label" for="edit-field-my-name-und-0-value">Full Name: </label>
  </div>
  <div class="col-sm-10">
    <?php print render($form['field_my_name']); ?>
  </div>
</div>
<div class="row">
  <div class="col-sm-2">
    <label class="control-label" for="edit-field-my-bio-und-0-value">About Me: </label>
  </div>
  <div class="col-sm-10">
    <?php print render($form['field_my_bio']); ?>
  </div>
</div>

<div class="row">
  <div class="col-sm-12">
    <h2>Profile picture</h2>
  <?php print render($form['picture']); ?>
</div>
</div>

<?php print drupal_render_children($form) ?>
