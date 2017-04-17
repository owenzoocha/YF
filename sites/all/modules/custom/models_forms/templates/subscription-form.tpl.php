<div class="row">
  <h2>Subscription Details</h2>
  <div class="col-sm-12">
    <?php print render($form['field_yf_subscription']); ?>
  </div>
</div>

<div class="row">
  <h2>Payment Details / Stripe</h2>
  <div class="col-sm-12">
    cancel etc goes here!!
    <?php print render($form['stripe_subscription_info']); ?>
    <?php if (isset($form['stripe_subscription_standard'])): ?>
      <?php print render($form['stripe_subscription_standard']); ?>
    <?php endif; ?>
    <?php if (isset($form['stripe_subscription_premium'])): ?>
      <?php print render($form['stripe_subscription_premium']); ?>
    <?php endif; ?>
  </div>
</div>

<?php print drupal_render_children($form) ?>
