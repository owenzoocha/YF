<?php print render($form['get_started']); ?>

<!--<h3>1. Your Listing</h3>-->
<!--<div class="row">-->
<!--  <div class="col-sm-12">-->
<!--    <label class="control-label" for="edit-field-yc-dow-und">Day of the Week-->
<!--      <span class="form-required"-->
<!--            title="This field is required.">*</span></label>-->
<!--  </div>-->
<!--  <div class="col-sm-12">-->
<!--    --><?php //print render($form['field_yc_dow']); ?>
<!--  </div>-->
<!--</div>-->
<!--<div class="row">-->
<!--  <div class="col-sm-12">-->
<!--    <label class="control-label" for="edit-field-yoga-style-und">Start / End Time</label>-->
<!--  </div>-->
<!--  <div class="col-sm-12">-->
<!--    --><?php //print render($form['field_yc_start_time']); ?>
<!--  </div>-->
<!--</div>-->

<?php print drupal_render_children($form) ?>
