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

<!--    <div class="day-wrapper" data-day="Monday">-->
<!--      <div class="class-1 yoga-class">-->
<!--        <div class="options op-time">4:00pm</div>-->
<!--        <div class="options op-style">Hot Yoga</div>-->
<!--        <div class="options op-duration">1hr</div>-->
<!--        <div class="options op-teacher">Owen Williams</div>-->
<!--        <div class="yoga-class-extra">-->
<!--          <div class="yoga-class-img"><img class="img-responsive" src="http://yogafind.dev/sites/default/files/styles/profile/public/heart.png?itok=BCKVtqjL"/></div>-->
<!--          <div class="yoga-class-desc">-->
<!--            <h4>Hot Yoga</h4>-->
<!--            <p>this is my description Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec euismod, enim vel suscipit convallis, nunc purus malesuada magna, quis tincidunt ex odio in quam. Curabitur a aliquet metus. Curabitur pulvinar, justo mollis viverra condimentum, eros lorem euismod urna, nec ultrices arcu dui at ante. Donec auctor est quis felis iaculis, vitae fermentum orci auctor. Sed id felis vitae tellus efficitur vulputate in quis orci. Aliquam tellus purus, iaculis non auctor a, dictum in elit. In sagittis volutpat pharetra. Nunc porttitor semper vehicula. Praesent scelerisque tincidunt nunc, sit amet tincidunt diam pulvinar in.</p>-->
<!--          </div>-->
<!--        </div>-->
<!--      </div>-->
<!--      <div class="class-2 yoga-class">-->
<!--        <div class="options op-time">4:00pm</div>-->
<!--        <div class="options op-style">Hot Yoga</div>-->
<!--        <div class="options op-duration">1hr</div>-->
<!--        <div class="options op-teacher">Owen Williams</div>-->
<!--        <div class="yoga-class-extra">-->
<!--          <div class="yoga-class-img"><img class="img-responsive" src="http://yogafind.dev/sites/default/files/styles/profile/public/heart.png?itok=BCKVtqjL"/></div>-->
<!--          <div class="yoga-class-desc">-->
<!--            <h4>Hot Yoga</h4>-->
<!--            <p>this is my description Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec euismod, enim vel suscipit convallis, nunc purus malesuada magna, quis tincidunt ex odio in quam. Curabitur a aliquet metus. Curabitur pulvinar, justo mollis viverra condimentum, eros lorem euismod urna, nec ultrices arcu dui at ante. Donec auctor est quis felis iaculis, vitae fermentum orci auctor. Sed id felis vitae tellus efficitur vulputate in quis orci. Aliquam tellus purus, iaculis non auctor a, dictum in elit. In sagittis volutpat pharetra. Nunc porttitor semper vehicula. Praesent scelerisque tincidunt nunc, sit amet tincidunt diam pulvinar in.</p>          </div>-->
<!--        </div>-->
<!--      </div>-->
<!--      <div class="class-3 yoga-class">-->
<!--        <div class="options op-time">4:00pm</div>-->
<!--        <div class="options op-style">Hot Yoga</div>-->
<!--        <div class="options op-duration">1hr</div>-->
<!--        <div class="options op-teacher">Owen Williams</div>-->
<!--        <div class="yoga-class-extra">-->
<!--          <div class="yoga-class-img"><img class="img-responsive" src="http://yogafind.dev/sites/default/files/styles/profile/public/heart.png?itok=BCKVtqjL"/></div>-->
<!--          <div class="yoga-class-desc">-->
<!--            <h4>Hot Yoga</h4>-->
<!--            <p>this is my description Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec euismod, enim vel suscipit convallis, nunc purus malesuada magna, quis tincidunt ex odio in quam. Curabitur a aliquet metus. Curabitur pulvinar, justo mollis viverra condimentum, eros lorem euismod urna, nec ultrices arcu dui at ante. Donec auctor est quis felis iaculis, vitae fermentum orci auctor. Sed id felis vitae tellus efficitur vulputate in quis orci. Aliquam tellus purus, iaculis non auctor a, dictum in elit. In sagittis volutpat pharetra. Nunc porttitor semper vehicula. Praesent scelerisque tincidunt nunc, sit amet tincidunt diam pulvinar in.</p>          </div>-->
<!--        </div>-->
<!--      </div>-->
<!--    </div>-->
<!--    <div class="day-wrapper active" data-day="Thursday">-->
<!--      <div class="class-1 yoga-class">-->
<!--        <div class="options op-time">4:00pm</div>-->
<!--        <div class="options op-style">Hot Yoga</div>-->
<!--        <div class="options op-duration">1hr</div>-->
<!--        <div class="options op-teacher">Owen Williams</div>-->
<!--        <div class="yoga-class-extra">-->
<!--          <div class="yoga-class-img"><img class="img-responsive" src="http://yogafind.dev/sites/default/files/styles/profile/public/heart.png?itok=BCKVtqjL"/></div>-->
<!--          <div class="yoga-class-desc">-->
<!--            <h4>Hot Yoga</h4>-->
<!--            <p>this is my description Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec euismod, enim vel suscipit convallis, nunc purus malesuada magna, quis tincidunt ex odio in quam. Curabitur a aliquet metus. Curabitur pulvinar, justo mollis viverra condimentum, eros lorem euismod urna, nec ultrices arcu dui at ante. Donec auctor est quis felis iaculis, vitae fermentum orci auctor. Sed id felis vitae tellus efficitur vulputate in quis orci. Aliquam tellus purus, iaculis non auctor a, dictum in elit. In sagittis volutpat pharetra. Nunc porttitor semper vehicula. Praesent scelerisque tincidunt nunc, sit amet tincidunt diam pulvinar in.</p>          </div>-->
<!--        </div>-->
<!--      </div>-->
<!--      <div class="class-2 yoga-class">-->
<!--        <div class="options op-time">4:00pm</div>-->
<!--        <div class="options op-style">Hot Yoga</div>-->
<!--        <div class="options op-duration">1hr</div>-->
<!--        <div class="options op-teacher">Owen Williams</div>-->
<!--        <div class="yoga-class-extra">-->
<!--          <div class="yoga-class-img"><img class="img-responsive" src="http://yogafind.dev/sites/default/files/styles/profile/public/heart.png?itok=BCKVtqjL"/></div>-->
<!--          <div class="yoga-class-desc">-->
<!--            <h4>Hot Yoga</h4>-->
<!--            <p>this is my description Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec euismod, enim vel suscipit convallis, nunc purus malesuada magna, quis tincidunt ex odio in quam. Curabitur a aliquet metus. Curabitur pulvinar, justo mollis viverra condimentum, eros lorem euismod urna, nec ultrices arcu dui at ante. Donec auctor est quis felis iaculis, vitae fermentum orci auctor. Sed id felis vitae tellus efficitur vulputate in quis orci. Aliquam tellus purus, iaculis non auctor a, dictum in elit. In sagittis volutpat pharetra. Nunc porttitor semper vehicula. Praesent scelerisque tincidunt nunc, sit amet tincidunt diam pulvinar in.</p>          </div>-->
<!--        </div>-->
<!--      </div>-->
<!--    </div>-->
  </div>
</div>
<?php else : ?>
no classes yet!
<?php endif; ?>