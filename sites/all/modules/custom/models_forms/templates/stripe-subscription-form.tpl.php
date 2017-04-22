<?php if (isset($tavmuch)): ?>
<div class="row">
  <div class="col-sm-12">
    <?php print $tavmuch; ?>
  </div>
</div>
<?php endif; ?>

<div class="row">
  <div class="col-sm-12">
    <h2>Subscription Details</h2>
    <?php print $current_plan; ?>
  </div>
</div>

<?php if (isset($make_payment)): ?>
<div class="row">
  <div class="col-sm-12">
    <h2>Upgrade Plan</h2>
    <?php print $make_payment; ?>
  </div>
</div>

<?php else: ?>

<div class="row">
  <div class="col-sm-12">
    <h2>Update/Cancel Plan</h2>
    <?php print $cancel_payment; ?>
  </div>
</div>

<?php endif; ?>

<!--cus_AWO4V7hXISDB05-->