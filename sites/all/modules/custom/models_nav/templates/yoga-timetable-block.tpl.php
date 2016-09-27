<?php if (!$class_header) : ?>
  <div id="yoga-classes-tables" class="yoga-timetable-tables">
    <?php
    $i = 0;
    foreach ($class_array as $index => $item): ?>
<!--      <div class="days-hdr clearfix">-->
        <h3><?php print $index; ?></h3>
<!--      </div>-->
      <div class="options-hdr clearfix">
        <div class="options op-time">Time</div>
        <div class="options op-style">Style</div>
        <div class="options op-duration">Duration</div>
        <div class="options op-teacher">Teacher</div>
      </div>
      <div class="classes-list clearfix">
        <?php print $class_data[$index]; ?>
      </div>
      <?php endforeach; ?>
  </div>
<?php else : ?>
  no classes yet!
<?php endif; ?>