<!--<fieldset class="panel panel-default form-wrapper">-->

<!--  <legend class="panel-heading">-->
<!--    <span class="panel-title fieldset-legend">Your Yoga Listing</span>-->
<!--  </legend>-->

<!--  <div class="panel-body">-->
<?php print render($form['get_started']); ?>

<!--<div class="col-sm-12">-->
<h3>1. Your Listing</h3>
<!--</div>-->
<div class="row">
  <div class="col-sm-2">
    <label class="control-label" for="edit-title">Yoga Listing<span
        class="form-required" title="This field is required.">*</span></label>
  </div>
  <div class="col-sm-10">
    <?php print render($form['title']); ?>
  </div>
</div>

<?php //if (strpos(current_path(), 'listing/') !== FALSE && !is_numeric(arg(1))): ?>
<div class="row">
  <div class="col-sm-2">
    <label class="control-label" for="edit-field-yoga-type-und-0">Listing Type</label>
  </div>
  <div class="col-sm-10">
    <?php print render($form['field_yoga_type']); ?>
  </div>
</div>
<?php //endif; ?>

<div class="row">
  <div class="col-sm-2">
    <label class="control-label"
           for="edit-field-yoga-mail-und-0-value">Email</label>
  </div>
  <div class="col-sm-10">
    <?php print render($form['field_yoga_mail']); ?>
  </div>
</div>
<div class="row">
  <div class="col-sm-2">
    <label class="control-label"
           for="edit-field-yoga-mail-und-0-value">Phone</label>
  </div>
  <div class="col-sm-10">
    <?php print render($form['field_yoga_number']); ?>
  </div>
</div>
<div class="row">
  <div class="col-sm-2">
    <label class="control-label"
           for="edit-field-yoga-link-und-0">My Website</label>
  </div>
  <div class="col-sm-10">
    <?php print render($form['field_yoga_link']); ?>
  </div>
</div>
<div class="row">
  <div class="col-sm-2">
    <label class="control-label"
           for="edit-field-my-fb-und-0">Facebook</label>
  </div>
  <div class="col-sm-10">
    <?php print render($form['field_my_fb']); ?>
  </div>
</div>
<div class="row">
  <div class="col-sm-2">
    <label class="control-label"
           for="edit-field-my-twitter-und-0">Twitter</label>
  </div>
  <div class="col-sm-10">
    <?php print render($form['field_my_twitter']); ?>
  </div>
</div>
<div class="row">
  <div class="col-sm-2">
    <label class="control-label"
           for="edit-field-ymy-instagram-und-0">Instagram</label>
  </div>
  <div class="col-sm-10">
    <?php print render($form['field_my_instagram']); ?>
  </div>
</div>

<h3>2. About</h3>
<div class="row">
  <div class="col-sm-12">
    <label class="control-label"
           for="edit-field_yoga_style-und-0-value">Yoga Styles tags</label>
  </div>
  <div class="col-sm-12">
    <?php print render($form['field_yoga_style']); ?>
  </div>
</div>
<div class="row">
  <div class="col-sm-12">
    <label class="control-label"
           for="edit-field-yoga-introduction-und-0-value">Introduction</label>
  </div>
  <div class="col-sm-12">
    <?php print render($form['field_yoga_introduction']); ?>
  </div>
</div>
<div class="row">
  <div class="col-sm-12">
    <label class="control-label"
           for="edit-body-und-0-value">About</label>
  </div>
  <div class="col-sm-12">
    <?php print render($form['body']); ?>
  </div>
</div>

<h3>3. Personalise</h3>
<div class="row">
  <div class="col-sm-2">
    <label class="control-label"
           for="edit-field-yoga-logo-und-0-upload">Logo</label>
  </div>
  <div class="col-sm-10">
    <?php print render($form['field_yoga_logo']); ?>
  </div>
</div>
<div class="row">
  <div class="col-sm-2">
    <label class="control-label"
           for="edit-field-yoga-cover-picture-und-0-upload">Cover
      Picture</label>
  </div>
  <div class="col-sm-10">
    <?php print render($form['field_yoga_cover_picture']); ?>
  </div>
</div>

<h3>4. Location</h3>
<div class="row">
  <div class="col-sm-12">
    <label class="control-label"
           for="geocomplete">Location</label>
  </div>
  <div class="col-sm-12">
    <?php print render($form['geocomplete']); ?>
  </div>
</div>
<div class="row">
  <div class="col-sm-12">
    <?php print render($form['field_yoga_location']); ?>
  </div>
</div>

<!--    <div class="col-sm-2">-->
<!--      <label class="control-label" for="edit-field-hb-gender">Who's it for? </label>-->
<!--    </div>-->
<!--    <div class="col-sm-4">-->
<!--      --><?php //// print render($form['wrapper']['field_hb_gender']); ?>
<!--    </div>-->
<!--    <div class="col-sm-2">-->
<!--      <label class="control-label" for="edit-hbf-field-hb-ht">Select hair treatment type </label>-->
<!--    </div>-->
<!--    <div class="col-sm-4">-->
<!--      --><?php //// print render($form['wrapper']['hbf_field_hb_ht']); ?>
<!--    </div>-->

<!--  </div>-->
<!--</fieldset>-->

<?php print drupal_render_children($form) ?>
