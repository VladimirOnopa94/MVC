<div class="container">
   <?php if ($error = flashMessage('error')) { ?>
     <div class="alert alert-danger" role="alert">
        <?php echo $error;  ?>
      </div>
    <?php } ?>
  <h2 class="text-center">Вход</h2>
  <div class="row">
    <form method="POST" action="<?php echo url('/signin') ?>" class="col-sm-4 mx-auto">
      <div class="form-group">
        <label for="exampleInputEmail1">Username</label>
        <input type="text" name="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter name">
        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
      </div>
      <div class="form-group">
        <label for="exampleInputPassword1">Password</label>
        <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
      </div>
      <div class="form-group">
        <label for="exampleInputPassword1">File</label>
        <input type="file" name="file" class="form-control" id="exampleInputPassword1">
      </div>
       <input type="hidden" name="token"  value="<?php echo getCsrfToken(); ?>">
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
</div>
