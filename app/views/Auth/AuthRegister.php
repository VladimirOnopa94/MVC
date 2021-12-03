<div class="container">
  <?php if ($messege = flashMessage('error')) { ?>
    <div class="alert alert-danger" role="alert">
      <?php echo $messege; ?>
    </div>
  <?php } ?>

  <h2 class="text-center">Регистрация</h2>
  <div class="row">
    <form method="POST" action="<?php echo url('/signup') ?>" class="col-sm-4 mx-auto">
      <div class="form-group">
        <label for="exampleInputEmail1">Name</label>
        <input type="text" name="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
      </div>
      <div class="form-group">
        <label for="exampleInputPassword1">Password</label>
        <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
      </div>
      <div class="form-check">
        <input type="checkbox" class="form-check-input" id="exampleCheck1">
        <label class="form-check-label" for="exampleCheck1">Check me out</label>
      </div>
      <input type="hidden" name="token"  value="<?php echo csrfToken(); ?>">
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
</div> 