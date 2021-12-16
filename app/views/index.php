<?php if ($error = flashMessage('error')) { ?>
 <div class="alert alert-danger" role="alert">
    <?php echo $error;  ?>
  </div>
<?php } ?>
<div class=" blog-main"> 
  <h2 class="blog-post-title"><?php echo __("title"); ?></h2>
</div><!-- /.blog-main -->

