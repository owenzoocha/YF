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
no classes yet!
<?php endif; ?>