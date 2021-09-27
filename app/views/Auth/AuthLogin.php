<div class="container">
  <h2 class="text-center">Вход</h2>
  <div class="row">
    <form method="POST" action="<?php echo url('signin') ?>" class="col-sm-4 mx-auto">
      <div class="form-group">
        <label for="exampleInputEmail1">Email address</label>
        <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
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
       <input type="hidden" name="token"  value="<?php echo getCsrfToken(); ?>">
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
</div>