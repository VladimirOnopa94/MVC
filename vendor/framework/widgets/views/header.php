<header class="bg-light">
  <nav class="navbar navbar-expand-lg navbar-light  container">
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item <?php if(currLoc() == url('')){ echo 'active'; } ?>">
          <a class="nav-link" href="<?php echo url('') ?>"><?php echo __("main_title"); ?></a>
        </li>
        <li class="nav-item <?php if(currLoc() == url('categories')){ echo 'active'; } ?>">
          <a class="nav-link" href="<?php echo url('categories') ?>">Категории</a>
        </li>
      </ul>
    </div>
    <div class="d-flex">
      <?php if ($user = Auth()) { ?>
        <div style="margin: 0 10px;display: flex;align-items: center;">
          <?php echo __("welcome_title"); ?> <?php echo $user['email']; ?>
        </div>
      <?php } ?>
      <ul class="navbar-nav">
        <?php if (Auth()) { ?>
           <li class="nav-item <?php if(currLoc() == url('logout')){ echo 'active'; } ?>">
            <a class="nav-link" href="<?php echo url('logout') ?>"><?php echo __("logout_title"); ?></a>
          </li>
        <?php }else{ ?>
          <li class="nav-item <?php if(currLoc() == url('login')){ echo 'active'; } ?>">
            <a class="nav-link" href="<?php echo url('login') ?>"><?php echo __("login_title"); ?></a>
          </li>
          <li class="nav-item <?php if(currLoc() == url('register')){ echo 'active'; } ?>">
            <a class="nav-link" href="<?php echo url('register') ?>"><?php echo __("signin_title"); ?></a>
          </li>
        <?php } ?>
      </ul>

      <?php framework\widgets\Lang::widget(); ?>
    </div>
  </nav>
</header>