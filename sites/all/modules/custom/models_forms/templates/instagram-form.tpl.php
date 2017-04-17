<!--<fieldset class="panel panel-default form-wrapper">-->

<!--  <legend class="panel-heading">-->
<!--    <span class="panel-title fieldset-legend">Your Yoga Listing</span>-->
<!--  </legend>-->

<!--  <div class="panel-body">-->
<?php print render($form['get_started']); ?>

<h3>Your Instagram Feed</h3>

<?php print drupal_render_children($form) ?>
