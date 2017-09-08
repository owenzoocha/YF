<article id="node-<?php print $node->nid; ?>"
         class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
  <?php if (isset($unpub_msg)): print $unpub_msg; endif; ?>

  <?php if ($yoga_type != 'event'): ?>

    <?php if (isset($claim_this)): ?>
      <div class="claim-this">
<!--        <h2 class="block-title">About</h2>-->
        <span>Do you own this listing? Is this your business? Click <a href="/%23" data-toggle="modal" data-target="#contactus-popup">here</a> to claim this page :)</span>
      </div>
    <?php endif; ?>

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
