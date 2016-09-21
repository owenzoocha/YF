<article id="node-<?php print $node->nid; ?>"
         class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
  <?php if (isset($unpub_msg)): print $unpub_msg; endif; ?>

  <?php if ($yoga_type != 'event'): ?>
    <div class="job-rhs job-content">
      <div class="job-info">
        <h2 class="block-title">About</h2>
        <?php
        print render($content['body']);
        ?>
      </div>
    </div>
    <?php if (isset($job_request_form)): print $job_request_form; endif; ?>
    <?php if (isset($job_publish_form)): print $job_publish_form; endif; ?>
  <?php endif; ?>

</article>
