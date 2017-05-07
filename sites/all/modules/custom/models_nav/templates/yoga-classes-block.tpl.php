<?php if ($class_header) : ?>
<div id="yoga-classes-tables">
  <div class="days-hdr clearfix">
   <?php print $class_header; ?>
  </div>
  <div class="options-hdr clearfix">
    <div class="options op-time">Time</div>
    <div class="options op-style">Style</div>
    <div class="options op-duration">Duration</div>
    <div class="options op-teacher">Teacher</div>
  </div>
  <div class="classes-list clearfix">
    <?php print $class_data; ?>
  </div>
</div>
<?php else : ?>
  <?php if ($make_edits) { ?>
    <div class="nothing-here-yet">
      <span>Add your classes. <a href="/classes/add" class="a-link link-go">here <i class="material-icons">trending_flat</i></a></span>
    </div>
  <?php } ?>
<?php endif; ?>