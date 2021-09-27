<div class=" blog-main">
    
    <h2 class="blog-post-title"><?php echo __("title"); ?></h2>

    <?php if ($messege = flashMessage('success')) { ?>
     <div class="alert alert-success" role="alert">
        <?php echo $messege;  ?>
      </div>
    <?php } ?>

    <div class="jumbotron">
      <h1 class="display-4">Hello, world!</h1>
      <p class="lead">This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
      <hr class="my-4">
      <p>It uses utility classes for typography and spacing to space content out within the larger container.</p>
      <p class="lead">
        <a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a>
      </p>
    </div>

    <figure class="text-center">
      <blockquote class="blockquote">
        <p>A well-known quote, contained in a blockquote element.</p>
      </blockquote>
      <figcaption class="blockquote-footer">
        Someone famous in <cite title="Source Title">Source Title</cite>
      </figcaption>
    </figure>


</div><!-- /.blog-main -->