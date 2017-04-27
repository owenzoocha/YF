<div class="date-circles clearfix">
  <div
    class="circles date-from <?php if (empty($month2)): print 'centred'; endif; ?>">
    <span class="m"><?php print $month; ?></span>
    <span class="d"><?php print $day; ?></span>
    <span class="y"><?php print $year; ?></span>
  </div>

  <?php if (!empty($month2)): ?>
    <span class="circles-middle">
      <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
      </span>
    <div class="circles date-to">
      <span class="m"><?php print $month2; ?></span>
      <span class="d"><?php print $day2; ?></span>
      <span class="y"><?php print $year2; ?></span>
    </div>
  <?php endif; ?>

</div>
<div class="separator">
  <?php if (!empty($book)): ?>
    <!-- <a class="btn btn-purple btn-block" href="/">Make a Booking</a> -->
    <?php print $book; ?>
  <?php endif; ?>

  <?php if (!empty($org)): ?>
    <?php print $org; ?>
  <?php endif; ?>
</div>
<?php if (!empty($tel)): ?>
  <div class="separator">
    <p>Want to find out more?</p>
    <p><i class="fa fa-phone"></i> Call <?php print $tel; ?></p>
  </div>
<?php endif; ?>

<?php if (!empty($org)): ?>
  <?php print $org_popup; ?>
<?php endif; ?>
