<!--<fieldset class="panel panel-default form-wrapper">-->

<!--  <legend class="panel-heading">-->
<!--    <span class="panel-title fieldset-legend">Your Yoga Listing</span>-->
<!--  </legend>-->

<!--  <div class="panel-body">-->
<?php print render($form['get_started']); ?>

<!--<div class="col-sm-12">-->
<h2>1. Your Event</h2>
<!--</div>-->
<div class="row">
  <div class="col-sm-2">
    <label class="control-label" for="edit-title">Event Title<span
        class="form-required" title="This field is required.">*</span></label>
  </div>
  <div class="col-sm-10">
    <?php print render($form['title']); ?>
  </div>
</div>

<div class="row">
  <div class="col-sm-2">
    <label class="control-label" for="edit-field-yoga-event-type-und">Event
      Type</label>
  </div>
  <div class="col-sm-10">
    <?php print render($form['field_yoga_event_type']); ?>
  </div>
</div>

<div class="row">
  <div class="col-sm-2">
    <label class="control-label"
           for="edit-field-yoga-link-und-0">Booking URL</label>
  </div>
  <div class="col-sm-10">
    <?php print render($form['field_yoga_link']); ?>
  </div>
</div>

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

<h2>2. About</h2>
<div class="row">
  <div class="col-sm-2">
    <label class="control-label"
           for="edit-field-yoga-event-dates-und-0">Dates</label>
  </div>
  <div class="col-sm-10">
    <?php print render($form['field_yoga_event_dates']); ?>
  </div>
</div>

<div class="row">
  <div class="col-sm-2">
    <label class="control-label"
           for="edit-field-yoga-logo-und-0-upload">Event Picture</label>
  </div>
  <div class="col-sm-10">
    <?php print render($form['field_yoga_logo']); ?>
  </div>
</div>

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
           for="edit-body-und-0-value">Event Description</label>
  </div>
  <div class="col-sm-12">
    <?php print render($form['body']); ?>
  </div>
</div>


<h2>3. Prices and More Information</h2>
<div class="row">
  <div class="col-sm-2">
    <label class="control-label" for="edit-field-yoga-event-price-und-0-value">£
      Price</label>
  </div>
  <div class="col-sm-10">
    <?php print render($form['field_yoga_event_price']); ?>
  </div>
</div>

<div class="row">
  <div class="col-sm-12">
    <label class="control-label"
           for="edit-field-yoga-event-price-include-und-0-value">What does the
      price include?</label>
  </div>
  <div class="col-sm-12">
    <?php print render($form['field_yoga_event_price_include']); ?>
  </div>
</div>

<div class="row">
  <div class="col-sm-12">
    <label class="control-label" for="edit-field-yoga-itinerary-und-0-value">Schedule
      / Itinerary</label>
  </div>
  <div class="col-sm-12">
    <?php print render($form['field_yoga_itinerary']); ?>
  </div>
</div>


<h2>4. Location</h2>
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

<div class="form-to-hide">
  <?php print drupal_render_children($form) ?>
</div>
