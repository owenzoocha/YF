<article id="node-<?php print $node->nid; ?>"
         class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
  <?php
    if (!empty($publish_msg)): print $publish_msg; endif;
    print render($content['field_post_image']);
    print render($content['body']);
    print render($content['field_yoga_style']);
  ?>
</article>
